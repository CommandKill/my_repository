@extends('site.desktop._layouts.index')
@section('content')
<div class="row">
<div class="col-xs-12">
<div class="container page">
    <div class="row detail-page">
        @if(isset($posts) && count($posts) > 3)
        <div class="col-xs-12">
        @else
        <div class="col-xs-9">
        @endif
            <header class="car-title">
                <div class="pull-right">
                	<a href="{{ URL::to(App::getLocale().'/compare/') }}">Clear all cars<i class="glyphicon glyphicon-trash"></i></a>
                </div>
				<h1 style="color:#1B5184;">{{ $data['page_title'] }}</h1>
            </header>
            <div class="row">
                <div class="col-xs-12">
                    <table id="example1" class="table table-bordered table-striped compare">
                        <thead>
                            <tr>
                                <th>&nbsp;</th>
                                @foreach($posts as $post)
                                <th>
									<a href="{{ URL::to(App::getLocale().'/car-detail/'.$post['id']) }}" class="pull-left">
									{{ $post['make']['make'] or ''}} {{ $post['model']['model'] or ''}} {{ $post['submodel']['sub_model'] or ''}}
								    </a>
								    <a href="#delete" data-id="{{ $post['id'] }}" class='btn btn-default btn-delete pull-right'><i class="delete fa fa-trash-o"></i></a>
								</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                          <tr>
                              <td calss="first">&nbsp;</td>
                              @foreach($posts as $post)
                              <td>
                                <img class="file-preview-image" src="{{ asset('uploaded/post/'.$post['id'].'/160x100-'.$post['thumbnail']) }}" title="" alt="">
                              </td>
                              @endforeach
                          </tr>
                          <tr>
                              <td class="first"><strong>Price</strong></td>
                              @foreach($posts as $post)
                              <td>{{ $post['price'] or ''}}</td>
                              @endforeach
                          </tr>
                          <tr>
                              <td class="first"><strong>Year</strong></td>
                              @foreach($posts as $post)
                              <td>{{ $post['year']['year'] or ''}}</td>
                              @endforeach
                          </tr>
                          <tr>
                              <td class="first"><strong>Brand</strong></td>
                              @foreach($posts as $post)
                              <td>{{ $post['make']['make'] or ''}}</td>
                              @endforeach
                          </tr>
                          <tr>
                              <td class="first"><strong>Model</strong></td>
                              @foreach($posts as $post)
                              <td>{{ $post['model']['model'] or ''}}</td>
                              @endforeach
                          </tr>
                          <tr>
                              <td class="first"><strong>Sub Model</strong></td>
                              @foreach($posts as $post)
                              <td>{{ $post['submodel']['sub_model'] or ''}}</td>
                              @endforeach
                          </tr>
                          <tr>
                              <td class="first"><strong>Parts</strong></td>
                              @foreach($posts as $post)
                              <td>
                                @if(isset($post['parts']))
                                <ul>
                                @foreach($post['parts'] as $value)
                                <li>{{ $value or ''}}</li>
                                @endforeach
                                </ul>
                                @endif
                              </td>
                              @endforeach
                          </tr>
                           <tr>
                              <td class="first"><strong>Milage</strong></td>
                              @foreach($posts as $post)
                              <td>{{ $post['milage'] or ''}}</td>
                              @endforeach
                          </tr>
                            <tr>
                              <td class="first"><strong>Color</strong></td>
                              @foreach($posts as $post)
                              <td>{{ $post['color']['color'] or ''}}</td>
                              @endforeach
                          </tr>
                          <tr>
                              <td class="first"><strong>Engine</strong></td>
                              @foreach($posts as $post)
                              <td>{{ $post['engine']['size'] or ''}}</td>
                              @endforeach
                          </tr>
                          <tr>
                              <td class="first"><strong>Fuel</strong></td>
                              @foreach($posts as $post)
                              <td>{{ $post['fuel']['type'] or ''}}</td>
                              @endforeach
                          </tr>
                          <tr>
                              <td class="first"><strong>Gear</strong></td>
                              @foreach($posts as $post)
                              <td>{{ $post['gear']['gear'] or ''}}</td>
                              @endforeach
                          </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
		
        @if(isset($posts) && count($posts) > 3)
      
        @else
         <div class="col-xs-3">
            <div class="row">
                <div class="col-xs-12">
                    @include('site.desktop.widgets.howto')
                </div>
            </div>
        </div>
        @endif
       
    </div>
</div>
</div>
</div>
@stop
@section('footer')
{{-- HTML::script('js/sample.js') --}}
<script type="text/javascript">
$(function(){
  
	$uri = '{{ Request::segment(3) }}';
	$arr = $uri.split(',');
	$newUri = [];
	$(".btn-delete").click(function(e) {
		e.preventDefault();
		// alert($(this).data('id'));

		for(var i = 0 ; i < $arr.length ; i++) {
			if($arr[i]!=$(this).data('id')) {
				$newUri.push($arr[i]);
			}
		}
//
		$load = $newUri.join();
		window.location.href = "{{ URL::to(App::getLocale().'/compare') }}"+'/'+$load;
	});
	
  	
});
</script>
@stop