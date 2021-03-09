<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>BCC | {{ Request::path() }}</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="{{url('public/assets/plugins/dist/css/style.css')}}">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{url('public/assets/plugins/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{url('public/assets/plugins/bower_components/font-awesome/css/font-awesome.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{url('public/assets/plugins/bower_components/Ionicons/css/ionicons.min.css')}}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{url('public/assets/plugins/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{url('public/assets/plugins/dist/css/AdminLTE.min.css')}}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{url('public/assets/plugins/dist/css/skins/_all-skins.min.css')}}">
  <!-- Morris chart -->
  <link rel="stylesheet" href="{{url('public/assets/plugins/bower_components/morris.js/morris.css')}}">
  <!-- jvectormap -->
  <link rel="stylesheet" href="{{url('public/assets/plugins/bower_components/jvectormap/jquery-jvectormap.css')}}">
  <!-- Date Picker -->
  <link rel="stylesheet" href="{{url('public/assets/plugins/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
  <!-- Date Time Picker -->
  <link rel="stylesheet" href="{{url('public/assets/plugins/bower_components/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css')}}">
  
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{url('public/assets/plugins/bower_components/bootstrap-daterangepicker/daterangepicker.css')}}">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="{{url('public/assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">
  <link rel="shortcut icon" href="{{url('public/assets/icons')}}/favicon.ico" type="image/x-icon">
  <link rel="icon" href="{{url('public/assets/icons')}}/favicon.ico" type="image/x-icon">

<link rel="apple-touch-icon" sizes="57x57" href="{{url('public/assets/icons')}}/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="{{url('public/assets/icons')}}/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="{{url('public/assets/icons')}}/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="{{url('public/assets/icons')}}/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="{{url('public/assets/icons')}}/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="{{url('public/assets/icons')}}/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="{{url('public/assets/icons')}}/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="{{url('public/assets/icons')}}/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="{{url('public/assets/icons')}}/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="{{url('public/assets/icons')}}/android-icon-192x192.png">
  
<link rel="icon" type="image/png" sizes="32x32" href="{{url('public/assets/icons')}}/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="{{url('public/assets/icons')}}/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="{{url('public/assets/icons')}}/favicon-16x16.png">
<link rel="manifest" href="{{url('public/assets/icons')}}/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="{{url('public/assets/icons')}}/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">


  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <!-- jQuery 3 -->
  <script src="{{url('public/assets/plugins/bower_components/jquery/dist/jquery.min.js')}}"></script>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
  <header class="main-header">
    <!-- Logo -->
    <a href="index2.html" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <!-- <span class="logo-mini"><b>A</b>LT</span> -->
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>BCC</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{url('public/assets/plugins/dist/img/user_avtar.jpg')}}" class="user-image" alt="User Image">
              <?php 
                $user_data = Auth::user();
                if($user_data == null){
                    $user_data = Session::get('user');
                    $user_data->name =  $user_data->first_name.' '.$user_data->last_name;
                    $user_data->created_at = $user_data->registered_at;
                }
              ?>
              <span class="hidden-xs">{{$user_data->name}}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="{{url('public/assets/plugins/dist/img/user_avtar.jpg')}}" class="img-circle" alt="User Image">

                <p>
                  {{$user_data->name}}
                  <small>Member since {{date('d M Y', strtotime($user_data->created_at))}}</small>
                </p>
              </li>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="{{url('admin/dashboard')}}" class="btn btn-default btn-flat">Dashboard</a>
                </div>
                <div class="pull-right">
                      <a href="{{ route('logout') }}" class="btn btn-default btn-flat"
                          onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();">
                          Sign out
                      </a>

                      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                          {{ csrf_field() }}
                      </form>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>