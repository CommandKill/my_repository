@extends('admin._layouts.index')
@section('head')
<style>

</style>

@stop
@section('content')
<div class="row">
  <form action="{{ URL::to('admin/banner-page/update') }}" id="frmUpdate" class="form-horizontal" method="POST" enctype="multipart/form-data">
  		<input type="hidden" name="id" id="id" value="{{ $d->id }}">
        <div class="col-xs-12">
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Page</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="name" id="name" value="{{ $d->name }}" placeholder="Enter page name">
                </div>
            </div>
            <div class="form-group">
                <label for="btn-submit" class="col-sm-2 control-label">&nbsp;</label>
                <div class="col-sm-10">
                    <button type="submit" id="btn-submit" class="btn btn-primary btn-save btn-sm">Save</button>
                    <a href="{{ URL::to('admin/banner-page') }}">Cancel</a>
                </div>
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