@extends('admin._layouts.index')
@section('head')
<!-- datetime picker -->
<link rel="stylesheet" href="{{ asset('css/plugins/bootstrap_datetimepicker/bootstrap-datetimepicker.min.css') }}" >

<!-- date range -->
<link rel="stylesheet" href="{{ asset('css/plugins/bootstrap_daterangepicker/daterangepicker-bs3.css') }}" >
<style>

</style>

@stop
@section('content')
<div class="row">
  <form action="{{ URL::to('admin/banner/update') }}" id="frmUpdate" method="POST" enctype="multipart/form-data">
  		<input type="hidden" name="id" id="id" value="{{ $d->id }}">
        <div class="col-xs-8">
            <div class="panel panel-default">
                <div class="panel-body">
			        <input name="authenticity_token" type="hidden" />
                 <div class='form-group'>
                   <label class='control-label' for='title'>Page</label>
                   <div class='input-group'>
                     <select id="page" name="page" required>
						 @foreach($page as $p)
                         <option value="{{ $p->id }}" @if($d->page_id==$p->id) selected @endif>{{ $p->name }}</option>
						 @endforeach	
                     </select>
                   </div>
                 </div> 
                 <div class='form-group'>
                   <label class='control-label' for='title'>Position</label>
                   <div class='controls'>
                     <select id="position" name="position" required>
						 @foreach($pos as $p)
                         <option value="{{ $p->id }}" data-dimension="{{ $p->banner_size }}"  @if($d->position_id==$p->id) selected @endif>{{ $p->name }}</option>
						 @endforeach
                     </select>
                   </div>
                 </div>
				 <div class='form-group'>
                   <label class='control-label' for='title'>Image</label>
                   <div class='controls'>
                     <img src="{{ asset('uploaded/banner/'.$d->files()->get()[0]->name) }}">
                   </div>
                 </div>
				 <div class='form-group'>
                   <label class='control-label' for='title'>File Banner</label>
                   <div class='controls'>
                     <select id="file" name="file" required>
						 @foreach($file as $f)
                         <option value="{{ $f->id }}" data-dimension="{{ $f->size }}"  @if($d->file_id==$f->id) selected @endif>{{ $f->name }}</option>
						 @endforeach
                     </select>
                   </div>
                 </div>
                 <div class='form-group'>
                   <label class='control-label' for='title'>Link</label>
                   <div class='controls'>
                     <input class="form-control" type="text" name="link" id="link" value="{{ $d->link }}" required />
					 <span id="suggestion"></span>
                   </div>
                 </div>
                 <div class="form-group">
                     <label>Available From</label>
                     <div class="controls">
                         <div class="input-group">
                             <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" name="available_from" id="available_from" value="{{ $d->available_from }} " class="form-control input-sm" minlength="2" required />
                         </div>
                     </div>
                 </div><!-- /.form group -->
                 <div class="form-group">
                     <label>Available To</label>
                     <div class="controls">
                         <div class="input-group">
                             <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" name="available_to" id="available_to" value="{{ $d->available_to }} " class="form-control input-sm" minlength="2" required />
                         </div>
                     </div>
                 </div><!-- /.form group -->
                 <div class="form-group">
                     <label>Publish</label>
                     <div class="controls">
                         <div class="input-group">
                            <input type="checkbox" name="status" id="status" @if($d->status==1) checked @endif />
                         </div>
                     </div>
                 </div><!-- /.form group -->
                </div><!-- /.box-body -->
                <div class="panel-footer">
                    <button type="submit" class="btn btn-success btn-save btn-sm">Save</button>
                    <a href="{{ URL::to('admin/banner') }}" class="btn btn-default btn-sm">Cancel</a>
                </div>  <!-- /panel footer -->
            </div><!-- /.box -->
        </div><!-- /.col-xs-4 -->
    </form>
</div><!-- /.row -->
@stop
@section('footer')
<!-- datetime picker -->
<script src="{{ asset('js/plugins/bootstrap_datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ asset('js/plugins/bootstrap_daterangepicker/moment.js') }}"></script>
<!-- date range -->
<script src="{{ asset('js/plugins/bootstrap_daterangepicker/daterangepicker.js') }}"></script>
<script type="text/javascript">
$(function(){
  $('#available_from').datetimepicker({pickTime: false});
  $('#available_to').datetimepicker({pickTime: false});
});
</script>
@stop