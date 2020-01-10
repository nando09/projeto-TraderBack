<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

use PeterColes\Betfair\Betfair;
use \DateTime;
use SportMonks\API\HTTPClient as SportMonksAPI;
use SportMonks\API\Utilities\Auth;
use Ixudra\Curl\Facades\Curl;
use App\SaveAnalysis;

class saveEvent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'day:insert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Insere Evento por tres dias';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
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
