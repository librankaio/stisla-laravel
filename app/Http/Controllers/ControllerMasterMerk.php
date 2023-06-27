<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ControllerMasterMerk extends Controller
{
    public function index(){
        return view('pages.master.mmerk');
    }
}
