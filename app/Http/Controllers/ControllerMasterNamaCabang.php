<?php

namespace App\Http\Controllers;

use App\Models\Mnamacabang;
use Illuminate\Http\Request;

class ControllerMasterNamaCabang extends Controller
{
    public function index(Mnamacabang $mnamacabang){
        $datas = Mnamacabang::select('id','code','name','address')->whereNull('deleted_at')->get();
        return view('pages.master.mnamacabang',[
            'datas' => $datas
        ]);
    }

    public function post(Request $request){
        // dd($request->all());
        $checkexist = Mnamacabang::select('id','code','name')->where('code','=', $request->kode)->first();
        if($checkexist == null){
            Mnamacabang::create([
                'code' => $request->kode,
                'name' => $request->name,
                'address' => $request->alamat,
            ]);
            return redirect()->back();
        }else{
            return redirect()->back();
        }
    }

    public function getedit(Mnamacabang $mnamacabang){
        // dd($mnamacabang);
        return view('pages.master.mnamacabangedit',[ 'mnamacabang' => $mnamacabang]);
    }

    public function update(Mnamacabang $mnamacabang){
        // dd(request()->all());
        Mnamacabang::where('id', '=', $mnamacabang->id)->update([
            'code' => request('kode'),
            'name' => request('name'),
            'address' => request('alamat'),
        ]);

        return redirect()->route('mnamacabang');
    }

    public function delete(Mmatauang $mmatauang){
        // Mmatauang::find($mmatauang->id)->delete();
        // return redirect()->route('mmatauang');

        // $item = Mmatauang::where('id','=',$mmatauang->id)->get();
        // foreach($item as $data){
        //     $itemname = $data->name;
        // }
        // $pembelian = Tpembelianh::select('mata_uang')->where('mata_uang', 'like', '%' . $itemname . '%')->whereNull('deleted_at')->first();
        // $pos = Tposh::select('mata_uang')->where('mata_uang', 'like', '%' . $itemname . '%')->whereNull('deleted_at')->first();
        // $bayarops = Tbayaropsh::select('mata_uang')->where('mata_uang', 'like', '%' . $itemname . '%')->whereNull('deleted_at')->first();
        // $jurnal_vouch = Tjurnalvouchh::select('mata_uang')->where('mata_uang', 'like', '%' . $itemname . '%')->whereNull('deleted_at')->first();
        // // dd($pembelian);
        
        // $havetrans = 0;
        // if($pembelian != null || $pos != null || $bayarops != null || $jurnal_vouch != null){
        //     $havetrans = 1;
        // }

        // if($havetrans == 0){
        //     Mmatauang::find($mmatauang->id)->delete();
        //     return redirect()->route('mmatauang')->with('success','Data Berhasil Di Hapus');
        // }else{
        //     return redirect()->route('mmatauang')->with('error','Tidak dapat menghapus data, karena data ada di dalam transaksi lainnya');
        // }
    }
}
