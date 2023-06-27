<?php

namespace App\Http\Controllers;

use App\Models\Msupp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControllerReportPembelian extends Controller
{
    public function index(){
        $suppliers = Msupp::select('id','code','name')->whereNull('deleted_at')->get();
        return view('pages.reports.reportpembelian',[
            'suppliers' => $suppliers
        ]);
    }

    public function post(Request $request){
        // dd($request->all());
        $dtfr = $request->input('dtfr');
        $dtto = $request->input('dtto');
        $supplier = $request->input('supplier');
        $suppliers = Msupp::select('id','code','name')->whereNull('deleted_at')->get();
        $results = DB::select('CALL prPembelian (?,?,?)', [$dtfr, $dtto, $supplier]);

        // dd($results);
        return view('pages.reports.reportpembelian', compact('suppliers','results', 'dtfr', 'dtto'));
    }
}
