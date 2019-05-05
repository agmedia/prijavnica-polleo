<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Service\LoyaltyService;
use App\Service\PolleoService;
use App\Service\SmsService;
use Illuminate\Http\Request;

class LogController extends Controller
{
    
    /**
     * Login View.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function login()
    {
        $backgroundimage = 'images/signup-screen-1.png';
        
        return view('login', compact('backgroundimage'));
    }
    
    
    /**
     * Register View.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function register()
    {
        $backgroundimage = 'images/signup-screen-1.png';
        
        return view('register', compact('backgroundimage'));
    }
    
    
    /**
     * Verify PIN View.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function verify()
    {
        $backgroundimage = 'images/signup-screen-1.png';
        
        return view('verifysms', compact('backgroundimage'));
    }
    
    
    /**
     * Try to log user.
     * If successfull redirect them to Dashboard.
     * If not back to login with error status.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function logUser(Request $request)
    {
        $polleo_service = new PolleoService();
        $response       = $polleo_service->login($request);
        
        /* @MOCK reference ID mocking @Delete_After */
        if (isset($response['userdata'])) {
            $response['userdata']['reference_id'] = '7189e51f-f773-4a3d-b845-86fcf1d1f378';
        }
        
        // if not loged get out
        if ( ! isset($response['success'])) {
            return back()->with('error', __('auth.error'));
        } elseif ($response['success'] == 'false') {
            return back()->with('error', __('auth.not_found'));
        }
        // add address to response user
        Customer::setSession($response['userdata']);
        
        return redirect()->route('dashboard');
    }
    
    
    /**
     * Register User.
     * Validate the user request and
     * register the user via OC API.
     * Create loyalty user and return to dashboard.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function registerUser(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname'  => 'required|string|max:255',
            'email'     => 'required|email',
            'telephone' => 'required',
            'address'   => 'required|string',
            'city'      => 'required|string|max:255',
            'zip'       => 'required',
            'birthday'  => 'required',
            'sex'       => 'required|string|max:1',
            'password'  => 'required|string|min:6',
        ]);
        
        // Add some customer data and Register user on Polleo.
        $customer       = Customer::setData($request);
        $polleo_service = new PolleoService();
        $ps_response    = $polleo_service->register($customer);
        
        //Log::debug($ps_response);
        
        // Customer created.
        if (isset($ps_response['status']) && $ps_response['status'] == 200) {
            // Create loyalty customer
            $loyalty_service = new LoyaltyService();
            $ls_response     = $loyalty_service->createCustomer($customer);
            
            // Loyalty customer created.
            if ($ls_response['status'] == 200) {
                // Send SMS verification PIN.
                $sms_service  = new SmsService();
                $sms_response = $sms_service->sendPIN($customer);
                
                // Add additional customer data
                $ps_response['userdata']['reference_id'] = $ls_response['referenceNumber'];
                $ps_response['userdata']['sms_response'] = $sms_response;
                
                // Set customer session.
                Customer::setSession($ps_response['userdata']);
                
                return redirect()->route('verify');
            }
        }
        
        return back()->with('error', __('auth.error'));
    }
    
    
    /**
     * Verify SMS PIN request.
     * If OK goto dashboard, else attempts remaining.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function verifySMS(Request $request)
    {
        // Verify PIN sent over SMS
        $sms_service  = new SmsService();
        $sms_response = $sms_service->verifyPIN($request);
        
        // Verify SMS response.
        if ($sms_response['verified']) {
            // OK.
            return redirect()->route('dashboard');
        } else {
            if ( ! $sms_response['verified'] && $sms_response['pinError'] == 'WRONG_PIN') {
                // Wrong PIN.
                return redirect()->route('verify-sms')->with('error', __('auth.pin_attempts', ['attempts' => $sms_response['attemptsRemaining']]));
            } else {
                // Failed.
                return redirect()->route('register')->with('error', __('auth.failed'));
            }
        }
    }
    
    
    /**
     * Logout User.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        $request->session()->forget('customer');
        
        return redirect()->route('home');
    }
    
}
