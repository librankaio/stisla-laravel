<?php

namespace App\Http\Controllers;

use App\Models\Mitem;
use App\Models\Mmatauang;
use App\Models\Mnamacabang;
use App\Models\Msupp;
use App\Models\Tpembeliand;
use App\Models\Tpembelianh;
use App\Models\Tpenerimaand;
use App\Models\Tpenerimaanh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControllerTransPenerimaan extends Controller
{
    public function index(){
        $notrans = DB::select("select fgetcode('tpenerimaanhs') as codetrans");
        $nopembelians = Tpembelianh::select('id','no')->whereNull('deleted_at')->get();
        $matauangs = Mmatauang::select('id','code','name')->whereNull('deleted_at')->get();
        $suppliers = Msupp::select('id','code','name')->whereNull('deleted_at')->get();
        $cabangs = Mnamacabang::select('id','code','name','address')->whereNull('deleted_at')->get();
        $items = Mitem::select('id','code','name','code_muom','price','code_mgrp','code_mwhse','note')->whereNull('deleted_at')->get();
        return view('pages.transaction.tpenerimaan',[
            'notrans' => $notrans,
            'nopembelians' => $nopembelians,
            'suppliers' => $suppliers,
            'cabangs' => $cabangs,
            'items' => $items,
            'matauangs' => $matauangs
        ]);
    }

    public function getnopembeliand(Request $request){
        $nopembelian = $request->nopembelian;
        if($nopembelian == ''){
            $items = Tpembeliand::select('id','no_pembelianh','code_mitem','name_mitem','qty','code_muom','price','disc','tax','subtotal','note')->whereNull('deleted_at')->get();
        }else{
            $items = Tpembeliand::select('id','no_pembelianh','code_mitem','name_mitem','qty','code_muom','price','disc','tax','subtotal','note')->whereNull('deleted_at')->where('no_pembelianh','=',$nopembelian)->get();
        }
        return json_encode($items);
    }
    public function getnopembelianh(Request $request){
        $nopembelian = $request->nopembelian;
        if($nopembelian == ''){
            $items = Tpembelianh::select('id','no','tdt','cabang','supplier','mata_uang','nolain','subtotal','disc','tax','grdtotal','note')->whereNull('deleted_at')->get();
        }else{
            $items = Tpembelianh::select('id','no','tdt','cabang','supplier','mata_uang','nolain','subtotal','disc','tax','grdtotal','note')->whereNull('deleted_at')->where('no','=',$nopembelian)->get();
        }
        return json_encode($items);
    }

    public function post(Request $request){
        // dd($request->all());
        $checkexist = Tpenerimaanh::select('id','no')->where('no','=', $request->no)->first();
        if($checkexist == null){
            Tpenerimaanh::create([
                'no' => $request->no,
                'no_tpembelian' => $request->nopembelian,
                'tdt' => $request->dt,
                'cabang' => $request->cabang,
                'mata_uang' => $request->mata_uang,
                'supplier' => $request->code_cust,
                'nolain' => $request->nolain,
                'kurs' => (float) str_replace(',', '', $request->kurs),
                'subtotal' => (float) str_replace(',', '', $request->subtot),
                'disc' => (float) str_replace(',', '', $request->price_disc),
                'tax' => (float) str_replace(',', '', $request->price_tax),
                'grdtotal' => (float) str_replace(',', '', $request->price_total),
                'note' => $request->note,
            ]);
            $idh_loop = Tpenerimaanh::select('id')->whereNull('deleted_at')->where('no','=',$request->no)->get();
            for($j=0; $j<sizeof($idh_loop); $j++){
                $idh = $idh_loop[$j]->id;
            }    
            // dd($idh_loop);
            $countrows = sizeof($request->no_d);
            $count=0;
            for ($i=0;$i<sizeof($request->no_d);$i++){
                Tpenerimaand::create([
                    'idh' => $idh,
                    'no_tpenerimaanh' => $request->no,
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

    public function update(Tpenerimaanh $tpenerimaanh){
        // dd(request()->all());
        for($j=0;$j<sizeof(request('no_d'));$j++){
            $no_tposh = request('no');
        }
        DB::delete('delete from tpenerimaands where no_tpenerimaanh = ?', [$no_tposh] );
        Tpenerimaanh::where('id', '=', $tpenerimaanh->id)->update([
            'no' => request('no'),
            'no_tpembelian' => request('nopembelian'),
            'tdt' => request('dt'),
            'cabang' => request('cabang'),
            'mata_uang' => request('mata_uang'),
            'supplier' => request('code_cust'),
            'nolain' => request('nolain'),
            'kurs' => (float) str_replace(',', '', request('kurs')),
            'subtotal' => (float) str_replace(',', '', request('subtot')),
            'disc' => (float) str_replace(',', '', request('price_disc')),
            'tax' => (float) str_replace(',', '', request('price_tax')),
            'grdtotal' => (float) str_replace(',', '', request('price_total')),
            'note' => request('note')
        ]);
        $count=0;
        $countrows = sizeof(request('no_d'));
        for ($i=0;$i<sizeof(request('no_d'));$i++){
            Tpenerimaand ::create([
                'idh' => $tpenerimaanh->id,
                'no_tpenerimaanh' => $tpenerimaanh->no,
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
            return redirect()->route('tpenerimaanlist');
        }
    }

    public function getedit(Tpenerimaanh $tpenerimaanh){
        $matauangs = Mmatauang::select('id','code','name')->whereNull('deleted_at')->get();
        $suppliers = Msupp::select('id','code','name')->whereNull('deleted_at')->get();
        $cabangs = Mnamacabang::select('id','code','name','address')->whereNull('deleted_at')->get();
        $items = Mitem::select('id','code','name','code_muom','price','code_mgrp','code_mwhse','note')->whereNull('deleted_at')->get();
        $tpenerimaands = Tpenerimaand::select('id','idh','no_tpenerimaanh','code_mitem','name_mitem','qty','code_muom','price','disc','tax','subtotal','note')->whereNull('deleted_at')->where('idh','=',$tpenerimaanh->id)->get();
        // dd($tpembeliands);
        return view('pages.transaction.tpenerimaanedit',[
            'tpenerimaanh' =>  $tpenerimaanh,
            'tpenerimaands' => $tpenerimaands,
            'cabangs' => $cabangs,
            'suppliers' => $suppliers,
            'items' => $items,
            'matauangs' => $matauangs,
        ]);
    }

    public function delete(Tpenerimaanh $tpenerimaanh){
        // dd($tbayaropsh);
        Tpenerimaanh::find($tpenerimaanh->id)->delete();
        return redirect()->back();
    }

    public function list(){
        $tpenerimaanhs = Tpenerimaanh::select('id','no','no_tpembelian','tdt','cabang','supplier','mata_uang','nolain','kurs','disc','tax','grdtotal','note')->whereNull('deleted_at')->get();
        $tpenerimaands = Tpenerimaand::select('id','idh','no_tpenerimaanh','code_mitem','name_mitem','qty','code_muom','price','disc','tax','subtotal','note')->whereNull('deleted_at')->get();
        // $msupps = Msupp::select('phone','code')->whereNull('deleted_at')->where('code', 'like', '%' . $tpenerimaanhs->code . '%')->first();
        return view('pages.transaction.tpenerimaanlist',[
            'tpenerimaanhs' => $tpenerimaanhs,
            'tpenerimaands' => $tpenerimaands,
            // 'msupps' => $msupps,
        ]);
    }

    public function print(Tpenerimaanh $tpenerimaanh){
        // dd($tbayaropsh);
        $tpenerimaands = Tpenerimaand::select('id','idh','no_tpenerimaanh','code_mitem','name_mitem','qty','code_muom','price','disc','tax','subtotal','note')->where('idh','=',$tpenerimaanh->id)->get();
        // $msupps = Msupp::select('phone','code')->whereNull('deleted_at')->where('code', 'like', '%' . $tpenerimaanh->code . '%')->first();
        return view('pages.print.tpenerimaanprint',[
            'tpenerimaanh' => $tpenerimaanh,
            'tpenerimaands' => $tpenerimaands,
            // 'msupps' => $msupps,
        ]);
    }
}