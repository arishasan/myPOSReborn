<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>My POS Basic | Auth</title>
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