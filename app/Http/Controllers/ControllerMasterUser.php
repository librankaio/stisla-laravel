<?php

namespace App\Http\Controllers;

use App\Models\AuthUser;
use App\Models\Mwhse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ControllerMasterUser extends Controller
{
    public function index(){
        $datas = User::select('id','username','email','branch')->get();
        $branhcs = Mwhse::whereNull('deleted_at')->get();
        return view('pages.master.muser',[
            'datas' => $datas,
            'branhcs' => $branhcs
        ]);
    }

    public function post(Request $request){      
        // dd($request->all());
        // dd($request->read_mitem);
        $checkexist = User::select('id','username','email')->where('username','=', $request->username)->first();
        if($checkexist == null){
            // $password = Hash::make($request->password);
            // dd($password);
            User::create([
                'username' => $request->username,
                'name' => $request->username,
                'email' => $request->email,
                'branch' => $request->branch,
                'password' => $request->password,
            ]);
            $user = User::select('id','username','email','name')->where('username','=', $request->username)->first();
            for ($i=0; $i<sizeof($request->features); $i++){
                AuthUser::create([
                    'id_user' => $user->id,
                    'username' => $user->username,
                    'email' => $user->email,
                    'name' => $user->name,
                    'feature' => $request->features[$i],
                ]);
            }
            
            AuthUser::where('id_user', '=', $user->id)->where('feature', '=', 'mitem')->update([
                'save' => $request->create_mitem,
                'open' => $request->read_mitem,
                'updt' => $request->update_mitem,
                'dlt' => $request->delete_mitem,
            ]);
            AuthUser::where('id_user', '=', $user->id)->where('feature', '=', 'muser')->update([
                'save' => $request->create_user,
                'open' => $request->read_user,
                'updt' => $request->update_user,
                'dlt' => $request->delete_user,
            ]);
            AuthUser::where('id_user', '=', $user->id)->where('feature', '=', 'msatuan')->update([
                'save' => $request->create_satuan,
                'open' => $request->read_satuan,
                'updt' => $request->update_satuan,
                'dlt' => $request->delete_satuan,
            ]);
            AuthUser::where('id_user', '=', $user->id)->where('feature', '=', 'mdtgrp')->update([
                'save' => $request->create_group,
                'open' => $request->read_group,
                'updt' => $request->update_group,
                'dlt' => $request->delete_group,
            ]);
            AuthUser::where('id_user', '=', $user->id)->where('feature', '=', 'mcoa')->update([
                'save' => $request->create_coa,
                'open' => $request->read_coa,
                'updt' => $request->update_coa,
                'dlt' => $request->delete_coa,
            ]);
            AuthUser::where('id_user', '=', $user->id)->where('feature', '=', 'mbank')->update([
                'save' => $request->create_bank,
                'open' => $request->read_bank,
                'updt' => $request->update_bank,
                'dlt' => $request->delete_bank,
            ]);
            AuthUser::where('id_user', '=', $user->id)->where('feature', '=', 'mmtuang')->update([
                'save' => $request->create_mtuang,
                'open' => $request->read_mtuang,
                'updt' => $request->update_mtuang,
                'dlt' => $request->delete_mtuang,
            ]);
            AuthUser::where('id_user', '=', $user->id)->where('feature', '=', 'mcust')->update([
                'save' => $request->create_cust,
                'open' => $request->read_cust,
                'updt' => $request->update_cust,
                'dlt' => $request->delete_cust,
            ]);
            AuthUser::where('id_user', '=', $user->id)->where('feature', '=', 'msupp')->update([
                'save' => $request->create_supp,
                'open' => $request->read_supp,
                'updt' => $request->update_supp,
                'dlt' => $request->delete_supp,
            ]);
            AuthUser::where('id_user', '=', $user->id)->where('feature', '=', 'mlokasi')->update([
                'save' => $request->create_lokasi,
                'open' => $request->read_lokasi,
                'updt' => $request->update_lokasi,
                'dlt' => $request->delete_lokasi,
            ]);
            AuthUser::where('id_user', '=', $user->id)->where('feature', '=', 'mcabang')->update([
                'save' => $request->create_cabang,
                'open' => $request->read_cabang,
                'updt' => $request->update_cabang,
                'dlt' => $request->delete_cabang,
            ]);
            AuthUser::where('id_user', '=', $user->id)->where('feature', '=', 'tpembelianbrg')->update([
                'save' => $request->create_belibrg,
                'open' => $request->read_belibrg,
                'updt' => $request->update_belibrg,
                'dlt' => $request->delete_belibrg,
            ]);
            AuthUser::where('id_user', '=', $user->id)->where('feature', '=', 'tpos')->update([
                'save' => $request->create_pos,
                'open' => $request->read_pos,
                'updt' => $request->update_pos,
                'dlt' => $request->delete_pos,
            ]);
            AuthUser::where('id_user', '=', $user->id)->where('feature', '=', 'tops')->update([
                'save' => $request->create_bayarops,
                'open' => $request->read_bayarops,
                'updt' => $request->update_bayarops,
                'dlt' => $request->delete_bayarops,
            ]);
            AuthUser::where('id_user', '=', $user->id)->where('feature', '=', 'tjvouch')->update([
                'save' => $request->create_jvouch,
                'open' => $request->read_jvouch,
                'updt' => $request->update_jvouch,
                'dlt' => $request->delete_jvouch,
            ]);
            AuthUser::where('id_user', '=', $user->id)->where('feature', '=', 'tpenerimaan')->update([
                'save' => $request->create_penerimaan,
                'open' => $request->read_penerimaan,
                'updt' => $request->update_penerimaan,
                'dlt' => $request->delete_penerimaan,
            ]);
            return redirect()->back();
        }else{
            return redirect()->back();
        }        
    }

    public function getedit(User $user){
        $auth_mitem = AuthUser::where('id_user', '=', $user->id)->where('feature', '=', 'mitem')->first();
        $auth_muser = AuthUser::where('id_user', '=', $user->id)->where('feature', '=', 'muser')->first();
        $auth_msatuan = AuthUser::where('id_user', '=', $user->id)->where('feature', '=', 'msatuan')->first();
        $auth_mdtgrp = AuthUser::where('id_user', '=', $user->id)->where('feature', '=', 'mdtgrp')->first();
        $auth_mcoa = AuthUser::where('id_user', '=', $user->id)->where('feature', '=', 'mcoa')->first();
        $auth_mbank = AuthUser::where('id_user', '=', $user->id)->where('feature', '=', 'mbank')->first();
        $auth_mmtuang = AuthUser::where('id_user', '=', $user->id)->where('feature', '=', 'mmtuang')->first();
        $auth_mcust = AuthUser::where('id_user', '=', $user->id)->where('feature', '=', 'mcust')->first();
        $auth_msupp = AuthUser::where('id_user', '=', $user->id)->where('feature', '=', 'msupp')->first();
        $auth_mlokasi = AuthUser::where('id_user', '=', $user->id)->where('feature', '=', 'mlokasi')->first();
        $auth_mcabang = AuthUser::where('id_user', '=', $user->id)->where('feature', '=', 'mcabang')->first();
        $auth_tpembelianbrg = AuthUser::where('id_user', '=', $user->id)->where('feature', '=', 'tpembelianbrg')->first();
        $auth_tpos = AuthUser::where('id_user', '=', $user->id)->where('feature', '=', 'tpos')->first();
        $auth_tops = AuthUser::where('id_user', '=', $user->id)->where('feature', '=', 'tops')->first();
        $auth_tjvouch = AuthUser::where('id_user', '=', $user->id)->where('feature', '=', 'tjvouch')->first();
        $auth_tpenerimaan = AuthUser::where('id_user', '=', $user->id)->where('feature', '=', 'tpenerimaan')->first();
        $branhcs = Mwhse::whereNull('deleted_at')->get();
        // dd($auth_mitems);
        return view('pages.master.museredit',[
            'user' => $user,
            'auth_mitem' => $auth_mitem,
            'auth_muser' => $auth_muser,
            'auth_msatuan' => $auth_msatuan,
            'auth_mdtgrp' => $auth_mdtgrp,
            'auth_mcoa' => $auth_mcoa,
            'auth_mbank' => $auth_mbank,
            'auth_mmtuang' => $auth_mmtuang,
            'auth_mcust' => $auth_mcust,
            'auth_msupp' => $auth_msupp,
            'auth_mlokasi' => $auth_mlokasi,
            'auth_mcabang' => $auth_mcabang,
            'auth_tpembelianbrg' => $auth_tpembelianbrg,
            'auth_tpos' => $auth_tpos,
            'auth_tops' => $auth_tops,
            'auth_tjvouch' => $auth_tjvouch,
            'auth_tpenerimaan' => $auth_tpenerimaan,
            'branhcs' => $branhcs,
        ]);
    }

    public function update(User $user){
        // dd(request()->all());
        if(request('password') == null || request('password') == ''){
            User::where('id', '=', $user->id)->update([
                'username' => request('username'),
                'name' => request('username'),
                'email' => request('email'),
                'branch' => request('branch'),
            ]);
        }elseif(request('password') != null){
            // dd(request()->all());
            // $password = Hash::make(request('password'));
            $password = bcrypt(request('password'));
            // dd($password);
            User::where('id', '=', $user->id)->update([
                'username' => request('username'),
                'name' => request('username'),
                'email' => request('email'),
                'password' => $password,
                'branch' => request('branch'),
            ]);
        }
        $user = User::select('id','username','email','name')->where('id','=', $user->id)->first();
            
            AuthUser::where('id_user', '=', $user->id)->where('feature', '=', 'mitem')->update([
                'save' => request('create_mitem'),
                'open' => request('read_mitem'),
                'updt' => request('update_mitem'),
                'dlt' => request('delete_mitem'),
            ]);
            AuthUser::where('id_user', '=', $user->id)->where('feature', '=', 'muser')->update([
                'save' => request('create_user'),
                'open' => request('read_user'),
                'updt' => request('update_user'),
                'dlt' => request('delete_user'),
            ]);
            AuthUser::where('id_user', '=', $user->id)->where('feature', '=', 'msatuan')->update([
                'save' => request('create_satuan'),
                'open' => request('read_satuan'),
                'updt' => request('update_satuan'),
                'dlt' => request('delete_satuan'),
            ]);
            AuthUser::where('id_user', '=', $user->id)->where('feature', '=', 'mdtgrp')->update([
                'save' => request('create_group'),
                'open' => request('read_group'),
                'updt' => request('update_group'),
                'dlt' => request('delete_group'),
            ]);
            AuthUser::where('id_user', '=', $user->id)->where('feature', '=', 'mcoa')->update([
                'save' => request('create_coa'),
                'open' => request('read_coa'),
                'updt' => request('update_coa'),
                'dlt' => request('delete_coa'),
            ]);
            AuthUser::where('id_user', '=', $user->id)->where('feature', '=', 'mbank')->update([
                'save' => request('create_bank'),
                'open' => request('read_bank'),
                'updt' => request('update_bank'),
                'dlt' => request('delete_bank'),
            ]);
            AuthUser::where('id_user', '=', $user->id)->where('feature', '=', 'mmtuang')->update([
                'save' => request('create_mtuang'),
                'open' => request('read_mtuang'),
                'updt' => request('update_mtuang'),
                'dlt' => request('delete_mtuang'),
            ]);
            AuthUser::where('id_user', '=', $user->id)->where('feature', '=', 'mcust')->update([
                'save' => request('create_cust'),
                'open' => request('read_cust'),
                'updt' => request('update_cust'),
                'dlt' => request('delete_cust'),
            ]);
            AuthUser::where('id_user', '=', $user->id)->where('feature', '=', 'msupp')->update([
                'save' => request('create_supp'),
                'open' => request('read_supp'),
                'updt' => request('update_supp'),
                'dlt' => request('delete_supp'),
            ]);
            AuthUser::where('id_user', '=', $user->id)->where('feature', '=', 'mlokasi')->update([
                'save' => request('create_lokasi'),
                'open' => request('read_lokasi'),
                'updt' => request('update_lokasi'),
                'dlt' => request('delete_lokasi'),
            ]);
            AuthUser::where('id_user', '=', $user->id)->where('feature', '=', 'mcabang')->update([
                'save' => request('create_cabang'),
                'open' => request('read_cabang'),
                'updt' => request('update_cabang'),
                'dlt' => request('delete_cabang'),
            ]);
            AuthUser::where('id_user', '=', $user->id)->where('feature', '=', 'tpembelianbrg')->update([
                'save' => request('create_belibrg'),
                'open' => request('read_belibrg'),
                'updt' => request('update_belibrg'),
                'dlt' => request('delete_belibrg'),
            ]);
            AuthUser::where('id_user', '=', $user->id)->where('feature', '=', 'tpos')->update([
                'save' => request('create_pos'),
                'open' => request('read_pos'),
                'updt' => request('update_pos'),
                'dlt' => request('delete_pos'),
            ]);
            AuthUser::where('id_user', '=', $user->id)->where('feature', '=', 'tops')->update([
                'save' => request('create_bayarops'),
                'open' => request('read_bayarops'),
                'updt' => request('update_bayarops'),
                'dlt' => request('delete_bayarops'),
            ]);
            AuthUser::where('id_user', '=', $user->id)->where('feature', '=', 'tjvouch')->update([
                'save' => request('create_jvouch'),
                'open' => request('read_jvouch'),
                'updt' => request('update_jvouch'),
                'dlt' => request('delete_jvouch'),
            ]);
            AuthUser::where('id_user', '=', $user->id)->where('feature', '=', 'tpenerimaan')->update([
                'save' => request('create_penerimaan'),
                'open' => request('read_penerimaan'),
                'updt' => request('update_penerimaan'),
                'dlt' => request('delete_penerimaan'),
            ]);

        return redirect()->route('muser');        
    }

    public function delete(User $user){
        User::find($user->id)->delete();
        return redirect()->route('muser')->with('success','Data Berhasil Di Hapus');
    }
}
