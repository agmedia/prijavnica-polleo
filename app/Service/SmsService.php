<?php

namespace App\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SmsService extends Model
{
    
    /**
     * @property Client $service
     */
    private $service;
    
    
    /**
     * SmsService constructor.
     */
    public function __construct()
    {
        $this->service = new Client([
            'base_uri' => config('services.sms_service.base_url'),
            'timeout'  => 5.0,
        ]);
    }
    
    
    /**
     * Send customer input PIN to SMS service.
     *
     * @param $customer
     *
     * @return mixed|\Psr\Http\Message\StreamInterface|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function sendPIN($customer)
    {
        try {
            $response = $this->service->request('POST', 'pin', [
                'headers' => [
                    'Authorization' => config('services.sms_service.basic_header')
                ],
                'json'    => [
                    'applicationId' => config('services.sms_service.app_id'),
                    'messageId'     => config('services.sms_service.msg_id'),
                    'from'          => 'InfoSMS',
                    'to'            => $customer['telephone'],
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
     * Verify customer input PIN with SMS service.
     *
     * @param Request $request
     *
     * @return mixed|\Psr\Http\Message\StreamInterface|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function verifyPIN(Request $request)
    {
        // Get user from session.
        $customer = $request->session()->get('customer');
        // Add some general user data
        $req_data = $request->all();
        
        // Verify PIN sent over SMS
        try {
            $response = $this->service->request('POST', 'pin/' . $customer['sms_response']['pinId'] . '/verify', [
                'headers' => [
                    'Authorization' => config('services.sms_service.app_header')
                ],
                'json'    => [
                    'pin' => $req_data['pin'],
                ]
            ])->getBody();
            $response = json_decode($response, true);
        } catch (RequestException $e) {
            $response = $e->getMessage();
            Log::alert($e->getMessage());
        }
        
        return $response;
    }
}
