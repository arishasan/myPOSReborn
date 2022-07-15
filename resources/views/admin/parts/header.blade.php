<div id="header" class="app-header app-header-inverse">
	<!-- BEGIN navbar-header -->
	<div class="navbar-header">
		<a href="{{ route('landing-admin') }}" class="navbar-brand"><!-- <img src="{{ asset('assets') }}/logo/logo_admin.png" class="img-responsive" alt="">&nbsp; --><b>My POS</b>Basic</a>
		<button type="button" class="navbar-mobile-toggler" data-toggle="app-sidebar-mobile">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
	</div>
	<!-- END navbar-header -->
	<!-- BEGIN header-nav -->
	<div class="navbar-nav">

		@php
			$notif_po_baru_supplier = App\Models\DashboardModel::widget_notif_po_baru();
			$notif_barang_stok_kurang = App\Models\DashboardModel::widget_barang_kurang();
			$notif_count = count($notif_po_baru_supplier) + count($notif_barang_stok_kurang);

			$array_notif = array();

			function date_compare($element1, $element2) {
			    $datetime1 = strtotime($element1['datetime']);
			    $datetime2 = strtotime($element2['datetime']);
			    return $datetime2 - $datetime1;
			}

			if(count($notif_po_baru_supplier) > 0){

				foreach($notif_po_baru_supplier as $val){
					$temp = array(
						'icon' => 'envelope',
						'text' => 'Pemesanan Barang Baru dari Admin',
						'content' => 'Tanggapi pemesanan barang baru sekarang.',
						'link' => url('transaksi/po/lanjut/PROSES/').'/'.md5($val['id']),
						'datetime' => $val['created_at']
					);

					array_push($array_notif, $temp);
				}

			}

			if(count($notif_barang_stok_kurang) > 0){

				foreach($notif_barang_stok_kurang as $val){
					$temp = array(
						'icon' => 'info',
						'text' => 'Stok Barang Menipis!',
						'content' => $val['kode'] . ' - '. $val['nama'] .' Sisa stoknya tinggal ('.$val['stok'].')',
						'link' => 'javascript:void(0)',
						'datetime' => date('Y-m-d H:i:s')
					);

					array_push($array_notif, $temp);
				}

			}

			usort($array_notif, 'date_compare');

			$notif_count = count($array_notif);

		@endphp

		<div class="navbar-item dropdown">
			<a href="#" data-bs-toggle="dropdown" class="navbar-link dropdown-toggle icon">
				<i class="fa fa-bell"></i>
				<span class="badge">{{ $notif_count }}</span>
			</a>
			<div class="dropdown-menu media-list dropdown-menu-end">
			
				<div class="dropdown-header">NOTIFICATIONS ({{ $notif_count }})</div>
				<div data-scrollbar="true" data-height="280px">
			      
			      	@if(count($array_notif) > 0)
						
						@foreach($array_notif as $val)

							<a href="{{ $val['link'] }}" class="dropdown-item media">
								<div class="media-left">
									<i class="fa fa-{{ $val['icon'] }} media-object bg-gray-400"></i>
									<!-- <i class="fab fa-google text-warning media-object-icon fs-14px"></i> -->
								</div>
								<div class="media-body">
									<label class="media-heading fs-10px">{{ $val['text'] }}</label>
									<p class="fs-10px">{{ $val['content'] }}</p>
									<div class="text-muted fs-10px">{{ App\Models\HelperModel::time_elapsed_string($val['datetime']) }}</div>
								</div>
							</a>

						@endforeach

					@endif

			    </div>
				<!-- <div class="dropdown-footer text-center">
					<a href="javascript:;" class="text-decoration-none">View more</a>
				</div> -->
			</div>
		</div>

		@php
		  $imgHeader = '';

		  if(Auth()->user()->photo_url == null || Auth()->user()->photo_url == ""){
		      $imgHeader = asset('assets').'/logo/noimage.png';
		  }else{
		      $imgHeader = asset('/').Auth()->user()->photo_url;
		  }
		@endphp

		<div class="navbar-item navbar-user dropdown">
			<a href="#" class="navbar-link dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown">
				<img src="{{ $imgHeader }}" alt="" /> 
				<span>
					<span class="d-none d-md-inline">{{ Auth()->user()->name }}</span>
					<b class="caret"></b>
				</span>
			</a>
			<div class="dropdown-menu dropdown-menu-end me-1">
				<a href="{{ route('my-acc') }}" class="dropdown-item">Akun saya</a>
				<div class="dropdown-divider"></div>
				<a href="{{ route('logout') }}" class="dropdown-item">Log Out</a>
			</div>
		</div>
	</div>
	<!-- END header-nav -->
</div>