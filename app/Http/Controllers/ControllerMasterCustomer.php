<?php

namespace App\Http\Controllers;

use App\Models\Mcust;
use App\Models\Tposh;
use Illuminate\Http\Request;

class ControllerMasterCustomer extends Controller
{
    public function index(){
        $datas = Mcust::select('id','code','name','address','npwp','cp','phone')->whereNull('deleted_at')->get();
        return view('pages.master.mcustomer',[
            'datas' => $datas
        ]);
    }

    public function post(Request $request){
        $checkexist = Mcust::select('id','code','name')->where('code','=', $request->kode)->first();
        if($checkexist == null){
            Mcust::create([
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

    public function getedit(Mcust $mcust){
        return view('pages.master.mcustomeredit',[ 'mcust' => $mcust]);
    }

    public function update(Mcust $mcust){
        Mcust::where('id', '=', $mcust->id)->update([
            'code' => request('kode'),
            'name' => request('nama'),
            'address' => request('address'),
            'npwp' => request('npwp'),
            'cp' => request('cp'),
            'phone' => request('phone'),
        ]);

        return redirect()->route('mcust');
    }

    public function delete(Mcust $mcust){
        // Mcust::find($mcust->id)->delete();
        // return redirect()->route('mcust');

        $item = Mcust::where('id','=',$mcust->id)->get();
        foreach($item as $data){
            $itemname = $data->name;
        }

        $pos = Tposh::select('code_mcust')->where('code_mcust', 'like', '%' . $itemname . '%')->whereNull('deleted_at')->first();
        // dd($pos);
        
        $havetrans = 0;
        if($pos != null ){
            $havetrans = 1;
        }

        if($havetrans == 0){
            Mcust::find($mcust->id)->delete();
            return redirect()->route('mcust')->with('success','Data Berhasil Di Hapus');
        }else{
            return redirect()->route('mcust')->with('error','Tidak dapat menghapus data, karena data ada di dalam transaksi lainnya');
        }
    }
}
