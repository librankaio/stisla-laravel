<?php

namespace App\Http\Controllers;

use App\Models\Mmatauang;
use App\Models\Tbayaropsh;
use App\Models\Tjurnalvouchh;
use App\Models\Tpembelianh;
use App\Models\Tposh;
use Illuminate\Http\Request;

class ControllerMasterMataUang extends Controller
{
    public function index(Mmatauang $mmatauang){
        // $datas = DB::table('muom')->select('code','name','id')->get();
        $datas = Mmatauang::select('id','code','name')->whereNull('deleted_at')->get();
        // dd($datas);
        return view('pages.master.mmatauang',[
            'datas' => $datas,
        ]);
    }

    public function post(Request $request){
        $checkexist = Mmatauang::select('id','code','name')->where('code','=', $request->kode)->first();
        if($checkexist == null){
            Mmatauang::create([
                'code' => $request->kode,
                'name' => $request->nama,
            ]);
            return redirect()->back();
        }else{
            return redirect()->back();
        }
    }

    public function getedit(Mmatauang $mmatauang){
        // dd($muom);
        return view('pages.master.mmatauangedit',[ 'mmatauang' => $mmatauang]);
    }

    public function update(Mmatauang $mmatauang){
        // dd(request()->all());
        Mmatauang::where('id', '=', $mmatauang->id)->update([
            'code' => request('kode'),
            'name' => request('nama'),
        ]);

        return redirect()->route('mmatauang');
    }

    public function delete(Mmatauang $mmatauang){
        // Mmatauang::find($mmatauang->id)->delete();
        // return redirect()->route('mmatauang');

        $item = Mmatauang::where('id','=',$mmatauang->id)->get();
        foreach($item as $data){
            $itemname = $data->name;
        }
        $pembelian = Tpembelianh::select('mata_uang')->where('mata_uang', 'like', '%' . $itemname . '%')->whereNull('deleted_at')->first();
        $pos = Tposh::select('mata_uang')->where('mata_uang', 'like', '%' . $itemname . '%')->whereNull('deleted_at')->first();
        $bayarops = Tbayaropsh::select('mata_uang')->where('mata_uang', 'like', '%' . $itemname . '%')->whereNull('deleted_at')->first();
        $jurnal_vouch = Tjurnalvouchh::select('mata_uang')->where('mata_uang', 'like', '%' . $itemname . '%')->whereNull('deleted_at')->first();
        // dd($pembelian);
        
        $havetrans = 0;
        if($pembelian != null || $pos != null || $bayarops != null || $jurnal_vouch != null){
            $havetrans = 1;
        }

        if($havetrans == 0){
            Mmatauang::find($mmatauang->id)->delete();
            return redirect()->route('mmatauang')->with('success','Data Berhasil Di Hapus');
        }else{
            return redirect()->route('mmatauang')->with('error','Tidak dapat menghapus data, karena data ada di dalam transaksi lainnya');
        }
    }
}
