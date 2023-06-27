<?php

namespace App\Http\Controllers;

use App\Models\Muom;
use App\Models\Tpembeliand;
use App\Models\Tposhd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControllerMasterSatuan extends Controller
{
    public function index(Muom $muom){
        // $datas = DB::table('muom')->select('code','name','id')->get();
        $datas = Muom::select('id','code','name')->whereNull('deleted_at')->get();
        // dd($datas);
        return view('pages.master.msatuan',[
            'datas' => $datas,
        ]);
    }

    public function post(Request $request){
        $checkexist = Muom::select('id','code','name')->where('code','=', $request->kode)->first();
        if($checkexist == null){
            Muom::create([
                'code' => $request->kode,
                'name' => $request->nama,
            ]);
            return redirect()->back();
        }else{
            return redirect()->back();
        }
    }

    public function getedit(Muom $muom){
        // dd($muom);
        return view('pages.master.msatuanedit',[ 'muom' => $muom]);
    }

    public function update(Muom $muom){
        // dd(request()->all());
        Muom::where('id', '=', $muom->id)->update([
            'code' => request('kode'),
            'name' => request('nama'),
        ]);

        return redirect()->route('msatuan');
    }

    public function delete(Muom $muom){
        // dd($muom);
        // Muom::find($muom->id)->delete();
        // return redirect()->route('msatuan');

        $item = Muom::where('id','=',$muom->id)->get();
        foreach($item as $data){
            $itemname = $data->name;
        }
        $pembelian = Tpembeliand::select('code_muom')->where('code_muom','=',$itemname)->whereNull('deleted_at')->first();
        $pos = Tposhd::select('code_muom')->where('code_muom','=',$itemname)->whereNull('deleted_at')->first();
        // dd($pembelian);
        $havetrans = 0;
        if($pembelian != null || $pos != null){
            $havetrans = 1;
        }

        if($havetrans == 0){
            Muom::find($muom->id)->delete();
            return redirect()->route('msatuan')->with('success','Data Berhasil Di Hapus');
        }else{
            return redirect()->route('msatuan')->with('error','Tidak dapat menghapus data, karena data ada di dalam transaksi lainnya');
        }
    }
}
