<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /**
     * Set some basic user session data.
     *
     * @param $data
     */
    public static function setUserSessionData($data)
    {
        $user = $data;
        $user['address'] = DB::table('oc_address')->where('customer_id', $user['customer_id'])->first();
        $user = self::setCustomFieldUserData($user);

        session(['user' => $user]);
    }


    /**
     * Set Custom fields user data.
     *
     * @param $data
     * @return bool
     */
    private static function setCustomFieldUserData($data)
    {
        if ( ! isset($data['custom_field']))
            return false;

        $temp = json_decode($data['custom_field'], true);

        $data['birthday'] = $temp['3'];
        $data['sex'] = $temp['1'] == '1' ? 'M' : 'F';

        return $data;
    }
}
