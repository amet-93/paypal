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
              <div class="row">
                <div class="col-sm-3 col-xs-12">
                  <div class="pricingTable">
                    <div class="img-level"> <img src="{{url('public/assets/plugins/dist/img/bronze-01.jpeg')}}"> </div>
                    <h3 class="title">Bronze Level </h3>
                    <div class="price-value">$195 /year</div>
                    <div class="paymentbutton"> @if(isset(Session::get('user')->id))
                      <form action="{{url('paypal')}}" method="post">
                        <input type="hidden" name="amount" class="bynowprice" value="195" />
                        <input type="hidden" name="id" value="{{Session::get('user')->id}}">
                        <input type="hidden" name="description" class="bynow-description" value="Bronze Level" />
                        <input class="pricingTable-signup" type="submit" value="Buy Now" />
                      </form>
                      @else <a href="#" class="pricingTable-signup" data-toggle="modal" onclick="filldata('Bronze Level','195')" data-target="#myModal">Buy Now</a> @endif </div>
                  </div>
                </div>
                <div class="col-sm-9 col-xs-12 pricing-Details">
                	<div>
                        <h2>Bronze Level</h2>
                        <p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                    </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-3 col-xs-12">
                  <div class="pricingTable1">
                    <div class="img-level"> <img src="{{url('public/assets/plugins/dist/img/silver-01.jpeg')}}"> </div>
                    <h3 class="title">SILVER LEVEL</h3>
                    <div class="price-value">$295 /year</div>
                    <div class="paymentbutton"> @if(isset(Session::get('user')->id))
                      <form action="{{url('paypal')}}" method="post">
                        <input type="hidden" name="amount" class="bynowprice" value="295" />
                        <input type="hidden" name="id" value="{{Session::get('user')->id}}">
                        <input type="hidden" name="description" class="bynow-description" value="SILVER LEVEL" />
                        <input class="pricingTable-signup" type="submit" value="Buy Now" />
                      </form>
                      @else <a href="#" class="pricingTable-signup" data-toggle="modal" onclick="filldata('SILVER LEVEL','295')" data-target="#myModal">Buy Now</a> @endif </div>
                  </div>
                </div>
                <div class="col-sm-9 col-xs-12 pricing-Details">
                	<div>
                        <h2>Silver Level</h2>
                        <p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                    </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-3 col-xs-12">
                  <div class="pricingTable">
                    <div class="img-level"> <img src="{{url('public/assets/plugins/dist/img/gold-01.jpeg')}}"> </div>
                    <h3 class="title">GOLD Level </h3>
                    <div class="price-value">$495 /year</div>
                    <div class="paymentbutton"> @if(isset(Session::get('user')->id))
                      <form action="{{url('paypal')}}" method="post">
                        <input type="hidden" name="amount" class="bynowprice" value="495" />
                        <input type="hidden" name="id" value="{{Session::get('user')->id}}">
                        <input type="hidden" name="description" class="bynow-description" value="GOLD Level" />
                        <input class="pricingTable-signup" type="submit" value="Buy Now" />
                      </form>
                      @else <a href="#" class="pricingTable-signup" data-toggle="modal" onclick="filldata('GOLD Level','495')" data-target="#myModal">Buy Now</a> @endif </div>
                  </div>
                </div>
                <div class="col-sm-9 col-xs-12 pricing-Details">
                	<div>
                        <h2>Gold Level </h2>
                        <p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                    </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-3 col-xs-12">
                  <div class="pricingTable1">
                    <div class="img-level"> <img src="{{url('public/assets/plugins/dist/img/platinum-01.jpeg')}}"> </div>
                    <h3 class="title">PLATINUM Level </h3>
                    <div class="price-value">$795 /year</div>
                    <div class="paymentbutton"> @if(isset(Session::get('user')->id))
                      <form action="{{url('paypal')}}" method="post">
                        <input type="hidden" name="amount" class="bynowprice" value="795" />
                        <input type="hidden" name="id" value="{{Session::get('user')->id}}">
                        <input type="hidden" name="description" class="bynow-description" value="PLATINUM Level" />
                        <input class="pricingTable-signup" type="submit" value="Buy Now" />
                      </form>
                      @else <a href="#" class="pricingTable-signup" data-toggle="modal" onclick="filldata('PLATINUM Level','795')" data-target="#myModal">Buy Now</a> @endif </div>
                  </div>
                </div>
                <div class="col-sm-9 col-xs-12 pricing-Details">
                	<div>
                        <h2>Platinum Level</h2>
                       <p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
