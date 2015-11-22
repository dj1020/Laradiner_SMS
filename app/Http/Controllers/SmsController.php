<?php

namespace App\Http\Controllers;

use App;
use App\Events\SendSMSEvent;
use App\Sms\Mitake_SMS;
use App\Sms\SmsCourierInterface;
use Event;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SmsController extends Controller
{
    private $apiKey = "some_random_string_here_adfqweradf";

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
        $data['user']['id'] = \App\User::first()->id;

        App::instance(SmsCourierInterface::class, new Mitake_SMS($this->apiKey));

        Event::fire(new SendSMSEvent($data));
    }
}
