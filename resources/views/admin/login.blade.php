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
            <small>Masuk untuk memulai sesi anda</small>
          </div>
          <div class="icon">
            <i class="fa fa-sign-in-alt"></i>
          </div>
        </div>
        <!-- END login-header -->
        
        <!-- BEGIN login-content -->
        <div class="login-content">
          <form action="{{ route('login') }}" method="POST" class="fs-13px">
            @csrf
            <div class="form-floating mb-15px">
              <input type="text" class="form-control h-45px fs-13px" placeholder="Nama Pengguna" id="username" name="username" />
              <label for="username" class="d-flex align-items-center fs-13px text-gray-600">Nama Pengguna atau Email</label>
            </div>
            <div class="form-floating mb-15px">
              <input type="password" class="form-control h-45px fs-13px" placeholder="Kata Sandi" id="password" name="password" />
              <label for="password" class="d-flex align-items-center fs-13px text-gray-600">Kata Sandi</label>
            </div>
            <div class="form-check mb-30px" hidden>
              <input class="form-check-input" type="checkbox" name="remember_me" value="1" id="rememberMe" />
              <label class="form-check-label" for="rememberMe">
                Ingat Saya
              </label>
            </div>
            <div class="row">
              <div class="col-lg-6">
                Lupa Kata Sandi?
              </div>
              <div class="col-lg-6 text-end">
                <a href="{{ url('lupa_password') }}" style="text-decoration: none;">Klik Disini</a>
              </div>
            </div>
            <br/>
            <div class="mb-15px">
              <button type="submit" class="btn btn-outline-primary d-block h-45px w-100 btn-lg fs-14px">Masuk</button>
            </div>
            <div class="row">
              <div class="col-lg-6">
                Pengguna Baru?
              </div>
              <div class="col-lg-6 text-end">
                <a href="{{ url('register') }}" style="text-decoration: none;">Klik Disini</a>
              </div>
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