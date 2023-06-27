<?php

use App\Http\Controllers\ControllerLogin;
use App\Http\Controllers\ControllerMasterBank;
use App\Http\Controllers\ControllerMasterCabang;
use App\Http\Controllers\ControllerMasterChartOfAcc;
use App\Http\Controllers\ControllerMasterCustomer;
use App\Http\Controllers\ControllerMasterDataBrg;
use App\Http\Controllers\ControllerMasterGroup;
use App\Http\Controllers\ControllerMasterLocation;
use App\Http\Controllers\ControllerMasterMataUang;
use App\Http\Controllers\ControllerMasterMerk;
use App\Http\Controllers\ControllerMasterNamaCabang;
use App\Http\Controllers\ControllerMasterSatuan;
use App\Http\Controllers\ControllerMasterSupp;
use App\Http\Controllers\ControllerMasterUser;
use App\Http\Controllers\ControllerReportPembelian;
use App\Http\Controllers\ControllerReportPenjualan;
use App\Http\Controllers\ControllerReportStock;
use App\Http\Controllers\ControllerTransBayarOps;
use App\Http\Controllers\ControllerTransJurnalVouch;
use App\Http\Controllers\ControllerTransPembelian;
use App\Http\Controllers\ControllerTransPembelianBrg;
use App\Http\Controllers\ControllerTransPenerimaan;
use App\Http\Controllers\ControllerTransPengeluaranBrg;
use App\Http\Controllers\ControllerTransPos;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/form', function () {
    return view('pages.form');
});
Route::get('/chart', function () {
    return view('chartjs');
});
Route::get('/transaction', function () {
    return view('pages.transaction.tpengeluaranbrglist');
});
Route::get('/table', function () {
    return view('pages.table');
});
Route::get('/advform', function () {
    return view('pages.advancedform');
});
Route::get('/modal', function () {
    return view('pages.modal'); 
});
Route::get('/sweetalert', function () {
    return view('sweetalert'); 
});
//LOGIN
Route::get('/', [ControllerLogin::class, 'index'])->name('login');
Route::post('/', [ControllerLogin::class, 'postLogin'])->name('postlogin');
Route::get('logout', [ControllerLogin::class, 'logout'])->name('logout');
// Route::get('/', [ControllerMasterDataBrg::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function () {
    //HOME
    Route::get('/home', function () {
        return view('chartjs');
    })->name('home');
    // Route::get('/home', [ControllerMasterDataBrg::class, 'home'])->name('home');
    
    //MUSER or Master data User
    Route::get('/materdatauser', [ControllerMasterUser::class, 'index'])->name('muser');
    Route::post('/materdatauserpost', [ControllerMasterUser::class, 'post'])->name('muserpost');
    Route::get('/materdatauser/{user}/edit', [ControllerMasterUser::class, 'getedit'])->name('materdatauseredit');
    Route::post('/materdatauser/{user}', [ControllerMasterUser::class, 'update'])->name('materdatauserupdt');
    Route::post('/materdatauser/delete/{user}', [ControllerMasterUser::class, 'delete'])->name('materdatauserdelete');

    //MITEM or Master data Item
    Route::get('/masterdatabarang', [ControllerMasterDataBrg::class, 'index'])->name('mbrg');
    Route::post('/masterdatabarangpost', [ControllerMasterDataBrg::class, 'post'])->name('mbrgpost');
    Route::get('/masterdatabarang/{mitem}/edit', [ControllerMasterDataBrg::class, 'getedit'])->name('mbrggetedit');
    Route::post('/masterdatabarang/{mitem}', [ControllerMasterDataBrg::class, 'update'])->name('mbrgupdt');
    Route::post('/masterdatabarang/delete/{mitem}', [ControllerMasterDataBrg::class, 'delete'])->name('mbrgdelete');


    Route::get('/mastercabang', [ControllerMasterCabang::class, 'index'])->name('mcabang');
    Route::get('/mastermerk', [ControllerMasterMerk::class, 'index'])->name('mmerk');

    //MUOM or Master Satuan
    Route::get('/mastersatuan', [ControllerMasterSatuan::class, 'index'])->name('msatuan');
    Route::post('/msatuanpost', [ControllerMasterSatuan::class, 'post'])->name('msatuanpost');
    Route::get('/mastersatuan/{muom}/edit', [ControllerMasterSatuan::class, 'getedit'])->name('msatuangetid');
    Route::post('/mastersatuan/{muom}', [ControllerMasterSatuan::class, 'update'])->name('msatuanupdt');
    Route::post('/mastersatuan/delete/{muom}', [ControllerMasterSatuan::class, 'delete'])->name('msatuandelete');
    
    //MUOM or Master Mata Uang
    Route::get('/mmatauang', [ControllerMasterMataUang::class, 'index'])->name('mmatauang');
    Route::post('/mmatauangpost', [ControllerMasterMataUang::class, 'post'])->name('mmatauangpost');
    Route::get('/mmatauang/{mmatauang}/edit', [ControllerMasterMataUang::class, 'getedit'])->name('mmatauanggetid');
    Route::post('/mmatauang/{mmatauang}', [ControllerMasterMataUang::class, 'update'])->name('mmatauangupdt');
    Route::post('/mmatauang/delete/{mmatauang}', [ControllerMasterMataUang::class, 'delete'])->name('mmatauangdelete');

    //MGRP or Master Group
    Route::get('/mastergroup', [ControllerMasterGroup::class, 'index'])->name('mgrup');
    Route::post('/mastergrouppost', [ControllerMasterGroup::class, 'post'])->name('mgruppost');
    Route::get('/mastergroup/{mgrp}/edit', [ControllerMasterGroup::class, 'getedit'])->name('mgrupgetid');
    Route::post('/mastergroup/{mgrp}', [ControllerMasterGroup::class, 'update'])->name('mgrupupdt');
    Route::post('/mastergroup/delete/{mgrp}', [ControllerMasterGroup::class, 'delete'])->name('mgrupdelete');

    //MBANK or Master Bank
    Route::get('/masterbank', [ControllerMasterBank::class, 'index'])->name('mbank');
    Route::post('/masterbankpost', [ControllerMasterBank::class, 'post'])->name('mbankpost');
    Route::get('/masterbank/{mbank}/edit', [ControllerMasterBank::class, 'getedit'])->name('mbankgetid');
    Route::post('/masterbank/{mbank}', [ControllerMasterBank::class, 'update'])->name('mbankupdt');
    Route::post('/masterbank/delete/{mbank}', [ControllerMasterBank::class, 'delete'])->name('mbankdelete');

    //MCUST or Master Customer
    Route::get('/mastercust', [ControllerMasterCustomer::class, 'index'])->name('mcust');
    Route::post('/mastercustpost', [ControllerMasterCustomer::class, 'post'])->name('mcustpost');
    Route::get('/mastercust/{mcust}/edit', [ControllerMasterCustomer::class, 'getedit'])->name('mcustgetid');
    Route::post('/mastercust/{mcust}', [ControllerMasterCustomer::class, 'update'])->name('mcustupdt');
    Route::post('/mastercust/delete/{mcust}', [ControllerMasterCustomer::class, 'delete'])->name('mcustdelete');

    //MSUPP or Master Supplier
    Route::get('/mastersupplier', [ControllerMasterSupp::class, 'index'])->name('msupp');
    Route::post('/mastersupplierpost', [ControllerMasterSupp::class, 'post'])->name('msupppost');
    Route::get('/mastersupplier/{msupp}/edit', [ControllerMasterSupp::class, 'getedit'])->name('msuppgetid');
    Route::post('/mastersupplier/{msupp}', [ControllerMasterSupp::class, 'update'])->name('msuppupdt');
    Route::post('/mastersupplier/delete/{msupp}', [ControllerMasterSupp::class, 'delete'])->name('msuppdelete');

    //MWHSE or Master Location
    Route::get('/masterloct', [ControllerMasterLocation::class, 'index'])->name('mwhse');
    Route::post('/masterloctpost', [ControllerMasterLocation::class, 'post'])->name('mwhsepost');
    Route::get('/masterloct/{mwhse}/edit', [ControllerMasterLocation::class, 'getedit'])->name('mwhsegetedit');
    Route::post('/masterloct/{mwhse}', [ControllerMasterLocation::class, 'update'])->name('mwhseupdt');
    Route::post('/masterloct/delete/{mwhse}', [ControllerMasterLocation::class, 'delete'])->name('mwhsedelete');
    
    // Mchartofacc
    Route::get('/mchartacc', [ControllerMasterChartOfAcc::class, 'index'])->name('mchartacc');
    Route::post('/mchartaccpost', [ControllerMasterChartOfAcc::class, 'post'])->name('mchartaccpost');
    Route::get('/mchartacc/{mchartofacc}/edit', [ControllerMasterChartOfAcc::class, 'getedit'])->name('mchartaccedit');
    Route::post('/mchartacc/{mchartofacc}', [ControllerMasterChartOfAcc::class, 'update'])->name('mchartaccupdt');
    Route::post('/mchartacc/delete/{mchartofacc}', [ControllerMasterChartOfAcc::class, 'delete'])->name('mchartaccdelete');
    
    // Mnamacabang
    Route::get('/mnamacabang', [ControllerMasterNamaCabang::class, 'index'])->name('mnamacabang');
    Route::post('/mnamacabangpost', [ControllerMasterNamaCabang::class, 'post'])->name('mnamacabangpost');
    Route::get('/mnamacabang/{mnamacabang}/edit', [ControllerMasterNamaCabang::class, 'getedit'])->name('mnamacabangedit');
    Route::post('/mnamacabang/{mnamacabang}', [ControllerMasterNamaCabang::class, 'update'])->name('mnamacabangupdt');
    Route::post('/mnamacabang/delete/{mnamacabang}', [ControllerMasterNamaCabang::class, 'delete'])->name('mnamacabangdelete');

    //TPOS or Transaction POS
    Route::get('/transpos', [ControllerTransPos::class, 'index'])->name('tpos');
    Route::post('/transpospost', [ControllerTransPos::class, 'post'])->name('transpospost');
    Route::post('/getmitem', [ControllerTransPos::class, 'getMitem'])->name('getmitem');
    
    //TPOS LIST or Trans POS LIST
    Route::get('/transposlist', [ControllerTransPos::class, 'list'])->name('tposlist');
    Route::get('/transpos/{tposh}/edit', [ControllerTransPos::class, 'getedit'])->name('transposedit');
    Route::post('/transpos/{tposh}', [ControllerTransPos::class, 'update'])->name('transposupdate');
    Route::post('/transpos/delete/{tposh}', [ControllerTransPos::class, 'delete'])->name('tposdelete');
    Route::get('/transpos/{tposh}/print', [ControllerTransPos::class, 'print'])->name('transposprint');
    
    //TBeli Barang
    Route::get('/transbelibrg', [ControllerTransPembelianBrg::class, 'index'])->name('transbelibrg');
    Route::post('/transbelibrgpost', [ControllerTransPembelianBrg::class, 'post'])->name('transbelibrgpost');
    Route::get('/transbelibrglist', [ControllerTransPembelianBrg::class, 'list'])->name('tbelibrglist');
    Route::get('/transbelibrg/{tpembelianh}/edit', [ControllerTransPembelianBrg::class, 'getedit'])->name('transbelibrgedit');
    Route::post('/transbelibrg/{tpembelianh}', [ControllerTransPembelianBrg::class, 'update'])->name('transbelibrgupdate');
    Route::get('/transbelibrg/{tpembelianh}/print', [ControllerTransPembelianBrg::class, 'print'])->name('transbelibrgprint');
    Route::post('/transbelibrg/delete/{tpembelianh}', [ControllerTransPembelianBrg::class, 'delete'])->name('transbelibrgdelete');
    
    // TBeli Barang
    Route::get('/transpengeluaranbrg', [ControllerTransPengeluaranBrg::class, 'index'])->name('tpengeluaranbrg');
    Route::get('/transpengeluaranbrglist', [ControllerTransPengeluaranBrg::class, 'list'])->name('tpengeluaranbrglist');
    
    // TBayar Operasional
    Route::get('/tbayarops', [ControllerTransBayarOps::class, 'index'])->name('tbayarops');
    Route::post('/tbayaropspost', [ControllerTransBayarOps::class, 'post'])->name('tbayaropspost');
    
    // TBayar Operasional LIST
    Route::get('/tbayaropslist', [ControllerTransBayarOps::class, 'list'])->name('tbayaropslist');
    Route::get('/tbayarops/{tbayaropsh}/edit', [ControllerTransBayarOps::class, 'getedit'])->name('tbayaropsedit');
    Route::post('/tbayarops/{tbayaropsh}', [ControllerTransBayarOps::class, 'update'])->name('tbayaropsupdate');
    Route::post('/tbayarops/delete/{tbayaropsh}', [ControllerTransBayarOps::class, 'delete'])->name('tbayaropsdelete');
    Route::get('/tbayarops/{tbayaropsh}/print', [ControllerTransBayarOps::class, 'print'])->name('tbayaropsprint');
    
    // TJournal Voucher
    Route::get('/tjurnalvoucher', [ControllerTransJurnalVouch::class, 'index'])->name('tjurnalvoucher');
    Route::post('/tjurnalvoucher', [ControllerTransJurnalVouch::class, 'post'])->name('tjurnalvoucherpost');
    Route::post('/getcoa', [ControllerTransJurnalVouch::class, 'getCoa'])->name('getcoa');
    
    // Tjournal Voucher List
    Route::get('/tjurnalvoucherlist', [ControllerTransJurnalVouch::class, 'list'])->name('tjurnalvoucherlist');
    Route::get('/tjurnalvoucher/{tjurnalvouchh}/edit', [ControllerTransJurnalVouch::class, 'getedit'])->name('tjurnalvoucheredit');
    Route::post('/tjurnalvoucher/{tjurnalvouchh}', [ControllerTransJurnalVouch::class, 'update'])->name('tjurnalvoucherupdate');
    Route::post('/tjurnalvoucher/delete/{tjurnalvouchh}', [ControllerTransJurnalVouch::class, 'delete'])->name('tjurnalvoucherdelete');
    Route::get('/tjurnalvoucher/{tjurnalvouchh}/print', [ControllerTransJurnalVouch::class, 'print'])->name('tjurnalvoucherprint');
    
    //TPenerimaan
    Route::get('/tpenerimaan', [ControllerTransPenerimaan::class, 'index'])->name('tpenerimaan');
    Route::post('/getnopembeliand', [ControllerTransPenerimaan::class, 'getnopembeliand'])->name('getnopembeliand');
    Route::post('/getnopembelianh', [ControllerTransPenerimaan::class, 'getnopembelianh'])->name('getnopembelianh');
    Route::post('/tpenerimaanpost', [ControllerTransPenerimaan::class, 'post'])->name('tpenerimaanpost');
    
    //Tpenerimaan List
    Route::get('/tpenerimaanlist', [ControllerTransPenerimaan::class, 'list'])->name('tpenerimaanlist');
    Route::get('/tpenerimaan/{tpenerimaanh}/edit', [ControllerTransPenerimaan::class, 'getedit'])->name('tpenerimaanedit');
    Route::post('/tpenerimaan/{tpenerimaanh}', [ControllerTransPenerimaan::class, 'update'])->name('tpenerimaanupdate');
    Route::post('/tpenerimaan/delete/{tpenerimaanh}', [ControllerTransPenerimaan::class, 'delete'])->name('tpenerimaandelete');
    Route::get('/tpenerimaan/{tpenerimaanh}/print', [ControllerTransPenerimaan::class, 'print'])->name('tpenerimaanprint');

    //Report Penjualan
    Route::get('/rpenjualan', [ControllerReportPenjualan::class, 'index'])->name('rpenjualan');
    Route::post('/rpenjualanpost', [ControllerReportPenjualan::class, 'post'])->name('rpenjualanpost');

    //Report Pembelian
    Route::get('/rpembelian', [ControllerReportPembelian::class, 'index'])->name('rpembelian');
    Route::post('/rpembelianpost', [ControllerReportPembelian::class, 'post'])->name('rpembelianpost');

    //Report Stock
    Route::get('/rstock', [ControllerReportStock::class, 'index'])->name('rstock');
    
    //TPembelian
    Route::get('/tpembelian', [ControllerTransPembelian::class, 'index'])->name('tpembelian');
    
    // Route::get('/transbelibrg', [ControllerTransPembelianBrg::class, 'index'])->name('tbelibrg');
});
