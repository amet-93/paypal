<!Doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>BCC | Buisness Cybersecurity Certification</title>
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{url('public/assets/plugins/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{url('public/assets/plugins/bower_components/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{url('public/assets/plugins/dist/css/style.css')}}">
    <link rel="stylesheet" href="{{url('public/assets/plugins/dist/css/responsive.css')}}">
    <link href="https://fonts.googleapis.com/css?family=Cabin:400,500,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
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
    <!-- jQuery 3 -->
    <script src="{{url('public/assets/plugins/bower_components/jquery/dist/jquery.min.js')}}"></script>
    <?php 
  $current_path = request()->path();
  $explode_url = explode('/', $current_path);
  if(in_array('certification-levels',$explode_url)){?>
  <!-- Facebook Pixel Code -->
	<script>
	  !function(f,b,e,v,n,t,s)
	  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
	  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
	  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
	  n.queue=[];t=b.createElement(e);t.async=!0;
	  t.src=v;s=b.getElementsByTagName(e)[0];
	  s.parentNode.insertBefore(t,s)}(window, document,'script',
	  'https://connect.facebook.net/en_US/fbevents.js');
	  fbq('init', '776371742558829');
	  fbq('track', 'PageView');
	</script>
	<noscript><img height="1" width="1" style="display:none"
	  src="https://www.facebook.com/tr?id=776371742558829&ev=PageView&noscript=1"
	/></noscript>
	<!-- End Facebook Pixel Code -->
 <?php } ?>
</head>
<body {{(!in_array('user',$explode_url) && isset($errors) && count($errors) > 0)?'class=modal-open':''}} {{(!in_array('user',$explode_url) && isset($errors) && count($errors) > 0)?'style=padding-right:17px':''}}>
<!-- Header -->
<div class="bg-header clearfix main-menu-1">
    <div class="top_header " id="header">
        <div class="row contact-nav">
            <div class="container">
                <div class="col-lg-6 col-md-6 col-sm-8 col-xs-12 font-2">
                    <ul class="contact-nav">
                        <li><a href="callto:303-997-5506"><strong>Phone:</strong> 303-997-5506</a></li>
                        <li><a href="mailto:support@bizcybercert.us"><strong>Email:</strong>support@bizcybercert.us</a></li>
                    </ul>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-4 col-xs-12">
                    <ul class="user-nav">
                         @if(Session::get('user'))
                            <li class="signup"><a href="{{URL::to('user/dashboard')}}" class="btn btn-primary">Go To Dashboard</a></li>
                        @else
                           <li class="signup"><a href="https://bizcybercert.us/join-now.html" class="btn btn-primary">Sign Up Now</a></li>
                        @endif
                        
                        @if(Session::get('user'))
                        <li class="signup"><a href="{{url('user/logout')}}" class="btn btn-default"> Logout</a></li>
                        @else
                        <li class="signup"><a href="{{url('user/login')}}" class="btn btn-default"> Login</a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
        <div class="container clearfix">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Main section containing logo and navigation -->
                    <nav class="navbar" role="navigation">
                        <!-- Brand and toggle get grouped for better mobile display -->
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a class="navbar-brand" href="https://www.cybercecurity.com">
                                <img id="logo-header" src="{{url('public/assets/plugins/dist/img/logo.png')}}" alt="BCC Logo" class="img-responsive">
                            </a>
                        </div>

                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" style="float:right;">
                            <div class="menu-container">
                                <ul class="nav navbar-nav navbar-right">
                                    <li class="menu-item">
                                        <a href="https://bizcybercert.us/">Home</a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="https://bizcybercert.us/dashboard/certification-levels">Certification Levels and Pricing</a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="https://bizcybercert.us/faq.html">FAQs</a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="https://bizcybercert.us/about_us.html">About Us</a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="https://bizcybercert.us/contact_us.html">Contact Us</a>
                                    </li>
                                </ul>
                            </div>
                        </div><!-- /.navbar-collapse -->
                    </nav>
                    <!-- Main section containing logo and navigation ends -->
                </div>
            </div>
        </div>
    </div>
</div>