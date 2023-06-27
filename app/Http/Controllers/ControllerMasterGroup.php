<?php

namespace App\Http\Controllers;

use App\Models\Mgrp;
use Illuminate\Http\Request;

class ControllerMasterGroup extends Controller
{
    public function index(){
        $datas = Mgrp::select('id','code','name')->whereNull('deleted_at')->get();
        return view('pages.master.mgroup',[
            'datas' => $datas
        ]);
    }

    public function post(Request $request){
        $checkexist = Mgrp::select('id','code','name')->where('code','=', $request->kode)->first();
        if($checkexist == null){
            Mgrp::create([
                'code' => $request->kode,
                'name' => $request->nama,
            ]);
            return redirect()->back();
        }else{
            return redirect()->back();
        }
    }

    public function getedit(Mgrp $mgrp){
        return view('pages.master.mgroupedit',[ 'mgrp' => $mgrp]);
    }

    public function update(Mgrp $mgrp){
        Mgrp::where('id', '=', $mgrp->id)->update([
            'code' => request('kode'),
            'name' => request('nama'),
        ]);

        return redirect()->route('mgrup');
    }

    public function delete(Mgrp $mgrp){
        Mgrp::find($mgrp->id)->delete();
        return redirect()->route('mgrup');

        // $item = Mgrp::where('id','=',$mgrp->id)->get();
        // foreach($item as $data){
        //     $itemname = $data->name;
        // }
        // $pembelian = Tpembeliand::select('code_muom')->where('code_muom','=',$itemname)->whereNull('deleted_at')->first();
        // $pos = Tposhd::select('code_muom')->where('code_muom','=',$itemname)->whereNull('deleted_at')->first();
        // // dd($pembelian);
        // $havetrans = 0;
        // if($pembelian != null || $pos != null){
        //     $havetrans = 1;
        // }

        // if($havetrans == 0){
        //     Mgrp::find($mgrp->id)->delete();
        //     return redirect()->route('mgrup')->with('success','Data Berhasil Di Hapus');
        // }else{
        //     return redirect()->route('mgrup')->with('error','Tidak dapat menghapus data, karena data ada di dalam transaksi lainnya');
        // }
    }
}
