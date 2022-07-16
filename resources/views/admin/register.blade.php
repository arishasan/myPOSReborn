@include('admin.logparts.top')
      
      <!-- BEGIN login-container -->
      <div class="login-container">
        <!-- BEGIN login-header -->
        <div class="login-header mb-30px">
          <div class="brand">
            <div class="d-flex align-items-center">
            <!-- <img src="{{ asset('assets') }}/logo/logo.png" class="img-responsive" width="15%" alt="">        -->
              
              <b>My POS</b> Basic 
            </div>
            <small>Daftar akun baru</small>
          </div>
          <div class="icon">
            <i class="fa fa-sign-in-alt"></i>
          </div>
        </div>
        <!-- END login-header -->
        
        <!-- BEGIN login-content -->
        <div class="login-content">
          <form action="{{ route('register') }}" method="POST" class="fs-13px">
            @csrf
            <div class="form-floating mb-15px">
              <select name="role" id="role" class="form-control fs-13px">
                <option value="Pembeli">Pembeli</option>
                <option value="Supplier">Supplier</option>
              </select>
              <label for="role" class="d-flex align-items-center fs-13px text-gray-600">Type</label>
            </div>
            <div class="form-floating mb-15px" id="holder_supplier" hidden>
              <select name="supplier" id="supplier" class="form-control fs-13px">
                <option value="">[ Silahkan Pilih ]</option>
                @foreach($data_supplier as $val)
                  <option value="{{ $val->id }}">{{ $val->nama }}</option>
                @endforeach
              </select>
              <label for="supplier" class="d-flex align-items-center fs-13px text-gray-600">Nama Supplier &nbsp;<small>(Pilih jika anda sebagai supplier)</small></label>
            </div>
            <div class="form-floating mb-15px">
              <input type="email" class="form-control h-45px fs-13px" placeholder="Email" id="email" name="email" value="{{ old('email') }}" required />
              <label for="email" class="d-flex align-items-center fs-13px text-gray-600">Email &nbsp;<small>(Digunakan untuk verifikasi kode lupa password)</small></label>
            </div>
            <div class="form-floating mb-15px">
              <input type="text" class="form-control h-45px fs-13px" placeholder="Nama" id="nama" name="nama" value="{{ old('nama') }}" required />
              <label for="nama" class="d-flex align-items-center fs-13px text-gray-600">Nama</label>
            </div>
            <div class="form-floating mb-15px">
              <input type="text" class="form-control h-45px fs-13px" placeholder="Nama Pengguna" id="username" value="{{ old('username') }}" name="username" required />
              <label for="username" class="d-flex align-items-center fs-13px text-gray-600">Username</label>
            </div>
            <div class="form-floating mb-15px">
              <input type="password" class="form-control h-45px fs-13px" placeholder="Kata Sandi" id="password" name="password" required />
              <label for="password" class="d-flex align-items-center fs-13px text-gray-600">Kata Sandi</label>
            </div>
            <div class="form-floating mb-15px">
              <input type="password" class="form-control h-45px fs-13px" placeholder="Kata Sandi" id="c-password" name="password_confirmation" required />
              <label for="c-password" class="d-flex align-items-center fs-13px text-gray-600">Konfirmasi Kata Sandi</label>
            </div>
            <br/>
            <div class="mb-15px">
              <button type="submit" class="btn btn-outline-primary d-block h-45px w-100 btn-lg fs-14px">Daftar</button>
            </div>
            <div class="mb-15px">
              <a href="{{ route('login') }}" class="btn btn-outline-warning d-block h-45px w-100 btn-lg fs-14px">Kembali</a>
            </div>
            <br/>
            <div class="mb-40px pb-40px text-inverse">
              @include('admin.parts.feedback')
            </div>
            <hr class="bg-gray-600 opacity-2" />
            <div class="text-gray-600 text-center text-gray-500-darker mb-0">
              &copy; 2022. All Right Reserved.
            </div>
          </form>
        </div>
        <!-- END login-content -->
      </div>
      <!-- END login-container -->
@include('admin.logparts.bot')