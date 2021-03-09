@extends('ThemePage.layout.home_dashboard_layout')
@section('content')
<section class="content-header">
  <?php 
    $url = str_replace('/'.basename(request()->path()).'','',Request::path());
    $final_url = str_replace('admin/','',$url);
    $extend = explode('-',$final_url);
    $route_url = explode('/',Request::path());
    $user_url =  explode('-',basename(request()->path()));
  ?>
  <h1>Certification Level Dashboard</h1>
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
<section class="content certification-level-dashboard" style="float:none;">
  <div class="box box-primary">
    <div class="box-body">
      <div class="row certification-level" style="padding-top: 0px;padding-left: 5px;">
          <div class="col-md-12 col-xs-12">
              <div class="row">
                <div class="col-sm-3 col-xs-12">
                  <div class="pricingTable">
                    <div class="img-level"> <img src="{{url('public/assets/plugins/dist/img/bronze-02.jpeg')}}"> </div>
                  </div>
                </div>
                <div class="col-sm-9 col-xs-12 pricing-Details">
                  <div>
                    <h2 class="title">Bronze Level Certification </h2>
                    <div class="certification-price">$195 /year</div>
                    <div class="clearfix"><p>The Bronze Level Certification is where most companies will start the process. The Bronze Level basically demonstrates a formal commitment to the public and your staff to build a professional cybersecurity program. </p>
                    <span><strong>Bronze Level actions include:</strong></span>
                    <ul>
                      <li>Providing us with a signed document from your company's leadership that describes their commitment to move forward with developing a professional cybersecurity program aligned with the 
					  NIST Cybersecurity Framework. 
            (We provide the document format).</li>
                      <li>Establishing an encrypted email communication channel with us so we can securely exchange confidential information.</li>
                      <li>Announcing to your company that a professional cybersecurity program has become a priority and asking for everyone's support as you move forward. 
            (We provide sample language).</li>
                      <li>Establishing a contractual relationship with a cybersecurity provider and providing us proof of such a relationship. 
            We can be your cybersecurity provider at no extra charge, 
            but this is not necessary. </li>
                      <li>Starting a cybersecurity education program for all staff. We will provide you with information for this at no additional cost.</li>
                      <li>Complete the BCC cyber security self-assessment or complete a cyber-security assessment that is performed by a 3rd party cybersecurity firm.</li>
                    </ul></div>
                    <?php 
                         $data = get_level_detail('bronze');
                         $user_id = !empty(Session::get('user'))?Session::get('user')->id:null;
                         $term_data = get_term_policy_data($user_id);
                         $bronze_data = get_certification_purchase_info(1,$user_id);
                    ?>
                    <div class="paymentbutton"> @if(isset(Session::get('user')->id))
                      <form action="{{url('paypal')}}" method="post">
                        <input type="hidden" name="amount" class="bynowprice" value="195" />
                        <input type="hidden" name="id" value="{{Session::get('user')->id}}">
                        <input type="hidden" name="description" class="bynow-description" value="Bronze Level" />
                        <input type="hidden" name="level" value="{{$data->id}}">
                        <input class="hide pricingTable-signup btn1" type="submit" value="Buy Now" />
                        @if((empty($bronze_data->payment_data) && empty($bronze_data->expire_date)) || (!empty($bronze_data->payment_data) && !empty($bronze_data->expire_date) && ($bronze_data->current_date > $bronze_data->expire_date )))
                          @if(!empty($term_data) && $term_data->terms_of_use_acceptance_date == NULL && $term_data->privacy_policy_acceptance_date == NULL)
                            <a href="#" class="pricingTable-signup" onclick="storeByNowBtn('btn1')" data-toggle="modal" data-target="#TermsandCondition">Buy Now</a>
                          @else
                            <input class="pricingTable-signup" type="submit" value="Buy Now" />
                          @endif
                        @elseif(empty($bronze_data->payment_data) && !empty($bronze_data->expire_date) && ($bronze_data->current_date <= $bronze_data->expire_date)) 
                          @if(!empty($term_data) && $term_data->terms_of_use_acceptance_date == NULL && $term_data->privacy_policy_acceptance_date == NULL)
                            <a href="#" class="pricingTable-signup" onclick="storeByNowBtn('btn1')" data-toggle="modal" data-target="#TermsandCondition">Buy Now</a>
                          @else
                            <input class="pricingTable-signup" type="submit" value="Buy Now" />
                          @endif
                        @endif
                        
                      </form>
                      @else <a href="#" class="pricingTable-signup" data-toggle="modal" onclick="filldata('Bronze Level','195','{{$data->id}}')" data-target="#myModal">Buy Now</a> @endif </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-3 col-xs-12">
                  <div class="pricingTable1">
                    <div class="img-level"> <img src="{{url('public/assets/plugins/dist/img/silver-02.jpeg')}}"> </div>
                  </div>
                  </div>
                  <div class="col-sm-9 col-xs-12 pricing-Details">
                    <div>
                      <h2 class="title">Silver Level Certification </h2>
                      <div class="certification-price">$295 /year</div>
                      <div class="clearfix"><p>The Silver Level Certification shows that your efforts to build a professional cybersecurity program are underway.</p>
                      <span><strong>Silver Level actions include:</strong></span>
                      <ul>
                        <li>Everything in the Bronze Level, plus…</li>
                        <li>Development and documentation of a cybersecurity improvement schedule and timeline.</li>
                        <li>Installation of a SSL/TLS certificate on your website.</li>
                      </ul></div>
                      <?php 
                        $data = get_level_detail('silver');
                        $silver_data = get_certification_purchase_info(2,$user_id);
                      ?>
                      <div class="paymentbutton"> @if(isset(Session::get('user')->id))
                        <form action="{{url('paypal')}}" method="post">
                          <input type="hidden" name="amount" class="bynowprice" value="295" />
                          <input type="hidden" name="id" value="{{Session::get('user')->id}}">
                          <input type="hidden" name="description" class="bynow-description" value="Silver Level" />
                          <input type="hidden" name="level" value="{{$data->id}}">
                          <input class="hide pricingTable-signup btn2" type="submit" value="Buy Now" />
                         
                          @if((empty($silver_data->payment_data) && empty($silver_data->expire_date) || (!empty($silver_data->payment_data) && !empty($silver_data->expire_date) && $silver_data->current_date > $silver_data->expire_date)))
                            @if(!empty($term_data) && $term_data->terms_of_use_acceptance_date == NULL && $term_data->privacy_policy_acceptance_date == NULL)
                              <a href="#" class="pricingTable-signup" onclick="storeByNowBtn('btn2')" data-toggle="modal" data-target="#TermsandCondition">Buy Now</a>
                            @else
                              <input class="pricingTable-signup" type="submit" value="Buy Now" />
                            @endif
                          @elseif(empty($silver_data->payment_data) && !empty($silver_data->expire_date) && ($silver_data->current_date <= $silver_data->expire_date))
                            @if(!empty($term_data) && $term_data->terms_of_use_acceptance_date == NULL && $term_data->privacy_policy_acceptance_date == NULL)
                              <a href="#" class="pricingTable-signup" onclick="storeByNowBtn('btn2')" data-toggle="modal" data-target="#TermsandCondition">Buy Now</a>
                            @else
                              <input class="pricingTable-signup" type="submit" value="Buy Now" />
                            @endif
                          @endif
                          
                        </form>
                        @else <a href="#" class="pricingTable-signup" data-toggle="modal" onclick="filldata('Silver Level','295','{{$data->id}}')" data-target="#myModal">Buy Now</a> @endif </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-3 col-xs-12">
                    <div class="pricingTable">
                      <div class="img-level"> <img src="{{url('public/assets/plugins/dist/img/gold-02.jpeg')}}"> </div>
                    </div></div>
                    <div class="col-sm-9 col-xs-12 pricing-Details">
                      <div>
                        <h2 class="title">Gold Level Certification </h2>
                        <div class="certification-price">$495 /year</div>
                        <div class="clearfix"><p>The Gold Level Certification demonstrates tangible progress towards development of a professional cybersecurity program.</p>
                        <span><strong>Gold Level actions include:</strong></span>
                        <ul>
                          <li>Everything in the Silver Level, plus…</li>
                          <li>Completion of a cybersecurity assessment by a 3rd party cyber Security Company and the review of this assessment by our Chief Information Security Officer (CISO), Mitch Tanenbaum.  There is no extra charge for this review by our CISO.</li>
                          <li>Documentation of a contractual relationship with a Chief Information Security Officer (CISO). This can be with us or with another qualified CISO.</li>
                          <li>Performance of various external technical scans of your network by our personnel. There is not an extra charge for these scans. </li>
                        </ul></div>
                        <?php 
                          $data = get_level_detail('gold');
                          $gold_data = get_certification_purchase_info(3,$user_id);
                        ?>
                        <div class="paymentbutton"> @if(isset(Session::get('user')->id))
                          <form action="{{url('paypal')}}" method="post">
                            <input type="hidden" name="amount" class="bynowprice" value="495" />
                            <input type="hidden" name="id" value="{{Session::get('user')->id}}">
                            <input type="hidden" name="description" class="bynow-description" value="Gold Level" />
                            <input type="hidden" name="level" value="{{$data->id}}">
                            <input class="hide pricingTable-signup btn3" type="submit" value="Buy Now" />
                            
                            @if((empty($gold_data->payment_data) && empty($gold_data->expire_date)) || (!empty($gold_data->payment_data) && !empty($gold_data->expire_date && $gold_data->current_date > $gold_data->expire_date)))
                              @if(!empty($term_data) && $term_data->terms_of_use_acceptance_date == NULL && $term_data->privacy_policy_acceptance_date == NULL)
                                <a href="#" class="pricingTable-signup" onclick="storeByNowBtn('btn3')" data-toggle="modal" data-target="#TermsandCondition">Buy Now</a>
                              @else
                                <input class="pricingTable-signup" type="submit" value="Buy Now" />
                              @endif
                            @elseif(empty($gold_data->payment_data) && !empty($gold_data->expire_date) && ($gold_data->current_date <= $gold_data->expire_date))
                              @if(!empty($term_data) && $term_data->terms_of_use_acceptance_date == NULL && $term_data->privacy_policy_acceptance_date == NULL)
                                <a href="#" class="pricingTable-signup" onclick="storeByNowBtn('btn3')" data-toggle="modal" data-target="#TermsandCondition">Buy Now</a>
                              @else
                                <input class="pricingTable-signup" type="submit" value="Buy Now" />
                              @endif
                            @endif
                            
                          </form>
                          @else <a href="#" class="pricingTable-signup" data-toggle="modal" onclick="filldata('Gold Level','495','{{$data->id}}')" data-target="#myModal">Buy Now</a> @endif </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-3 col-xs-12">
                      <div class="pricingTable1">
                        <div class="img-level"> <img src="{{url('public/assets/plugins/dist/img/platinum-02.jpeg')}}"> </div>                        
                    </div> </div>
                    <div class="col-sm-9 col-xs-12 pricing-Details">
                      <div> 
                        <h2 class="title">Platinum Level Certification </h2>
                        <div class="certification-price">$795 /year</div>
                        <div class="clearfix"><p>The Platinum Level 
							Certification is a significant achievement. We 
							certify that your cybersecurity program is in 
							alignment with the NIST Cybersecurity Framework which is regarded as best practice for 
							business entities. </p>
                        <span><strong>Platinum Level actions include:</strong></span>
                        <ul>
                          <li>Everything in the Gold Level, plus:</li>
                          <li>Completion of all actions associated with NIST 
						  Cybersecurity Framework (or equivalent). </li>
                          <li>Providing us with documentation of your company's commitment to maintain your cybersecurity program at this level or better moving forward.</li>
                        </ul></div>
                        <?php 
                          $data = get_level_detail('platinum');
                          $platinum_data = get_certification_purchase_info(4,$user_id);
                        ?>
                        <div class="paymentbutton"> @if(isset(Session::get('user')->id))
                          <form action="{{url('paypal')}}" method="post">
                            <input type="hidden" name="amount" class="bynowprice" value="795" />
                            <input type="hidden" name="id" value="{{Session::get('user')->id}}">
                            <input type="hidden" name="description" class="bynow-description" value="Platinum Level" />
                            <input type="hidden" name="level" value="{{$data->id}}">
                            <input class="hide pricingTable-signup btn4" type="submit" value="Buy Now" />
                           
                            @if((empty($platinum_data->payment_data) && empty($platinum_data->expire_date)) || (!empty($platinum_data->payment_data) && !empty($platinum_data->expire_date) && $platinum_data->current_date > $platinum_data->expire_date))
                              @if(!empty($term_data) && $term_data->terms_of_use_acceptance_date == NULL && $term_data->privacy_policy_acceptance_date == NULL)
                                <a href="#" class="pricingTable-signup" onclick="storeByNowBtn('btn4')" data-toggle="modal" data-target="#TermsandCondition">Buy Now</a>
                              @else
                                <input class="pricingTable-signup" type="submit" value="Buy Now" />
                              @endif
                            @elseif(empty($platinum_data->payment_data) && !empty($platinum_data->expire_date) && ($platinum_data->current_date <= $platinum_data->expire_date))
                              @if(!empty($term_data) && $term_data->terms_of_use_acceptance_date == NULL && $term_data->privacy_policy_acceptance_date == NULL)
                                <a href="#" class="pricingTable-signup" onclick="storeByNowBtn('btn4')" data-toggle="modal" data-target="#TermsandCondition">Buy Now</a>
                              @else
                                <input class="pricingTable-signup" type="submit" value="Buy Now" />
                              @endif
                            @endif
                            
                          </form>
                          @else <a href="#" class="pricingTable-signup" data-toggle="modal" onclick="filldata('Platinum Level','795','{{$data->id}}')" data-target="#myModal">Buy Now</a> @endif </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
          </div>
          <section class="clearfix support-roll blue-bg">
              <div class="row">
            <div class="col-md-12">
                  <h2>BCC's Support Role </h2>
                  <p>The BCC support team works with you each step of the way.  Our team will track, verify, and record the various cybersecurity actions described above as you accomplish them.  When you have completed all the items associated with your particular certification level, we will grant that certification level, authorize you to display the certification level image on your web site, and provide you with the 
            simple code that your web developer will need to install the certification level image.</p>
              </div>
           </div>
          </section>

          <section class="clearfix how-it-works">
            <div class="text-center">
                  <h4>See how it works</h4>
                  <p>We have set up a demo web page that simulates a typical company home page. You can 
            view our certification image on this page and click on it 
            to see a sample of what visitors to your web site will see about your company and your certification information. Please go here: 
				  <a href="//BizCyberCert.us/demo/business.html" target="_blank">
				  BizCyberCert.us/demo/mortgage.html</a></p>
                
            </div>
          </section>
            <section class="clearfix chash-back">
              <div class="row">
                <div class="col-sm-6 cash-back-details">
                    <h4>100% Money-back Guarantee</h4>
                    <p>100% Money-back Guarantee. If you are not satisfied for any reason with our products and/or services, we will provide a full refund to the annual time period associated with your certification level. Please see our Terms of Use for more information.</p>
                </div>
                <div class="col-sm-6"><img class="img-responsive" src="{{url('public/assets/plugins/dist/img/cash-back.jpg')}}">  </div>
              </div>
          </section>
        </div>
    <!-- </div> -->
