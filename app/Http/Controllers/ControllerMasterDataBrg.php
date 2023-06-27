<?php

namespace App\Http\Controllers;

use App\Models\Mgrp;
use App\Models\Mitem;
use App\Models\Muom;
use App\Models\Mwhse;
use App\Models\Tpembeliand;
use App\Models\Tposh;
use App\Models\Tposhd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ControllerMasterDataBrg extends Controller
{   
    public function home(){
        return view('layouts.home');
    }

    public function index(){
        $datas = Mitem::select('id','code','name','code_muom','price','price2','code_mgrp','code_mwhse','admin_id','note')->whereNull('deleted_at')->get();
        $muoms = Muom::select('id','code','name')->whereNull('deleted_at')->get();
        $mgrps = Mgrp::select('id','code','name')->whereNull('deleted_at')->get();
        $mwhses = Mwhse::select('id','code','name', 'location')->whereNull('deleted_at')->get();
        return view('pages.master.mdatabrg',[
            'datas' => $datas,
            'muoms' => $muoms,
            'mgrps' => $mgrps,
            'mwhses' => $mwhses
        ]);
    }

    public function post(Request $request){
        // dd($request->file('upload')->hashname());        
        $checkexist = Mitem::select('id','code','name')->where('code','=', $request->kode)->first();
        // dd($checkexist);
        if($checkexist == null){
            if($request->upload != null){
                $request->file('upload')->store('images');
                Mitem::create([
                    'code' => $request->kode,
                    'name' => $request->nama,
                    'code_muom' => $request->satuan,
                    'price' => (float) str_replace(',', '', $request->hrgbeli),
                    'price2' => (float) str_replace(',', '', $request->hrgjual),
                    'code_mgrp' => $request->itemgrp,
                    'code_mwhse' => $request->lokasi,
                    'img' => $request->file('upload')->hashname() ,
                    'note' => $request->note,
                ]);
                return redirect()->back();
            }
            Mitem::create([
                'code' => $request->kode,
                'name' => $request->nama,
                'code_muom' => $request->satuan,
                'price' => (float) str_replace(',', '', $request->hrgbeli),
                'price2' => (float) str_replace(',', '', $request->hrgjual),
                'code_mgrp' => $request->itemgrp,
                'code_mwhse' => $request->lokasi,
                'note' => $request->note,
            ]);
            return redirect()->back();
        }else{
            return redirect()->back();
        }        
    }

    public function getedit(Mitem $mitem){
        $muoms = Muom::select('id','code','name')->whereNull('deleted_at')->get();
        $mgrps = Mgrp::select('id','code','name')->whereNull('deleted_at')->get();
        $mwhses = Mwhse::select('id','code','name', 'location')->whereNull('deleted_at')->get();
        return view('pages.master.mdatabrgedit',[ 
            'mitem' => $mitem,
            'muoms' => $muoms,
            'mgrps' => $mgrps,
            'mwhses' => $mwhses,
        ]);
    }

    public function update(Mitem $mitem){
        // dd(request()->all());
        if(request('upload') != null){
            $filename = request('hdnupload');
            if(Storage::exists('images/'.$filename)){
                Storage::delete('images/'.$filename);
                // dd("success delete");
                /*
                Delete Multiple File like this way
                    Storage::delete(['upload/test.png', 'upload/test2.png']);
                */
            }
            request()->file('upload')->store('images');
            Mitem::where('id', '=', $mitem->id)->update([
                'code' => request('kode'),
                'name' => request('nama'),
                'code_muom' => request('satuan'),
                'price' => (float) str_replace(',', '', request('hrgbeli')),
                'price2' => (float) str_replace(',', '', request('hrgjual')),
                'code_mgrp' => request('itemgrp'),
                'img' => request()->file('upload')->hashname(),
                'code_mwhse' => request('lokasi'),
                'note' => request('note'),
            ]);

            return redirect()->route('mbrg');
        }
        Mitem::where('id', '=', $mitem->id)->update([
            'code' => request('kode'),
            'name' => request('nama'),
            'code_muom' => request('satuan'),
            'price' => (float) str_replace(',', '', request('hrgbeli')),
            'price2' => (float) str_replace(',', '', request('hrgjual')),
            'code_mgrp' => request('itemgrp'),
            'code_mwhse' => request('lokasi'),
            'note' => request('note'),
        ]);

        return redirect()->route('mbrg');        
    }

    public function delete(Mitem $mitem){
        $item = Mitem::where('id','=',$mitem->id)->get();
        foreach($item as $data){
            $itemname = $data->name;
        }
        $pembelian = Tpembeliand::select('name_mitem')->where('name_mitem','=',$itemname)->whereNull('deleted_at')->first();
        $pos = Tposhd::select('name_mitem')->where('name_mitem','=',$itemname)->whereNull('deleted_at')->first();
        
        $havetrans = 0;
        if($pembelian != null || $pos != null){
            $havetrans = 1;
        }

        if($havetrans == 0){
            Mitem::find($mitem->id)->delete();
            return redirect()->route('mbrg')->with('success','Data Berhasil Di Hapus');
        }else{
            return redirect()->route('mbrg')->with('error','Tidak dapat menghapus data, karena data ada di dalam transaksi lainnya');
        }
    }
}
