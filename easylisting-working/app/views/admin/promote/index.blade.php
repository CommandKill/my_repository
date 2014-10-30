@extends('admin._layouts.index')
@section('content')

{{-- Notification::showAll() --}}
{{ Notification::group('info', 'success', 'error', 'warning')->showAll() }}

<div class="panel panel-default">
	<div class="panel-heading">
		<a href="#modal-content" class="btn btn-primary btn-sm btn-add" data-toggle='modal' role='button'> Add new promote</a>
	</div>
	<div class="panel-body">
	<form class="form-inline" role="form">
		<div class="form-group">
		  <label class="sr-only" for="title">Title</label>
		  <input type="text" class="form-control" id="q" name="q" placeholder="Enter title">
		</div>
		<div class="form-group">
		  <div class="input-group">
		    <div class="input-group-addon">Slug</div>
		    <input class="form-control" type="text" name="slug" id="slug" placeholder="Enter slug">
		  </div>
		</div>
		<button type="submit" class="btn btn-default">Search</button>
		<a href="{{ URL::to('admin/content-promote') }}" class="alert-link">Reset</a>
	</form>
	</div>
</div>

	@if($data['pages'])
	<table class="table table-hover ">
	<thead>
	  <tr>
	    <th>#</th>
	    <th>Thumbnail</th>
	    <th>Status</th>
	    <th>Action</th>
	  </tr>
	</thead>
	<tbody>
	  @foreach($data['pages'] as $page)
	  <tr>
	    <td>{{ $page['id'] }}</td>
	    <td>
          @if ($page['thumbnail'] && $page['thumbnail'] != '' && $page['thumbnail'] != 'null')
          <img src="{{$data['thumbnail_url']}}{{$page['id']}}/160x100-{{$page['thumbnail']}}" alt="..." class="">
          @else
          <img src="{{ asset('img/car-empty.jpg') }}" alt="..." class="">
          @endif
        </td>
	    <td>{{ Str::limit($page->title, 50) }}<br/><small>( {{ $page['slug'] }} )</small>
	    <hr/>
	    @if ($page['promoted'])
                  <button type="button" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-star"></span> Featured</button>
                  @endif
                  @if ($page['status'] == $data['status']['active'])
                  <button type="button" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-globe"></span> Online</button>
                  @elseif ($page['status'] == $data['status']['inactive'])
                  <button type="button" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-globe"></span> Offline</button>
                  @elseif ($page['status'] == $data['status']['lock'])
                  <button type="button" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-lock"></span> Lock</button>
                  @endif
	    </td>
	    <td>
	      <div class="btn-group">
	        <a href="{{ URL::to('admin/content-promote/edit') }}/{{ $page->id }}" type="button" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-pencil"></span> Edit</a>
	        <a type="button" class="btn btn-default btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span> Delete</a>
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
		<p>Please check your data again, or <a href="{{ URL::to('admin/content-promote') }}" class="alert-link">Reset</a>.</p>
	</div>
	@endif


@include('admin.promote.add-modal')

@stop
@section('footer')
{{-- HTML::script('js/sample.js') --}}
<script type="text/javascript">
$(function(){

});
</script>
@stop