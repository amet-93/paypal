@extends('ThemePage.layout.home_layout')
@section('content')
<section class="">
  <div class="clearfix">
    <div class="row">
      <div class="col-lg-12">
        <div class="row">
          <div class="bg-title padding_40">
            <h1>Certification Level</h1>
          </div>
        </div>
        <div class="row certification-level">
          <div class="col-md-12 col-xs-12">
            <div class="inner-div1">
              <div class="row" id="bronze-level">
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
                       if($user_id != null){
                          $term_data = get_term_policy_data($user_id);
                       }else{
                          $email_id = Session::get('email');
                          $term_data = get_term_policy_data($user_id,$email_id);
                       }
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
              <div class="row" id="silver-level">
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
						  <li>Deployment of cybersecurity policies.</li>
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
                <div class="row" id="gold-level">
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
                          <li>Performance of various external technical scans of your network by our personnel. There is not 
              an extra charge for these scans. </li>
							<li>Increasing cybersecurity awareness training for 
							all staff</li>
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
                  <div class="row" id="platinum-level">
                    <div class="col-sm-3 col-xs-12">
                      <div class="pricingTable1">
                        <div class="img-level"> <img src="{{url('public/assets/plugins/dist/img/platinum-02.jpeg')}}"> </div>                        
                    </div> </div>
                    <div class="col-sm-9 col-xs-12 pricing-Details">
                      <div> 
                        <h2 class="title">Platinum Level Certification </h2>
                        <div class="certification-price">$795 /year</div>
                        <div class="clearfix"><p>The Platinum Level Certification is a significant achievement. We certify that your cybersecurity program is in alignment with the 
							NIST Cybersecurity Framework which is regarded as best practice for 
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
      <div class="container">
          <h2>BCC's Support Role </h2>
            <p>The BCC support team works with you each step of the way.  Our team will track, verify, and record the various cybersecurity actions described above as you accomplish them.  When you have completed all the items associated with your particular certification level, we will grant that certification level, authorize you to display the certification level image on your web site, and provide you with the code your web developer will need to install the certification level image. 
			You can track your progress on your User Dashboard. </p>
        </div>
    </section>

        <section class="clearfix how-it-works">
        <div class="text-center">
          <div class="">
              <h4>See how it works</h4>
                <p>We have set up a demo web page that simulates a mortgage company home page. 
				Look for the BCC Gold Certificationon image on the page and click on it 
				to view a sample of what visitors to your web site would see about your company and your certification information. Please go here:
				<a href="//BizCyberCert.us/demo/business.html" target="_blank">
				BizCyberCert.us/demo/business.html</a></p>
            </div>
        </div>
    </section>
        <section class="clearfix chash-back">
      <div class="row is-flex">
          <div class="col-md-9 col-sm-6 col-xs-12 cash-back-details">
              <h4>100% Money-back Guarantee</h4>
                <p>100% Money-back Guarantee. If you are not satisfied for any reason with our products and/or services, we will provide a full refund 
				associated with the annual time period associated with your certification level. Please see our Terms of Use 
				below for more information.</p>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12 cash-back-image"><div  class="img-guarntee"><img class="img-responsive" src="{{url('public/assets/plugins/dist/img/cash-back_bigger.png')}}"> </div> </div>
        </div>
        </section>
  </div>
  <div class="modal fade {{(count($errors) > 0)?'in':''}}" id="myModal" role="dialog" style="display:{{(count($errors) > 0)?'block':'none'}}">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <form method="post" action="{{(!Session::has('already_register') ? url('user/register') : url('payuser/login'))}}" id="{{(!Session::get('user') ? "paypaluser-signup" : "paypaluser-login")}}">
                {{ csrf_field() }}
                <div class="modal-header">
                    <button type="button" class="close btn-closed" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title popup_header">{{(!Session::get('user') ? 'Personal Details' : 'Login')}}</h4>
                </div>
                <div class="modal-body">
                    
                    <div class="row">
                         @if($errors->any())
                          <div class="alert alert-danger">
                            <ul>
                              @foreach($errors->all() as $error)
                                <li>{{$error}}</li>
                              @endforeach
                            </ul>
                          </div>
                        @endif
                        <div class="flash-message"> @foreach(['danger','warning','success','info'] as $msg) @if(Session::has('alert-' .$msg))
                            <input type="hidden" class="check_when_userhave" value="1">
                            <p class="alert alert-{{$msg}}">{{Session::get('alert-'. $msg)}}<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                            @endif @endforeach </div>
                        <div class="col-sm-6 col-xs-12">
                            <div class="row">
                                <div class="form-group col-sm-12">
                                    <input type="text" class="form-control" name="first_name" id="first_name" placeholder="First Name" value="{{old('first_name')}}">
                                    <span class="form-icon fa fa-user"></span> </div>
                                <div class="form-group col-sm-12">
                                    <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name" value="{{old('last_name')}}">
                                    <span class="form-icon fa fa-user"></span> </div>
                                <div class="form-group col-sm-12">
                                    <input type="text" class="form-control" name="company_name" id="company_name" placeholder="Company Name" value="{{old('company_name')}}">
                                    <span class="form-icon fa fa-user"></span> </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-12">
                            <div class="row">
                                <div class="form-group col-sm-12">
                                    <input type="email" class="form-control" name="email" id="user_password" placeholder="Email" value="{{old('email')}}">
                                    <span class="form-icon fa fa-envelope"></span> </div>
                                <div class="form-group col-sm-12">
                                    <input type="password" class="form-control" name="user_password" id="user-password" placeholder="Password" value="{{old('user_password')}}">
                                    <span class="form-icon fa fa-lock"></span> </div>
                                <div class="form-group col-sm-12">
                                    <input type="password" class="form-control" id="confirm_user_password" name="confirm_user_password" placeholder="Confirm Password" value="{{old('confirm_user_password')}}">
                                    <span class="form-icon fa fa-lock"></span> </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                          <div class="form-check">
                            <label>
                              <input type="checkbox" onclick="checkedtermBtn()" id="PrivacyPolicyTerm" value="0"> <span class="label-text">I have read and agree to the <a href="//bizcybercert.us/terms-of-use.html">Terms of Use</a> and <a href="//bizcybercert.us/terms-of-use.html">Privacy Policy</a></span>
                            </label>
                          </div>
                          <p>Already a member? <a href="{{url('user/login')}}">Sign In</a></p>
                        </div>
                    </div>
                     
                    <div class="modal-footer">
                        <div class="model-hidden-field">
                            <input type="hidden" name="amount" id="pay-amount" class="bynowprice" value="795" />
                            <input type="hidden" name="description" id="pay-description" class="bynow-description" value="PLATINUM Level $795" />
                            <input type="hidden" name="level" id="pay-level" value="1">
                        </div>
                          @if(!empty($term_data))
                            @if($term_data->terms_of_use_acceptance_date == NULL && $term_data->privacy_policy_acceptance_date == NULL)
                            <input type="hidden" name="url" value="{{url('user/termsconfirmation')}}" id="URLT">
                            <input type="hidden" name="btnIDForSubmit" value="" id="btnIDForSubmit">
                            <button type="submit" class="btn btn-default" id="pay-submission" onclick="TermsAndCondtionAccept('PrivacyPolicyTerm')" disabled>{{(Session::get('user') ? 'Pay' : 'Pay')}}</button>
                           @else
                            <button type="submit" class="btn btn-default" id="pay-submission" disabled>{{(Session::get('user') ? 'Pay' : 'Pay')}}</button>
                           @endif
                          @else
                            <button type="submit" class="btn btn-default" id="pay-submission" disabled>{{(Session::get('user') ? 'Pay' : 'Pay')}}</button>
                          @endif
                        <button type="button" class="btn btn-default btn-closed" data-dismiss="modal">Close</button>
                    </div>
            </form>
            </div>
        </div>
    </div>
