@extends('ThemePage.layout.home_dashboard_layout')
@section('content')
<!-- Main content -->
<section class="content-header">
  <?php 
    $url = str_replace('/'.basename(request()->path()).'','',Request::path());
    $final_url = str_replace('admin/','',$url);
    $extend = explode('-',$final_url);
    $route_url = explode('/',Request::path());
    $user_url =  explode('-',basename(request()->path()));
  ?>
  <h1>Dashboard</h1>
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
       <!--  <div class="box-header">
          <h3 class="box-title">User Dashboard</h3>
        </div> -->
        <!-- /.box-header -->
        <div class="box-body">
          <form id="edit-user">
            <input type="hidden" name="id" id="user_id" value="{{$client_data->primary_id}}">
            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
            <table class="table table-bordered table-hover datatable-table management-table">
              <thead>
                <tr>
                  <th colspan="3" style="text-align: center;border-bottom: 1px solid;">User Information</th>
                  <!-- <th>Action</th> -->
                </tr>
              </thead>
              <tbody>
                  <tr>
                    <th>First Name</th>
                    <td>
                      <span id="first_name_{{$client_data->primary_id}}">{{$client_data->first_name}}</span>
                      <input type="hidden" name="firstname" id="firstname-{{$client_data->primary_id}}" value="{{$client_data->first_name}}">
                      <a class="col-md-offset-1" href="#" onclick="create_field_editable('first_name','{{$client_data->primary_id}}','firstname')" title="Edit Firstname"><i class="fa fa-edit" aria-hidden="true"></i></a>
                    </td>
                   
                  <tr>
                    <tr>
                    <th>Last Name</th>
                    <td><span id="last_name_{{$client_data->primary_id}}">{{$client_data->last_name}}</span>
                      <input type="hidden" name="lastname" id="lastname-{{$client_data->primary_id}}" value="{{$client_data->last_name}}">
                      <a class="col-md-offset-1" href="#" onclick="create_field_editable('last_name','{{$client_data->primary_id}}','lastname')" title="Edit Lastname"><i class="fa fa-edit" aria-hidden="true"></i></a>
                    </td>
                  <tr>
                  <tr>
                    <th>Email</th>
                    <td>
                      <span id="email_{{$client_data->primary_id}}">{{$client_data->email_id}}</span>
                      <input type="hidden" name="email" id="email-{{$client_data->primary_id}}" value="{{$client_data->email_id}}">
                      <a class="col-md-offset-1" href="#" onclick="create_field_editable('email','{{$client_data->primary_id}}','email')" title="Edit Email"><i class="fa fa-edit" aria-hidden="true"></i></a>
                    </td>
                  <tr>
                  <tr>
                    <th>Password</th>
                    <td>
                      <span id="user_password_{{$client_data->primary_id}}">*************</span>
                      <input type="hidden" id="password-{{$client_data->primary_id}}" value="">
                      <a class="col-md-offset-1" href="#" onclick="create_field_editable('user_password','{{$client_data->primary_id}}','password')" title="Edit Email"><i class="fa fa-edit" aria-hidden="true"></i></a>
                    </td>
                  <tr>
                  <tr>
                    <th>Company Name</th>
                    <td>
                      <span id="company_name_{{$client_data->primary_id}}">{{$client_data->company_name}}</span>
                      <input type="hidden" name="companyname" id="companyname-{{$client_data->primary_id}}" value="{{$client_data->company_name}}">
                      <a class="col-md-offset-1" href="#" onclick="create_field_editable('company_name','{{$client_data->primary_id}}','companyname')" title="Edit Company Name"><i class="fa fa-edit" aria-hidden="true"></i></a>
                    </td>
                    
                  <tr>
                  <tr>
                    <th>Registered Date</th>
                    <td>{{date('M d Y H:i:s',strtotime($client_data->registered_at))}}</td>
                  <tr>
                  <tr>
                    <th></th>
                    <td><button type="submit" class="btn btn-primary user-submit" style="display: none; margin-right: 15px;">Update</button><button type="button" class="btn btn-default user-cancel" id="{{$client_data->primary_id}}" style="display: none;">Cancel</button></td>
                    <td></td>
                  <tr>
                </tbody>
              </table>
            </form>
            <table class="table table-bordered table-hover datatable-table management-table" style="margin-top: 30px;">
             @if(!empty($payment_log))
              <thead>
                <tr>
                  <th colspan="4" style="text-align: center; border-bottom: 1px solid;">Transaction Information</th>
                </tr>
              </thead>
              <tbody>
                @foreach($payment_log as $payment_val)
                  <tr>
                    <td style="width:75%">
                      <table class="table table-bordered table-hover">
                        <tbody>
                          <tr>
                            <th>Payer Name</th>
                            <td>{{$payment_val->name}}</td>
                          <tr>
                          <tr>
                            <th>Payer Email Id</th>
                            <td style="width: 40%;">{{$payment_val->payer_email_id}}</td>
                          <tr>
                          <tr>
                            <th>Amount</th>
                            <td>{{'$'.number_format($payment_val->amount,2)}}</td>
                          <tr>
                          <tr>
                            <th>Product</th>
                            <td>{{$payment_val->product}}</td>
                          <tr>
                            <tr>
                            <th>Payment Id</th>
                            <td>{{$payment_val->payer_id}}</td>
                          <tr>
                          <tr>
                            <tr>
                            <th>Paypal Payment Id</th>
                            <td>{{$payment_val->paypal_payment_id}}</td>
                          <tr>
                        </tbody>
                      </table>
                    </td>
                    <td class="dashboard-cert-img"><a href="<?php echo 'https://'.$_SERVER['SERVER_NAME'].'/dashboard/user/certification-detail/'.substr(uniqid('', true), -4).$client_data->client_id.substr(uniqid('', true), -4).''; ?>"><img src="<?php echo 'https://'.$_SERVER['SERVER_NAME'].'/images/cert_img/bcc_'.$payment_val->level_name.'_click.jpg'; ?>"></a></td>
                  </tr>
                  <tr><td colspan="2" style="padding:0px;border-bottom: 1px solid;"></td></tr>
                @endforeach
              </tbody>
            @endif
          </table>
           @if(!empty($process_info)  && $client_data->certification_award_date != NULL && $client_data->certification_status && $payment_status == 2)
            <div class="box-body" style="border-top: 1px solid">
              <div class="form-group">
                <label for="PrivacyPolicyAcceptanceDate"><h4><b>Certification Awarded:&nbsp;&nbsp;</b>{{date('M d Y H:i:s',strtotime($client_data->certification_award_date))}}</h4></label>
                
              </div>
              <div class="form-group">
                <label for="PrivacyPolicyAcceptanceDate"><h4><b>Completed Certification Milestones</b></h4></label>
                <table class="table table-bordered table-hover" style="margin-bottom: 30px;">
                  <tbody>
                      @foreach($process_info as $feature_val)
                      <tr>
                        <td class="cert-check"><i class="fa fa-check" style="color: #73bd4c;"></i>&nbsp;&nbsp;</td>
                        <td class="cert-content" style="padding-left: 8px !important;">{{$feature_val->feature_name}}</td>
                        <td class="cert-date">{{($feature_val->certification_process_date != NULL)?date('M d Y H:i:s',strtotime($feature_val->certification_process_date)):''}}</td>
                      </tr>
                      @endforeach
                  </tbody>
                </table>
              </div>
            </div>
            @else
             @if(!empty($level_features))
               <div class="box-body" style="border-top: 1px solid">
                <div class="form-group">
                  <label for="PrivacyPolicyAcceptanceDate"><h4><b>{{ucwords($level_action)}}&nbsp;Required Actions</b></h4></label>
                  <table class="table table-bordered table-hover" style="margin-bottom: 30px;">
                    <tbody>
                      @foreach($level_features as $feature_val)
                        <tr>
                          @if($feature_val->complete_process == 'complete')
                            <td class="cert-check" ><i class="fa fa-check" style="color: #73bd4c;"></i>&nbsp;&nbsp;</td>
                          @else
                            <td class="cert-check">&nbsp;&nbsp;</td>
                          @endif
                          <td class="cert-content" style="padding-left: 8px !important;">{{$feature_val->feature_name}}</td>
                          @if($feature_val->complete_process == 'complete')
                            <td class="cert-date">{{($feature_val->date != '')?date('M d Y H:i:s',strtotime($feature_val->date)):''}}</td>
                          @else
                            <td class="cert-date">Not Completed</td>
                          @endif
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
              @endif
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
<script src="{{url('public/assets/plugins/dist/js/user-script.js')}}"></script>
@endsection
<script type="text/javascript">
</script>