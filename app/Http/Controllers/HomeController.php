<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    //

    public function index()
    {
        Session::forget('user');

        return view('home');
    }


    public function enter()
    {
        $backgroundimage = 'images/login-screen.png';

        return view('enter', compact('backgroundimage'));
    }
}
