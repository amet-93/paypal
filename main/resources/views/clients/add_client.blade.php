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
      Add Client
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
            	<!-- /.box-header -->
				<!-- form start -->
				<form role="form" method="post" action="{{url('admin/create')}}" name="add_client" class="client-form">
					<input type="hidden" name="_token" value="{{csrf_token()}}">
					<div class="box-body" style="border-bottom: 1px solid #d2d6de;">
						<!-- <h3 class="box-title">Company Details</h3> -->
						<div class="form-group">
							<label for="Companyname">Company Name</label>
							<input type="text" class="form-control" id="Companyname" name="company_name" placeholder="Enter Company Name" value="{{old('company_name')}}">
						</div>
						<div class="form-group">
							<label for="ClientFirstname">First Name</label>
							<input type="text" class="form-control" id="ClientFirstname" name="first_name" placeholder="Enter Fristname" value="{{old('first_name')}}">
						</div>
						<div class="form-group">
							<label for="ClientLastname">Last Name</label>
							<input type="text" class="form-control" id="ClientLastname" name="last_name" placeholder="Enter Lastname" value="{{old('last_name')}}">
						</div>
						<div class="form-group">
							<label for="ClientPassword">Password</label>
							<input type="password" class="form-control" name="password" id="ClientPassword" placeholder="Password" value="{{old('password')}}">
						</div>
						<div class="form-group">
							<label for="ClientEmail">Email Provider</label>
							<input type="text" class="form-control" name="email_provider" id="ClientEmailProvider" placeholder="Enter email provider" value="{{old('email_provider')}}">
						</div>
						<div class="form-group">
							<label for="ClientEmail">Email</label>
							<input type="email" class="form-control" name="email_id" id="ClientEmail" placeholder="Enter email" value="{{old('email_id')}}">
						</div>
						<div class="form-group">
							<label for="ClientEmail">Email Notes</label>
							<textarea class="form-control" rows="3" name="email_notes" id="ClientEmailNotes" placeholder="Enter email notes">{{old('email_notes')}}</textarea>
						</div>
					</div>
		          	<div class="box-footer">
		            	<button type="submit" class="btn btn-primary" id="client_submit">Submit</button>
		          	</div>
            	</form>
      		</div>
      	<!-- /.box -->
    	</div>
   	</div>
  	<!-- /.row -->
</section>
@endsection