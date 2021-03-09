@extends('ThemePage.layout.home_layout')
@section('content')
<div class="container">
@if ($message = Session::get('success'))
    <div class="custom-alerts alert alert-success fade in">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
        {!! $message !!}
    </div>
    <?php Session::forget('success');?>
    @endif

    @if (isset($data['payer_id']))
    <?php $user_data = payment_info($data['payer_id']);?>
    <div class="container" style="margin-top:15px;">
        @if(!empty($user_data))
        <div>Hello {{$user_data->first_name}},
            Thank you for your payment. Below is your payment summary.
        </div>
        @endif
    <div class="row"><div class="col-md-12"><h2>Payment Summary</h2></div></div>
    <div class="row">
            <div class="col-md-6">
                <p>Name</p>
            </div>
            <div class="col-md-6">
                {{ (isset($data['name']) ? $data['name'] : '') }}
            </div>
    </div>
    <div class="row">
            <div class="col-md-6">
                <p>Payer Email-ID</p>
            </div>
            <div class="col-md-6">
                {{ (isset($data['payer_email_id']) ? $data['payer_email_id'] : '') }}
            </div>
    </div>
    <div class="row">
            <div class="col-md-6">
                <p>Amount</p>
            </div>
            <div class="col-md-6">
                {{ (isset($data['amount']) ? '$'.$data['amount'] : '') }}
            </div>
    </div>
    <div class="row">
            <div class="col-md-6">
                <p>Product</p>
            </div>
            <div class="col-md-6">
                {{ (isset($data['product']) ? $data['product'] : '') }}
            </div>
    </div>
    <div class="row">
            <div class="col-md-6">
                <p>Payer ID</p>
            </div>
            <div class="col-md-6">
                {{ (isset($data['payer_id']) ? $data['payer_id'] : '') }}
            </div>
    </div>
    <div class="row">
            <div class="col-md-6">
                <p>Paypal Payment ID</p>
            </div>
            <div class="col-md-6">
                {{ (isset($data['paypal_payment_id']) ? $data['paypal_payment_id'] : '') }}
            </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h3>Click Here to go <a href={{url('user/dashboard')}}>Dashboard</a></h3>
            @if(!empty($user_data) && $user_data->verified == 0)
                <h5>Note: You have to verify your email before access to dashboard.</h5>
            @endif
        </div>
    </div>
    </div>
    @endif

    @if ($message = Session::get('error'))
    <div class="custom-alerts alert alert-danger fade in">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
        {!! $message !!}
        <h1>Click Here to go <a href="{{url('/')}}">Home</a></h1>
    </div>
    <?php Session::forget('error');?>
@endif
</div>
@endsection