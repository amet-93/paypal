@extends('ThemePage.layout.home_layout')
@section('content')
<!-- Main content -->
<!-- Main content -->
<section class="content" style="float: none;">
  <div class="row">
    <div class="col-xs-12 certification-level">
      <div class="box box-primary inner-div1" style="height: auto;">
      	<p style="text-align: left;margin-bottom: 95px;">
       		I hereby release BCC and/or Cybercecurity, LLC from all liability associated with the certification information I am about to see related to <b>@if($_REQUEST['referrer'] == 'bizcybercert.us') {{'ABC Automotive Franchises'}} @else {{$user_data->company_name}} @endif</b>. This information will be used for my 
			or my company's purposes only.
       	</p>
		<form class="signUp-form" name="disclaimer_signup" action="{{url('user/savedisclaimer')}}" method="POST">
			<?php 
				$segment = basename(request()->path());
				$client_id = substr($segment, 4, -4);
			?>
	        <input type="hidden" name="_token" value="{{csrf_token()}}">
	        <input type="hidden" name="client_id" value="{{$client_id}}">
	        <input type="hidden" name="id" value="{{$segment}}">
	        <input type="hidden" name="url" value="{{$_REQUEST['referrer']}}">
          	<div class="row">
              	<div class="col-md-12">
                  	<div class="dv-center">
                  		<div class="btn-group">
	                  		<button class="btn btn-primary btn-lg submit-btn" type="submit" style="border-radius: 4px !important;"><span class="ladda-label">I Agree</span><span class="ladda-spinner"></span></button>
	                  		<a href="/" class="btn btn-default btn-lg" style="margin-left:20px;border-radius: 4px;">Leave Web Page</a>
	                  		
	                  	</div>
                  	</div>
              	</div>
          	</div>
      	</form>
      <!-- /.box -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</section>
@endsection
<script type="text/javascript">
</script>
<section>
	
</section>