@extends('site.desktop._layouts.index')
@section('content')
<div class="row">
<div class="col-xs-12">

    <div class="container">

        <header><h1>Member signup</h1></header>
        <div class="row">
            <div class="col-xs-5 col-xs-offset-4">

            @if(isset($email_template))
            {{$email_template}}
            @else
            <h3>We found your account in our system</h3>
            <p>your account is exist in our system but still not verify</p>
            <p>Please, check your inbox {{ $email }} for verify your account</a>
            <p>but if you not receive email from our,
            <a href="{{ URL::to(App::getLocale().'/resent-verify-email') }}" >send it again</a>
            and please check your inbox and <a href="{{ URL::to(App::getLocale().'/signin') }}">sign in</a> again</p>
            <p>Thank you<br/>Carlisting Crew</p>
            @endif
            <a href="{{ URL::to(App::getLocale().'/') }}" class="link-arrow">Go to homepage</a>

            </div>
        </div>

    </div>

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