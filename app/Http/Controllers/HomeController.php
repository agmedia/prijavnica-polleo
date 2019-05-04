<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    
    //
    
    public function index()
    {
        Session::forget('customer');
        Session::forget('error');
        
        return view('home');
    }
    
    
    public function enter()
    {
        $backgroundimage = 'images/login-screen.png';
        
        return view('enter', compact('backgroundimage'));
    }
}
