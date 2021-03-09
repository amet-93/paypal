@extends('ThemePage.layout.home_layout')
@section('content')
<section class="">

    <div class="clearfix">

        <div class="row">

            <div class="col-lg-12">

                <div class="row">

                    <div class="bg-title padding_40">

                        <h1>Certification Levels</h1>

                    </div>

                </div>                                        

                <div class="row certification-level">

                    <div class="col-md-12 col-xs-12">

                        <div class="inner-div1">

                            <div class="row">

                                <div class="col-sm-3 col-xs-12">

                                    <div class="pricingTable">

                                        <div class="img-level">

                                            <img src="{{url('public/assets/plugins/dist/img/bronze.png')}}">

                                        </div>

                                        <h3 class="title">Bronze Level </h3>

                                        <div class="price-value">$195 /year</div>

                                        <a href="#" class="pricingTable-signup">Buy Now</a>

                                    </div>

                                </div>

                                <div class="col-sm-3 col-xs-12">

                                    <div class="pricingTable1">

                                        <div class="img-level">

                                            <img src="{{url('public/assets/plugins/dist/img/silver-level.png')}}">

                                        </div>

                                        <h3 class="title">SILVER LEVEL</h3>

                                        <div class="price-value">$295 /year</div>

                                        <a href="#" class="pricingTable-signup">Buy Now</a>

                                    </div>

                                </div>

                                <div class="col-sm-3 col-xs-12">

                                    <div class="pricingTable">

                                        <div class="img-level">

                                            <img src="{{url('public/assets/plugins/dist/img/gold-level.png')}}">

                                        </div>

                                        <h3 class="title">GOLD Level </h3>

                                        <div class="price-value">$495 /year</div>

                                        <a href="#" class="pricingTable-signup">Buy Now</a>

                                    </div>

                                </div>

                                <div class="col-sm-3 col-xs-12">

                                    <div class="pricingTable1">

                                        <div class="img-level">

                                            <img src="{{url('public/assets/plugins/dist/img/platinum-level.png')}}">

                                        </div>

                                        <h3 class="title">PLATINUM Level </h3>

                                        <div class="price-value">$795 /year</div>

                                        <a href="#" class="pricingTable-signup">Buy Now</a>

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
@endsection