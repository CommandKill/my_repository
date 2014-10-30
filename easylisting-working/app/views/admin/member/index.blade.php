@extends('admin._layouts.index')
@section('head')
<style>

</style>

@stop
@section('content')
  <div class="row">
    <div class="col-xs-12">
        <!-- all user list -->
        <div class="box">
            <div class="box-body">

				{{ Notification::group('info', 'success', 'error', 'warning')->showAll() }}

                @if(isset($data['member']))

                 <div class="panel panel-default">
                 	<div class="panel-body">
                 	<form class="form-inline" role="form">
                 		<div class="form-group">
                 		  <label class="sr-only" for="title">Email</label>
                 		  <input type="text" class="form-control" id="email" name="email" placeholder="Enter email">
                 		</div>
                 		<button type="submit" class="btn btn-default">Search</button>
                 		<a href="{{ URL::to('admin/member') }}" class="alert-link">Reset</a>
                 	</form>
                 	</div>
                 </div>


                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Id</th>
						<th>Name</th>
                        <th>Receive newsletter</th>
						<th>Action</th>
                    </tr>
                    </thead>
                    @foreach($data['member'] as $l)
                    <tr>
                        <td>{{ $l->id }}</td>
						<td>{{ $l->first_name }} {{ $l->last_name }} <br/><small><i>{{ $l->email }}</i></small></td>
                        <td>{{ $l->receive_newsletter==1?'yes':'no' }}</td>
                        <td>
                            <a href="{{ URL::to('admin/member/edit') }}/{{ $l->id }}" class="btn btn-default btn-xs">edit</a>
                            <!-- <a href="{{ URL::to('admin/member/remove') }}/{{ $l->id }}" class="btn btn-default btn-sm">delete</a> -->
                        </td>
                    </tr>
                    @endforeach
                </table>
				{{-- $list->links() --}}
                @else
                <span class='no-data'>No data</span>
                @endif
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