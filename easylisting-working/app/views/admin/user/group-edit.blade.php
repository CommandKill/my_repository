@extends('admin._layouts.index')
@section('head')
<style>

</style>

@stop
@section('content')
  <div class="row">
	  <form action="{{ URL::to('admin/usergroup/update') }}" id="frmUpdate" method="POST" enctype="multipart/form-data">
	  <input type="hidden" name="id" id="id" value="{{ $user_group->id }}">
          <div class="col-xs-4">
              <div class="panel panel-default">
                  <div class="panel-body">
                      <p>
                          <strong>Create date </strong> <time class="timeago" datetime="{{ $user_group->created_at or 'none' }}">-</time>
                      </p>
                      @if( $user_group->updated_at != '')
                      <p>
                          <strong>Last modify </strong> <time class="timeago" datetime="{{ $user_group->updated_at or 'none' }}">-</time>
                      </p>
                      @endif

                  </div><!-- /.box-body -->
                  <div class="panel-footer">
                      <button type="submit" class="btn btn-success btn-save btn-sm">Save</button>
                      <a href="{{ URL::to('admin/usergroup') }}" class="btn btn-default btn-sm">Cancel</a>
                  </div>  <!-- /panel footer -->
              </div><!-- /.box -->
          </div><!-- /.col-xs-4 -->
        <div class="col-md-8">
              <!-- profile -->
              <div class="panel panel-default">
                  <div class="panel-heading">
                      <h3 class="panel-title">User Group</h3>
                  </div><!-- /.box-header -->
               	<div class="panel-body">
                  <div class='form-group'>
                      <label class='control-label' for='title'>name</label>
                      <div class='controls'>
                          <input class='form-control' minlength='2' required id='group_name' name='group_name' placeholder='Group name' type='text' value='{{ $user_group->name }}'>
                      </div>
                  </div>

                  <table class="table">
                    <tr>
                        <th>Permission</th>
                        <th>Allow</th>
                    </tr>
                    @foreach($permissions as $key=>$value)
                    <tr>
                        <td><label for="permission[{{ $key }}]" style="width:100%;font-weight: normal;">{{ $key }}</label></td>
                        <td>{{ Form::checkbox('permission['.$key.']', $value, $value, array('id'=>'permission['.$key.']')) }}</td>
                    </tr>
                    @endforeach
                </table>


               </div><!-- /.box-body -->
              </div><!-- /.panel -->
        </div><!-- /.col-md-8 -->
      </form>
  </div><!-- /.row -->
@stop
@section('footer')
<script type="text/javascript">
$(function(){

});
</script>
@stop