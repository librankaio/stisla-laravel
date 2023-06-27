<?php

namespace App\Http\Controllers;

use App\Models\Msupp;
use App\Models\Tpembelianh;
use Illuminate\Http\Request;

class ControllerMasterSupp extends Controller
{
    public function index(){
        $datas = Msupp::select('id','code','name','address','npwp','cp','phone')->whereNull('deleted_at')->get();
        return view('pages.master.msupp',[
            'datas' => $datas
        ]);
    }

    public function post(Request $request){
        $checkexist = Msupp::select('id','code','name')->where('code','=', $request->kode)->first();
        if($checkexist == null){
            Msupp::create([
                'code' => $request->kode,
                'name' => $request->nama,
                'address' => $request->address,
                'npwp' => $request->npwp,
                'cp' => $request->cp,
                'phone' => $request->phone,
            ]);
            return redirect()->back();
        }else{
            return redirect()->back();
        }
    }

    public function getedit(Msupp $msupp){
        return view('pages.master.msuppedit',[ 'msupp' => $msupp]);
    }

    public function update(Msupp $msupp){
        Msupp::where('id', '=', $msupp->id)->update([
            'code' => request('kode'),
            'name' => request('nama'),
            'address' => request('address'),
            'npwp' => request('npwp'),
            'cp' => request('cp'),
            'phone' => request('phone'),
        ]);

        return redirect()->route('msupp');
    }

    public function delete(Msupp $msupp){
        // Msupp::find($msupp->id)->delete();
        // return redirect()->route('msupp');

        $item = Msupp::where('id','=',$msupp->id)->get();
        foreach($item as $data){
            $itemname = $data->name;
        }

        $pembelian = Tpembelianh::select('supplier')->where('supplier', 'like', '%' . $itemname . '%')->whereNull('deleted_at')->first();
        // dd($pembelian);
        
        $havetrans = 0;
        if($pembelian != null ){
            $havetrans = 1;
        }

        if($havetrans == 0){
            Msupp::find($msupp->id)->delete();
            return redirect()->route('msupp')->with('success','Data Berhasil Di Hapus');
        }else{
            return redirect()->route('msupp')->with('error','Tidak dapat menghapus data, karena data ada di dalam transaksi lainnya');
        }
    }
}
