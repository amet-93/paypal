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
          <h1 class="certification-title">Turnkey Cybersecurity & Privacy Solutions, LLC has earned the <span style="text-shadow:3px 1px #808080;padding:0px 10px;color:#E5E4E2"> Platinum</span> Level Business Cybersecurity Certification.</h1>
          <div class="row">
          <div class=" col-md-2 col-xs-12"> <div class="certification-img"><img src="https://bizcybercert.us/images/cert_img/tcps-certification.jpg"></div></div>
          <div class=" col-md-10 col-xs-12">
            <h3 style="text-align:left;">Certification requirements are as follows</h3>
            <ul>
                            <li style="text-align: left;">Company's leadership publicly commits to the cybersecurity enhancement program</li>
                            <li style="text-align: left;">Leadership's commitment is announced to all company staff</li>
                            <li style="text-align: left;">Company performs the BCC cybersecurity self-assessment </li>
                            <li style="text-align: left;">Or engages 3rd party cybersecurity company to perform a cybersecurity assessment that is aligned with the ISO 27001 standard and the NY DFS regulation</li>
                            <li style="text-align: left;">A relationship is established with a 3rd party cybersecurity company </li>
                            <li style="text-align: left;">Communications between the company and the 3rd party cybersecurity company are conducted via encrypted email</li>
                            <li style="text-align: left;">The company begins a cybersecurity education program for all staff</li>
                            <li style="text-align: left;">The company commits to a cybersecurity improvement schedule</li>
                            <li style="text-align: left;">The company iInstalls a SSL/TLS  certificate on its website(s)</li>
                            <li style="text-align: left;">The company deploys cybersecurity policies</li>
                            <li style="text-align: left;">The company establishes a relationship with a qualified CISO internally or on a contract basis</li>
                            <li style="text-align: left;">A 3rd party cybersecurity assessment is performed on the company's network</li>
                            <li style="text-align: left;">The company increases security awareness training for all staff</li>
                            <li style="text-align: left;">CyberCecurity, LLL performs various technical scans on the company's network and website</li>
                            <li style="text-align: left;">The company implements a comprehensive security program equivalent to that required by the NY DFS reg</li>
                            <li style="text-align: left;">The company commits to maintain security program at this level</li>
                          </ul>
          </div>
      </div>
                        <div id="" class="client_info">
            <h4>Certification Requirements Accomplished</h4>
            <table class="table table-bordered table-hover" style="margin-bottom: 30px;">
              <tbody>
                                    <tr>
                    <td class="cert-check"><i class="fa fa-check"></i>&nbsp;&nbsp;</td>
                    <td class="cert-content">Company's leadership publicly commits to the cybersecurity enhancement program</td>
                    <td class="cert-date">Dec 05 2019 11:47:39</td>
                  </tr>
                                    <tr>
                    <td class="cert-check"><i class="fa fa-check"></i>&nbsp;&nbsp;</td>
                    <td class="cert-content">Leadership's commitment is announced to all company staff</td>
                    <td class="cert-date">Dec 06 2019 11:47:50</td>
                  </tr>
                                    <tr>
                    <td class="cert-check"><i class="fa fa-check"></i>&nbsp;&nbsp;</td>
                    <td class="cert-content">Company performs the BCC cybersecurity self-assessment </td>
                    <td class="cert-date">Dec 13 2019 11:47:58</td>
                  </tr>
                                    <tr>
                    <td class="cert-check"><i class="fa fa-check"></i>&nbsp;&nbsp;</td>
                    <td class="cert-content">Or engages 3rd party cybersecurity company to perform a cybersecurity assessment that is aligned with the ISO 27001 standard and the NY DFS regulation</td>
                    <td class="cert-date">Dec 14 2019 11:48:13</td>
                  </tr>
                                    <tr>
                    <td class="cert-check"><i class="fa fa-check"></i>&nbsp;&nbsp;</td>
                    <td class="cert-content">Communications between the company and the 3rd party cybersecurity company are conducted via encrypted email</td>
                    <td class="cert-date">Jan 02 2020 11:48:27</td>
                  </tr>
                                    <tr>
                    <td class="cert-check"><i class="fa fa-check"></i>&nbsp;&nbsp;</td>
                    <td class="cert-content">The company begins a cybersecurity education program for all staff</td>
                    <td class="cert-date">Jan 04 2020 08:06:28</td>
                  </tr>
                                    <tr>
                    <td class="cert-check"><i class="fa fa-check"></i>&nbsp;&nbsp;</td>
                    <td class="cert-content">A 3rd party cybersecurity assessment is performed on the company's network</td>
                    <td class="cert-date">Jan 06 2020 04:14:14</td>
                  </tr>
                                    <tr>
                    <td class="cert-check"><i class="fa fa-check"></i>&nbsp;&nbsp;</td>
                    <td class="cert-content">The company commits to a cybersecurity improvement schedule</td>
                    <td class="cert-date">Jan 06 2020 08:06:37</td>
                  </tr>
                                    <tr>
                    <td class="cert-check"><i class="fa fa-check"></i>&nbsp;&nbsp;</td>
                    <td class="cert-content">The company iInstalls a SSL/TLS  certificate on its website(s)</td>
                    <td class="cert-date">Jan 08 2020 08:06:43</td>
                  </tr>
                                    <tr>
                    <td class="cert-check"><i class="fa fa-check"></i>&nbsp;&nbsp;</td>
                    <td class="cert-content">The company deploys cybersecurity policies</td>
                    <td class="cert-date">Jan 09 2020 08:06:48</td>
                  </tr>
                                    <tr>
                    <td class="cert-check"><i class="fa fa-check"></i>&nbsp;&nbsp;</td>
                    <td class="cert-content">The company establishes a relationship with a qualified CISO internally or on a contract basis</td>
                    <td class="cert-date">Jan 10 2020 08:06:55</td>
                  </tr>
                                    <tr>
                    <td class="cert-check"><i class="fa fa-check"></i>&nbsp;&nbsp;</td>
                    <td class="cert-content">The company commits to maintain security program at this level</td>
                    <td class="cert-date">Jan 10 2020 08:11:26</td>
                  </tr>
                                    <tr>
                    <td class="cert-check"><i class="fa fa-check"></i>&nbsp;&nbsp;</td>
                    <td class="cert-content">The company increases security awareness training for all staff</td>
                    <td class="cert-date">Jan 18 2020 08:07:05</td>
                  </tr>
                                    <tr>
                    <td class="cert-check"><i class="fa fa-check"></i>&nbsp;&nbsp;</td>
                    <td class="cert-content">CyberCecurity, LLL performs various technical scans on the company's network and website</td>
                    <td class="cert-date">Jan 20 2020 08:07:12</td>
                  </tr>
                                    <tr>
                    <td class="cert-check"><i class="fa fa-check"></i>&nbsp;&nbsp;</td>
                    <td class="cert-content">The company implements a comprehensive security program equivalent to that required by the NY DFS reg</td>
                    <td class="cert-date">Jan 21 2020 08:07:20</td>
                  </tr>
                                    <tr>
                    <td class="cert-check"><i class="fa fa-check"></i>&nbsp;&nbsp;</td>
                    <td class="cert-content">A relationship is established with a 3rd party cybersecurity company </td>
                    <td class="cert-date">Mar 19 2020 11:48:21</td>
                  </tr>
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