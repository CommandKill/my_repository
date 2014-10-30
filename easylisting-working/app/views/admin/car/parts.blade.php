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
      <label class="sr-only" for="part">Part</label>
      <input type="text" class="form-control" id="part" name="part" value="{{{ $input['part'] or '' }}}" placeholder="Enter part name">
    </div>
    <button type="submit" class="btn btn-default">Search</button>
    <a href="{{ URL::to('admin/car') }}" class="alert-link">Reset</a>
  </form>
  <hr>
  </div>
  </div>
	@if($data['cars'])
  <a href="{{ URL::to('admin/car-parts?lang=th') }}">TH</a> | <a href="{{ URL::to('admin/car-parts?lang=en') }}">EN</a>
  <h5 class="pull-right">Total {{ $data['cars']->getTotal() }}</h5>
  <table class="table table-hover table-bordered">
    <thead>
      <tr>
        <th>#</th>
        <th>Part</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
    @foreach($data['cars'] as $car)
    <tr>
        <td>{{ $car->id }}</td>
        <td>{{ $car->lang[0]['title'] }}</td>
        <td>
          <div class="btn-group">
            <a href=""
            data-content="{{ $car->lang[0]['title'] }}"
            type="button" 
            class="btn btn-edit btn-default btn-sm" 
            data-editid="{{ $car->lang[0]['id'] }}" 
            data-toggle="modal" 
            data-target="#model-edit">
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
          <form role="form" method="post">
            <input type="hidden" id="edit_id" name="edit_id" value="" />
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Edit Partlists</h4>
            </div>
            <div class="modal-body">
              
              
                <div class="form-group">
                  <input type="text" class="form-control" id="name" name="name" value="" placeholder="Enter name">
                </div>
              
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">
                  <span class="glyphicon glyphicon-ok"></span> Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>
@stop
@section('footer')
<script type="text/javascript">
$(function(){
	$('.btn-edit').click(function(){
    obj = $(this);
    $('#edit_id').val(obj.data('editid'));
    $('#name').val(obj.data('content'));
  });

  // Set url for cropper toolkit brefore open modal
  $('#model-edit').on('show.bs.modal', function (e) {
    
  })
});
</script>
@stop