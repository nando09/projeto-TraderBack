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

    public function eventsURL(){ return "https://api.betfair.com/exchange/betting/rest/v1.0/";}

    public function getLiveEvents(Request $request){
        $data = $request->all();
        $filter = array(
            "filter" => array(
                "eventTypeIds"=>[1],
                "inPlayOnly"=>true
            )
        );
        try {
            $res = Curl::to($this->eventsURL()."listEvents/")
            ->withHeaders([
                'Accept'=>'application/json',
                'X-Application' => 'BOW5JF3VnYo4rqkt',
                'X-Authentication' => strval($data['token']),
                'Content-Type' => 'application/json'
            ])
            ->withData(
                $filter
            )
            ->asJsonRequest()
            ->post();
        } catch (Exception $e){
            return $e;
        }
        $res = json_decode($res);
        foreach($res as $key => $game){
            $res2 = Curl::to('https://ips.betfair.com/inplayservice/v1/eventTimelines?_ak=nzIFcwyWhrlwYMrh&alt=json&eventIds='.$game->event->id.'&locale=pt')->get();
            $res[$key]->info = json_decode($res2);
        }
        // $res->status = true;
        return $res;

    }

    public function getNextGames(Request $request){
        date_default_timezone_set('UTC');
        $data = $request->all();
        $fromDate = date("Y-m-d");
        $fromTime = date("H:i");
        $from = strval($fromDate)."T".strval($fromTime).":00Z";
        $toDate = date("Y-m-d", mktime(23,59,59,date("n"),date("j"),date("Y")));
        $toTime = date("H:i", mktime(23,59,59,date("n"),date("j"),date("Y")));
        $to = strval($toDate)."T".strval($toTime).":00Z";
        // return $from;
        // return date('Y-m-dTh:i:sZ', mktime(23,59,59));
        $filter = array(
            "filter" => array(
                "eventTypeIds"=>[1],
                "locale"=>"Portuguese",
                "marketStartTime"=>array(
                    "from"=>$from,
                    "to"=>$to
                    )
                ),
            "maxResults"=>20
            // "marketProjection"=>[ "EVENT"]
        );
        try {
            $res = Curl::to($this->eventsURL().'listEvents/')
            ->withHeaders([
                'Accept'=>'application/json',
                'X-Application' => 'BOW5JF3VnYo4rqkt',
                'X-Authentication' => strval($data['token']),
                'Content-Type' => 'application/json'
            ])
            ->withData(
                $filter
            )
            ->asJsonRequest()
            ->post();

        } catch (Exception $e){
            return $e;
        }
        $res = json_decode($res);
        $res = array_reverse($res);
        return $res;
    }
}
