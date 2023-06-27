<ul class="sidebar-menu">
    <li class="menu-header">MASTER</li>
    <li class="nav-item dropdown">
        <a href="#" class="nav-link has-dropdown"><i class="fas fa-cubes"></i><span>Master Data</span></a>
        <ul class="dropdown-menu">
            @php
                $role = session('privilage');
                $mitem_open = session('mitem_open');
                $muser_open = session('muser_open');
                $msatuan_open = session('msatuan_open');
                $mdtgrp_open = session('mdtgrp_open');
                $mcoa_open = session('mcoa_open');
                $mbank_open = session('mbank_open');
                $mmtuang_open = session('mmtuang_open');
                $mcust_open = session('mcust_open');
                $msupp_open = session('msupp_open');
                $mlokasi_open = session('mlokasi_open');
                $mcabang_open = session('mcabang_open');
                $tpembelianbrg_open = session('tpembelianbrg_open');
                $tpos_open = session('tpos_open');
                $tops_open = session('tops_open');
                $tjvouch_open = session('tjvouch_open');
                $tpenerimaan_open = session('tpenerimaan_open');
            @endphp
            @if($muser_open == 'Y' || $role == 'ADM')  
                <li><a class="nav-link" href="{{ route('muser') }}">Master Data User</a></li>          
            @endif
            @if($mitem_open == 'Y')
                <li><a class="nav-link" href="{{ route('mbrg') }}">Master Data Item</a></li>     
            @endif
            @if($msatuan_open == 'Y')
                <li><a class="nav-link" href="{{ route('msatuan') }}">Master Satuan</a></li>   
            @endif
            @if($mdtgrp_open == 'Y')
                <li><a class="nav-link" href="{{ route('mgrup') }}">Master Data Group</a></li>  
            @endif
            @if($mcoa_open == 'Y')
                <li><a class="nav-link" href="{{ route('mchartacc') }}">Master Chart Of Account</a></li> 
            @endif
            @if($mbank_open == 'Y')
                <li><a class="nav-link" href="{{ route('mbank') }}">Master Bank</a></li>
            @endif
            @if($mmtuang_open == 'Y')
                <li><a class="nav-link" href="{{ route('mmatauang') }}">Master Mata Uang</a></li>
            @endif
            @if($mcust_open == 'Y')
                <li><a class="nav-link" href="{{ route('mcust') }}">Master Data Customer</a></li>
            @endif
            @if($msupp_open == 'Y')
                <li><a class="nav-link" href="{{ route('msupp') }}">Master Data Supplier</a></li>
            @endif
            @if($mlokasi_open == 'Y')
                <li><a class="nav-link" href="{{ route('mwhse') }}">Master Data Lokasi</a></li>
            @endif
            @if($mcabang_open == 'Y')
                <li><a class="nav-link" href="{{ route('mnamacabang') }}">Master Data Nama Cabang</a></li>
            @endif
        </ul>
    </li>
    <li class="menu-header">Transaction</li>
    <li class="nav-item dropdown">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-exchange-alt"></i>
            <span>Transaction</span></a>
        <ul class="dropdown-menu">
            @if($tpembelianbrg_open == 'Y')
                <li><a class="nav-link" href="{{ route('transbelibrg') }}">Pembelian Barang</a></li>
                <li><a class="nav-link" href="{{ route('tbelibrglist') }}">Pembelian Barang List</a></li>
            @endif
            @if($tpos_open == 'Y')
                <li><a class="nav-link" href="{{ route('tpos') }}">Point of Sales</a></li>
                <li><a class="nav-link" href="{{ route('tposlist') }}">Point of Sales List</a></li>
            @endif
            @if($tops_open == 'Y')
                <li><a class="nav-link" href="{{ route('tbayarops') }}">Pembayaran Operasional</a></li>
                <li><a class="nav-link" href="{{ route('tbayaropslist') }}">Pembayaran Ops. List</a></li>
            @endif
            @if($tjvouch_open == 'Y')
                <li><a class="nav-link" href="{{ route('tjurnalvoucher') }}">Journal Voucher</a></li>
                <li><a class="nav-link" href="{{ route('tjurnalvoucherlist') }}">Journal Voucher List</a></li>
            @endif
            @if($tpenerimaan_open == 'Y')
                <li><a class="nav-link" href="{{ route('tpenerimaan') }}">Penerimaan Barang</a></li>
                <li><a class="nav-link" href="{{ route('tpenerimaanlist') }}">Penerimaan Barang List</a></li>
            @endif
            {{-- @if($mcabang_open == 'Y')
                <li><a class="nav-link" href="{{ route('tpembelian') }}">Pembelian</a></li>
            @endif --}}
            {{-- <li><a class="nav-link" href="{{ route('tpengeluaranbrg') }}">Penjualan Barang</a></li>
            <li><a class="nav-link" href="{{ route('tpengeluaranbrglist') }}">Penjualan Barang List</a></li> --}}
        </ul>
    </li>
    <li class="menu-header">Reports</li>
    <li class="nav-item dropdown">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-chart-bar"></i>
            <span>Reports</span></a>
        <ul class="dropdown-menu">
            <li><a class="nav-link" href="{{ route('rpenjualan') }}">Laporan Penjualan</a></li>
            <li><a class="nav-link" href="{{ route('rpembelian') }}">Laporan Pembelian</a></li>
            <li><a class="nav-link" href="{{ route('rstock') }}">Laporan Stock</a></li>
        </ul>
    </li>
    {{-- <li><a class="nav-link" href="blank.html"><i class="far fa-square"></i> <span>Blank Page</span></a></li>
    <li class="nav-item dropdown">
        <a href="#" class="nav-link has-dropdown"><i class="fas fa-th"></i> <span>Bootstrap</span></a>
        <ul class="dropdown-menu">
            <li><a class="nav-link" href="bootstrap-alert.html">Alert</a></li>
            <li><a class="nav-link" href="bootstrap-badge.html">Badge</a></li>
            <li><a class="nav-link" href="bootstrap-breadcrumb.html">Breadcrumb</a></li>
            <li><a class="nav-link" href="bootstrap-buttons.html">Buttons</a></li>
            <li><a class="nav-link" href="bootstrap-card.html">Card</a></li>
            <li><a class="nav-link" href="bootstrap-carousel.html">Carousel</a></li>
            <li><a class="nav-link" href="bootstrap-collapse.html">Collapse</a></li>
            <li><a class="nav-link" href="bootstrap-dropdown.html">Dropdown</a></li>
            <li><a class="nav-link" href="bootstrap-form.html">Form</a></li>
            <li><a class="nav-link" href="bootstrap-list-group.html">List Group</a></li>
            <li><a class="nav-link" href="bootstrap-media-object.html">Media Object</a></li>
            <li><a class="nav-link" href="bootstrap-modal.html">Modal</a></li>
            <li><a class="nav-link" href="bootstrap-nav.html">Nav</a></li>
            <li><a class="nav-link" href="bootstrap-navbar.html">Navbar</a></li>
            <li><a class="nav-link" href="bootstrap-pagination.html">Pagination</a></li>
            <li><a class="nav-link" href="bootstrap-popover.html">Popover</a></li>
            <li><a class="nav-link" href="bootstrap-progress.html">Progress</a></li>
            <li><a class="nav-link" href="bootstrap-table.html">Table</a></li>
            <li><a class="nav-link" href="bootstrap-tooltip.html">Tooltip</a></li>
            <li><a class="nav-link" href="bootstrap-typography.html">Typography</a></li>
        </ul>
    </li> --}}
    {{-- <li><a class="nav-link" href="credits.html"><i class="fas fa-pencil-ruler"></i> <span>Credits</span></a></li>
</ul> --}}

{{-- <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
    <a href="https://getstisla.com/docs" class="btn btn-primary btn-lg btn-block btn-icon-split">
        <i class="fas fa-rocket"></i> Documentation
    </a>
</div> --}}