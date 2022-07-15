<head>
  <meta charset="utf-8" />
  <title>My POS Basic | {{ @ucwords(str_replace("/", " ", Request::path())) }}</title>
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
  <meta content="" name="description" />
  <meta content="" name="author" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  
  <!-- ================== BEGIN core-css ================== -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <link href="{{ asset('assets') }}/css/vendor.min.css" rel="stylesheet" />
  <!-- <link href="{{ asset('assets') }}/css/default/app.min.css" rel="stylesheet" /> -->
  <link href="{{ asset('assets') }}/css/facebook/app.min.css" rel="stylesheet" />
  <!-- ================== END core-css ================== -->
  
  <!-- ================== BEGIN page-css ================== -->
  <link href="{{ asset('assets') }}/plugins/jvectormap-next/jquery-jvectormap.css" rel="stylesheet" />
  <link href="{{ asset('assets') }}/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.css" rel="stylesheet" />
  <link href="{{ asset('assets') }}/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" />
  <!-- ================== END page-css ================== -->
</head>