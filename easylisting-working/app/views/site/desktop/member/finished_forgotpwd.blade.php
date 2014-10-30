@extends('site.desktop._layouts.index')
@section('content')
<div class="row">
<div class="col-xs-12">
   <div class="container">

        <header><h1>Forget password</h1></header>
        <div class="row">
            <div class="col-xs-5 col-xs-offset-4">

            @if($email_template)
            {{$email_template}}
            @else
            <h3>Forgot your password?</h3>
            <p>We sent new password to your email (<strong>{{ $email }}</strong>) please check your mail box</p>
            <p>Thank you<br/>EasyCar team</p>
            @endif
            <a href="{{ URL::to(App::getLocale().'/') }}" class="link-arrow">Go to homepage</a>

            </div>
        </div>

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