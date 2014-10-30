@extends('site.desktop._layouts.index')

@section('head')

<style>

</style>
@stop

@section('content')
<div class="container">
    <div class="row page">
        <div class="col-xs-3">
            @include('site.desktop._partials.member_nav')
        </div>
        <div class="col-xs-9">
            <header><h1>Change your password</header>
            <div class="col-md-6 col-sm-9">

            {{ Notification::showAll() }}

            <form role="form" id="frmPassword" method="POST" action="{{ URL::to(App::getLocale().'/password') }}">
                <div class="form-group">
                    <label for="form-account-password-current">Current Password</label>
                    {{ $errors->first('password_current') }}
                    <input type="password" class="form-control" id="password_current" name="password_current" required>
                </div>
                <div class="form-group">
                    <label for="form-account-password-new">New Password</label>
                    {{ $errors->first('password') }}
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="form-account-password-confirm-new">Confirm New Password</label>
                    {{ $errors->first('password_confirmation') }}
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                </div>
                <div class="form-group clearfix">
                    <button type="submit" class="btn submit-btn" id="form-account-password-submit">Change Password</button>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>
@stop
@section('footer')

<script type='text/javascript'>
$(function(){

});	
</script>
@stop
