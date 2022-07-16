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
            <small>Lupa Kata Sandi</small>
          </div>
          <div class="icon">
            <i class="fa fa-sign-in-alt"></i>
          </div>
        </div>
        <!-- END login-header -->
        
        <!-- BEGIN login-content -->
        <div class="login-content">
          <form action="{{ route('lupa_password') }}" method="POST" class="fs-13px">
            @csrf
            <div class="form-floating mb-15px">
              <input type="email" class="form-control h-45px fs-13px" placeholder="Email" id="email" value="{{ old('email') }}" name="email" />
              <label for="email" class="d-flex align-items-center fs-13px text-gray-600">Email</label>
            </div>
            
            <br/>
            <div class="mb-15px">
              <button type="submit" class="btn btn-outline-primary d-block h-45px w-100 btn-lg fs-14px">Kirim Kode</button>
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