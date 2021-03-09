<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <!-- <li class="header">MAIN NAVIGATION</li> -->
        <style type="text/css">
          .active{
            background-color: inherit;
          }
        </style>
        <?php 
          $route_url = explode('/',Request::path());
         if(in_array('user', $route_url)){
            $user_id = !empty(Session::get('user'))?Session::get('user')->id:null;
            $award_data = get_awarded_data($user_id);
            $user_data = $award_data['award_data'];
            $current_date = date('Y-m-d');
            $expire_date = date('Y-m-d',strtotime($user_data->certification_date));
            $renew_date = date('Y-m-d',strtotime($user_data->certification_renewal_date ));
            $verify = !empty($user_data)?$user_data->certification_status:NUll;
            $payment_status = !empty($award_data['payment_info'])?$award_data['payment_info']->status:NULL;
          }
        ?>
        @if(!in_array('user', $route_url))
        <li class="{{(Request::path()  == 'admin/dashboard' || Request::path()  == 'admin') ? 'active' : ''}}">
          <a href="{{url('admin/dashboard')}}" style="border-left-color:inherit;">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
        <?php $route_name = Route::currentRouteName();?>
        <li class="treeview {{$route_name =="clients.addClient" || $route_name =="clients.clients_list" || $route_name=="clients.certification_details" ? 'menu-open' :''}}">
          <a href="#">
            <i class="fa fa-user"></i>
            <span>Client Management</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu" {{$route_name == "clients.addClient" ||$route_name=="clients.clients_list" || $route_name=="clients.certification_details" ? 'style=display:block;' : ''}}>
            <li class="{{ Route::currentRouteName() == "clients.clients_list" ? 'active' : '' }}"><a href="{{url('admin/Clients')}}"><i class="fa fa-circle-o"></i>Manage Clients</a></li>
            <li class="{{ Route::currentRouteName() == "clients.addClient" ? 'active' : '' }}"><a href="{{url('admin/addClients')}}"><i class="fa fa-circle-o"></i>Add Clients</a></li>
          </ul>
        </li>
        @else
          <li class="{{(Request::path()  == 'user/dashboard' || Request::path()  == 'user') ? 'active' : ''}}">
            <a href="{{url('user/dashboard')}}" style="border-left-color:inherit;">
              <i class="fa fa-dashboard"></i> <span>User Dashboard</span>
            </a>
          </li>
          <li class="{{(Request::path()  == 'user/generatecode') ? 'active' : ''}}">
         @if(($current_date < $expire_date) && ($current_date > $renew_date))
            <a href="javascript:void(0);" style="border-left-color:inherit;" data-toggle="tooltip" data-placement="right" title="Your purchase certification has been expired, Certification purchase and approval is required before certification image code can be generated ."><i class="fa fa-code" aria-hidden="true"></i> <span>Generate Code</span></a>
          @elseif(($verify == 1 || $verify == NULL) && ($payment_status == 1 || $payment_status== NULL))
           <a href="javascript:void(0);" style="border-left-color:inherit;" data-toggle="tooltip" data-placement="right" title="Certification 
	purchase and approval is required before certification image code can be 
	generated"><i class="fa fa-code" aria-hidden="true"></i> <span>Generate Code</span></a>
            @else
            <a href="{{url('user/generatecode')}}" style="border-left-color:inherit;">
              <i class="fa fa-code" aria-hidden="true"></i> <span>Generate Code</span>
            </a>
            @endif
          </li>
          <li class="{{(Request::path()  == 'user/certification-level-dashboard') ? 'active' : ''}}">
            <a href="{{url('user/certification-level-dashboard')}}" style="border-left-color:inherit;">
              <i class="fa fa-certificate" aria-hidden="true"></i> <span>Purchase/Upgrade Certification</span>
            </a>
          </li>
          <li class="{{(Request::path()  == 'user/certification-details/'.$user_id) ? 'active' : ''}}">
            <a href="{{url('user/certification-details/'.$user_id)}}" style="border-left-color:inherit;">
              <i class="fa fa-certificate" aria-hidden="true"></i> <span>Visitor History</span>
            </a>
          </li>
        @endif
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>