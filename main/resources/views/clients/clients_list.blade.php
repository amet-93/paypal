@extends('ThemePage.layout.admin_layout')
@section('content')
<!-- Main content -->
<style type="text/css">
  .dataTables_scrollHeadInner, .management-table{
    width: 100% !important;
  }
  .warning:hover{
    color: #f39c12;
  }

</style>
<section class="content-header">
  <?php 
    $url = str_replace('/'.basename(request()->path()).'','',Request::path());
    $final_url = str_replace('admin/','',$url);
    $extend = explode('-',$final_url);
    $route_url = explode('/',Request::path());
    $user_url =  explode('-',basename(request()->path()));
  ?>
    <h1>
      Clients Dashboard
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
    <div class="col-xs-12">
    	<div class="flash-message">
			  @foreach (['danger', 'warning', 'success', 'info'] as $msg)
			    @if(Session::has('alert-' . $msg))

			    <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
			    @endif
			  @endforeach
			</div> <!-- end .flash-message -->
      <div class="box box-primary">
        <!-- /.box-header -->
        <div class="box-body">
          <table class="table table-bordered table-hover datatable-table management-table">
            <thead>
            <tr>
            	<!-- <th class="sr_no">Sr. No.</th> -->
            	<th class="date-datatable">Name</th>
            	<th class="date-datatable">Company Name</th>
              <th class="date-datatable">Certification Level</th>
              <th class="email-data">Email</th>
              <th class="date-datatable">Signup Status</th>
            	<th class="email-data">Certification Status</th>
            	<th class="date-datatable">Registered Date</th>
            	<th class="action-data">Action</th>
            </tr>
            </thead>
            <tbody>
            	@foreach($client_data as $key => $client)
                <tr>
                	<!-- <td class="sr_no"></td> -->
                	<td class="date-datatable">{{$client->first_name.' '.$client->last_name}}</td>
                	<td class="date-datatable">{{$client->company_name}}</td>
                  <td class="date-datatable">{{$client->product}}</td>
                  <td class="email-data">{{$client->email_id}}</td>
                  <td class="date-datatable">{{($client->verified == '1')?'Signup & Verified':'Signup'}}</td>
                	<td class="email-data">
                    @if($client->certification_status == 2)
                      Certification Awarded
                    @elseif($client->certification_status == 1)
                      Certification In Process
                    @else
                      None
                    @endif
                    </td>
                	<td class="date-datatable">{{date('M d Y H:i:s',strtotime($client->registered_at))}}</td>
                	<td class="action-data">
                    <a href="{{url('admin/editClient/'.$client->primary_id)}}" title="Edit" class="middle-action"><i class="fa fa-edit" aria-hidden="true"></i></a>
                    <a href="{{url('admin/certification-details/'.$client->primary_id)}}" title="Image Viewer Records" class="warning middle-action"><i class="fa fa-eye" aria-hidden="true"></i></a>
                    <a href="{{url('admin/add-process-info/'.$client->primary_id)}}" class="middle-action" title="Add Process Info"><i class="fa fa-exchange" aria-hidden="true"></i></a>
                    <a href="javascript:void(0)" onclick="delete_client('{{$client->primary_id}}')" title="Delete" class="error"><i class="fa fa-trash" aria-hidden="true"></i></a>
                  </td>
                </tr>
            @endforeach
            </tbody>
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
@endsection
<script type="text/javascript">
  function delete_client(id) {
    if (confirm("Are you sure want to delete!")) {
      var base_url = '<?php echo URL::to('/');?>';
        $.ajax({
          type:'POST',
          url: base_url+'/admin/deleteClient/'+id,
          data:{id:id, "_token": "{{ csrf_token() }}"},
          success:function(response){
            response = JSON.parse(response);
            // alert(response.message);
            window.location.href= base_url+'/admin/Clients';
          }
        });
    } else {
        
    }
    // document.getElementById("demo").innerHTML = txt;
}
</script>