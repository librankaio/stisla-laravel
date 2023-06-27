<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ControllerReportStock extends Controller
{
    public function index(){
        return view('pages.reports.reportstock');
    }
}
