<?php

namespace App\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LoyaltyService extends Model
{
    
    /**
     * @property Client $service
     */
    private $service;
    
    
    /**
     * LoyaltyService constructor.
     */
    public function __construct()
    {
        $this->service = new Client([
            'base_uri' => config('services.loyalty.base_url'),
            'verify'   => false,
            'timeout'  => 5.0,
        ]);
    }
    
    
    /**
     * Create loyalty customer.
     * Add customer referenceNumber to Polleo database.
     *
     * @param $customer
     *
     * @return mixed|\Psr\Http\Message\StreamInterface|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function createCustomer($customer)
    {
        try {
            $response = $this->service->request('POST', 'customer', [
                'json' => [
                    'email'   => $customer['email'],
                    'name'    => $customer['firstname'],
                    'surname' => $customer['lastname'],
                ]
            ])->getBody();
            $response = json_decode($response, true);
        } catch (RequestException $e) {
            $response = $e->getMessage();
            Log::alert($e->getMessage());
        }
        
        // Ako je user napravljan i odgovara registriranom, snimi reference-Number u bazu.
        if ($response['email'] == $customer['email']) {
            DB::table('oc_customer')->where('email',
                $response['email'])->update(['reference_id' => $response['referenceNumber']]);
        }
        
        return $response;
    }
    
    
    /**
     * Update loyalty customer.
     *
     * @param Request $request
     *
     * @return mixed|\Psr\Http\Message\StreamInterface|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function updateCustomer(Request $request)
    {
        try {
            $response = $this->service->request('POST', 'customer', [
                'json' => [
                    'email'           => $request['email'],
                    'name'            => $request['firstname'],
                    'surname'         => $request['lastname'],
                    'referenceNumber' => $request['reference_id'],
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
     * Get customer points from loyalty service.
     *
     * @param $customer
     *
     * @return mixed|\Psr\Http\Message\StreamInterface|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPoints($customer)
    {
        try {
            $response = $this->service->request('POST', 'points', [
                'json' => [
                    /** @IMPORTANT ovo ne valja. ODAKLE Reference Number */
                    //'email' => $customer['email'],
                    'referenceNumber' => $customer['reference_id'],
                ]
            ])->getBody();
            $response = json_decode($response, true);
        } catch (RequestException $e) {
            $response = $e->getMessage();
            Log::alert('LoyaltyService::getPoints() Error message::: ' . $response);
        }
        
        return $response;
    }
}
