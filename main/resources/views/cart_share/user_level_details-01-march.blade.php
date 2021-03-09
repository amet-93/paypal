@extends('ThemePage.layout.home_layout')
@section('content')
<!-- Main content -->
<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12 certification-level">
      <div class="box box-primary inner-div1">
        <div class="box-header">
          <h3 class="box-title"></h3>
          
        </div>
        <!-- /.box-header -->
        <div class="box-body container">
          <h1 class="certification-title">{{$company_data->company_name}} has earned the <span style="color:{{$level_color}}"> {{ucwords($level_name)}}</span> Level Mortgage Industry Cybersecurity Certification.</h1>
          <div class="row">
		  <div class="col-md-2 col-xs-12"> <div class="certification-img"> <img src="{{$image_file}}"></div></div>
          <div class="col-md-10 col-xs-12">
            <h3 style="text-align:left;">Certification requirements are as follows</h3>
            <ul>
              @foreach($certification_feature as $certification_val)
              <li style="text-align: left;">{{$certification_val->feature_name}}</li>
              @endforeach
            </ul>
          </div>
		  </div>
          <div id="no-more-tables" class="client_info">
            <h4>Certification Requirements Accomplished</h4>
            <table class="table table-bordered table-hover management-table" style="margin-bottom: 30px;">
              
              <tbody>
                <tr>
                  <th>Certification level</th>
                  <td>{{ucwords($level_name)}}</td>
                  <td><i class="fa fa-check"></i></td>
                </tr>
                @if(!empty($company_data->certification_renewal_date))
                  <tr>
                    <th>Certification renewal date</th>
                    <td>{{$company_data->certification_renewal_date}}</td>
                    <td><i class="fa fa-check"></i></td>
                  </tr>
                @endif
                @if(!empty($company_data->certification_date))
                  <tr>
                    <th>Certification start date</th>
                    <td>{{$company_data->certification_date}}</td>
                    <td><i class="fa fa-check"></i></td>
                  </tr>
                @endif
                @if(!empty(get_process_info_data($company_data->primary_id,'cybersecurity program commitment letter received')->who_action))
                  <tr>
                    <th>Completed program committment letter received</th>
                    <td>{{get_process_info_data($company_data->primary_id,'cybersecurity program commitment letter received')->who_action}}</td>
                    <td><i class="fa fa-check"></i></td>
                  </tr>
                @endif
                <tr>
                  <th>Encrypted email communication established</th>
                  <td>{{ucwords($user_level->first_name.' '.$user_level->last_name)}}</td>
                  <td><i class="fa fa-check"></i></td>
                </tr>
                @if(!empty(get_process_info_data($company_data->primary_id,'cybersecurity self-assessment received')->who_action) && ($level_name == 'bronze' || $level_name == 'silver'))
                  <tr>
                    <th>Completed self-assessment received</th>
                    <td>{{get_process_info_data($company_data->primary_id,'cybersecurity self-assessment received')->who_action}}</td>
                    <td><i class="fa fa-check"></i></td>
                  </tr>
                @endif
                @if(!empty(get_process_info_data($company_data->primary_id,'cybersecurity self-assessment reviewed')->who_action) && ($level_name == 'silver'))
                  <tr>
                    <th>Completed self-assessment reviewed</th>
                    <td>{{get_process_info_data($company_data->primary_id,'cybersecurity self-assessment reviewed')->who_action}}</td>
                    <td><i class="fa fa-check"></i></td>
                  </tr>
                @endif
                @if(!empty(get_process_info_data($company_data->primary_id,'cybersecurity 3rd party assessment received')->who_action) && ($level_name == 'bronze' || $level_name == 'silver'))
                  <tr>
                    <th>Third-party assessment received</th>
                    <td>{{get_process_info_data($company_data->primary_id,'cybersecurity 3rd party assessment received')->who_action}}</td>
                    <td><i class="fa fa-check"></i></td>
                  </tr>
                @endif
                @if(!empty(get_process_info_data($company_data->primary_id,'cybersecurity 3rd party assessment reviewed')->who_action) && ($level_name == 'bronze' || $level_name == 'silver'))
                  <tr>
                    <th>Third-party assessment reviewed</th>
                    <td>{{get_process_info_data($company_data->primary_id,'cybersecurity 3rd party assessment reviewed')->who_action}}</td>
                    <td><i class="fa fa-check"></i></td>
                  </tr>
                @endif
                @if(!empty(get_process_info_data($company_data->primary_id,'Company-wide cybersecurity program announcement received')->who_action))
                  <tr>
                    <th>Company wide announcement confirmation received</th>
                    <td>{{get_process_info_data($company_data->primary_id,'Company-wide cybersecurity program announcement received')->who_action}}</td>
                    <td><i class="fa fa-check"></i></td>
                  </tr>
                @endif
                @if(!empty(get_process_info_data($company_data->primary_id,'Cybersecurity company partner relationship confirmation letter sent')->who_action))
                  <tr>
                    <th>Cybersecurity company relationship letter sent</th>
                    <td>{{get_process_info_data($company_data->primary_id,'Cybersecurity company partner relationship confirmation letter sent')->who_action}}</td>
                    <td><i class="fa fa-check"></i></td>
                  </tr>
                @endif
                @if(!empty(get_process_info_data($company_data->primary_id,'Cybersecurity company partner relationship confirmation letter received')->who_action))
                  <tr>
                    <th>Completed cybersecurity company relationship letter received</th>
                    <td>{{get_process_info_data($company_data->primary_id,'Cybersecurity company partner relationship confirmation letter received')->who_action}}</td>
                    <td><i class="fa fa-check"></i></td>
                  </tr>
                @endif
                <tr>
                  <th>Logo installed on website</th>
                  <td>{{$disclaimer_data->url}}</td>
                  <td><i class="fa fa-check"></i></td>
                </tr>
                @if(!empty(get_process_info_data($company_data->primary_id,'Cybersecurity program improvement schedule received')->who_action) && ($level_name == 'silver' || $level_name == 'gold' || $level_name == 'platinum'))
                  <tr>
                    <th>Cybersecurity program improvement schedule letter received</th>
                    <td>{{get_process_info_data($company_data->primary_id,'Cybersecurity program improvement schedule received')->who_action}}</td>
                    <td><i class="fa fa-check"></i></td>
                  </tr>
                @endif
                @if(!empty(get_process_info_data($company_data->primary_id,'   SSL/TLS installation notice received')->who_action) && ($level_name == 'silver' || $level_name == 'gold' || $level_name == 'platinum'))
                  <tr>
                    <th>Install SSL/TLS  certificate on website(s)</th>
                    <td>{{get_process_info_data($company_data->primary_id,'   SSL/TLS installation notice received')->who_action}}</td>
                    <td><i class="fa fa-check"></i></td>
                  </tr>
                @endif
                @if(!empty(get_process_info_data($company_data->primary_id,'CISO relationship letter received')->who_action) && ($level_name == 'gold' || $level_name == 'platinum'))
                  <tr>
                    <th>vCISO relationship letter received</th>
                    <td>{{get_process_info_data($company_data->primary_id,'CISO relationship letter received')->who_action}}</td>
                    <td><i class="fa fa-check"></i></td>
                  </tr>
                @endif
                @if(!empty(get_process_info_data($company_data->primary_id,'Website/network scans')->who_action) && ($level_name == 'platinum'))
                  <tr>
                    <th>Website/network scans</th>
                    <td>{{get_process_info_data($company_data->primary_id,'Website/network scans')->who_action}}</td>
                    <td><i class="fa fa-check"></i></td>
                  </tr>
                @endif
                @if(!empty(get_process_info_data($company_data->primary_id,'the NY DFS Program (or equivalent) successfully implemented')->who_action) && ($level_name == 'platinum'))
                  <tr>
                    <th>NY DFS Program (or equivalent) successfully implemented</th>
                    <td>{{get_process_info_data($company_data->primary_id,'the NY DFS Program (or equivalent) successfully implemented')->who_action}}</td>
                    <td><i class="fa fa-check"></i></td>
                  </tr>
                @endif
                @if(!empty(get_process_info_data($company_data->primary_id,'Cybersecurity program level maintenance commitment letter received')->who_action) && ($level_name == 'platinum'))
                  <tr>
                    <th>Cybersecurity program level maintenance commitment letter received</th>
                    <td>{{get_process_info_data($company_data->primary_id,'Cybersecurity program level maintenance commitment letter received')->who_action}}</td>
                    <td><i class="fa fa-check"></i></td>
                  </tr>
                @endif
              </tbody>
            </table>
          </div>
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