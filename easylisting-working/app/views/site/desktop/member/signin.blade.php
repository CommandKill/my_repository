@extends('site.desktop._layouts.index')
@section('content')
<div class="row">
<div class="col-xs-12">

        <div class="container">
            <header><h1>Sign In</h1></header>
            <div class="row">
                <div class="col-xs-5 col-xs-offset-4">

                    <div class="form-group" style="text-align: center">
                        <a href="{{ URL::to('/signin-with-facebook') }}?url={{ $previous or URL::previous()}}" class=""> <img src="{{ asset('/img/facebook-login-button.png') }}" height="50"/></a>
                    </div><!-- /.form-group -->
                    <p class="fancy"><span>or use email</span></p>

                    {{ Form::open(array('url' => App::getLocale().'/signin','id'=>'frmSignin')) }}

                    {{ Notification::showAll() }}
					<input type="hidden" name="previous" value="{{ $previous or URL::previous()}}">
                    <div class="form-group">
                        <label for="form-create-account-email">Email:</label> {{ $errors->first('email') }}
                        <input type="email" class="form-control" name="email" id="email" placeholder='xxx@xxxx.com' required>
                    </div><!-- /.form-group -->
                    <div class="form-group">
                        <label for="form-create-account-password">Password:</label> {{ $errors->first('password') }}
                        <input type="password" class="form-control" name="password" id="password" placeholder='*********' required>
                    </div><!-- /.form-group -->

					<div class="form-group clearfix">
                        <button type="submit" class="btn pull-right btn-default" id="account-submit">Sign in</button>
                    </div><!-- /.form-group -->
                   	 {{ Form::close() }}
                    <hr>
                    <div class="center"><a href="{{ URL::to(App::getLocale().'/forgotpwd') }}">I don't remember my password</a></div>
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