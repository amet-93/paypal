<!--Video section ends-->
  <!--Purchase Plan ends-->
<?php 
  $current_path = request()->path();
  $explode_url = explode('/', $current_path);
?>
@if(!in_array('user',$explode_url) && !in_array('certification-detail',$explode_url))
  <a href="#top" class="scrollToTop"><i class="fa fa-arrow-up"></i></a>
@endif
<footer class="padding_40">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-xs-12">
                <div class="footer-logo">
                    <img src="{{url('public/assets/plugins/dist/img/logo_white.png')}}" class="img-responsive" />
                </div>
            </div>
            <div class="col-md-8 col-xs-12">
              <ul class="useful-links">
                  <li> <a href="/security_statement.html" class="">Security statement</a> </li>
                  <li> <a href="/terms-of-use.html" class="">Terms of Use</a> </li>
                  <li> <a href="/privacy_policy.html" class="">Privacy notice</a> </li>
                  <li> <a href="/testimonials.html" class=""> Testimonials</a> </li>
              </ul>
            </div>
            <div class="row">
                <div class="col-md-12"> 
                    <div class="divider"></div>                      
                    <p class="copyright">© 2018 Copyright Business Cybersecurity Certification, All rights reserved | Privacy Policy | Last Updated December 13, 2017</p>
                </div>
            </div>
            <!--do not sell link-->
                <div class="row">

                    <div class="col-md-12 text-center">

                        <a class="active do_not_sell_link"  href="/do-not-sell-my-personal-information.php">DO NOT SELL MY PERSONAL INFORMATION</a>
                        <br>
                        <span class="do_not_sell_bottom_text">Click link above for more info</span>

                    </div>

                </div>
                
                <!--do not sell link end-->
        </div>
    </div>
</footer>
<!-- jQuery 3 -->
<script src="{{url('public/assets/plugins/bower_components/jquery/dist/jquery.min.js')}}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{url('public/assets/plugins/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script>
   $(document).ready(function () {
       //Check to see if the window is top if not then display button
      $(window).scroll(function () {
          if ($(this).scrollTop() > 100) {
              $('.scrollToTop').fadeIn();
          } else {
              $('.scrollToTop').fadeOut();
          }
      });

      //Click event to scroll to top
      $(document).on('click','.scrollToTop',function () {
          $('html, body').animate({ scrollTop: 0 }, 800);
          return false;
      });

   });
</script>
<script>
  // $(document).ready(function () {
  //     $('a[href^="#"]').on('click', function (e) {
  //         e.preventDefault();
  //         var target = this.hash,
  //         $target = $(target);

  //         $('html, body').stop().animate({
  //             'scrollTop': $target.offset().top
  //         }, 900, 'swing', function () {
  //             window.location.hash = target;
  //         });
  //     });
  //     if(window.location.href == 'http://bizcybercert.us/index.html' || window.location.href == "http://bizcybercert.us/"){
  //         $('.home-menu').addClass('active');
  //     }
  // });
  var a123456 =  $('.check_when_userhave').val();
  if(a123456==1){
  $('#myModal').modal('show');
  }
</script>
@if(!in_array('user',$explode_url) && count($errors) > 0)
  <div class="modal-backdrop fade in"></div>
@endif
</body>
</html>