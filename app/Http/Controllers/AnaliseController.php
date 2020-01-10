<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PeterColes\Betfair\Betfair;
use \DateTime;
use SportMonks\API\HTTPClient as SportMonksAPI;
use SportMonks\API\Utilities\Auth;
use Ixudra\Curl\Facades\Curl;
use App\SaveAnalysis;
use Illuminate\Support\Facades\DB;

class AnaliseController extends Controller
{
	public function analise(Request $request){

		// return [
		//     'status'    =>  true
		// ];

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

	// public function teste(){
	public function teste(){
        $array = [];
        $data = 'uJFjXIQnft4+KO8+edqJ/on2qhCpcGn1fnlvip850RM=';
        $tomorrow = new \DateTime('tomorrow', new \DateTimeZone('America/Sao_Paulo'));
        $event = $this->getByDate($tomorrow, $data);

        foreach ($event as $key => $value) {
            $data = [];
            // $data['id']             =   $value->event->id;
            $data['name']           =   $value->event->name;
            $data['created_at']     =   NOW();
            $data['updated_at']     =   NOW();
            array_push($array, $data);

            break;
        }

        DB::table('save_analyses')->insert($array);
        return $array;

		// $data = 'uJFjXIQnft4+KO8+edqJ/on2qhCpcGn1fnlvip850RM=';
		// $tomorrow = new \DateTime('tomorrow', new \DateTimeZone('America/Sao_Paulo'));
		// $reto = $this->getByDate($tomorrow, $data);
		// $retorno = $this->setSaveAnalysis($reto);
		// // foreach ($reto as $key => $value) {
		// //     echo "<pre>";
		// //     print_r($value->event->id);
		// //     echo "</pre>";
		// // }
		// // dd($reto[0]);
		// // return;
		// // return $reto;
		// dd($retorno);
		// return;
		// return $retorno;
	}

	public function setSaveAnalysis($event){
		$array = [];
		foreach ($event as $key => $value) {
			$data = [];
			$data['id']				=	$value->event->id;
			$data['name']			=	$value->event->name;
			$data['created_at']		=	NOW();
			$data['updated_at']		=	NOW();
			array_push($array, $data);
		}

		DB::table('save_analyses')->insert($array);
		return $array;
	}

	public function getByDate($date, $token){
		try{

			$filter = array(
				"filter" => array(
					// "competitionIds" => ["12205499", "81", "99", "55", "10932509", "9404054", "194215", "12204313", "35", "12010356", "12117172", "12204313"],
					"eventTypeIds"=>[1],
					"locale"=>"Portuguese",
					"marketStartTime"=>array(
						"from"=>$date->setTime(0, 0)->setTimeZone(new \DateTimeZone('GMT'))->format("Y-m-d\TH:i:s").'Z',
						"to"=>$date->setTime(23, 45)->setTimeZone(new \DateTimeZone('GMT'))->format("Y-m-d\TH:i:s").'Z',
					)
				),
				// "marketProjection"=>[ "EVENT"]
			);
			Betfair::auth()->persist('BOW5JF3VnYo4rqkt', $token);
			$res = Betfair::betting('listEvents', $filter);


			return $res;
		} catch(Exception $e) {
			return $e;
		}
	}
}