</section>
<section>
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog"> 
      <!-- Modal content-->
      <div class="modal-content">
        <form method="post" action="{{(!Session::has('already_register') ? url('user/register') : url('payuser/login'))}}" id="{{(!Session::get('user') ? "paypaluser-signup" : "paypaluser-login")}}">
          {{ csrf_field() }}
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title popup_header">{{(!Session::get('user') ? 'Personal Details' : 'Login')}}</h4>
          </div>
          <div class="modal-body">
          @if(!Session::has('already_register'))
          <div class="row">
            <div class="flash-message"> @foreach(['danger','warning','success','info'] as $msg)
              @if(Session::has('alert-' .$msg))
              <input type="hidden" class="check_when_userhave" value="1">
              <p class="alert alert-{{$msg}}">{{Session::get('alert-'. $msg)}}<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
              @endif
              @endforeach </div>
            <div class="col-sm-6 col-xs-12">
              <div class="row">
                <div class="form-group col-sm-12">
                  <input type="text" class="form-control" name="first_name" id="first_name" placeholder="First Name">
                  <span class="form-icon fa fa-user"></span> </div>
                <div class="form-group col-sm-12">
                  <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name">
                  <span class="form-icon fa fa-user"></span> </div>
                <div class="form-group col-sm-12">
                  <input type="text" class="form-control" name="company_name" id="company_name" placeholder="Company Name">
                  <span class="form-icon fa fa-user"></span> </div>
              </div>
            </div>
            <div class="col-sm-6 col-xs-12">
              <div class="row">
                <div class="form-group col-sm-12">
                  <input type="email" class="form-control" name="email" id="user_password" placeholder="Email">
                  <span class="form-icon fa fa-envelope"></span> </div>
                <div class="form-group col-sm-12">
                  <input type="password" class="form-control" name="user_password" id="user-password" placeholder="Password">
                  <span class="form-icon fa fa-lock"></span> </div>
                <div class="form-group col-sm-12">
                  <input type="password" class="form-control" id="confirm_user_password" name="confirm_user_password" placeholder="Confirm Password">
                  <span class="form-icon fa fa-lock"></span> </div>
              </div>
            </div>
          </div>
          @endif
          @if(Session::has('already_register') == "yes")
          <div class="row">
            <div class="col-sm-12 col-xs-12">
              <div class="flash-message"> @foreach(['danger','warning','success','info'] as $msg)
                @if(Session::has('alert-' .$msg))
                <input type="hidden" class="check_when_userhave" value="1">
                <p class="alert alert-{{$msg}}">{{Session::get('alert-'. $msg)}}<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                @endif
                @endforeach </div>
              <div class="row">
                <div class="form-group col-sm-12">
                  <input type="email" class="form-control" name="email" id="email" placeholder="Email">
                  <span class="form-icon fa fa-envelope"></span> </div>
                <div class="form-group col-sm-12">
                  <input type="password" class="form-control" name="password" id="user_password" placeholder="Password">
                  <span class="form-icon fa fa-lock"></span> </div>
              </div>
            </div>
            @endif 
          </div>
          <div class="modal-footer">
            <div class="model-hidden-field">
              <input type="hidden" name="amount" class="bynowprice" value="795" />
              <input type="hidden" name="description" class="bynow-description" value="PLATINUM Level $795" />
            </div>
            <button type="submit" class="btn btn-default">{{(Session::get('user') ? 'Pay' : 'Pay')}}</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </form>
        </div>      
      </div>
    </div>
  </div>
</section>
<script src="{{url('public/assets/plugins/bower_components/jquery/dist/jquery.min.js')}}"></script> 
<script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script> 
<script type="text/javascript">
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
function filldata(details, price){
 $('.model-hidden-field .bynowprice').val(price);
 $('.model-hidden-field .bynow-description').val(details);
}
</script> 
@endsection 