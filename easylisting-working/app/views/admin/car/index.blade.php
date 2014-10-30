@extends('admin._layouts.index')
@section('header')
<style>

</style>

@stop
@section('content')
  <div class="row">
    <div class="col-xs-12">
  <form class="form-inline" role="form">
    <div class="form-group">
      <label class="sr-only" for="title">Make</label>
      <input type="text" class="form-control" id="make" name="make" value="{{{ $input['make'] or '' }}}" placeholder="Enter make">
    </div>
    <div class="form-group">
      <label class="sr-only" for="title">Model</label>
      <input type="text" class="form-control" id="model" name="model" value="{{{ $input['model'] or '' }}}" placeholder="Enter model">
    </div>
    <button type="submit" class="btn btn-default">Search</button>
    <a href="{{ URL::to('admin/car') }}" class="alert-link">Reset</a>
  </form>
  <hr>
  </div>
  </div>
	@if($data['cars'])
  <h5 class="pull-right">Total {{ $data['cars']->getTotal() }}</h5>
  <table class="table table-hover table-bordered">
    <thead>
      <tr>
        <th>#</th>
        <th>Make</th>
        <th>Answer (Wizard)</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
    @foreach($data['cars'] as $car)
    <tr>
        <td>{{ $car->id }}</td>
        <td><b>{{ $car->model->model }}</b><br/>{{ $car->sub_model }}</td>
        <td>
        	<ul>
        		
        	</ul>
        </td>
        <td>
        	<div class="btn-group">
            <a href="" type="button" data-car-id="{{-- $car->id --}}" class="btn btn-edit btn-default btn-sm" data-toggle="modal" data-target="#model-edit" >
            	<span class="glyphicon glyphicon-pencil"></span> Edit</a>
          </div>
        </td>
    </tr>
    @endforeach
    </tbody>
	</table>
	<?php echo $data['pagination']; ?> 
  @else
  <div class="alert alert-dismissable alert-warning">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <h4>Empty data!</h4>
    <p>Please check your data again, or <a href="{{ URL::to('admin/post') }}" class="alert-link">Reset</a>.</p>
  </div>
  @endif

<!-- Modal -->
<div class="modal fade" id="model-edit" tabindex="-1" role="dialog" aria-labelledby="model-edit" aria-hidden="true">
    <div class="modal-dialog" style="width:650px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Edit answer car</h4>
            </div>
            <div class="modal-body">
            	
							<form class="form-inline" role="form">
							  <div class="form-group">
							    <label class="sr-only" for="questionaire">Questionaires</label>
							    <select name="questionaire" id="questionaire">
							    	<option value="" >Select a questionaires</option>
								    	@foreach ($data['questionaire'] as $key => $value) 
								    		<option value="" >{{ $value->lang[0]->name }}</option>
								    	@endforeach
							      </select>
							  </div>
								<div class="form-group">
							    <label class="sr-only" for="question">question</label>
							    <select name="questionaire" id="question">
							          <option value="" >Select a question</option>
							      </select>
							  </div>
							  <div class="form-group">
							    <label class="sr-only" for="answer">Answer</label>
							    <select name="questionaire" id="answer">
							          <option value="" >Select a answer</option>
							      </select>
							  </div>
							  <button type="submit" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-ok"></span> Choose</button>
							</form>
							<hr>
							<h4>Answers</h4>
               <div class="row">
                <div class="col-sm-12">

									<div class="list-group">
									  <a href="#" class="list-group-item">Cras justo odio <button type="button" class="btn btn-default btn-xs pull-right"><span class="glyphicon glyphicon-remove"></span> Remove</button>
									  </a>
									  <a href="#" class="list-group-item">Dapibus ac facilisis in <button type="button" class="btn btn-default btn-xs pull-right"><span class="glyphicon glyphicon-remove"></span> Remove</button></a>
									  <a href="#" class="list-group-item">Morbi leo risus  <button type="button" class="btn btn-default btn-xs pull-right"><span class="glyphicon glyphicon-remove"></span> Remove</button></a>
									  <a href="#" class="list-group-item">Porta ac consectetur ac <button type="button" class="btn btn-default btn-xs pull-right"><span class="glyphicon glyphicon-remove"></span> Remove</button></a>
									  <a href="#" class="list-group-item">Vestibulum at eros <button type="button" class="btn btn-default btn-xs pull-right"><span class="glyphicon glyphicon-remove"></span> Remove</button></a>
									</div>

						    </div>
						   </div>
            </div>
            <div class="modal-footer">
                <a id="full-preview-link" href="#" class="pull-left" target="_blank"></a>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@stop
@section('footer')
<script type="text/javascript">
$(function(){
	$('.btn-edit').click(function(){
    obj = $(this);
    var carId = obj.data('car-id');

  });

  // Set url for cropper toolkit brefore open modal
  $('#model-edit').on('show.bs.modal', function (e) {
    
  })
});
</script>
@stop