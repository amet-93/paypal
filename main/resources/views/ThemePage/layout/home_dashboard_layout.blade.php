  @include('ThemePage.layout.home_dashboard_header')
   <!-- Left side column. contains the logo and sidebar -->
  @include('ThemePage.layout.master_sidebar')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    
    @yield('content')
  </div>
@include('ThemePage.layout.admin_footer')