</section>
<section>
  <div class="modal fade" id="TermsandCondition" role="dialog">
 <!--End of terms and condition Model-->
   <div class="modal-dialog"> 
      <!-- Modal content-->
      <div class="modal-content">
       <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title popup_header">Terms and Condition</h4>
        </div>
        <div class="modal-body">
         
            <div class="form-check">
            <label>
              <input type="checkbox" onclick="checkedBtn()" id="PrivacyPolicy" value="0"> <span class="label-text">I have read and agree to the <a href="//bizcybercert.us/terms-of-use.html">Terms of Use</a> and <a href="//bizcybercert.us/terms-of-use.html">Privacy Policy</a></span>
            </label>
            </div>
        
      </div>
      <div class="modal-footer">
         <input type="hidden" name="url" value="{{url('user/termsconfirmation')}}" id="URLT">
         <input type="hidden" name="btnIDForSubmit" value="" id="btnIDForSubmit">
         <button class="btn btn-primary" disabled id="clickSubmitBtn" onclick="TermsAndCondtionAccept('PrivacyPolicy')">Accept</button>
         <button class="hide" data-dismiss="modal" id="termsCancel">Cancel</button>
        </div>
    </div>
    <!--End of terms and condition Model-->
  <!-- </div> -->
  </div>
  </div>
</section>
<script src="{{url('public/assets/plugins/bower_components/jquery/dist/jquery.min.js')}}"></script> 
<script type="text/javascript" src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script> 
<script type="text/javascript">
// this is for accept terms and condition
function TermsAndCondtionAccept(termid) {
 $('#termsCancel').click();
 let b = $('#'+termid).prop('checked')
 if(b == true){
   let url = $('#URLT').val();
  $.ajax({
    url: url,
    type: "get",
    cache: false,
    success: function(html){
     var id = $('#btnIDForSubmit').val();
     $('.'+id).click();
    },
    fail: function() {
     $('#termsCancel').click();
    }
  });
 }
}

function checkedBtn() {
 let a = $('#clickSubmitBtn').is(":disabled");
 if(a){
  $('#clickSubmitBtn').prop('disabled',false);
 }else{
  $('#clickSubmitBtn').prop('disabled',true);
 }
 return true;
}
function storeByNowBtn(id) {
  $('#btnIDForSubmit').val(id);
}
</script>
@endsection('content')