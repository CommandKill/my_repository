@extends('admin._layouts.index')
@section('content')

{{-- Notification::showAll() --}}
{{ Notification::group('info', 'success', 'error', 'warning')->showAll() }}

<div class="panel panel-default">
	<div class="panel-heading">
		<a href="#modal-content" class="btn btn-primary btn-sm btn-add" data-toggle='modal' role='button'> Add new subscriber</a>
	</div>
	<div class="panel-body">
	<form class="form-inline" role="form">
		<div class="form-group">
		  <label class="sr-only" for="title">Email</label>
		  <input type="text" class="form-control" id="email" name="email" placeholder="Enter email">
		</div>
		<button type="submit" class="btn btn-default">Search</button>
		<a href="{{ URL::to('admin/subscriber') }}" class="alert-link">Reset</a>
	</form>
	</div>
</div>

	@if($data['subscribers'])
	<table class="table table-hover ">
	<thead>
	  <tr>
	    <th>#</th>
	    <th>Email</th>
	    <th>Create at</th>
	    <th>Action</th>
	  </tr>
	</thead>
	<tbody>
	  @foreach($data['subscribers'] as $subscriber)
	  <tr>
	    <td>{{ $subscriber['id'] }}</td>
	    <td>{{ $subscriber['email'] }}</td>
	    <td>{{ $subscriber['created_at'] }}</td>
	    <td>
	      <div class="btn-group">
	        <a href="{{ URL::to('admin/subscriber/remove/'.$subscriber['id']) }}" class="btn btn-default btn-danger btn-xs" ><span class="glyphicon glyphicon-trash"></span> Delete</a>
	      </div>
	    </td>
	  </tr>
	  @endforeach
	</tbody>
	</table>
	<?php echo $data['pagination']; ?> 
	@else
	<div class="alert alert-dismissable alert-warning" style="margin:10px">
		<button type="button" class="close" data-dismiss="alert">×</button>
		<h4>Empty data!</h4>
		<p>Please check your data again, or <a href="{{ URL::to('admin/subscriber') }}" class="alert-link">Reset</a>.</p>
	</div>
	@endif


@include('admin.subscriber.add-modal')

@stop
@section('footer')
{{-- HTML::script('js/sample.js') --}}
<script type="text/javascript">
$(function(){

});
</script>
@stop