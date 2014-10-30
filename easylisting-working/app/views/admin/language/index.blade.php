@extends('admin._layouts.index')
@section('header')
<style>

</style>
@stop
@section('content')
  <div class="row">
    <div class="col-xs-4">
    	<h5>Language</h5>
		<div class="list-group">
		@foreach ($data['languages'] as $lang)
			<a href="{{ URL::to('admin/language') }}/{{ $lang['short_code'] }}/{{ $data['module'] }}" 
			class="list-group-item {{ Request::is('admin/language/'.$lang['short_code']) 
			|| Request::is('admin/language/'.$lang['short_code'].'/*') ? 'active' : '' }}">
			{{ $lang['title'] }}</a>
		@endforeach
		</div>
		<h5>Module</h5>
		<div class="list-group">
			<a href="{{ URL::to('admin/language').'/'.$data['lang'].'/all' }}" 
			class="list-group-item {{ Request::is('admin/language/'.$data['lang'].'/all') ? 'active' : '' }}">All</a>
		@foreach ($data['modules'] as $m)
			<a href="{{ URL::to('admin/language').'/'.$data['lang'].'/'.$m['module'] }}" 
			class="list-group-item {{ Request::is('admin/language/'.$data['lang'].'/'.$m['module']) ? 'active' : '' }}">{{ ucfirst($m['module']) }}</a>
		@endforeach
		</div>
    </div>
    <div class="col-xs-8">
    	@if($data['lang'] && $data['lang'] != '')
		<form action="{{ URL::to('admin/language') }}/{{ $data['lang'] }}/{{ $data['module'] }}/save" role="form" method="post">
    	@elseif($data['lang'] && $data['lang'] != '' && $data['module'] && $data['module'] != '')
		<form action="{{ URL::to('admin/language') }}/{{ $data['lang'] }}/{{ $data['module'] }}save" role="form" method="post">
		@else
		<form action="{{ URL::to('admin/language') }}/save" role="form" method="post">
    	@endif
		@foreach ($data['text'] as $key => $text)
		  <div class="form-group">
		    <label for="{{ $text['key'] }}">{{ $text['key'] }}</label><br/>
		    <small>{{ $text['input_option'] }}</small>
		    @if($text['input_type'] == 'editor')
            {{ Form::textarea($text['key'], $text['value'], array('class' => 'ckeditor')) }}
		    @elseif($text['input_type'] == 'textarea')
            {{ Form::textarea($text['key'], $text['value'], array('style' => 'width:100%')) }}
            @else
            <input type="text" class="form-control" id="{{ $text['key'] }}" name="{{ $text['key'] }}" placeholder="Enter text" value="{{ $text['value'] }}">
            @endif
		  </div>
		@endforeach
		  <button type="submit" class="btn btn-primary">Save</button>
		</form>
    </div>
  </div>
@stop
@section('footer')
<!-- editor ckeditor and config -->
<script src="{{ asset('js/plugins/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('js/plugins/ckeditor/adapters/jquery.js') }}"></script>
<script src="{{ asset('js/editor.js') }}"></script>
<script type="text/javascript">
$(function(){
    $('.ckeditor').ckeditor({toolbar_liteToolbar:liteToolbar, toolbar: 'liteToolbar'});
    //$('.ckeditor').ckeditor({toolbar_simpleToolbar:simpleToolbar, toolbar: 'simpleToolbar'});
    // $('.ckeditor').ckeditor({toolbar_fullToolbar:fullToolbar, toolbar: 'fullToolbar'});
    // CKEDITOR.timestamp='ABCD'; for test refresh editor
});
</script>
@stop