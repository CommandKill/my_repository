@extends('admin._layouts.index')
@section('head')
<style>

</style>

@stop
@section('content')
<div class="row">

    <div class="col-xs-12">
        <div class='modal fade' id='modal-content' tabindex='-1'>
          <div class='modal-dialog'>
            <div class='modal-content'>
              <form class="form validate-form" id="frmCreate" style="margin-bottom: 0;" method="POST" action="{{ URL::to('admin/banner/store') }}" accept-charset="UTF-8" enctype="multipart/form-data">
                <div class='modal-header'>
                 <button aria-hidden='true' class='close' data-dismiss='modal' type='button'>×</button>
                 <h4 class='modal-title' id='myModalLabel'>Create new banner</h4>
                </div>
                <div class='modal-body'>
                <input name="authenticity_token" type="hidden" />
                 <div class='form-group'>
                   <label class='control-label' for='title'>Page</label>
                   <div class='input-group'>
                     <select id="page" name="page" required>
                    @foreach($page as $p)
                       <option value="{{ $p->id }}">{{ $p->name }}</option>
                    @endforeach	
                     </select>
                   </div>
                 </div> 
                 <div class='form-group'>
                   <label class='control-label' for='title'>Position</label>
                   <div class='controls'>
                     <select id="position" name="position" required>
        						 @foreach($pos as $p)
                    <option value="{{ $p->id }}" data-dimension="{{ $p->banner_size }}">{{ $p->name }}</option>
        						 @endforeach
                     </select>
                   </div>
                 </div>
				        <div class='form-group'>
                   <label class='control-label' for='title'>File Banner</label>
                   <div class='controls'>
                     <select id="file" name="file" required>
        						 @foreach($file as $f)
                       <option value="{{ $f->id }}" data-dimension="{{ $f->size }}"><img src="{{ asset('uploaded/banner'.$f->name) }}" width="50" height="20">{{ $f->name }}</option>
        						 @endforeach
                     </select>
                   </div>
                 </div>
                 <div class='form-group'>
                   <label class='control-label' for='title'>Link</label>
                   <div class='controls'>
                     <input class="form-control" type="text" name="link" id="link" required />
					           <span id="suggestion"></span>
                   </div>
                 </div>
                </div>
                <div class='modal-footer'>
                 <button class='btn btn-default btn-sm' data-dismiss='modal' type='button'>Close</button>
                 <button class='btn btn-primary btn-sm' id="submitform" type='submit'>Save</button>
                </div>
              </form>
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div> <!-- /.modal -->
        <!-- all user list -->
        <div class="box">

            <div class="box-body table-responsive">
    				<div class="row">
    					<div class="col-xs-12">
                <a href="#modal-content" class="btn btn-primary pull-right btn-sm btn-add" data-toggle='modal' role='button'>
                    <i class="glyphicon glyphicon-plus"></i> Add new banner
                </a>
    					</div>
    				</div>
            @if($list->count())  
            <table class="table table-hover">
              <tr>
                  <th>ID</th>
			            <th>Image</th>
                  <th>Page</th>
			            <th>Position</th>
			            <th>Action</th>
              </tr>
              @foreach($list as $l)
              <tr>
                  <td>{{ $l->id }}</td>
			            <td><img src="{{ asset('uploaded/banner/'.$l->files()->get()[0]->name) }}"></td>
                  <td><b>{{ $l->page()->get()[0]->name }}</b></td>
			            <td><b>{{ $l->position()->get()[0]->name }}</b></td>
                  <td><a href="{{ URL::to('admin/banner/edit') }}/{{ $l->id }}" class="btn btn-default btn-sm">edit</a>
                      <a href="{{ URL::to('admin/banner/destroy') }}/{{ $l->id }}" class="btn btn-default btn-sm">delete</a></td>
              </tr>
              @endforeach
            </table>
		        {{ $list->links() }}
            @else
            <span class='no-data'>No data</span>
            @endif
            </div><!-- /.box-body -->
        </div><!-- /.box -->

    </div>

</div><!-- /.row -->
@stop
@section('footer')
<script type="text/javascript">
$(function(){

});
</script>
@stop