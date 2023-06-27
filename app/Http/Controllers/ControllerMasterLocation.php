<?php

namespace App\Http\Controllers;

use App\Models\Mwhse;
use Illuminate\Http\Request;

class ControllerMasterLocation extends Controller
{
    public function index(Mwhse $mwhse){
        $datas = Mwhse::select('id','code','name')->whereNull('deleted_at')->get();
        return view('pages.master.mwhse',[
            'datas' => $datas,
        ]);
    }

    public function post(Request $request){
        $checkexist = Mwhse::select('id','code','name')->where('code','=', $request->kode)->first();
        if($checkexist == null){
            Mwhse::create([
                'code' => $request->kode,
                'name' => $request->nama,
                'location' => $request->lokasi,
            ]);
            return redirect()->back();
        }else{
            return redirect()->back();
        }
    }

    public function getedit(Mwhse $mwhse){
        return view('pages.master.mwhseedit',[ 'mwhse' => $mwhse]);
    }

    public function update(Mwhse $mwhse){
        Mwhse::where('id', '=', $mwhse->id)->update([
            'code' => request('kode'),
            'name' => request('nama'),
            'location' => request('lokasi'),
        ]);

        return redirect()->route('mwhse');
    }

    public function delete(Mwhse $mwhse){
        Mwhse::find($mwhse->id)->delete();
        return redirect()->route('mwhse');
    }
}
