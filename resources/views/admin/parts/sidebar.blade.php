<div id="sidebar" class="app-sidebar">
  <!-- BEGIN scrollbar -->
  <div class="app-sidebar-content" data-scrollbar="true" data-height="100%">
    <!-- BEGIN menu -->
    <div class="menu">
      
      <div class="menu-header">Navigasi</div>
      <div class="menu-item {{ Request::is('landing_admin') ? 'active' : '' }}">
        <a href="{{ route('landing-admin') }}" class="menu-link">
          <div class="menu-icon">
            <i class="fa fa-th-large"></i>
          </div>
          <div class="menu-text">Dashboard</div>
        </a>
      </div>

      <div class="menu-item has-sub {{ Request::is('master/*') ? 'active' : '' }}" <?= (Auth()->user()->role == 'Pembeli' || Auth()->user()->role == 'Supplier' || Auth()->user()->role == 'Pemilik' ? 'hidden' : '') ?>>
        <a href="javascript:void(0)" class="menu-link">
          <div class="menu-icon">
            <i class="fa fa-database"></i>
          </div>
          <div class="menu-text">Data Master</div> 
          <div class="menu-caret"></div>
        </a>
        <div class="menu-submenu" style="display: {{ Request::is('master/*') ? 'block' : 'none' }};">

          <div class="menu-item {{ Request::is('master/kategori') ? 'active' : '' }}">
            <a href="{{ route('master-kategori') }}" class="menu-link">
              <div class="menu-text">Kategori</div>
            </a>
          </div>

          <div class="menu-item {{ Request::is('master/satuan') ? 'active' : '' }}">
            <a href="{{ route('master-satuan') }}" class="menu-link">
              <div class="menu-text">Satuan Barang</div>
            </a>
          </div>
          
          <div class="menu-item {{ Request::is('master/supplier') ? 'active' : '' }}">
            <a href="{{ route('master-supplier') }}" class="menu-link">
              <div class="menu-text">Supplier</div>
            </a>
          </div>

          <div class="menu-item {{ Request::is('master/barang') ? 'active' : '' }}">
            <a href="{{ route('adm-barang') }}" class="menu-link">
              <div class="menu-text">Barang</div>
            </a>
          </div>

        </div>
      </div>


      <div class="menu-item has-sub {{ Request::is('transaksi/*') || Request::is('transaksi') ? 'active' : '' }}" <?= (Auth()->user()->role == 'Pemilik' ? 'hidden' : '') ?>>
        <a href="javascript:;" class="menu-link">
          <div class="menu-icon">
            <i class="fa fa-laptop"></i>
          </div>
          <div class="menu-text">Transaksi</div> 
          <div class="menu-caret"></div>
        </a>
        <div class="menu-submenu" style="display: {{ Request::is('transaksi/*') || Request::is('transaksi') ? 'block' : 'none' }};">

          <div class="menu-item {{ Request::is('transaksi') ? 'active' : '' }}" <?= (Auth()->user()->role == 'Supplier' || Auth()->user()->role == 'Pemilik' ? 'hidden' : '') ?>>
            <a href="{{ route('transaksi') }}" class="menu-link">
              <div class="menu-text">Transaksi Pembelian</div>
            </a>
          </div>

          <div class="menu-item {{ Request::is('transaksi/po') ? 'active' : '' }}" <?= (Auth()->user()->role == 'Pembeli' || Auth()->user()->role == 'Pemilik' ? 'hidden' : '') ?>>
            <a href="{{ route('transaksi-po') }}" class="menu-link">
              <div class="menu-text">Pemesanan Barang (PO)</div>
            </a>
          </div>

          <div class="menu-item {{ Request::is('transaksi/stok_opname') ? 'active' : '' }}" <?= (Auth()->user()->role == 'Admin' ? '' : 'hidden') ?>>
            <a href="{{ route('stok-opname') }}" class="menu-link">
              <div class="menu-text">Stock Opname</div>
            </a>
          </div>

        </div>
      </div>

      <div class="menu-item has-sub {{ Request::is('laporan/*') ? 'active' : '' }}" <?= (Auth()->user()->role == 'Pembeli' || Auth()->user()->role == 'Supplier' ? 'hidden' : '') ?>>
        <a href="javascript:;" class="menu-link">
          <div class="menu-icon">
            <i class="fa fa-print"></i>
          </div>
          <div class="menu-text">Laporan</div> 
          <div class="menu-caret"></div>
        </a>
        <div class="menu-submenu" style="display: {{ Request::is('laporan/*') ? 'block' : 'none' }};">

         
          <div class="menu-item {{ Request::is('laporan/barang') ? 'active' : '' }}">
            <a href="{{ route('laporan-barang') }}" class="menu-link">
              <div class="menu-text">Penjualan Barang</div>
            </a>
          </div>

          <div class="menu-item {{ Request::is('laporan/stok_opname') ? 'active' : '' }}" <?= (Auth()->user()->role == 'Pemilik' ? '' : 'hidden') ?>>
            <a href="{{ route('laporan-opname') }}" class="menu-link">
              <div class="menu-text">Stok Opname</div>
            </a>
          </div>

          <div class="menu-item {{ Request::is('laporan/po') ? 'active' : '' }}" <?= (Auth()->user()->role == 'Pemilik' ? '' : 'hidden') ?>>
            <a href="{{ route('laporan-po') }}" class="menu-link">
              <div class="menu-text">Pemesanan Barang (PO)</div>
            </a>
          </div>

        </div>
      </div>


      <div class="menu-item {{ Request::is('system/users') ? 'active' : '' }}" <?= (Auth()->user()->role == 'Pembeli' || Auth()->user()->role == 'Supplier' || Auth()->user()->role == 'Pemilik' ? 'hidden' : '') ?>>
        <a href="{{ route('users') }}" class="menu-link">
          <div class="menu-icon">
            <i class="fa fa-users"></i>
          </div>
          <div class="menu-text">Daftar Akun</div>
        </a>
      </div>

      <div class="menu-item {{ Request::is('system/logActivity') ? 'active' : '' }}" <?= (Auth()->user()->role == 'Pembeli' || Auth()->user()->role == 'Supplier' || Auth()->user()->role == 'Pemilik' ? 'hidden' : '') ?>>
        <a href="{{ route('logs') }}" class="menu-link">
          <div class="menu-icon">
            <i class="fa fa-list"></i>
          </div>
          <div class="menu-text">Log Aktivitas</div>
        </a>
      </div>



      
      <!-- BEGIN minify-button -->
      <div class="menu-item d-flex">
        <a href="javascript:;" class="app-sidebar-minify-btn ms-auto" data-toggle="app-sidebar-minify"><i class="fa fa-angle-double-left"></i></a>
      </div>
      <!-- END minify-button -->
    </div>
    <!-- END menu -->
  </div>
  <!-- END scrollbar -->
</div>
<div class="app-sidebar-bg"></div>
<div class="app-sidebar-mobile-backdrop"><a href="#" data-dismiss="app-sidebar-mobile" class="stretched-link"></a></div>