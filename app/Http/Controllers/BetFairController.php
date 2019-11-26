<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;

class BetFairController extends Controller
{
    public $betURL = "https://api.betfair.com/exchange/account/rest/v1.0/";
    public function login(Request $request){
        $data = $request->all();

        $res = Curl::to("https://identitysso.betfair.com/api/login")
        ->withHeaders(['Accept'=>'application/json', 'X-Application' => 'BOW5JF3VnYo4rqkt', 'Content-Type' => 'application/x-www-form-urlencoded'])
        ->withData(['username'=>$data['username'], 'password'=>$data['password']])
        ->post();
        return $res;

    }

    // public function odds(){
    //     $res = Curl::to("https://api.betfair.com/exchange/betting/rest/v1.0/listMarketBook/")
    //     ->withHeaders(['Accept'=>'application/json', 'X-Application' => 'BOW5JF3VnYo4rqkt',
    //      'X-Authentication'=>'raqrkQKhVcv7W05nSn7KumGoIaK9fHeIHj5FJTl4Cls=', 'Content-Type' => 'application/json'])
    //     ->withData("marketIds":["' . $marketId . '"], "priceProjection":{"priceData":["EX_BEST_OFFERS"]})
    //     ->post();
    //     return $res;
    // }
}
