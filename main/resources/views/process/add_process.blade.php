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
      Certification Process Record
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
				<form role="form" method="POST" action="{{url('admin/add_process/'.$id)}}" name="save_process" id="process-form">
					<input type="hidden" name="_token" value="{{csrf_token()}}">
					<div class="box-body">
						<div class="col-md-5" style="padding-left: 0px;">
							<label for="ActionType">Action Name</label>
						</div>
						<div class="col-md-7" style="padding-right: 0px;">
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<label for="WhoAction">Who accomplished task</label>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label for="WhereAction">Data Storage Location</label>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label for="Notes">Notes</label>
					                </div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label for="CertificationDate">Date Task Completed</label>
					                </div>
								</div>
							</div>	
						</div>
						@foreach($process_action as $key => $process_val)
							<?php 
							
								$plan_data = get_process_log_data($id,$process_val->level_feature_id);
								$plan_id = !empty($plan_data)?$plan_data->id:'';
								$who_action = !empty($plan_data)?$plan_data->who_action:'';
								$where_action = !empty($plan_data)?$plan_data->where_action:'';
								$notes = !empty($plan_data)?$plan_data->notes:'';
								$plan_date = !empty($plan_data)?$plan_data->date:'';
							?>
							<div class="col-md-5" style="padding-left: 0px;">
								<label for="ActionType" {{($process_val->feature_award_allow	== 1)?'class=allowed-process':''}}>{{ucwords($process_val->certification_process)}}</label>
							</div>
							<div class="col-md-7" style="padding-right: 0px;">
								<div class="row">
									<div class="col-md-3">
										<div class="form-group">
											<input type="text" class="form-control" id="WhoAction" name="who_action_[{{(count($info_data)!=0)?$plan_id:$key+1}}]" placeholder="Enter Who ?" value="{{(count($info_data)!=0)?$who_action:old('who_action')}}">
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<input type="text" class="form-control" id="WhereAction" name="where_action_[{{(count($info_data)!=0)?$plan_id:$key+1}}]" placeholder="Enter Where ?" value="{{(count($info_data) !=0)?$where_action:old('where_action')}}">
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<textarea rows="2" cols="25" class="form-control" id="Notes" name="notes_[{{(count($info_data)!=0)?$plan_id:$key+1}}]">{{(count($info_data) !=0)?$notes:old('notes')}}</textarea>
										</div>
									</div>
									<div class="col-md-3">
										 <div class='input-group date'>
						                    <input type='text' class="form-control company_approve_calander" id="process_info_date" name="process_date_[{{(count($info_data)!=0)?$plan_id:$key+1}}]" placeholder="Enter Date" value="{{(count($info_data) !=0)?(!empty($plan_date)?date('M d Y H:i:s',strtotime($plan_date)):''):old('date')}}"/>
						                    <span class="input-group-addon">
						                        <span class="glyphicon glyphicon-calendar"></span>
						                    </span>
						                </div>
									</div>
								</div>	
							</div>
						
						@endforeach
					</div>
              		<!-- /.box-body -->

		          	<div class="box-footer">
		            	<button type="submit" class="btn btn-primary" id="process_submit">Submit</button>
		          	</div>
            	</form>
      		</div>
      	<!-- /.box -->
    	</div>
   	</div>
  	<!-- /.row -->
</section>
@endsection