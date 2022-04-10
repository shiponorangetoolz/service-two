<?php

namespace App\Http\Controllers;

class RedisController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function redis()
    {
//        app('redis')->set('token', '1235');
        $token = app('redis')->get('token');
        if (app('redis')->exists('token')) {
            dd($token);
        }else {
            dd('Token redis expired');
        }
    }

    //
}
