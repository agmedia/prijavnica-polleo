<?php

namespace App\Http\Controllers;

use App\User;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LogController extends Controller
{
    // VIEWS
    public function login()
    {
        $backgroundimage = 'images/signup-screen-1.png';

        return view('login', compact('backgroundimage'));


    }

    public function register()
    {
        $backgroundimage = 'images/signup-screen-1.png';

        return view('register', compact('backgroundimage'));

    }


    /**
     * Try to log user.
     * If successfull redirect them to Dashboard.
     * If not back to login with error status.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function logUser(Request $request)
    {
        // get user login
        try {
            $response = $this->polleo_client->request('POST', '/index.php?route=feed/rest_api/login&key=12345', [
                'verify' => false,
                'form_params' => [
                    'email' => $request->email,
                    'password' => $request->pass,
                ]
            ])->getBody();
            $response = json_decode($response, true);

        } catch (RequestException $e) {
            Log::alert($e->getMessage());
        }

        // if not loged get out
        if ($response['success'] == 'false') {
            return back()->with('error', $response['userdata'][0]);
        }
        // add address to response user
        User::setUserSessionData($response['userdata']);

        return redirect()->route('dashboard');
    }


    /**
     * Register User.
     * Validate the user request and
     * register the user via OC API.
     * Create loyalty user and return to dashboard.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function registerUser(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email',
            'telephone' => 'required',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'zip' => 'required',
            'birthday' => 'required',
            'sex' => 'required|string|max:1',
            'password' => 'required|string|min:6',
        ]);

        // Add some general user data
        $user_data = $request->all();
        $user_data['customer_group_id'] = 2;
        $user_data['country_id'] = 53; // 53 == HR

        // Register user via OC API
        try {
            $p_response = $this->polleo_client->request('POST', '/index.php?route=feed/rest_api/register&key=12345', [
                'form_params' => $user_data
            ])->getBody();
            $p_response = json_decode($p_response, true);

        } catch (RequestException $e) {
            Log::alert($e->getMessage());
        }

        /** @ERROR. User već postoji(300) ili nepotpuni podaci(400). */
        if ($p_response['status'] == 300 || $p_response['status'] == 400) {
            return back()->with('error', $p_response['userdata']);
        }

        // Sve OK. Nastavi sa registracijom.
        if ($p_response['status'] == 200) {
            // Napravi klijenta u Loyalty-u
            try {
                $l_response = $this->loyalty_client->request('POST', 'customer', [
                    'json' => [
                        'email' => $user_data['email'],
                        'name' => $user_data['firstname'],
                        'surname' => $user_data['lastname'],
                    ]
                ])->getBody();
                $l_response = json_decode($l_response, true);

            } catch (RequestException $e) {
                Log::alert($e->getMessage());
            }

            // Ako je user napravljan i odgovara registriranom, snimi reference-Number u bazu.
            if ($l_response['email'] == $user_data['email']) {
                DB::table('oc_customer')->where('email', $l_response['email'])->update(['reference_id' => $l_response['referenceNumber']]);
            }

            // Verify telephone number by SMS
            try {
                $sms_response = $this->sms_client->request('POST', 'pin', [
                    'json' => [
                        'applicationId' => config('services.sms_service.app_id'),
                        'messageId' => config('services.sms_service.app_id'),
                        'from' => 'InfoSMS',
                        'to' => $user_data['telephone'],
                    ]
                ])->getBody();
                $sms_response = json_decode($sms_response, true);

            } catch (RequestException $e) {
                Log::alert($e->getMessage());
            }

            $p_response['sms_response'] = $sms_response;

            // add session user
            User::setUserSessionData($p_response['userdata']);

            return redirect()->route('verify-sms');
        }

        return back()->with('error', 'Dogodila se greška. Pozovite prodavača!');
    }


    public function verifySMS(Request $request)
    {
        // Get user from session.
        $user = $request->session()->get('user');
        // Add some general user data
        $req_data = $request->all();

        // Verify PIN sent over SMS
        try {
            $sms_response = $this->sms_client->request('POST', 'pin/' . $user['sms_response']['pinId'] . '/verify', [
                'json' => [
                    'pin' => $req_data['pin'],
                ]
            ])->getBody();
            $sms_response = json_decode($sms_response, true);

        } catch (RequestException $e) {
            Log::alert($e->getMessage());
        }

        if ($sms_response['verified']) {
            return redirect()->route('dashboard');
        } else {
            return redirect()->route('verify-sms')->with('error', 'Dogodila se greška. Pozovite prodavača!');
        }
    }


    /**
     * Logout User.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        $request->session()->forget('user');

        return redirect()->route('home');
    }

}
