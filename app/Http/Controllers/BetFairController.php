<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BetFairController extends Controller
{
    public function login(Request $request){
        return $request->all();
    }
}
