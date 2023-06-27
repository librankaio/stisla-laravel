<?php

namespace App\Http\Controllers;

use App\Models\Mitem;
use App\Models\Mmatauang;
use App\Models\Mnamacabang;
use App\Models\Msupp;
use App\Models\Tpembeliand;
use App\Models\Tpembelianh;
use App\Models\Tposh;
use App\Models\Tposhd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControllerTransPembelianBrg extends Controller
{
    public function index(){
        $notrans = DB::select("select fgetcode('pembelianhs') as codetrans");
        $matauangs = Mmatauang::select('id','code','name')->whereNull('deleted_at')->get();
        $suppliers = Msupp::select('id','code','name')->whereNull('deleted_at')->get();
        $cabangs = Mnamacabang::select('id','code','name','address')->whereNull('deleted_at')->get();
        $items = Mitem::select('id','code','name','code_muom','price','code_mgrp','code_mwhse','note')->whereNull('deleted_at')->get();
        return view('pages.transaction.tbelibrg',[
            'notrans' => $notrans,
            'suppliers' => $suppliers,
            'cabangs' => $cabangs,
            'items' => $items,
            'matauangs' => $matauangs
        ]);
    }

    public function post(Request $request){
        // dd($request->all());
        $checkexist = Tpembelianh::select('id','no')->where('no','=', $request->no)->first();
        if($checkexist == null){
            Tpembelianh::create([
                'no' => $request->no,
                'tdt' => $request->dt,
                'cabang' => $request->cabang,
                'mata_uang' => $request->mata_uang,
                'supplier' => $request->code_cust,
                'nolain' => $request->nolain,
                'kurs' => (float) str_replace(',', '', $request->kurs),
                'disc' => (float) str_replace(',', '', $request->price_disc),
                'subtotal' => (float) str_replace(',', '', $request->subtotal_h),
                'tax' => (float) str_replace(',', '', $request->price_tax),
                'grdtotal' => (float) str_replace(',', '', $request->price_total),
                'note' => $request->note,
            ]);
            $idh_loop = Tpembelianh::select('id')->whereNull('deleted_at')->where('no','=',$request->no)->get();
            for($j=0; $j<sizeof($idh_loop); $j++){
                $idh = $idh_loop[$j]->id;
            }    
            // dd($idh_loop);
            $countrows = sizeof($request->no_d);
            $count=0;
            for ($i=0;$i<sizeof($request->no_d);$i++){
                Tpembeliand::create([
                    'idh' => $idh,
                    'no_pembelianh' => $request->no,
                    'code_mitem' => $request->kode_d[$i],
                    'name_mitem' => $request->nama_item_d[$i],
                    'qty' => $request->quantity[$i],
                    'code_muom' => $request->satuan_d[$i],
                    'price' => (float) str_replace(',', '', $request->harga_d[$i]),
                    'disc' => (float) str_replace(',', '', $request->disc_d[$i]),
                    'tax' => (float) str_replace(',', '', $request->tax_d[$i]),
                    'subtotal' => (float) str_replace(',', '', $request->subtot_d[$i]),
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

    public function update(Tpembelianh $tpembelianh){
        // dd(request()->all());
        for($j=0;$j<sizeof(request('no_d'));$j++){
            $no_tposh = request('no');
        }
        DB::delete('delete from tpembeliands where no_pembelianh = ?', [$no_tposh] );
        Tpembelianh::where('id', '=', $tpembelianh->id)->update([
            'no' => request('no'),
            'tdt' => request('dt'),
            'cabang' => request('cabang'),
            'mata_uang' => request('mata_uang'),
            'supplier' => request('code_cust'),
            'nolain' => request('nolain'),
            'kurs' => (float) str_replace(',', '', request('kurs')),
            'subtotal' => (float) str_replace(',', '', request('subtotal_h')),
            'disc' => (float) str_replace(',', '', request('price_disc')),
            'tax' => (float) str_replace(',', '', request('price_tax')),
            'grdtotal' => (float) str_replace(',', '', request('price_total')),
            'note' => request('note')
        ]);
        $count=0;
        $countrows = sizeof(request('no_d'));
        for ($i=0;$i<sizeof(request('no_d'));$i++){
            Tpembeliand::create([
                'idh' => $tpembelianh->id,
                'no_pembelianh' => $tpembelianh->no,
                'code_mitem' => request('kode_d')[$i],
                'name_mitem' => request('nama_item_d')[$i],
                'qty' => request('quantity')[$i],
                'code_muom' => request('satuan_d')[$i],
                'price' => (float) str_replace(',', '', request('harga_d')[$i]),
                'disc' => (float) str_replace(',', '', request('disc_d')[$i]),
                'tax' => (float) str_replace(',', '', request('tax_d')[$i]),
                'subtotal' => (float) str_replace(',', '', request('subtot_d')[$i]),
                'note' => request('note_d')[$i],
            ]);
            $count++;
        }
        
        if($count == $countrows){
            return redirect()->route('tbelibrglist');
        }
    }

    public function getedit(Tpembelianh $tpembelianh){
        $matauangs = Mmatauang::select('id','code','name')->whereNull('deleted_at')->get();
        $suppliers = Msupp::select('id','code','name')->whereNull('deleted_at')->get();
        $cabangs = Mnamacabang::select('id','code','name','address')->whereNull('deleted_at')->get();
        $items = Mitem::select('id','code','name','code_muom','price','code_mgrp','code_mwhse','note')->whereNull('deleted_at')->get();
        $tpembeliands = Tpembeliand::select('id','idh','no_pembelianh','code_mitem','name_mitem','code_muom','qty','subtotal','price','disc','tax','subtotal','note')->whereNull('deleted_at')->where('idh','=',$tpembelianh->id)->get();
        // dd($tpembeliands);
        return view('pages.transaction.tbelibrgedit',[
            'tpembelianh' =>  $tpembelianh,
            'tpembeliands' => $tpembeliands,
            'cabangs' => $cabangs,
            'suppliers' => $suppliers,
            'items' => $items,
            'matauangs' => $matauangs,
        ]);
    }

    public function list(){
        $tpembelianhs = Tpembelianh::select('id','no','tdt','supplier','mata_uang','nolain','disc','tax','grdtotal','note')->whereNull('deleted_at')->get();
        $tpembeliands = Tpembeliand::select('id','idh','no_pembelianh','code_mitem','name_mitem','code_muom','price','disc','tax','subtotal','note')->whereNull('deleted_at')->get();
        return view('pages.transaction.tbelibrglist',[
            'tpembelianhs' => $tpembelianhs,
            'tpembeliands' => $tpembeliands
        ]);
    }

    public function print(Tpembelianh $tpembelianh){
        $tpembeliands = Tpembeliand::select('id','idh','no_pembelianh','code_mitem','name_mitem','qty','code_muom','price','disc','tax','subtotal','note')->whereNull('deleted_at')->where('idh','=',$tpembelianh->id)->get();
        $msupps = Msupp::select('phone','code')->whereNull('deleted_at')->where('code', 'like', '%' . $tpembelianh->code . '%')->first();
        return view('pages.print.tpembelianbrgprint',[
            'tpembelianh' => $tpembelianh,
            'tpembeliands' => $tpembeliands,
            'msupps' => $msupps,
        ]);
    }

    public function delete(Tpembelianh $tpembelianh){
        // dd($tpembelianh);
        Tpembelianh::find($tpembelianh->id)->delete();
        return redirect()->route('tbelibrglist');
    }
}
