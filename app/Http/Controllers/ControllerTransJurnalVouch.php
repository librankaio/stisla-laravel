<?php

namespace App\Http\Controllers;

use App\Models\Mchartofacc;
use App\Models\Mmatauang;
use App\Models\Mnamacabang;
use App\Models\Tjurnalvouchd;
use App\Models\Tjurnalvouchh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControllerTransJurnalVouch extends Controller
{
    public function index(){
        $novouch = DB::select("select fgetcode('tjurnal') as codetrans");
        $matauangs = Mmatauang::select('id','code','name')->whereNull('deleted_at')->get();
        $cabangs = Mnamacabang::select('id','code','name','address')->whereNull('deleted_at')->get();
        $chartaccs = Mchartofacc::select('id','code','jenis')->whereNull('deleted_at')->get();
        return view('pages.transaction.tjurnalvouch',[
            'novouch' => $novouch,
            'chartaccs' => $chartaccs,
            'matauangs' => $matauangs,
            'cabangs' => $cabangs,
        ]);
    }

    public function post(Request $request){
        // dd($request->all());
        $checkexist = Tjurnalvouchh::select('id','no')->where('no','=', $request->no_vouch)->first();
        if($checkexist == null){
            Tjurnalvouchh::create([
                'no' => $request->no_vouch,
                'tdt' => $request->dt,
                'cabang' => $request->cabang,
                'mata_uang' => $request->mata_uang,
                'keterangan' => $request->keterangan,
                'kurs' => (float) str_replace(',', '', $request->kurs),
                'total_debit' => (float) str_replace(',', '', $request->total_debit),
                'total_credit' => (float) str_replace(',', '', $request->total_credit),
                'balance' => (float) str_replace(',', '', $request->balance),
            ]);
            $idh_loop = Tjurnalvouchh::select('id')->whereNull('deleted_at')->where('no','=',$request->no_vouch)->get();
            // dd($idh_loop);
            for($j=0; $j<sizeof($idh_loop); $j++){
                $idh = $idh_loop[$j]->id;
            }
            
            $countrows = sizeof($request->no_d);
            $count=0;
            for ($i=0;$i<sizeof($request->no_d);$i++){
                Tjurnalvouchd::create([
                    'idh' => $idh,
                    'no_tjurnalvouchh' => $request->no_vouch,
                    'kode' => $request->kode_d[$i],
                    'nama' => $request->nama_d[$i],
                    'debit' => (float) str_replace(',', '', $request->debit_d[$i]),
                    'credit' => (float) str_replace(',', '', $request->credit_d[$i]),
                    'memo' => $request->memo_d[$i],
                ]);
                $count++;
            }
            if($count == $countrows){
                return redirect()->back();
            }
        }else{
            return redirect()->back();
        }       
    }

    public function getCoa(Request $request){
        $kode = $request->kode;
        if($kode == ''){
            $items = Mchartofacc::select('id','code','jenis','saldo')->whereNull('deleted_at')->get();
        }else{
            $items = Mchartofacc::select('id','code','jenis','saldo')->whereNull('deleted_at')->where('code','=',$kode)->get();
        }
        return json_encode($items);
    }

    public function getedit(Tjurnalvouchh $tjurnalvouchh){
        // dd($tjurnalvouchh);
        $matauangs = Mmatauang::select('id','code','name')->whereNull('deleted_at')->get();
        $chartaccs = Mchartofacc::select('id','code','jenis')->whereNull('deleted_at')->get();
        $cabangs = Mnamacabang::select('id','code','name','address')->whereNull('deleted_at')->get();
        $tjurnalvouchds = Tjurnalvouchd::select('id','idh','no_tjurnalvouchh','kode','nama','debit','credit','memo')->whereNull('deleted_at')->where('idh','=',$tjurnalvouchh->id)->get();
        return view('pages.transaction.tjurnalvouchedit',[
            'tjurnalvouchh' => $tjurnalvouchh,
            'tjurnalvouchds' => $tjurnalvouchds,
            'chartaccs' => $chartaccs,
            'cabangs' => $cabangs,
            'matauangs' => $matauangs
        ]);
    }

    public function update(Tjurnalvouchh $tjurnalvouchh){
        // dd(request()->all());
        for($j=0;$j<sizeof(request('no_d'));$j++){
            $no_tjurnalvouchh = request('no_vouch');
        }
        DB::delete('delete from tjurnalvouchds where no_tjurnalvouchh = ?', [$no_tjurnalvouchh] );
        Tjurnalvouchh::where('id', '=', $tjurnalvouchh->id)->update([
            'no' => request('no_vouch'),
            'tdt' => request('dt'),
            'cabang' => request('cabang'),
            'mata_uang' => request('mata_uang'),
            'keterangan' => request('keterangan'),
            'kurs' => (float) str_replace(',', '',request('kurs')),
            'total_debit' => (float) str_replace(',', '', request('total_debit')),
            'total_credit' => (float) str_replace(',', '', request('total_credit')),
            'balance' => (float) str_replace(',', '', request('balance')),
        ]);
        $count=0;
        $countrows = sizeof(request('no_d'));
        for ($i=0;$i<sizeof(request('no_d'));$i++){
            if(request('memo') == null){
                $nullmemo = '';
                Tjurnalvouchd::create([
                    'idh' => $tjurnalvouchh->id,
                    'no_tjurnalvouchh' => request('no_vouch'),
                    'kode' => request('kode_d')[$i],
                    'nama' => request('nama_d')[$i],
                    'debit' => (float) str_replace(',', '', request('debit_d')[$i]),
                    'credit' => (float) str_replace(',', '', request('credit_d')[$i]),
                    'memo' => $nullmemo
                ]);
                $count++;
            }else{
                Tjurnalvouchd::create([
                    'idh' => $tjurnalvouchh->id,
                    'no_tjurnalvouchh' => request('no_vouch'),
                    'kode' => request('kode_d')[$i],
                    'nama' => request('nama_d')[$i],
                    'debit' => (float) str_replace(',', '', request('debit_d')[$i]),
                    'credit' => (float) str_replace(',', '', request('credit_d')[$i]),
                    'memo' => request('memo')[$i],
                ]);
                $count++;
            }            
        }
        
        if($count == $countrows){
            return redirect()->route('tjurnalvoucherlist');
        }
    }

    public function list(Tjurnalvouchh $tjurnalvouchh){
        $tjurnalvouchhs = Tjurnalvouchh::select('id','no','tdt','keterangan','balance','total_debit','total_credit','mata_uang')->whereNull('deleted_at')->get();
        $tjurnalvouchds = Tjurnalvouchd::select('id','idh','no_tjurnalvouchh','kode','nama','debit','credit','memo')->whereNull('deleted_at')->get();
        return view('pages.transaction.tjurnalvouchlist',[
            'tjurnalvouchhs' => $tjurnalvouchhs,
            'tjurnalvouchds' => $tjurnalvouchds
        ]);
    }

    public function delete(Tjurnalvouchh $tjurnalvouchh){
        // dd($tbayaropsh);
        Tjurnalvouchh::find($tjurnalvouchh->id)->delete();
        return redirect()->back();
    }

    public function print(Tjurnalvouchh $tjurnalvouchh){
        // dd($tjurnalvouchh);
        $tjurnalvouchds = Tjurnalvouchd::select('id','idh','no_tjurnalvouchh','kode','nama','debit','credit','memo')->whereNull('deleted_at')->where('idh','=',$tjurnalvouchh->id)->get();
        return view('pages.print.tjurnalvouchprint',[
            'tjurnalvouchh' => $tjurnalvouchh,
            'tjurnalvouchds' => $tjurnalvouchds
        ]);
    }
}
