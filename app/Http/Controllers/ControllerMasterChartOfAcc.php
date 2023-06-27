<?php

namespace App\Http\Controllers;

use App\Models\Mchartofacc;
use Illuminate\Http\Request;

class ControllerMasterChartOfAcc extends Controller
{
    public function index(){
        $datas = Mchartofacc::select('id','code','name','jenis','saldo')->whereNull('deleted_at')->get();
        return view('pages.master.mchartofacc',[
            'datas' => $datas
        ]);
    }

    public function post(Request $request){
        // dd($request->all());
        $checkexist = Mchartofacc::select('id','code','jenis')->where('code','=', $request->kode)->first();
        if($checkexist == null){
            Mchartofacc::create([
                'code' => $request->kode,
                'name' => $request->name,
                'jenis' => $request->jenis,
                'saldo' => (float) str_replace(',', '', $request->saldo),
            ]);
            return redirect()->back();
        }else{
            return redirect()->back();
        }
    }

    public function getedit(Mchartofacc $mchartofacc){
        // dd($mchartofacc);
        return view('pages.master.mchartofaccedit',[ 'mchartofacc' => $mchartofacc]);
    }

    public function update(Mchartofacc $mchartofacc){
        // dd(request()->all());
        Mchartofacc::where('id', '=', $mchartofacc->id)->update([
            'code' => request('kode'),
            'name' => request('name'),
            'jenis' => request('jenis'),
            'saldo' => (float) str_replace(',', '', request('saldo')),
        ]);

        return redirect()->route('mchartacc');
    }

    public function delete(Mchartofacc $mchartofacc){
        // dd($muom);
        Mchartofacc::find($mchartofacc->id)->delete();
        return redirect()->route('mchartacc');
    }
}
