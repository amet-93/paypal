@extends('ThemePage.layout.admin_layout')
@section('content')
<!-- Main content -->
<section class="content"  style="float: none;">
  <!-- Small boxes (Stat box) -->
  <div class="row">
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3>{{count(get_client())}}</h3>

          <p>Clients</p>
        </div>
        <div class="icon">
          <i class="ion ion-person"></i>
        </div>
        <a href="{{url('admin/Clients')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
  </div>
  <!-- /.row -->

</section>
<!-- /.content -->
@endsection