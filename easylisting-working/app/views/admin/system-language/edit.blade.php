@extends('admin._layouts.index')
@section('header')
<style>

</style>

@stop
@section('content')
<div class="row">
	<form action="{{ URL::to('admin/system-language/update') }}" id="frmUpdate" class="form-horizontal" method="POST" enctype="multipart/form-data">
	  <input type="hidden" name="id" id="id" value="{{ $lang->id }}">


		<div class="form-group">
			<label for="inputPassword3" class="col-sm-2 control-label">Title</label>
			<div class="col-sm-10">
			  <input class='form-control' minlength='2' required id='title' name='title' placeholder='Title' type='text' value='{{ $lang->title }}'>
			</div>
		</div>
		<div class="form-group">
			<label for="inputPassword3" class="col-sm-2 control-label">Code</label>
			<div class="col-sm-10">
			  <input class='form-control' minlength='2' required id='code' name='code' placeholder='Code' type='text' value='{{ $lang->code }}'>
			</div>
		</div>
		<div class="form-group">
			<label for="inputPassword3" class="col-sm-2 control-label">Short Code</label>
			<div class="col-sm-10">
			  <input class='form-control' minlength='2' required id='short_code' name='short_code' placeholder='short code' type='text' value='{{ $lang->short_code }}'>
			</div>
		</div>

		<div class="form-group" style="clear:both">
			<div class="col-sm-offset-3 col-sm-10">
			  <button type="submit" class="btn btn-primary">Save</button>
			  <a href="{{ URL::to('/admin/system-language') }}">Back to all post</a>
			</div>
		</div>
	</form>

</div><!-- /.row -->
@stop
@section('footer')
<script type="text/javascript">
$(function(){

});
</script>
@stop