</div>
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
         
            <div class="form-check" style="border-top:inherit;">
            <label>
              <input type="checkbox" onclick="checkedBtn()" id="PrivacyPolicy" value="0"> <span class="label-text">I have read and agree to the <a href="//bizcybercert.us/terms-of-use.html" target="_blank">Terms of Use</a> and <a href="//bizcybercert.us/terms-of-use.html" target="_blank">Privacy Policy</a></span>
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
  </div>
  </div>
</section>
<script src="{{url('public/assets/plugins/bower_components/jquery/dist/jquery.min.js')}}"></script> 
<script type="text/javascript" src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
@if(count($errors) > 0)
<script type="text/javascript">
  jQuery(document).ready(function(){
    jQuery('.btn-closed').click(function(){
      setTimeout(function(){ 
        jQuery('body').removeClass('modal-open');
        jQuery('.modal-backdrop').remove();
        jQuery('#myModal').removeClass('in');
        jQuery('#myModal').css('display','none');
      }, 500);
      // jQuery('#myModal').modal('hide');
    });
  });
</script>
@endif 
<script type="text/javascript">
  jQuery('#pay-submission').click(function(){
    var payment_data = getCookie('pay_field');
    var pay_arr = payment_data.split(',');
    var details = pay_arr[0];
    var price = pay_arr[1];
    $('#pay-amount').val(price);
    $('#pay-description').val(details);
    $('#pay-level').val(pay_arr[2]);
  });
  jQuery('#paypaluser-signup').validate({ // initialize the plugin
    rules: {
      first_name: {
          required: true,
      },
      last_name: {
          required: true
      },
      email: {
        required: true
      },
      user_password: {
        required: true,
        minlength: 8,
      },
      company_name: {
        required: true
      },
      confirm_user_password: {
        required: true,
        minlength: 8,
        equalTo: "#user-password"
      }
    }
  });
  
  jQuery('#paypaluser-login').validate({ // initialize the plugin
    rules: {
      email: {
        required: true
      },
      user_password: {
        required: true,
        minlength: 8,
      }
    }
  });
function filldata(details, price,level){
 // $('.model-hidden-field .bynowprice').val(price);
 // $('.model-hidden-field .bynow-description').val(details);
 setCookie("pay_field", ""+details+","+price+","+level+"", 1);
 $('#pay-amount').val(price);
 $('#pay-description').val(details);
 $('#pay-level').val(level);
}
function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function delteCookie(cname, cvalue) {
    var d = new Date("January 01, 1970 00:00:00");
    d.setTime(d.getTime());
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}
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
function checkedtermBtn() {
 let a = $('#pay-submission').is(":disabled");
 if(a){
  $('#pay-submission').prop('disabled',false);
 }else{
  $('#pay-submission').prop('disabled',true);
 }
 return true;
}
function storeByNowBtn(id) {
  $('#btnIDForSubmit').val(id);
}
</script> 
@endsection 