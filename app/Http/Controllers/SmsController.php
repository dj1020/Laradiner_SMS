<?php

namespace App\Http\Controllers;

use App\Events\SendSMSEvent;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SmsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function send(Request $request)
    {
        $data = $request->except('_token');
//        $data['user']['id'] = \App\User::first()->id;

        event(new SendSMSEvent($data));
    }
}
