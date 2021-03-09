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
                        <h1>Congrats!</h1>
                    </div>
                </div>
                
                <div class="sign-up">
                    <div class="row inner-div">
                      <div class="col-md-12 col-xs-12">
                            <div class="flash-message">
                             

                                <p class="alert alert-success">Your profile has been activated. Please Login<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                
                            </div> <!-- end .flash-message -->
                            <a href="<?php echo URL::to('/user/login'); ?>" class="">Go to login</a>
                        
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</section>
@endsection