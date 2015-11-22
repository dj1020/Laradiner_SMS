<?php

namespace App\Http\Controllers;

use App\Events\SendSMSEvent;
use App\Sms\Mitake_SMS;
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

        // 這裡和 Laravel 的 Event 系統綁太緊，變成要送簡訊一定要 fire a event
        Event::fire(new SendSMSEvent($data, new Mitake_SMS($this->apiKey)));

        // 挑戰 4：如果我不想使用 Event 系統來發簡訊的話怎麼辦？
        // Solution: 關注點分離，解耦合，Decoupling Handler，把傳 SMS 的
        //           處理程序移到別的 class 裡，做為獨立的 service。

    }
}
