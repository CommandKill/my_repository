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
    <a href="{{ URL::to('admin/car-vehicle') }}" class="alert-link">Reset</a>
  </form>
  <hr>
  </div>
  </div>
	@if($data['cars'])
  <h5 class="pull-right">Total {{ $data['cars']->getTotal()}} cars</h5>
  <table class="table table-hover table-bordered">
    <thead>
      <tr>
        <!--<th>#</th>-->
        <th>Make</th>
        <th>Model</th>
        <th>Answer (Wizard)</th>
        <th>Color</th>
      </tr>
    </thead>
    <tbody>
    @foreach($data['cars'] as $car)
    <tr>
        <!--<td>{{ $car->id }}</td>-->
        <td><b>{{ $car->make }}</b></td>
        <td><b>{{ $car->model }}</b></td>
        <td>{{ $car->trim }}</td>
        <td>
          @if($car->colors->count())
        	<div class="btn-group">
            <a href="#color-{{ $car->id }}" type="button" class="btn-toggle-color">
            	<span class="glyphicon glyphicon-eye-open"></span> Color</a>
          </div>
          @endif
        </td>
    </tr>
    @if($car->colors->count())
    <tr id="color-{{ $car->id }}" style="display:none">
      <td colspan="4">
        <div>Interior
        @foreach($car->colors as $color)
        @if($color->colorType == 'Interior')
          <button type="button" class="btn-color btn btn-default btn-xs pull-right" style="margin-right:4px;width:30px;height:16px;background:#{{ $color->colorHEX }};" 
          data-toggle="tooltip" 
          data-placement="top" 
          title="{{ $color->colorName }} ({{ $color->colorType }})">&nbsp;</button> 
        @endif
        @endforeach
        </div><div>Exterior
        @foreach($car->colors as $color)
        @if($color->colorType == 'Exterior')
          <button type="button" class="btn-color btn btn-default btn-xs pull-right" style="margin-right:4px;width:30px;height:16px;background:#{{ $color->colorHEX }};" 
          data-toggle="tooltip" 
          data-placement="top" 
          title="{{ $color->colorName }} ({{ $color->colorType }})">&nbsp;</button> 
        @endif
        @endforeach
        </div>
      </td>
    </tr>
    @endif
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

@stop
@section('footer')
<script type="text/javascript">
$(function(){
	$('.btn-color').tooltip();
  $('.btn-toggle-color').click(function(){
    var id = $(this).attr('href');
    $(id).toggle();
    return false;
  });
});
</script>
@stop