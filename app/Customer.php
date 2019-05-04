<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Customer extends Model
{
    
    /**
     * Set customer basic loyalty data.
     *
     * @param Request $request
     *
     * @return array
     */
    public static function setData(Request $request)
    {
        $customer                      = $request->all();
        $customer['customer_group_id'] = 2;
        $customer['country_id']        = 53; // 53 == HR
        
        return $customer;
    }
    
    
    /**
     * Set some basic user session data.
     *
     * @param $data
     */
    public static function setSession($data)
    {
        $customer            = $data;
        $customer['address'] = DB::table('oc_address')->where('customer_id', $customer['customer_id'])->first();
        $customer            = self::setCustomFieldCustomerData($customer);
        
        session(['customer' => $customer]);
    }
    
    
    /**
     * Set Custom fields user data.
     *
     * @param $data
     *
     * @return bool
     */
    private static function setCustomFieldCustomerData($data)
    {
        if (!isset($data['custom_field'])) {
            return false;
        }
        
        $temp = json_decode($data['custom_field'], true);
        
        $data['birthday'] = $temp['3'];
        $data['sex']      = $temp['1'] == '1' ? 'M' : 'F';
        
        return $data;
    }
    
    
    /**
     * @param Request $request
     * @param array   $customer
     *
     * @return bool
     */
    public static function updatePolleoDB(Request $request, $customer)
    {
        try {
            DB::table('oc_customer')->where('email', $request['email'])
                ->update([
                    'firstname' => $request['firstname'],
                    'lastname'  => $request['lastname'],
                    'email'     => $request['email'],
                    'telephone' => $request['telephone'],
                    'birthday'  => $request['birthday'],
                    'sex'       => $request['sex'],
                ]);
            DB::table('oc_address')->where('customer_id', $customer['customer_id'])
                ->update([
                    'address'  => $request['address'],
                    'city'     => $request['city'],
                    'postcode' => $request['postcode'],
                ]);
        } catch (\Exception $exception) {
            Log::alert('Customer::update() error. Could not write to database.');
            
            return false;
        }
        
        return true;
    }
}
