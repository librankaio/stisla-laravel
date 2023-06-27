<?php

namespace App\Http\Controllers;

use App\Models\Mcust;
use App\Models\Mitem;
use App\Models\Tposh;
use App\Models\Tposhd;
use Illuminate\Http\Request;

class ControllerTransPengeluaranBrg extends Controller
{
    public function index(){
        $customers = Mcust::select('id','code','name')->whereNull('deleted_at')->get();
        $items = Mitem::select('id','code','name','code_muom','price','code_mgrp','code_mwhse','note')->whereNull('deleted_at')->get();
        return view('pages.transaction.tpengeluaranbrg',[
            'customers' => $customers,
            'items' => $items
        ]);
    }
    public function list(){
        $tposhs = Tposh::select('id','no','tdt','code_mcust','disc','tax','grdtotal','note')->whereNull('deleted_at')->get();
        $tposhds = Tposhd::select('id','idh','code_mitem','qty','price','subtotal','note')->whereNull('deleted_at')->get();
        return view('pages.transaction.tpengeluaranbrglist',[
            'tposhs' => $tposhs,
            'tposhds' => $tposhds
        ]);
    }
}
