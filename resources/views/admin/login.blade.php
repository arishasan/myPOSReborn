<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>My POS Basic | Login</title>
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
  <meta content="" name="description" />
  <meta content="" name="author" />
  
  <!-- ================== BEGIN core-css ================== -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <link href="{{ asset('assets') }}/css/vendor.min.css" rel="stylesheet" />
  <link href="{{ asset('assets') }}/css/default/app.min.css" rel="stylesheet" />
  <!-- ================== END core-css ================== -->
</head>
<body class='pace-top'>
  <!-- BEGIN #loader -->
  <div id="loader" class="app-loader">
    <span class="spinner"></span>
  </div>
  <!-- END #loader -->

  <!-- BEGIN #app -->
  <div id="app" class="app">
    <!-- BEGIN login -->
    <div class="login login-with-news-feed">
      <!-- BEGIN news-feed -->
      <div class="news-feed">
        <div class="news-image" style="background-image: url({{ asset('assets') }}/logo/bg.jpg); transform: scaleX(-1);"></div>
        <div class="news-caption">
          <h4 class="caption-title"><b>My POS</b> Basic</h4>
          <!-- <p>
            Tracking Assets Web
          </p> -->
        </div>
      </div>
      <!-- END news-feed -->
      
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
                <a href="#" style="text-decoration: none;">Klik Disini</a>
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
                <a href="#" style="text-decoration: none;">Klik Disini</a>
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
    </div>
    <!-- END login -->
    
    <!-- BEGIN scroll-top-btn -->
    <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top" data-toggle="scroll-to-top"><i class="fa fa-angle-up"></i></a>
    <!-- END scroll-top-btn -->
  </div>
  <!-- END #app -->
  
  <!-- ================== BEGIN core-js ================== -->
  <script src="{{ asset('assets') }}/js/vendor.min.js"></script>
  <script src="{{ asset('assets') }}/js/app.min.js"></script>
  <script src="{{ asset('assets') }}/js/theme/default.min.js"></script>
  <!-- ================== END core-js ================== -->
</body>
</html>