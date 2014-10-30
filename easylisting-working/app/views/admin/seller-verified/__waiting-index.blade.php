@extends('admin._layouts.index')
@section('content')

{{ Notification::showAll() }}
{{-- Notification::group('info', 'success', 'error', 'warning')->showAll() --}}

<!-- <div class="panel panel-default">
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
</div> -->

  @if($data['posts'])
  <table class="table table-hover ">
    <thead>
      <tr>
        <th>#</th>
        <th>Docs</th>
        <th>Seller Info</th>
        <th width="180">Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach($data['posts'] as $post)
      <tr>
        <td>{{ $post->id }}</td>
        <td>
          @if ($post->id_docs && $post->id_docs != '' && $post->id_docs != 'null')
          <img src="{{ sprintf($data['thumbnail_url'], $post->member_id, $post->id_docs) }}" alt="..." class="">

          <?php $_large = $post->member_id.'/'.$post->id_docs; ?>
          {{-- <!-- <img src="{{ $data['thumbnail_large'] }}{{ $_large }}" alt="..." class=""> --> --}}

          @else
          <img src="{{ asset('img/car-empty.jpg') }}" alt="..." class="">
          @endif
        </td>
        <td>
          <h5></h5>
          <ul class="car-desc">
            <li><b>Name</b> {{ $post->first_name }}</li>
            <li><b>Email </b> {{ $post->email }}</li>
            <li><b>Post at</b> {{ $post->created_at }}</li>
          </ul>
        </td>
        <td>
          <div class="btn-group">
            <a href="{{ URL::to('admin/seller-verified/approve') }}/{{ $post->id }}" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-ok"></span> Approve</a>
            <a href="{{ URL::to('admin/seller-verified/disapprove') }}/{{ $post->id }}" class="btn btn-default btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span> Disapprove</a>
          </div>

          <!-- <h5><button type="button" class="btn btn-default btn-xs btn-car-id">#</button></h5> -->
      
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
  <div class="text-center">
    <?php echo $data['pagination']; ?>
  </div>
  @else
  <div class="alert alert-dismissable alert-warning">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <h4>Empty data!</h4>
    <!-- <p>Please check your data again, or <a href="{{ URL::to('admin/seller-verified') }}" class="alert-link">Reset</a>.</p> -->
  </div>
  @endif

@include('admin.post.add-modal')

@stop
@section('footer')


@stop