@extends('site.desktop._layouts.index')
@section('content')
<div class="row">
<div class="col-xs-12">
	<div class="container">

		<header><h1>Email Verification</h1></header>
		<div class="row">
		    <div class="col-xs-5 col-xs-offset-4">

		    @if($email_template)
		    {{$email_template}}
		    @else
		    <h3>Email Verification - Your account set up is complete!</h3>
	        <p>Your email {{ $email }} has been successfully verified.</p>
	        <p>Go to <a href="{{ URL::to(App::getLocale().'/profile') }}">your profile</a></p>
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