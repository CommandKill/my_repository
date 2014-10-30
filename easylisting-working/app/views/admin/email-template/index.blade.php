@extends('admin._layouts.index')
@section('header')
<style>

</style>

@stop
@section('content')
<div class="row">

    <div class="col-xs-12">
        
        <div class="row">
			<div class="col-xs-12">
				<a href="#modal-content" class="btn btn-default btn-sm btn-add" data-toggle='modal' role='button'>
                    <i class="glyphicon glyphicon-plus"></i> Add new post
                </a><br/>
			</div>
		</div>
        <br>
        @if($list->count())  
        <table class="table table-bordered table-striped">
            <tr>
                <th>ID</th>
                <th>Email templates</th>
				<th>Action</th>
            </tr>
            @foreach($list as $l)
            <tr>
                <td>{{ $l->id }}</td>
                <td><b>{{ $l->key }}{{-- $l->template[0]->title --}}</b></td>
                <td><a href="{{ URL::to('admin/email-template/edit') }}/{{ $l->id }}" class="btn btn-default btn-sm">edit</a>
                    <a href="{{ URL::to('admin/email-template/destroy') }}/{{ $l->id }}" class="btn btn-default btn-sm">delete</a></td>
            </tr>
            @endforeach
        </table>
		{{ $list->links() }}
        @else
        <span class='no-data'>No data</span>
        @endif

    </div>

</div><!-- /.row -->

<div class='modal fade' id='modal-content' tabindex='-1'>
  <div class='modal-dialog'>
    <div class='modal-content'>
      <form class="form validate-form" id="frmCreate" style="margin-bottom: 0;" method="post" action="{{ URL::to('admin/email-template/store') }}" accept-charset="UTF-8">
        <div class='modal-header'>
         <button aria-hidden='true' class='close' data-dismiss='modal' type='button'>×</button>
         <h4 class='modal-title' id='myModalLabel'>Create new template</h4>
        </div>
        <div class='modal-body'>
        <input name="authenticity_token" type="hidden" />

            <div class='form-group'>
                <label class='control-label' for='title'>Email template name</label>
                <div class='controls'>
                    <input class='form-control' minlength='2' required id='key' name='key' placeholder='Title' type='text' value=''>
                </div>
            </div>

        </div>
        <div class='modal-footer'>
         <button class='btn btn-default btn-sm' data-dismiss='modal' type='button'>Close</button>
         <button class='btn btn-primary btn-sm' type='submit'>Save</button>
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