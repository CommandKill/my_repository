@extends('admin._layouts.index')
@section('head')
<style>

</style>

@stop
@section('content')
<div class="row">

    <div class="col-xs-12">

        <div class="box">
            <div class="box-body table-responsive">
              <div class="row">
                <div class="col-xs-12">
                  <a href="#modal-content" class="pull-right btn btn-primary btn-sm btn-add" data-toggle='modal' role='button'>
                    <i class="glyphicon glyphicon-plus"></i> Add new page
                  </a>
                </div>
              </div>
              <br>
              @if($list->count())  
              <table class="table table-hover table-bordered">
                  <tr>
                      <th>ID</th>
                      <th>Page Name</th>
                      <th>Action</th>
                  </tr>
                  @foreach($list as $l)
                  <tr>
                      <td>{{ $l->id }}</td>
                      <td><b>{{ $l->name }}</b></td>
                      <td>
                      <div class="btn-group">
                        <a href="{{ URL::to('admin/banner-page/edit') }}/{{ $l->id }}" type="button" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-pencil"></span> Edit</a>
                        <a href="{{ URL::to('admin/banner-page/destroy') }}/{{ $l->id }}" class="btn btn-default btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span> Delete</a>
                      </div>
                      </td>
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
<div class='modal fade' id='modal-content' tabindex='-1'>
  <div class='modal-dialog'>
    <div class='modal-content'>
      <form class="form validate-form" id="frmCreate" style="margin-bottom: 0;" method="POST" action="{{ URL::to('admin/banner-page/store') }}" 
      accept-charset="UTF-8" enctype="multipart/form-data">
        <div class='modal-header'>
         <button aria-hidden='true' class='close' data-dismiss='modal' type='button'>×</button>
         <h4 class='modal-title' id='myModalLabel'>Create new page</h4>
        </div>
        <div class='modal-body'>
        <input name="authenticity_token" type="hidden" />
         <div class='form-group'>
           <label class='control-label' for='title'>Page</label>
           <div class="controls">
              <input type="text" name="name" id="name">
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
@stop
@section('footer')
<script type="text/javascript">
$(function(){

});
</script>
@stop