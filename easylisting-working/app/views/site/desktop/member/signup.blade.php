@extends('site.desktop._layouts.index')
@section('content')
<div class="row">
<div class="col-xs-12">

<div class="container">
    <header><h1>Create an Account</h1></header>
    <div class="row">
        <div class="col-xs-4 col-xs-offset-4">

            {{ Form::open(array('url' => 'signup','id'=>'frmSignup')) }}

            {{ Form::hidden('facebook_id', $data_form['facebook_id']) }}
            {{ Form::hidden('first_name', $data_form['first_name']) }}
            {{ Form::hidden('last_name', $data_form['last_name']) }}
            {{ Form::hidden('timezone', $data_form['timezone']) }}
            {{ Form::hidden('locale', $data_form['locale']) }}
            {{ Form::hidden('gender', $data_form['gender']) }}
            {{ Form::hidden('facebook_link', $data_form['facebook_link']) }}

            <div class="form-group" style="text-align: center">
                @if ($data_form['facebook_id'] != '' || Input::old('facebook_id'))
                <div style="text-align: left">
                <strong>Linked with:</strong> <a href="<?= Input::old('facebook_link') != '' ? Input::old('facebook_link') : $data_form['facebook_link'] ?>" target="_blank">
                    <img src="https://graph.facebook.com/<?= Input::old('facebook_id') != '' ? Input::old('facebook_id') : $data_form['facebook_id'] ?>/picture"></a>
                <br/><small>*Please provide your email and password below. <br/>After sign up, you can sign in with your Facebook account or Email address and password</small>
                </div>
                @else

                <a href="{{ URL::to('/signup-with-facebook') }}" class=""><img src="{{ asset('img/facebook-signup-button.png') }}" height="50"/></a>


                @endif
            </div>
            <p class="fancy"><span>or enter register form</span></p>
<!--             <h3>Account Type</h3>
            @foreach ($data_form['member_type'] as $key => $value)
            <div class="radio">
                <label>
                    <input type="radio" id="account-type-{{ $value }}" name="account-type"
                    {{ ($key==0)?'checked':'' }}
                    value="{{ $value }}" required>{{ studly_case($value) }}
                </label>
            </div>
            @endforeach
            <hr> -->
            
            {{ Notification::showAll() }}

                <div class="form-group">
                    <label for="form-create-account-full-name">First name:</label>
                    <input type="text" class="form-control" name="first_name" id="first_name" required value="{{ $data_form['first_name'] }}">
                </div>
                <div class="form-group">
                    <label for="form-create-account-full-name">Last name:</label>
                    <input type="text" class="form-control" name="last_name" id="last_name" required value="{{ $data_form['last_name'] }}">
                </div>
                <div class="form-group">
                    <label for="form-create-account-email">Email:</label> {{ $errors->first('email') }}
                    <input type="email" class="form-control" name="email" id="email" required value="{{ $data_form['email'] }}">
                </div>
                <div class="form-group">
                    <label for="form-create-account-password">Password:</label> {{ $errors->first('password') }}
                    <input type="password" class="form-control" name="password" id="password" required>
                </div>
                <div class="form-group clearfix">
                    <label for="form-create-account-confirm-password">Confirm Password:</label>
                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" required>
                </div>
                <div class="checkbox switch clearfix" id="receive_newsletter">
                    <label>
                        <input type="checkbox" id="receive_newsletter" name="receive_newsletter" checked>  Receive Newsletter
                    </label>
                </div><br/>

                <div class="form-group clearfix">
                    <button type="submit" class="btn pull-right btn-default">Create an Account</button>
                </div><!-- /.form-group -->
            {{ Form::close() }}
            <hr>
            <div class="center">
                <figure class="note">By clicking the “Create an Account” button you agree with our <a href="terms-conditions.html">Terms and conditions</a></figure>
            </div>
            <br/><br/>
        </div>
    </div><!-- /.row -->
</div><!-- /.container -->

</div>
</div>
@stop
@section('footer')
{{-- HTML::script('js/sample.js') --}}
<script type="text/javascript">
$(function(){
  
});
</script>
@stop