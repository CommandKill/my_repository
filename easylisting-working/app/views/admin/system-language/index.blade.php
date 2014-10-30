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
				<a href="#modal-content" class="btn btn-primary btn-sm btn-add pull-right" data-toggle='modal' role='button'>
		            <i class="glyphicon glyphicon-plus"></i> Add new post
		        </a><br/>
			</div>
		</div>
		
		@if($data['langauges']->count())  
		<table class="table table-hover ">
			<thead>
		    <tr>
		        <th>ID</th>
		        <th>Title</th>
				<th>Code</th>
				<th>Short Code</th>
				<th>Action</th>
		    </tr>
		    </thead>
    		<tbody>
		    @foreach($data['langauges'] as $lang)
		    <tr>
		        <td>{{ $lang->id }}</td>
		        <td>{{ $lang->title }}</td>
				<td>{{ $lang->code }}</td>
				<td>{{ $lang->short_code }}</td>
		        <td><a href="{{ URL::to('admin/system-language/edit') }}/{{ $lang->id }}" class="btn btn-default btn-sm">edit</a>
		            <a href="{{ URL::to('admin/system-language/destroy') }}/{{ $lang->id }}" class="btn btn-default btn-sm">delete</a></td>
		    </tr>
		    @endforeach
			</tbody>
		</table>
		{{ $data['langauges']->links() }}
		@else
		<span class='no-data'>No data</span>
		@endif

        <div class='modal fade' id='modal-content' tabindex='-1'>
          <div class='modal-dialog'>
            <div class='modal-content'>
              <form class="form validate-form" id="frmCreate" style="margin-bottom: 0;" method="post" action="{{ URL::to('admin/system-language/store') }}" accept-charset="UTF-8">
                <div class='modal-header'>
                 <button aria-hidden='true' class='close' data-dismiss='modal' type='button'>×</button>
                 <h4 class='modal-title' id='myModalLabel'>Create new language</h4>
                </div>
                <div class='modal-body'>
                <input name="authenticity_token" type="hidden" />
                 <div class='form-group'>
                   <label class='control-label' for='title'>Title</label>
                   <div class='controls'>
                     <input class='form-control' minlength='2' required id='title' name='title' placeholder='Title' type='text'>
                   </div>
                 </div> 
                 <div class='form-group'>
                   <label class='control-label' for='title'>Code</label>
                   <div class='controls'>
                     <input class='form-control' minlength='2' required id='code' name='code' placeholder='Code' type='text'>
                   </div>
                 </div>
                 <div class='form-group'>
                   <label class='control-label' for='title'>Short Code</label>
                   <div class='controls'>
                     <input class='form-control' minlength='2' required id='short_code' name='short_code' placeholder='short code' type='text'>
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
    </div>

</div><!-- /.row -->
@stop
@section('footer')
<script type="text/javascript">
$(function(){

});
</script>
@stop