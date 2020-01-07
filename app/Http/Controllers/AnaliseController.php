<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PeterColes\Betfair\Betfair;
use \DateTime;
use SportMonks\API\HTTPClient as SportMonksAPI;
use SportMonks\API\Utilities\Auth;
use Ixudra\Curl\Facades\Curl;

class AnaliseController extends Controller
{
    public function analise(Request $request){

        // $apiToken = 'j0cIIxOa92FPRtFAM2vPbbXi7SQhMbiJ51xzAG2p5MXekrdrBeYIT3oTYdWF';
        // $data = $request->all();
        // $teams = explode(' v ',$data->event->name);
        // $home = $teams[0];
        // $away = $teams[1];
        // return $data;
        // $seasons = Curl::to("https://soccer.sportmonks.com/api/v2.0/seasons?api_token=".$apiToken)->get();
        // $seasons = json_decode($seasons);
        // foreach ($seasons->data as $season){
        //     if($season->is_current_season){
        //         $currentSeason =  $season;
        //     }
        // }
        // $seasonTeams = Curl::to('https://soccer.sportmonks.com/api/v2.0/teams/season/'.$currentSeason->id.'?api_token='.$apiToken)->get();
        // $currentSeason->id
        // return $seasonTeams;
        // j0cIIxOa92FPRtFAM2vPbbXi7SQhMbiJ51xzAG2p5MXekrdrBeYIT3oTYdWF


    }
}
