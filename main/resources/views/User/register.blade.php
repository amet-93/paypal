@extends('ThemePage/layout/home_layout')
@section('content')
<style type="text/css">
  .error{
    text-align: left;
    width: 100%;
  }
</style>    
<section class="">
    <div class="clearfix">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="bg-title padding_40">
                        <h1>Create a Business Cybersecurity Certification (BizCyberCert.us) client account</h1>
                    </div>
                </div>
                
                <div class="sign-up">
                    <div class="row inner-div">
                      <div class="col-md-12 col-xs-12">
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
                          <form class="signUp-form" name="user_signup" action="{{url('user/registers')}}" method="POST" id="user-signup">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                              <div class="row">
                                  <div class="col-sm-6">
                                      <div class="row">
                                          <div class="form-group col-sm-12">
                                              <input type="text" class="form-control" name="first_name" id="first_name" placeholder="First Name" value="{{old('first_name')}}">
                                              <span class="form-icon fa fa-user"></span>
                                          </div>
                                          <div class="form-group col-sm-12">
                                              <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name" value="{{old('last_name')}}">
                                              <span class="form-icon fa fa-user"></span>
                                          </div>
                                          <div class="form-group col-sm-12">
                                              <input type="text" class="form-control" name="company_name" id="company_name" placeholder="Company Name" value="{{old('company_name')}}">
                                              <span class="form-icon fa fa-user"></span>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="col-sm-6">
                                      <div class="row">
                                          <div class="form-group col-sm-12">
                                              <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="{{old('email')}}">
                                              <span class="form-icon fa fa-envelope"></span>
                                          </div>
                                          <div class="form-group col-sm-12">
                                              <input type="password" class="form-control" name="user_password" id="user-password" placeholder="Password">
                                              <span class="form-icon fa fa-lock"></span>
                                          </div>
                                          <div class="form-group col-sm-12">
                                              <input type="password" class="form-control" name="confirm_user_password" id="confirm_user_password" placeholder="Confirm Password">
                                              <span class="form-icon fa fa-lock"></span>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="row">
                                  <div class="col-md-12">
                                      <div class="dv-center">
                                          <!-- <div class="form-check">
                                              <label>
                                                  <input type="checkbox" name="check"> <span class="label-text">    By signing up, you agree with the terms and conditions.</span>
                                              </label>
                                          </div> -->

                                          <button class="btn btn-primary btn-lg submit-btn" type="submit"><span class="ladda-label">Submit</span><span class="ladda-spinner"></span></button>

                                      </div>
                                  </div>
                              </div>
                          </form>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</section>
<script src="{{url('public/assets/plugins/bower_components/jquery/dist/jquery.min.js')}}"></script>
<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script type="text/javascript">
  jQuery('#user-signup').validate({ // initialize the plugin
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
</script>
@endsection
