@extends('admin._layouts.index')
@section('head')
<style>

</style>

@stop
@section('content')
<div class="row">

    <div class="col-xs-12">
        <table class="table table-bordered table-striped">
            <tr>
                <th>#</th>
                <th>Api</th>
				<th>Action</th>
            </tr>
            <tr>
                <td>1</td>
                <td><b>Car</b></td>
                <td><a href="#" data-toggle="modal" data-target="#myPreviewModal" data-href="{{ URL::to('api/v1/car?html') }}" class="btn btn-view btn-default btn-sm">View</a></td>
            </tr>
            <tr>
                <td>2</td>
                <td><b>Address</b></td>
                <td><a href="#" data-toggle="modal" data-target="#myPreviewModal" data-href="{{ URL::to('api/v1/address?html') }}" class="btn btn-view btn-default btn-sm">View</a></td>
            </tr>
        </table>
    </div>

</div><!-- /.row -->
@include('admin.api-doc.preview-modal')
@stop
@section('footer')
<script type="text/javascript">
$(function(){
	$('.btn-view').click(function(){
		$('#content-preview').attr('src', $(this).data('href'));
	});
    $('#myPreviewModal').on('show.bs.modal', function (e) {
      // do something...
    });
});
</script>
@stop