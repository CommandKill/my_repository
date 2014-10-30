@extends('admin._layouts.index')
@section('head')
<style>

</style>

@stop
@section('content')
<form action="{{ URL::to('admin/banner-file/update') }}" id="frmUpdate" method="POST" enctype="multipart/form-data">
  		<input type="hidden" name="id" id="id" value="{{ $d->id }}">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-body">
			        <input name="authenticity_token" type="hidden" />
					<div class="form-group">
						<div class="controls">
							<img src="{{ asset('uploaded/banner/'.$d->name) }}" width="100%" />
						</div>
					</div>
					 <div class='form-group'>
	                   <label class='control-label' for='title'>File Banner</label>
	                   <div class='controls'>
	                     <input type="file" name="files" id="files" multiple='false' required>
						 <span id="suggestion"></span>
	                   </div>
	                 </div>
                </div><!-- /.box-body -->
                <div class="panel-footer">
                    <button type="submit" class="btn btn-primary btn-save btn-sm">Save</button>
                    <a href="{{ URL::to('admin/banner-file') }}">Cancel</a>
                </div>
            </div>
        </div><!-- /.col-xs-12 -->
    </form>
@stop
@section('footer')
<script type="text/javascript">
$(function(){

});
</script>
@stop