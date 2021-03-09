@extends('ThemePage.layout.admin_layout')
@section('content')
<section class="content-header">
  <?php 
    $url = str_replace('/'.basename(request()->path()).'','',Request::path());
    $final_url = str_replace('admin/','',$url);
    $extend = explode('-',$final_url);
    $route_url = explode('/',Request::path());
    $user_url =  explode('-',basename(request()->path()));
  ?>
    <h1>
      Certification Image View Data
      <!-- <small>Control panel</small> -->
    </h1>
  <ol class="breadcrumb">
    <li><a href="{{in_array('user', $route_url) == true?url('user'):url('admin/dashboard')}}"><i class="fa fa-dashboard"></i>{{in_array('user', $route_url) == true?'User':'Dashboard'}}</a></li>
  @if(is_numeric(basename(request()->path())) == true)
      <li class="active"> 
        @if(!empty($extend[1]))
          @for($j= 0; $j < count($extend); $j++)
            {{ucwords($extend[$j].' ')}}
          @endfor
        @else
          {{ucwords($final_url)}}
        @endif
      </li>
    @elseif(in_array('user', $route_url))
       @if(!empty($user_url[1]))
        <li class="active">
          @for($k= 0; $k < count($user_url); $k++)
            {{ucwords($user_url[$k].' ')}}
          @endfor
        </li>
      @else
        <li class="active">{{ucwords(str_replace('user/','',Request::path()))}}</li>
      @endif
    @else
      <li class="active">{{ucwords(str_replace('admin/','',Request::path()))}}</li>
    @endif
  </ol>
</section>
<!-- Main content -->
    <section class="content" style="float: none;">
      <div class="row">
        <div class="col-xs-12">
        	<div class="flash-message">
    			  @foreach (['danger', 'warning', 'success', 'info'] as $msg)
    			    @if(Session::has('alert-' . $msg))

    			    <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
    			    @endif
    			  @endforeach
    			</div> <!-- end .flash-message -->
          <div class="box box-primary">
            <!-- <div class="box-header"> -->
              <!-- <h3 class="box-title">Purchased Certification Details </h3> -->
            <!-- </div> -->
            <!-- /.box-header -->
            <div class="box-body">
              <div id="segment_id" style="visibility: hidden;">{{basename(request()->path())}}</div>
              <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
              <table class="table table-bordered table-hover" style="width: 100%;" id="ip-info">
                  <thead>
                    <tr>
                      <th colspan="5" style="border-bottom: 1px solid;">Viewer Data</th>
                    </tr>
                    <tr>
                      <th>Visit #</th>
                      <th>Ip Address</th>
                      <th>Visit Date</th>
                    </tr>
                  </thead>
                  
                </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
</section>
<script type="text/javascript" src="{{url('public/assets/plugins/dist/js/ip-info-ajaxUSER.js')}}"></script>
@endsection
<script type="text/javascript">
</script>