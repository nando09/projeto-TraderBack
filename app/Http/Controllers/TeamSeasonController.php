<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeamSeasonController extends Controller
{
	public function estatistica(){
		$teste = [
					"team_id" => 9,
					"season_id" => 16036,
					"stage_id" => 77443862,
					"win" => [
						"total" => 8,
						"home" => 4,
						"away" => 4,
						"porcTotal" => 0,
						"porcHome" => 0,
						"porcAway" => 0
					],
					"draw" => [
						"total" => 1,
						"home" => 1,
						"away" => 0,
						"porcTotal" => 0,
						"porcHome" => 0,
						"porcAway" => 0
					],
					"lost" => [
						"total" => 2,
						"home" => 1,
						"away" => 1,
						"porcTotal" => 0,
						"porcHome" => 0,
						"porcAway" => 0
					],
					"goals_for" => [
						"total" => 34,
						"home" => 19,
						"away" => 15
					],
					"goals_against" => [
						"total" => 10,
						"home" => 5,
						"away" => 5
					],
					"clean_sheet" => [
						"total" => 5,
						"home" => 3,
						"away" => 2
					],
					"failed_to_score" => [
						"total" => 1,
						"home" => 1,
						"away" => 0
					],
					"scoring_minutes" => [
						[
							"period" => [
								[
									"minute" => "0-15",
									"count" => 6,
									"percentage" => 17.6
								],
								[
									"minute" => "15-30",
									"count" => 4,
									"percentage" => 11.8
								],
								[
									"minute" => "30-45",
									"count" => 6,
									"percentage" => 17.6
								],
								[
									"minute" => "45-60",
									"count" => 5,
									"percentage" => 14.7
								],
								[
									"minute" => "60-75",
									"count" => 6,
									"percentage" => 17.6
								],
								[
									"minute" => "75-90",
									"count" => 7,
									"percentage" => 20.6
								]
							]
						]
					],
					"goals_conceded_minutes" => [
						[
							"period" => [
								[
									"minute" => "0-15",
									"count" => 1,
									"percentage" => 10
								],
								[
									"minute" => "15-30",
									"count" => 3,
									"percentage" => 30
								],
								[
									"minute" => "30-45",
									"count" => 2,
									"percentage" => 20
								],
								[
									"minute" => "45-60",
									"count" => 2,
									"percentage" => 20
								],
								[
									"minute" => "60-75",
									"count" => 0,
									"percentage" => 0
								],
								[
									"minute" => "75-90",
									"count" => 2,
									"percentage" => 20
								]
							]
						]
					],
					"avg_goals_per_game_scored" => [
						"total" => 3.09,
						"home" => 3.17,
						"away" => 3
					],
					"avg_goals_per_game_conceded" => [
						"total" => 0.91,
						"home" => 0.83,
						"away" => 1
					],
					"avg_first_goal_scored" => [
						"total" => "29m",
						"home" => "28m",
						"away" => "30m"
					],
					"avg_first_goal_conceded" => [
						"total" => "35m",
						"home" => "32m",
						"away" => "39m"
					],
					"attacks" => 1429,
					"dangerous_attacks" => 945,
					"avg_ball_possession_percentage" => "65.45",
					"fouls" => 112,
					"avg_fouls_per_game" => "10.18",
					"offsides" => 26,
					"redcards" => 1,
					"yellowcards" => 24,
					"shots_blocked" => null,
					"shots_off_target" => 132,
					"avg_shots_off_target_per_game" => "12.00",
					"shots_on_target" => 86,
					"avg_shots_on_target_per_game" => "7.82",
					"avg_corners" => "8.82",
					"total_corners" => 97,
					"btts" => 45.45,
					"goal_line" => [
						"over" => [
							"0_5" => [
								"home" => 83.33,
								"away" => 100
							],
							"1_5" => [
								"home" => 83.33,
								"away" => 100
							],
							"2_5" => [
								"home" => 50,
								"away" => 60
							],
							"3_5" => [
								"home" => 33.33,
								"away" => 20
							],
							"4_5" => [
								"home" => 16.67,
								"away" => 20
							],
							"5_5" => [
								"home" => 16.67,
								"away" => 0
							]
						],
						"under" => [
							"0_5" => [
								"home" => 0,
								"away" => 0
							],
							"1_5" => [
								"home" => 0,
								"away" => 0
							],
							"2_5" => [
								"home" => 16.67,
								"away" => 20
							],
							"3_5" => [
								"home" => 50,
								"away" => 20
							],
							"4_5" => [
								"home" => 100,
								"away" => 60
							],
							"5_5" => [
								"home" => 83.33,
								"away" => 100
							]
						]
					]
				];

		$win = $this->win($teste);

		// "porcHome" => 0,
		// "porcAway" => 0

		// "porcHome" => 0,
		// "porcAway" => 0

		// "porcHome" => 0,
		// "porcAway" => 0

		$teste['win']['porcTotal']		=	$win['vitoria'];
		$teste['lost']['porcTotal']		=	$win['empate'];
		$teste['draw']['porcTotal']		=	$win['derrota'];

		$teste['win']['porcHome']		=	$win['vitoriaCasa'];
		$teste['win']['porcAway']		=	$win['vitoriaFora'];

		$teste['lost']['porcHome']		=	$win['empateCasa'];
		$teste['lost']['porcAway']		=	$win['empateFora'];

		$teste['draw']['porcHome']		=	$win['derrotaCasa'];
		$teste['draw']['porcAway']		=	$win['derrotaFora'];

		// return $win;
		return $teste;
	}

	public function win($win){
		$vitoria 	= $win['win'];
		$empate 	= $win['lost'];
		$derrota 	= $win['draw'];

		$totalJogos = $vitoria['total'] + $empate['total'] + $derrota['total'];
		$totalJogosFora = $vitoria['away'] + $empate['away'] + $derrota['away'];
		$totalJogosCasa = $vitoria['home'] + $empate['home'] + $derrota['home'];

		$vitoriaCentagem = ((100 / $totalJogos) * $vitoria['total']);
		$empateCentagem = ((100 / $totalJogos) * $empate['total']);
		$derrotaCentagem = ((100 / $totalJogos) * $derrota['total']);

		$vitoriaCasaCentagem = ((100 / $totalJogosCasa) * $vitoria['home']);
		$vitoriaForaCentagem = ((100 / $totalJogosFora) * $vitoria['away']);

		$empateCasaCentagem = ((100 / $totalJogosCasa) * $empate['home']);
		$empateForaCentagem = ((100 / $totalJogosFora) * $empate['away']);

		$derrotaCasaCentagem = ((100 / $totalJogosCasa) * $derrota['home']);
		$derrotaForaCentagem = ((100 / $totalJogosFora) * $derrota['away']);

		return [
			'vitoria'		=>	$vitoriaCentagem,
			'empate'		=>	$empateCentagem,
			'derrota'		=>	$derrotaCentagem,
			'vitoriaCasa'	=>	$vitoriaCasaCentagem,
			'vitoriaFora'	=>	$vitoriaForaCentagem,

			'empateCasa'	=>	$empateCasaCentagem,
			'empateFora'	=>	$empateForaCentagem,

			'derrotaCasa'	=>	$derrotaCasaCentagem,
			'derrotaFora'	=>	$derrotaForaCentagem,
		];

		return [
			'vitoria'	=>	round($vitoriaCentagem),
			'empate'	=>	round($empateCentagem),
			'derrota'	=>	round($derrotaCentagem),
		];
	}

	public function index(){
	}

	public function store(Request $request){
	}

	public function show($id)
	{
	}

	public function update(Request $request, $id)
	{
	}

	public function destroy($id)
	{
	}
}
