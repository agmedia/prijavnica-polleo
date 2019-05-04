<?php

namespace App\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PolleoService extends Model
{
    
    /**
     * @property Client $service
     */
    private $service;
    
    
    /**
     * PolleoService constructor.
     */
    public function __construct()
    {
        $this->service = new Client([
            'base_uri' => config('services.polleo.base_url'),
            'verify'   => false,
            'timeout'  => 5.0,
        ]);
    }
    
    
    /**
     * Login user to Polleo service.
     *
     * @param Request $request
     *
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function login(Request $request)
    {
        try {
            $response = $this->service->request('POST', '/index.php?route=feed/rest_api/login&key=12345', [
                'form_params' => [
                    'email'    => $request->email,
                    'password' => $request->pass,
                ]
            ])->getBody();
            $response = json_decode($response, true);
        } catch (RequestException $e) {
            $response = $e->getMessage();
            Log::alert($e->getMessage());
        }
        
        return $response;
    }
    
    
    /**
     * Register user against polleo_hr database.
     *
     * @param $customer_data
     *
     * @return \Illuminate\Support\Collection|mixed|\Psr\Http\Message\StreamInterface|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function register($customer_data)
    {
        try {
            $response = $this->service->request('POST', '/index.php?route=feed/rest_api/register&key=12345', [
                'form_params' => $customer_data
            ])->getBody();
            $response = json_decode($response, true);
        } catch (RequestException $e) {
            $response = $e->getMessage();
            Log::alert($e->getMessage());
        }
        
        // User already exist (300).
        if (isset($response['status']) && $response['status'] == 300) {
            $response = collect(DB::table('oc_customer')->where('email', $customer_data['email'])->first());
        }
        
        return $response;
    }
}
