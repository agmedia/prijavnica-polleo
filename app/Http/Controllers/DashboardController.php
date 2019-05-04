<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Service\LoyaltyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    
    /**
     * Show Dashboard.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function index()
    {
        // Set customer.
        $customer = $this->setCustomer();
        // Get customer loyalty points.
        $loyalty_service = new LoyaltyService();
        $data            = $loyalty_service->getPoints($customer);
        /* @Possible_Response_ERROR - u $data se javlja mogući error u
         * /Exception $e->getMessage() responsu ako naprimjer customer nije pronađen...
         * Kontaktirati EtraNet da isprave error response da umjesto stringa sa objektom
         * u response stave samo objekt.
         * Log:
         * [2019-05-04 13:22:21] local.DEBUG: Client error: `POST http://165.227.137.83:9000/api/v1/points` resulted in a `404 Not Found` response:
         * {"timestamp":1556976141786,"status":404,"error":"Not Found","message":"Customer not found","path":"/api/v1/points"}
         *
         * Cijeli error je string unutar kojeg je sadržan objekt?
         * Error bi trebao biti objekt unutar kojeg je string ili više podataka (stringova)...
         */
        
        if (gettype($data) == 'string') {
            return redirect()->route('enter')->with('error', 'Login podaci nisu pronađeni... Molimo pokušajte ponovo.');
        }
        
        // Assign some additional data rules for the view.
        $data['required_user_data'] = $this->checkRequiredUserData($customer);
        $data['optional_user_data'] = $this->checkOptionalUserData($customer);
        $backgroundimage            = 'images/login-screen1.png';
        $user                       = $customer;
        
        return view('dashboard.dashboard', compact('data', 'user', 'backgroundimage'));
    }
    
    
    /**
     * Edit required customer data method.
     * Validate customer request.
     * Save to database.
     * Save to loyalty if changed.
     * Set new session.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function editUserRequiredData(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname'  => 'required|string|max:255',
            'email'     => 'required|email',
            'telephone' => 'required',
            'address'   => 'required|string',
            'city'      => 'required|string|max:255',
            'postcode'  => 'required',
            'birthday'  => 'required',
            'sex'       => 'required|string|max:1',
        ]);
    
        // Set customer.
        $customer = $this->setCustomer();
        // Update customer data on Polleo database.
        Customer::updatePolleoDB($request, $customer);
        // Update loyalty customer.
        $loyalty_service = new LoyaltyService();
        $loyalty_service->updateCustomer($request);
        
        // Add customer session.
        $session_customer = DB::table('oc_customer')->where('customer_id', $customer['customer_id'])->first();
        Customer::setSession(collect($session_customer));
        
        return redirect()->route('dashboard');
    }
    
    
    public function editUserOptionalData(Request $request)
    {
        dd($request);
    }
    
    
    /**
     * check REQUIRED user data.
     *
     * @param $data
     *
     * @return bool
     */
    private function checkRequiredUserData($data)
    {
        if (empty($data['firstname'])
            || empty($data['lastname'])
            || empty($data['email'])
            || empty($data['telephone'])
            || empty($data['status'])
            || empty($data['birthday'])
            || empty($data['sex'])
            || empty($data['address']->address_1)
            || empty($data['address']->city)
            || empty($data['address']->postcode)) {
            return false;
        } else {
            return true;
        }
    }
    
    
    /**
     * check OPTIONAL user data.
     *
     * @param $data
     *
     * @return bool
     */
    private function checkOptionalUserData($data)
    {
        if (empty($data['data1'])
            || empty($data['data2'])
            || empty($data['data3'])) {
            return false;
        } else {
            return true;
        }
    }
    
    
    private function setCustomer()
    {
        $customer = session()->get('customer');
        
        if ( ! $customer) {
            return redirect()->route('enter')->with('error', 'Morate se ponovo logirati na loyalty sustav!');
        }
        
        return $customer;
    }
}
