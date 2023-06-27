<?php

namespace App\Http\Controllers;

use App\Models\Mbank;
use App\Models\Tbayaropsh;
use Illuminate\Http\Request;

class ControllerMasterBank extends Controller
{
    public function index(){
        $datas = Mbank::select('id','code','name','note')->whereNull('deleted_at')->get();
        return view('pages.master.mbank',[
            'datas' => $datas
        ]);
    }

    public function post(Request $request){
        $checkexist = Mbank::select('id','code','name')->where('code','=', $request->kode)->first();
        if($checkexist == null){
            Mbank::create([
                'code' => $request->kode,
                'name' => $request->nama,
                'note' => $request->note,
            ]);
            return redirect()->back();
        }else{
            return redirect()->back();
        }
    }

    public function getedit(Mbank $mbank){
        // dd($mbank);
        return view('pages.master.mbankedit',[ 'mbank' => $mbank]);
    }

    public function update(Mbank $mbank){
        Mbank::where('id', '=', $mbank->id)->update([
            'code' => request('kode'),
            'name' => request('nama'),
            'note' => request('note'),
        ]);

        return redirect()->route('mbank');
    }

    public function delete(Mbank $mbank){
        // Mbank::find($mbank->id)->delete();
        // return redirect()->route('mbank');

        $item = Mbank::where('id','=',$mbank->id)->get();
        foreach($item as $data){
            $itemname = $data->name;
        }
        $bayarops = Tbayaropsh::select('akun_pembayaran')->where('akun_pembayaran', 'like', '%' . $itemname . '%')->whereNull('deleted_at')->first();
        // $pos = Tposh::select('mata_uang')->where('mata_uang', 'like', '%' . $itemname . '%')->whereNull('deleted_at')->first();
        // dd($bayarops);
        $havetrans = 0;
        if($bayarops != null){
            $havetrans = 1;
        }

        if($havetrans == 0){
            Mbank::find($mbank->id)->delete();
            return redirect()->route('mbank')->with('success','Data Berhasil Di Hapus');
        }else{
            return redirect()->route('mbank')->with('error','Tidak dapat menghapus data, karena data ada di dalam transaksi lainnya');
        }
    }
}
