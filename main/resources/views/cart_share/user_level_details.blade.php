@extends('ThemePage.layout.home_layout')
@section('content')
<!-- Main content -->
<!-- Main content -->
<style type="text/css">
  .expired-date{
    position: absolute;
    top: 170px;
    font-size: 13px;
    left: 0px;
    right: 0px;
  }
  .expired-div-one{
    width: 22%;
  }
  .expired-div-two{
    width: 78%;
  }
  .expire-cert{
    position: absolute;
    top: 74px;
    left: 0px;
    right: 0px;
    font-size: 26px;
    font-weight: bolder;
    color: #464646;
  }
  .expired-date div{

  }
</style>
<section class="content">
  <div class="row">
    <div class="col-xs-12 certification-level">
      <div class="box box-primary inner-div1">
        <div class="box-header">
          <h3 class="box-title"></h3>
          
        </div>
        <!-- /.box-header -->
        <div class="box-body container">
          <h1 class="certification-title">{{$company_data->company_name}} has {{$cert_type}} the <span style="text-shadow:3px 1px #808080;padding:0px 10px;color:{{$level_color}}"> {{ucwords($level_name)}}</span> Level Business Cybersecurity Certification.</h1>
          <div class="row">
          <div class="{{!empty($expired_date)?'expired-div-one':''}} col-md-2 col-xs-12"> <div class="certification-img">@if(!empty($expired_date))<span class="expire-cert">{{strtoupper($level_name)}}</span>@endif<img {{!empty($expired_date)?'class=img-thumbnail':''}} src="{{$image_file}}">@if(!empty($expired_date))<div class="expired-date">{{$expired_date}}</div>@endif</div></div>
          <div class="{{!empty($expired_date)?'expired-div-two':''}} col-md-10 col-xs-12">
            <h3 style="text-align:left;">Certification requirements are as follows</h3>
            <ul>
              @foreach($certification_feature as $certification_val)
              <li style="text-align: left;">{{$certification_val->feature_name}}</li>
              @endforeach
            </ul>
          </div>
      </div>
      <?php
        // print_r($level_feature_data);die();
      ?>
        @if(!empty($level_feature_data) && $company_data->certification_award_date != NULL && $company_data->certification_status && $payment_status == 2)
          <div id="" class="client_info">
            <h4>Certification Requirements Accomplished</h4>
            <table class="table table-bordered table-hover" style="margin-bottom: 30px;">
              <tbody>
                  @foreach($level_feature_data as $feature_data)
                  <tr>
                    <td class="cert-check"><i class="fa fa-check"></i>&nbsp;&nbsp;</td>
                    <td class="cert-content">{{$feature_data->feature_name}}</td>
                    <td class="cert-date">{{($feature_data->certification_process_date != NULL)?date('M d Y H:i:s',strtotime($feature_data->certification_process_date)):''}}</td>
                  </tr>
                  @endforeach
              </tbody>
            </table>
          </div>
           @endif
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</section>
@endsection
<script type="text/javascript">
</script>