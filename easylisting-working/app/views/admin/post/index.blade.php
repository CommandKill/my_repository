@extends('admin._layouts.index')
@section('content')

{{ Notification::showAll() }}
{{-- Notification::group('info', 'success', 'error', 'warning')->showAll() --}}

<div class="panel panel-default">
  <div class="panel-heading">
    <a href="#modal-content" class="btn btn-primary btn-sm btn-add" data-toggle='modal' role='button'> Add new post</a>
  </div>
  <div class="panel-body">
  <form class="form-inline" role="form">
    <div class="form-group">
      <label class="sr-only" for="title">Title</label>
      <input type="text" class="form-control" id="q" name="q" placeholder="Enter title">
    </div>
    <div class="form-group">
      <div class="input-group">
        <div class="input-group-addon">Post ID</div>
        <input class="form-control" type="text" name="post_id" id="post_id" placeholder="Enter post id">
      </div>
    </div>
    <button type="submit" class="btn btn-default">Search</button>
    <a href="{{ URL::to('admin/post') }}" class="alert-link">Reset</a>
  </form>
  </div>
</div>

  @if($data['posts'])
  <table class="table table-hover ">
    <thead>
      <tr>
        <th>#</th>
        <th>Post image</th>
        <th>Description</th>
        <th width="150">Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach($data['posts'] as $post)
      <tr>
        <td>{{ $post['id'] }}</td>
        <td>
          @if ($post->thumbnail && $post->thumbnail != '' && $post->thumbnail != 'null')
          <img src="{{ sprintf($data['thumbnail_url'], $post->id, $post->thumbnail) }}" alt="..." class="">
          @else
          <img src="{{ asset('img/car-empty.jpg') }}" alt="..." class="">
          @endif
        </td>
        <td>
          <h5>{{ $post->make->make or '' }} {{ $post->model->model or '' }} {{ $post->submodel->sub_model or '' }}</h5>
          <ul class="car-desc">
            <li><b>Price</b> {{ number_format($post->price) }} ฿</li>
            <li><b>by</b> <a href="#link-to-profile">{{ $post->post_by->username }} ({{ $post->post_by->email }})</a></li>
            <li><b>Phone</b> {{ $post->post_by->phone }}</li>
            <li><b>Line</b> {{ $post->post_by->line_id }}</li>
            <li><b>Post at</b> {{ $post->created_at }}</li>
            <li><b>IP address</b> {{ $post->ip }}</li>
          </ul>
          @if ($post->promoted)
          <button type="button" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-star"></span> Promote</button>
          @endif
          @if ($post->status == $data['status']['active'])
          <button type="button" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-globe"></span> Online</button>
          @elseif ($post->status == $data['status']['inactive'])
          <button type="button" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-globe"></span> Offline</button>
          @elseif ($post->status == $data['status']['lock'])
          <button type="button" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-lock"></span> Lock</button>
          @elseif ($post->status == $data['status']['waiting'])
          <button type="button" class="btn btn-info btn-xs"><span class="glyphicon glyphicon-folder-close"></span> Waiting for approval...</button>
          @endif
          @if ($post->verified)
          <button type="button" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-ok"></span> Verified</button>
          @endif
        </td>
        <td>
          <div class="btn-group">
            <a href="{{ URL::to('admin/post/edit') }}/{{ $post->id }}" type="button" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-pencil"></span> Edit</a>
            <a href="{{ URL::to('admin/post/remove') }}/{{ $post->id }}" type="button" class="btn btn-default btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span> Delete</a>
          </div>

          <h5><button type="button" class="btn btn-default btn-xs btn-car-id">#{{ sprintf($data['pattern_post_id'], $post->id) }}</button></h5>
      
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

@include('admin.post.add-modal')

@stop
@section('footer')
{{-- HTML::script('js/sample.js') --}}
<script type="text/javascript">
function copyToClipboard(text) {
  window.prompt("Copy to clipboard: Ctrl+C, Enter", text);
}
$(function(){
  $('.btn-car-id').click(function(){
    copyToClipboard($(this).text().replace('#', ''));
  });

    $.get( "/api/v1/car/year", function( data ) {
  	  $.each( data.years, function( key, val ) {
  		 if(year==val.id) {
  		 	$("#year").append($('<option selected></option>').val(val.id).html(val.year));
  		 }else {
  		 	$("#year").append($('<option></option>').val(val.id).html(val.year));
  	 	 }
  	  });
  	  $("#year").change();
    }, "json" );

    $.get( "/api/v1/car/make",{ year:$(this).val() }, function( data ) {
        $.each( data.makes, function( key, val ) {
         if(make==val.id) {
          $("#make").append($('<option selected></option>').val(val.id).html(val.make));
         }else {
          $("#make").append($('<option></option>').val(val.id).html(val.make));
         }
        });
        $("#make").change();
      }, "json" );

    $("#make").change(function(){

   	  $("#model").empty();
   	  $("#model").append($('<option value=""></option>').html('Select a model'));
      $("#submodel").empty();
      $("#submodel").append($('<option value=""></option>').html('Select a sub model'));

      if ($(this).val()) {
        $.get( "/api/v1/car/model",{ make_id:$(this).val() }, function( data ) {
          $.each( data.models, function( key, val ) {
           if(model==val.id) {
            $("#model").append($('<option selected></option>').val(val.id).html(val.model));
           }else {
            $("#model").append($('<option></option>').val(val.id).html(val.model));
           }
          });
          $("#model").change();
        }, "json" );
      }


    });

     $("#model").change(function(){
      $("#submodel").empty();
      $("#submodel").append($('<option value=""></option>').html('Select a sub model'));
      if ($(this).val()) {
        $.get( "/api/v1/car/sub-model",{ model_id:$(this).val() }, function( data ) {
          $.each( data.submodels, function( key, val ) {
           if(submodel==val.id) {
            $("#submodel").append($('<option selected></option>').val(val.id).html(val.sub_model));
           }else {
            $("#submodel").append($('<option></option>').val(val.id).html(val.sub_model));
           }
          });
        }, "json" );
      }
     });
});
</script>
@stop