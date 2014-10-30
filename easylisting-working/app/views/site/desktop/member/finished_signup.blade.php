@extends('site.desktop._layouts.index')
@section('content')
<div class="row">
<div class="col-xs-12">	
    <div class="container">
    	<header><h1>Sign up</h1></header>
        <div class="row">
            <div class="col-xs-5 col-xs-offset-4">

			@if($email_template)
			{{$email_template}}
        	@else
            <h3>Sign up for a new customer!</h3>
            <p>To complete the sign up process please check your mail box at <strong>{{ $email }}</strong> to verify your account</p>
			<p>Thank you<br/>Carlisting Crew</p>
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