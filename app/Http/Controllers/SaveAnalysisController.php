<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SaveAnalysis;

class SaveAnalysisController extends Controller
{
	public function index()
	{
		return SaveAnalysis::all();
	}

	public function store(Request $request)
	{
		$data = $request->all();
		$save = SaveAnalysis::create($data);
		return $save;
	}

	public function show($id)
	{
		$save = SaveAnalysis::find($id);
		return $save;
	}

	public function update(Request $request, $id)
	{
		$data = $request->all();
		$save = SaveAnalysis::find($id);
		$save->update($data);
		return $save;
	}

	public function destroy($id)
	{
		$save = SaveAnalysis::find($id);
		$save->delete();
		return $save;
	}
}
