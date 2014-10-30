@extends('admin._layouts.index')
@section('head')
<style>

</style>

@stop
@section('content')
<div class="row">

    <div class="col-xs-12">

        @include('admin/_partials/notifications')

        <!-- all user list -->
        <div class="box">

            <div class="box-body table-responsive">

                <div class="row">
                    <div class="col-xs-12">
                        <a href="#modal-content" class="btn btn-primary pull-right btn-sm btn-add" data-toggle='modal' role='button'>
                            <i class="glyphicon glyphicon-plus"></i> Add new user
                        </a><br/>
                    </div>
                </div><br/>

                <table id="example1" class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>User</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $key=>$user)
                    <tr>
                        <td>{{ $user->id}}</td>
                        <td>
                            {{ $user->first_name}} &nbsp; {{ $user->last_name }}<br/>
                            <small>{{ $user->email }}</small><br/>
                            @if($user->avatar)
                              <img class="file-preview-image" src="{{ $avatar_url }}{{ $user->avatar }}" title="" alt="{{ $user->avatar }}"/>
                            @else
                              
                            @endif
                            <small style="color:#ccc"><i>Last sign in</i> {{ $user->last_login }}</small>
                        </td>
                        <td>
                            @foreach ($user->groups as $key => $value)
                                {{ $value->name }}@if ($key+1 < count($user->groups)), @endif
                            @endforeach
                            <hr>
                            @foreach ($user->permissions as $k => $v)
                                {{ $k }} /
                            @endforeach

                            {{-- $user->groups[0]->name --}}
                        </td>
                        <td>{{ $user->status }}</td>
                        <td>
                            <a class="btn btn-default btn-xs" href='{{ action('UserController@edit', array($user->id)) }}'">Edit</a>
                            @if ($user->status != 'Suspended')
                            <a class="btn btn-default btn-xs" href="{{ action('UserController@suspend', array($user->id)) }}">Suspend</a>
                            @else
                            <a class="btn btn-default btn-xs" href="{{ action('UserController@unsuspend', array($user->id)) }}">Un-Suspend</a>
                            @endif
                            @if ($user->status != 'Banned')
                            <a class="btn btn-default btn-xs" href="{{ action('UserController@ban', array($user->id)) }}">Ban</a>
                            @else
                            <a class="btn btn-default btn-xs" href="{{ action('UserController@unban', array($user->id)) }}">Un-Ban</a>
                            @endif

                            <button class="btn btn-default action_confirm btn-xs" href="{{ action('UserController@destroy', array($user->id)) }}" data-token="{{ Session::getToken() }}" data-method="delete">Delete</button></td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div><!-- /.box-body -->
        </div><!-- /.box -->

    </div>

</div>
<div class='modal fade' id='modal-content' tabindex='-1'>
  <div class='modal-dialog'>
    <div class='modal-content'>
        {{ Form::open(array(
                    'route'    => 'admin.users.store',
                    'class'     => 'form validate-form',
                    'role'      => 'form',
                    'id'        => 'frmCreate'
            )) 
        }}

        <div class='modal-header'>
         <button aria-hidden='true' class='close' data-dismiss='modal' type='button'>×</button>
         <h4 class='modal-title' id='myModalLabel'>Create new user</h4>
        </div>
        <div class='modal-body'>
        
            <div class='form-group'>
                <label class='control-label' for='title'>Email</label>
                <div class='controls'>
                    <input class='form-control' minlength='2' required id='email' name='email' placeholder='Email' type='text' value=''>
                </div>
            </div>
            <div class='form-group'>
                <label class='control-label' for='title'>Password</label>
                <div class='controls'>
                    {{ Form::password('password', array('class' => 'form-control', 'placeholder' => 'Password', 'required')) }}
                </div>
            </div>

        </div>
        <div class='modal-footer'>
         <button class='btn btn-default btn-sm' data-dismiss='modal' type='button'>Close</button>
         <button class='btn btn-success btn-sm' type='submit'>Save</button>
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