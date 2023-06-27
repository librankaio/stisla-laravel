<?php

namespace App\Http\Controllers;

use App\Models\Mcust;
use App\Models\Vpembelian;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControllerReportPenjualan extends Controller
{
    public function index(){
        $customers = Mcust::select('id','code','name')->whereNull('deleted_at')->get();
        
        return view('pages.reports.reportpenjualan',[
            'customers' => $customers,
        ]);
    }

    public function post(Request $request){
        // dd($request->all());
        $dtfr = $request->input('dtfr');
        $dtto = $request->input('dtto');
        $customer = $request->input('customer');
        $customers = Mcust::select('id','code','name')->whereNull('deleted_at')->get();
        $results = DB::select('CALL prPenjualan (?,?,?)', [$dtfr, $dtto, $customer]);

        // dd($results);
        return view('pages.reports.reportpenjualan', compact('customers','results', 'dtfr', 'dtto'));
    }
}
