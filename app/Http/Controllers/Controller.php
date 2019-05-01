<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    /**
     * Polleosport Opencart HTTP/CURL client service.
     *
     * @var Client GuzzleHttp
     */
    protected $polleo_client;

    /**
     * Etranet Loyalty HTTP/CURL client service.
     *
     * @var Client GuzzleHttp
     */
    protected $loyalty_client;

    /**
     * Infobip SMS HTTP/CURL client service.
     *
     * @var Client GuzzleHttp
     */
    protected $sms_client;


    /**
     * Controller constructor.
     */
    public function __construct()
    {
        /** instantiate the clients with basic setup */
        $this->polleo_client = new Client([
            'base_uri' => config('services.polleo.base_url'),
            'timeout' => 5.0,
        ]);

        $this->loyalty_client = new Client([
            'base_uri' => config('services.loyalty.base_url'),
            'verify' => false,
            'timeout' => 5.0,
        ]);

        $this->sms_client = new Client([
            'base_uri' => config('services.sms_service.base_url'),
        ]);
    }
}
