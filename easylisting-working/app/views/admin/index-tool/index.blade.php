@extends('admin._layouts.index')
@section('head')
<style>

</style>

@stop
@section('content')
  <div class="row">
    <div class="col-xs-12">
    	{{ Notification::showAll() }}
      <ul>
		<li><a href="{{ URL::to('admin/index-tool/index-post') }}">Index post</a></li>
		<li><a href="{{ URL::to('admin/index-tool/update-car-avariable-make-model') }}">Update car avariable (Make & Model)</a></li>
		<li><a href="{{ URL::to('admin/index-tool/update-car-avariable-sub-model') }}">Update car avariable (Sub model)</a></li>
      </ul>
    </div>
  </div>
@stop
@section('footer')
<script type="text/javascript">
$(function(){

});
</script>
@stop