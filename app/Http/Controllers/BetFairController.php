<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Ixudra\Curl\Facades\Curl;
use PeterColes\Betfair\Betfair;
use \DateTime;

class BetFairController extends Controller
{
    public function login(Request $request){
        $data = $request->all();

        $token = Betfair::auth()->login('BOW5JF3VnYo4rqkt', $data['username'], $data['password']);
        Cache::put('betfairToken', $token, \PeterColes\Betfair\Api\Auth::SESSION_LENGTH);

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
                Betfair::auth()->persist('BOW5JF3VnYo4rqkt', $data['token']);
                $res = Betfair::betting('listEvents', $filter);
            } catch (Exception $e){
                return $e;
            }
//        $res = json_decode($res);
        foreach($res as $key => $game){
            $res2 = Curl::to('https://ips.betfair.com/inplayservice/v1/eventTimelines?_ak=nzIFcwyWhrlwYMrh&alt=json&eventIds='.$game->event->id.'&locale=pt')->get();
            $res[$key]->info = json_decode($res2);
        }
        // $res->status = true;
        return $res;

    }

    public function getNextGames(Request $request){
//        date_default_timezone_set('UTC');

        $data = $request->all();
        $from = new DateTime('now + 2 hour');
        $to = new DateTime('now');
        // return $from;
        // return date('Y-m-dTh:i:sZ', mktime(23,59,59));
        $filter = array(
            "filter" => array(
                "eventTypeIds"=>[1],
                "locale"=>"Portuguese",
                "marketStartTime"=>array(
                    "from"=>$from->setTimeZone(new \DateTimeZone('America/Sao_Paulo'))->format("Y-m-d\TH:i:s").'Z',
                    "to"=>$to->setTime(23, 45)->setTimeZone(new \DateTimeZone('America/Sao_Paulo'))->format("Y-m-d\TH:i:s").'Z'
                    )
                ),
            // "marketProjection"=>[ "EVENT"]
        );
        try {
            Betfair::auth()->persist('BOW5JF3VnYo4rqkt', $data['token']);
            $res = Betfair::betting('listEvents', $filter);

            } catch (Exception $e){
                return $e;
            }
            $res = array_reverse($res);
            return (array) $res;
        }

        public function getByDate($date, $token){
            try{

                $filter = array(
                    "filter" => array(
                        "eventTypeIds"=>[1],
                        "locale"=>"Portuguese",
                        "marketStartTime"=>array(
                            "from"=>$date->setTime(0, 0)->setTimeZone(new \DateTimeZone('GMT'))->format("Y-m-d\TH:i:s").'Z',
                            "to"=>$date->setTime(23, 45)->setTimeZone(new \DateTimeZone('GMT'))->format("Y-m-d\TH:i:s").'Z',
                        )
                    ),
                    "maxResults"=>20
                    // "marketProjection"=>[ "EVENT"]
                );
                Betfair::auth()->persist('BOW5JF3VnYo4rqkt', $token);
                $res = Betfair::betting('listEvents', $filter);
                usort($res , function ($a, $b){
                    if(strtotime($a->event->openDate) > strtotime($b->event->openDate)){
                        return 1;
                    }
                    if(strtotime($a->event->openDate) < strtotime($b->event->openDate)){
                        return -1;
                    }
                    else {
                        return 0;
                    }
                });
                $gameIds = [];
                foreach($res as $event){
                    array_push($gameIds, $event->event->id);
                }
                $filter2 = [
                    "filter"=>[
                        "marketTypeCodes"=>["BOTH_TEAMS_TO_SCORE", "FIRST_HALF_GOALS_05","FIRST_HALF_GOALS_15","FIRST_HALF_GOALS_25","OVER_UNDER_05","OVER_UNDER_15","OVER_UNDER_25","OVER_UNDER_35","MATCH_ODDS"],
                        "eventTypeIds"=>[1],
                        "locale"=>"Portuguese",
                        "eventIds"=>$gameIds,
                    ],
                    "maxResults"=>1000,
                    "marketProjection"=>["EVENT"]
                ];
                $res2 = Betfair::betting('listMarketCatalogue', $filter2);
                $contador = 0;
                $tempMarkets = [];
                foreach($res2 as $key => $market){
                    array_push($tempMarkets, $market->marketId);
                    if(count($tempMarkets) == 4){
                        $filter3 = [
                            "marketIds"=>$tempMarkets,
                            "priceProjection"=>[
                                "priceData"=>["EX_BEST_OFFERS"]
                            ]
                        ];
                        $odd = Betfair::betting('listMarketBook', $filter3);
                        foreach( $odd as $tempOdd){
                            foreach( $res2 as $keyRes => $tempMarket){
                                if($tempOdd->marketId == $tempMarket->marketId){
                                    $res2[$keyRes]->odds = $tempOdd;
                                }
                            }
                        }
                        $tempMarkets = [];
                    }

                }
                foreach($res as $key => $event){
                    $arr = [];
                    foreach($res2 as $market){
                        if($event->event->id == $market->event->id){
                            array_push($arr, $market);
                        }
                    }
                    $res[$key]->market = $arr;

                    // $res[$key]->market = array_chunk($res2, 7)[$key];
                }

                return $res;
            } catch(Exception $e) {
                return $e;
            }
        }

        public function tomorrowOdds(Request $request){
            $data = $request->all();
            $tomorrow = new \DateTime('tomorrow', new \DateTimeZone('America/Sao_Paulo'));
            return $this->getByDate($tomorrow, $data['token']);
        }

        public function nextOdds(Request $request){
            $data = $request->all();
            $day = new \DateTime('today + 2 days', new \DateTimeZone('America/Sao_Paulo'));
            return $this->getByDate($day, $data['token']);
        }

        public function todayOdds(Request $request){
            $data = $request->all();
            $today = new \DateTime('today', new \DateTimeZone('America/Sao_Paulo'));
            return $this->getByDate($today, $data['token']);
        }

}
