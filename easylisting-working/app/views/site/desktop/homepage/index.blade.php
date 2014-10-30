@extends('site.desktop._layouts.index')
@section('head')
{{ HTML::style('css/plugins/bootstrap-select/bootstrap-select.min.css') }}
{{ HTML::style('css/plugins/owl-carousel/owl.carousel.css') }}
{{ HTML::style('css/homepage.css') }}
{{ HTML::style('css/dropdown.css') }}
@stop
@section('content')
<div class="container">
	<div class="row">
	    <div class="col-xs-12">
	        <!-- <div class="banner-holder"><img src="/img/banner3.png"  width="100%" /></div> -->
	        <div class="pull-left" id="search-placeholder">@include('site.desktop.homepage.searchbox')</div>
	        <div class="pull-right" style="width: 709px;" id="promote-placeholder">@include('site.desktop.homepage.promotebox')</div>
	    </div>
	</div>
	<br/>
	<div class="row">
		<div class="col-xs-12">
			@include('site.desktop.widgets.our-services')
		</div>
    <div class="col-xs-12">
        @include('site.desktop.homepage.new-cars')
    </div>
<!--     <div class="col-xs-12">
        @include('site.desktop.widgets.partners')
    </div> -->
	</div>
</div>
@stop
@section('footer')
{{ HTML::script('js/plugins/bootstrap_select/bootstrap-select.min.js') }}
{{ HTML::script('js/plugins/owl-carousel/owl.carousel.min.js') }}
{{ HTML::script('js/plugins/iCheck/icheck.min.js') }}
{{ HTML::script('js/homepage.js') }}
<script type="text/javascript">
$(function(){

});
</script>
@stop