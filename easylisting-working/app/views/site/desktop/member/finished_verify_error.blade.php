@extends('site.desktop._layouts.index')
@section('content')
<div class="row">
<div class="col-xs-12">

	<div class="container">

		<header><h1>Member verification</h1></header>
		<div class="row">
		    <div class="col-xs-5 col-xs-offset-4">

		    @if(isset($email_template) && $email_template)
		    {{ $email_template }}
		    @else
		    <h3>Your verification code invalid or expired!.</h3>
	        <p>Please <a href="{{ URL::to(App::getLocale().'/signup') }}">sign up again</a></p>
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