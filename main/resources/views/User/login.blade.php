@extends('ThemePage/layout/home_layout')
@section('content')
<style type="text/css">
  .error{
    text-align: left;
    width: 100%;
  }
  .user-login-states{
    text-align: left;
  }
</style>    
<section class="">
    <div class="clearfix">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="bg-title padding_40">
                        <h1>BCC Client Login</h1>
                    </div>
                </div>
                
                <div class="sign-up user-login-states">
                    <div class="row inner-div">
                      <div class="col-md-offset-3 col-md-6 col-xs-12">
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
                          <form role="form" action="{{url('user_login')}}" name="user_login" method="post">
                            {!! csrf_field() !!}
                            <div class="box-body">
                              <div class="form-group has-feedback">
                                <label for="exampleInputEmail1">Email address</label>
                                <input type="email" class="form-control" name="email" placeholder="Enter Email">
                              </div>
                              <div class="form-group has-feedback">
                                <label for="exampleInputPassword1">Password</label>
                                <input type="password" class="form-control" name="password" placeholder="Enter Password">
                              </div>
                            </div>
                            <!-- /.box-body -->

                            <div class="box-footer">
                              <button type="submit" class="btn btn-primary btn-flat">Sign In</button>
                            </div>
                          </form>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</section>
@endsection