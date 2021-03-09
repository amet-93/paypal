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
      Client Data
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
 <section class="content" style="float: none;">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          	<!-- general form elements -->
          	@if($errors->any())
			  <div class="alert alert-danger">
			    <ul>
			      @foreach($errors->all() as $error)
			        <li>{{$error}}</li>
			      @endforeach
			    </ul>
			  </div>
			@endif
			 <div class="flash-message">
			  @foreach (['danger', 'warning', 'success', 'info'] as $msg)
			    @if(Session::has('alert-' . $msg))

			    <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
			    @endif
			  @endforeach
			</div> <!-- end .flash-message -->
      <div class="box box-primary">
				<!-- form start -->
				<form role="form" method="post" action="{{url('admin/edit/'.$clients_data->primary_id)}}" name="edit_client" id="edit-client">
					<input type="hidden" name="_token" value="{{csrf_token()}}">
					<div class="box-body">
						<!-- <h3 class="box-title">Client Details</h3> -->
						<div class="form-group">
							<label for="Companyname">Company Name</label>
							<input type="text" class="form-control" id="Companyname" name="company_name" placeholder="Enter Company Name" value="{{$clients_data->company_name}}">
						</div>
						<div class="form-group">
							<label for="ClientFirstname">First Name</label>
							<input type="text" class="form-control" id="ClientFirstname" name="first_name" placeholder="Enter Fristname" value="{{$clients_data->first_name}}">
						</div>
						<div class="form-group">
							<label for="ClientLastname">Last Name</label>
							<input type="text" class="form-control" id="ClientLastname" name="last_name" placeholder="Enter Lastname" value="{{$clients_data->last_name}}">
						</div>
						<div class="form-group">
							<label for="ClientPassword">Password</label>
							<div class="row">
								<div class="col-md-10" style="padding-right: 0px;">
									<input type="password" class="form-control" id="EditClientPassword" placeholder="Password" value="password" disabled>
								</div>
								<div class="col-md-2">
									<button type="button" class="btn btn-primary pull-right" id="editpassword">Change Password</button>
								</div>
							</div>
						</div>
            @if($awarded_user->payment_status == 2)
            <div class="box-body" style="border-bottom: 1px solid #d2d6de;">
              <!-- <h3 class="box-title">Company Details</h3> -->
              
              <div class="form-group">
                <label for="Companyname">{{($clients_data->payment_status == 2)?'Awarded':''}} Certification Level: </label>
                <span>{{' '.$awarded_user->product}}</span>
              </div>
             <div class="form-group">
                <label for="CertificationDate">Certification Start Date</label>
                <div class='input-group date'>
                  {{($awarded_user->certification_date != NULL)?date('M d Y H:i:s',strtotime($awarded_user->certification_date)):'--'}}
                </div>
              </div>
              <div class="form-group">
                <label for="CertificationAwardDate">Certification Award Date</label>
                <div class='input-group date'>
                  {{($awarded_user->certification_award_date != NULL)?date('M d Y H:i:s',strtotime($awarded_user->certification_award_date)):'--'}}
                </div>
              </div>
              <div class="form-group">
                <label for="CertificationRenewalDate">Certification Renewal Date</label>
                <div class='input-group date'>
                     {{($awarded_user->certification_renewal_date != NULL)?date('M d Y H:i:s',strtotime($awarded_user->certification_renewal_date)):'--'}}
                </div>
              </div>
              <div class="form-group">
                <label for="TermsofUseAcceptanceDate">Terms Of Use Acceptance Date</label>
                <div class='input-group date'>
                    {{($awarded_user->terms_of_use_acceptance_date != NULL)?date('M d Y H:i:s',strtotime($awarded_user->terms_of_use_acceptance_date)):'--'}}
                </div>
              </div>
              <div class="form-group">
                <label for="PrivacyPolicyAcceptanceDate">Privacy Policy Acceptance Date</label>
                <div class='input-group date'>
                    {{($awarded_user->privacy_policy_acceptance_date != NULL)?date('M d Y H:i:s',strtotime($awarded_user->privacy_policy_acceptance_date)):'--'}}
                </div>
              </div>
            </div>
            @endif
            @if($clients_data->payment_status == 1)
						<div class="box-body">
							<!-- <h3 class="box-title">Company Details</h3> -->
							
							<div class="form-group" style="margin-bottom: 0px;">
								<label for="Companyname">In Process Certification Level: </label>
								<span>{{' '.$clients_data->product}}</span>
							</div>
              <input type="hidden" id="payment_stats" name="payment_stats" value="{{($clients_data->certification_status == 2)?'2':'1'}}">
							
							<div class="form-check" style="border-top: inherit;">
                <label id="checkbox-award">
                    @if(!empty($process_info))
                      <input type="checkbox" id="certification-status" name="certification_status" value="{{$clients_data->certification_status}}" {{($clients_data->certification_status == 1)?'checked':''}}>
                    @else
                      <input type="checkbox" id="certification-status" name="certification_status" value="{{$clients_data->certification_status}}">
                    @endif
                    <span class="label-text"><b style="color: #333;">Award {{$clients_data->product}} Certification</b></span>
                </label>
                <label class="error" id="level_awarded"></label>
              </div>
	           <div class="form-group">
              	<label for="CertificationDate">Certification Start Date</label>
                <div class='input-group date'>
                  {{($clients_data->certification_date != NULL)?date('M d Y H:i:s',strtotime($clients_data->create_date)):'--'}}
                </div>
            	</div>
              <div class="form-group">
                <label for="CertificationAwardDate">Certification Award Date</label>
                <div class='input-group date'>
                  {{($clients_data->certification_award_date != NULL && ($clients_data->payment_status != 1))?date('M d Y H:i:s',strtotime($clients_data->certification_award_date)):'--'}}
                </div>
              </div>
            	<div class="form-group">
              	<label for="CertificationRenewalDate">Certification Renewal Date</label>
                <div class='input-group date'>
                    {{($clients_data->certification_renewal_date != NULL && ($clients_data->payment_status != 1))?date('M d Y H:i:s',strtotime($clients_data->certification_renewal_date)):'--'}}
                </div>
            	</div>
            	<div class="form-group">
              	<label for="TermsofUseAcceptanceDate">Terms Of Use Acceptance Date</label>
                <div class='input-group date'>
                    {{($clients_data->terms_of_use_acceptance_date != NULL)?date('M d Y H:i:s',strtotime($clients_data->terms_of_use_acceptance_date)):'--'}}
                </div>
            	</div>
            	<div class="form-group">
              	<label for="PrivacyPolicyAcceptanceDate">Privacy Policy Acceptance Date</label>
                <div class='input-group date'>
                    {{($clients_data->privacy_policy_acceptance_date != NULL)?date('M d Y H:i:s',strtotime($clients_data->privacy_policy_acceptance_date)):'--'}}
                </div>
            	</div>
						</div>
					</div>
          @endif
              		<!-- /.box-body -->

        	<div class="box-footer">
          	<button type="submit" class="btn btn-primary" id="client_submit">Update</button>
        	</div>
      	</form>
      	<!-- /.box -->
  		  @if(!empty($payment_log))
              <!-- <tbody>
                <tr><td><br></td></tr>
              </tbody> -->
            <table class="table table-bordered table-hover" style="margin-top: 30px;">
              <thead>
                <tr>
                  <th colspan="6" style="border-bottom: 1px solid;">Transaction Information</th>
                </tr>
              </thead>
              <tbody>
                @foreach($payment_log as $payment_val)
                  <tr>
                    <td style="width:75%; padding-top: 25px;">
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
                    <td style="width:25%;padding-top: 25px;"><img width="85%" height="230" src="{{url('public/assets/plugins/dist/img/'.$payment_val->level_name.'-02.jpeg')}}"></td>
                  </tr>
                  <tr><td colspan="2" style="padding:0px;border-bottom: 1px solid;"></td></tr>
                @endforeach
              </tbody>
            </table>
            @endif
            
        </table>
        @if(!empty($process_info) && $clients_data->certification_award_date != NULL && $clients_data->certification_status && $payment_status == 2)
        <div class="box-body" style="border-top: 1px solid;">
          <div class="form-group">
            <label for="PrivacyPolicyAcceptanceDate"><h5><b>Completed Certification Milestones</b></h5></label>
            <table class="table table-bordered table-hover" style="margin-bottom: 30px;">
              <tbody>
                  @foreach($process_info as $feature_val)
                  <tr>
                    <td class="cert-content" style="padding-left: 8px !important;">{{$feature_val->feature_name}}</td>
                    <td class="cert-date">{{($feature_val->certification_process_date != NULL)?date('M d Y H:i:s',strtotime($feature_val->certification_process_date)):''}}</td>
                  </tr>
                  @endforeach
              </tbody>
            </table>
          </div>
        </div>
        @endif
      </div>
  	</div>
 	</div>
  	<!-- /.row -->
</section>
<script type="text/javascript">
	$('#certification-status').click(function(){
      var process_info = '<?php echo $process_info_status; ?>';
      if(process_info == 1){
        $('#level_awarded').html('');
        if($(this).prop("checked") == true){
          	$(this).val('2');
            $('#payment_stats').val('2');
      	}else if($(this).prop("checked") == false){
      		$(this).val('1');
          $('#payment_stats').val('1');
      	}
      }else{
        if($('.lebel-break').length < 1){
          $('#checkbox-award').after('<br class="lebel-break">');
        }
        var product = '<?php echo $clients_data->product?>';
        if(product == ''){
          $('#level_awarded').html('If user have no purchase any plan, you can\'t award certification this user.');
        }else{
          $('#level_awarded').html('Please complete <?php echo strtolower($clients_data->product);?> certification features.');
        }
        return false;
      }
	});
</script>
@endsection
<script type="text/javascript"></script>