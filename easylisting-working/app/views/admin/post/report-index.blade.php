@extends('admin._layouts.index')
@section('content')

{{ Notification::showAll() }}
{{-- Notification::group('info', 'success', 'error', 'warning')->showAll() --}}

<div class="panel panel-default">
<!--   <div class="panel-heading">
    <a href="#modal-content" class="btn btn-primary btn-sm btn-add" data-toggle='modal' role='button'> Add new post</a>
  </div> -->
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
   <a href="{{ URL::to('admin/post/report-listing?lang=th') }}">TH</a> | <a href="{{ URL::to('admin/post/report-listing?lang=en') }}">EN</a>
  <table class="table table-hover ">
    <thead>
      <tr>
        <th>#</th>
        <th>Post image</th>
        <th>Description</th>
        <th width="180">Action</th>
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
          <h5>{{ Str::limit($post->title, 50) }}</h5>
          <ul class="car-desc">
            <li><b>Report by</b> <a href="mailto:{{ $post->report_by }}"> {{ $post->report_by }}</a></li>
            <li><b>Reason</b> {{$post->answer_title}}</li>
          </ul>
        </td>
        <td>
          <div class="btn-group">
            <a href="{{ URL::to('admin/post/ignore') }}/{{ $post->report_id }}" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-ok"></span> Ignore</a>
            <a href="{{ URL::to('admin/post/remove') }}/{{ $post->id }}" class="btn btn-default btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span> Remove</a>
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
});
</script>
@stop