<?php

namespace App\Http\Controllers;

use App\Models\Mbank;
use App\Models\Mmatauang;
use App\Models\Mnamacabang;
use App\Models\Tbayaropsd;
use App\Models\Tbayaropsh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControllerTransBayarOps extends Controller
{
    public function index(){
        $notrans = DB::select("select fgetcode('tbayaropshs') as codetrans");
        $matauangs = Mmatauang::select('id','code','name')->whereNull('deleted_at')->get();
        $cabangs = Mnamacabang::select('id','code','name','address')->whereNull('deleted_at')->get();
        $banks = Mbank::select('id','code','name')->whereNull('deleted_at')->get();
        return view('pages.transaction.tbayarops',[
            'notrans' => $notrans,
            'matauangs' => $matauangs,
            'cabangs' => $cabangs,
            'banks' => $banks,
        ]);
    }

    public function post(Request $request){
        // dd($request->all());
        $checkexist = Tbayaropsh::select('id','no')->where('no','=', $request->no)->first();
        if($checkexist == null){
            Tbayaropsh::create([
                'no' => $request->no,
                'tdt' => $request->dt,
                'cabang' => $request->cabang,
                'mata_uang' => $request->mata_uang,
                'jenis' => $request->jenis,
                'akun_pembayaran' => $request->akun_bayar,
                'noref' => $request->noref,
                'kurs' => (float) str_replace(',', '', $request->kurs),
                'total' => $request->nominal,
                'grdtotal' => (float) str_replace(',', '', $request->grand_total),
            ]);
            $idh_loop = Tbayaropsh::select('id')->whereNull('deleted_at')->where('no','=',$request->no)->get();
            for($j=0; $j<sizeof($idh_loop); $j++){
                $idh = $idh_loop[$j]->id;
            }
    
            $countrows = sizeof($request->no_d);
            $count=0;
            for ($i=0;$i<sizeof($request->no_d);$i++){
                Tbayaropsd::create([
                    'idh' => $idh,
                    'no_tbayaropsh' => $request->no,
                    'total' => (float) str_replace(',', '', $request->total_d[$i]),
                    'note' => $request->note_d[$i],
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

    public function getedit(Tbayaropsh $tbayaropsh){
        $matauangs = Mmatauang::select('id','code','name')->whereNull('deleted_at')->get();
        $banks = Mbank::select('id','code','name')->whereNull('deleted_at')->get();
        $cabangs = Mnamacabang::select('id','code','name','address')->whereNull('deleted_at')->get();
        $tbayaropsds = Tbayaropsd::select('id','idh','no_tbayaropsh','total','note')->whereNull('deleted_at')->where('idh','=',$tbayaropsh->id)->get();
        return view('pages.transaction.tbayaropsedit',[
            'tbayaropsh' => $tbayaropsh,
            'tbayaropsds' => $tbayaropsds,
            'banks' => $banks,
            'cabangs' => $cabangs,
            'matauangs' => $matauangs
        ]);
    }

    public function update(Tbayaropsh $tbayaropsh){
        // dd(request()->all());
        for($j=0;$j<sizeof(request('no_d'));$j++){
            $no_tbayaropsh = request('no');
        }
        DB::delete('delete from tbayaropsds where no_tbayaropsh = ?', [$no_tbayaropsh] );
        Tbayaropsh::where('id', '=', $tbayaropsh->id)->update([
            'no' => request('no'),
            'tdt' => request('dt'),
            'cabang' => request('cabang'),
            'mata_uang' => request('mata_uang'),
            'jenis' => request('jenis'),
            'akun_pembayaran' => request('akun_bayar'),
            'noref' => request('noref'),
            'kurs' => (float) str_replace(',', '', request('kurs')),
            'total' => request('nominal'),
            'grdtotal' => (float) str_replace(',', '', request('grand_total'))
        ]);
        $count=0;
        $countrows = sizeof(request('no_d'));
        for ($i=0;$i<sizeof(request('no_d'));$i++){
            Tbayaropsd::create([
                'idh' => $tbayaropsh->id,
                'no_tbayaropsh' => request('no'),
                'total' => (float) str_replace(',', '', request('total_d')[$i]),
                'note' => request('note_d')[$i],
            ]);
            $count++;
        }
        
        if($count == $countrows){
            return redirect()->route('tbayaropslist');
        }
    }

    public function list(Tbayaropsh $tbayaropsh){
        $tbayaropshs = Tbayaropsh::select('id','no','tdt','jenis','noref','total','grdtotal','akun_pembayaran','note')->whereNull('deleted_at')->get();
        $tbayaropsds = Tbayaropsd::select('id','idh','no_tbayaropsh','total')->whereNull('deleted_at')->get();
        return view('pages.transaction.tbayaropslist',[
            'tbayaropshs' => $tbayaropshs,
            'tbayaropsds' => $tbayaropsds
        ]);
    }

    public function delete(Tbayaropsh $tbayaropsh){
        // dd($tbayaropsh);
        Tbayaropsh::find($tbayaropsh->id)->delete();
        return redirect()->back();
    }

    public function print(Tbayaropsh $tbayaropsh){
        // dd($tbayaropsh);
        $tbayaropsds = Tbayaropsd::select('id','idh','no_tbayaropsh','total','note')->whereNull('deleted_at')->where('idh','=',$tbayaropsh->id)->get();
        return view('pages.print.tbayaropsprint',[
            'tbayaropsh' => $tbayaropsh,
            'tbayaropsds' => $tbayaropsds
        ]);
    }
}
