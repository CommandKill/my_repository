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
              <form class="form validate-form" id="frmCreate" style="margin-bottom: 0;" method="post" action="{{ URL::to('admin/usergroup/store') }}" accept-charset="UTF-8">
                <div class='modal-header'>
                 <button aria-hidden='true' class='close' data-dismiss='modal' type='button'>×</button>
                 <h4 class='modal-title' id='myModalLabel'>Create new group</h4>
                </div>
                <div class='modal-body'>
                
                <div class='form-group'>
                    <label class='control-label' for='title'>Group name</label>
                    <div class='controls'>
                        <input class='form-control' minlength='2' required id='group_name' name='group_name' placeholder='Group name' type='text' value=''>
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
        <!-- all user list -->
        <div class="box">
            <div class="box-body table-responsive">
				<div class="row">
					<div class="col-xs-12">
						<a href="#modal-content" class="pull-right btn btn-primary btn-sm btn-add" data-toggle='modal' role='button'>
                            <i class="glyphicon glyphicon-plus"></i> Add new group
                        </a><br/>
					</div>
				</div>
				<br>
                <table class="table table-bordered table-striped">
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Permissions</th>
						<th>Action</th>
                    </tr>
                    @foreach($list as $l)
                    <tr>
                        <td>{{ $l->id }}</td>
                        <td><b>{{ $l->name }}</b></td>
                        <td><ul>
                            @foreach($l->permissions as $k=>$v)
                            <li>{{ $k }}</li>
                            @endforeach
                            </ul>
                        </td>
                        <td><a href="{{ URL::to('admin/usergroup/edit') }}/{{ $l->id }}" class="btn btn-default btn-sm">edit</a>
                            <a href="{{ URL::to('admin/usergroup/destroy') }}/{{ $l->id }}" class="btn btn-default btn-sm">delete</a></td>
                    </tr>
                    @endforeach
                </table>
            </div><!-- /.box-body -->
        </div><!-- /.box -->

    </div>
  </div>
@stop
@section('footer')
<script type="text/javascript">
$(function(){

});
</script>
@stop