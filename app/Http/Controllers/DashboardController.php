<?php

namespace App\Http\Controllers;

use App\User;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    /**
     * Show Dashboard.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function index(Request $request)
    {
        // Get user from session.
        $user = $request->session()->get('user');

        $backgroundimage = 'images/signup-screen-1.png';

        if ( ! $user)
            return redirect()->route('enter');

        // Get user loyalty points.
        try {
            $response = $this->loyalty_client->request('POST', 'points', [
                'json' => [
                    /** @IMPORTANT ovo ne valja. ODAKLE Reference Number */
                    'referenceNumber' => 'd75e519e-e465-4783-a7fd-90b6357e358f',
                ]
            ])->getBody();
            $data = json_decode($response, true);

        } catch (RequestException $e) {
            Log::alert($e->getMessage());
        }

        // Assign some additional data.
        $data['required_user_data'] = $this->checkRequiredUserData($user);
        $data['optional_user_data'] = $this->checkOptionalUserData($user);

        return view('dashboard.dashboard', compact('data', 'user', 'backgroundimage'));
    }


    /**
     * Edit required user data.
     * Validate user request.
     * Save to database.
     * Save to loyalty if changed.
     * Set new session.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function editUserRequiredData(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email',
            'telephone' => 'required',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'postcode' => 'required',
            'birthday' => 'required',
            'sex' => 'required|string|max:1',
        ]);

        // Assign some data vars.
        $user_data = $request->all();
        $user = $request->session()->get('user');

        // update user data with address
        try {
            DB::table('oc_customer')->where('email', $user_data['email'])
                ->update([
                    'firstname' => $user_data['firstname'],
                    'lastname' => $user_data['lastname'],
                    'email' => $user_data['email'],
                    'telephone' => $user_data['telephone'],
                    'birthday' => $user_data['birthday'],
                    'sex' => $user_data['sex'],
                ]);
            DB::table('oc_address')->where('customer_id', $user['customer_id'])
                ->update([
                    'address' => $user_data['address'],
                    'city' => $user_data['city'],
                    'postcode' => $user_data['postcode'],
                ]);
        } catch (\Exception $exception) {
            Log::alert('Could not write to database.');
        }

        // Loyalty user data have changed. Update.
        if ($this->checkLoyaltyUserDataChange($user, $user_data))
        {
            try {
                $l_response = $this->loyalty_client->request('POST', 'customer', [
                    'json' => [
                        'email' => $user_data['email'],
                        'name' => $user_data['firstname'],
                        'surname' => $user_data['lastname'],
                        'referenceNumber' => $user_data['reference_id'],
                    ]
                ])->getBody();
                $l_response = json_decode($l_response, true);

            } catch (RequestException $e) {
                Log::alert($e->getMessage());
            }
        }

        // add session user
        $session_user = DB::table('oc_customer')->where('customer_id', $user['customer_id'])->first();
        User::setUserSessionData(collect($session_user));

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
     * @return bool
     */
    private function checkRequiredUserData($data)
    {
        if ( empty($data['firstname'])
            || empty($data['lastname'])
            || empty($data['email'])
            || empty($data['telephone'])
            || empty($data['status'])
            || empty($data['birthday'])
            || empty($data['sex'])
            || empty($data['address']->address_1)
            || empty($data['address']->city)
            || empty($data['address']->postcode))
        {
            return false;
        } else {
            return true;
        }
    }


    /**
     * check OPTIONAL user data.
     *
     * @param $data
     * @return bool
     */
    private function checkOptionalUserData($data)
    {
        if ( empty($data['data1'])
            || empty($data['data2'])
            || empty($data['data3']))
        {
            return false;
        } else {
            return true;
        }
    }


    /**
     * Check if the user data for the
     * loyalty system has changed.
     *
     * @param $user
     * @param $data
     * @return bool
     */
    private function checkLoyaltyUserDataChange($user, $data)
    {
        if ($data['firstname'] == $user['firstname']
            && $data['lastname'] == $user['lastname']
            && $data['email'] == $user['email'])
        {
            return false;
        } else {
            return true;
        }
    }
}
