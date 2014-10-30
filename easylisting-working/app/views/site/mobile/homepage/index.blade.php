@extends('site.mobile._layouts.index')
@section('head')
{{ HTML::style('css/plugins/bootstrap-select/bootstrap-select.min.css') }}
{{ HTML::style('css/mobile-homepage.css') }}
@stop
@section('content')
<div class="container">
	<div class="row">
	    <div class="col-xs-12" id="search-placeholder">@include('site.mobile.homepage.searchbox')</div>
	    <div class="col-xs-12" id="promote-placeholder">@include('site.mobile.homepage.promotebox')</div>
	</div>
</div>
@stop
@section('footer')
{{ HTML::script('js/plugins/bootstrap_select/bootstrap-select.min.js') }}
<script type="text/javascript">
$(function(){
  $('.selectpicker').selectpicker();
});
</script>
@stop