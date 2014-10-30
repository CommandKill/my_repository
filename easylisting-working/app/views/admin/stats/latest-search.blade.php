@extends('admin._layouts.index')
@section('head')
<style>

</style>

@stop
@section('content')
  <div class="row">
    <div class="col-xs-12">
    	{{ Notification::showAll() }}
        
      






    </div>
  </div>
@stop
@section('footer')
<script type="text/javascript">
$(function(){

});
</script>
@stop