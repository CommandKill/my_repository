@extends('admin._layouts.index')
@section('head')
<style>

</style>
@stop
@section('content')
<div class="row">

        <form action="{{ URL::to('admin/setting/store') }}" id="frmUpdate" method="POST" enctype="multipart/form-data">
        <div class="col-xs-12">
			<ul class="nav nav-pills">
                @foreach ($data['setting'] as $key=>$value)
                <li class="{{ ($key == 'global') ? 'active' : '' }}"><a data-toggle="tab" href="#tab-{{ $key }}">{{ ucfirst($key) }}</a></li>
                @endforeach
            </ul>
            <br/>
            <div class="tab-content">
                @foreach ($data['setting'] as $key=>$value)
                <div class="tab-pane {{ $key == 'global' ? 'active' : '' }}" id="tab-{{ $key }}">
                    
                    @foreach ($data['setting'][$key] as $config)
                        <div class="form-group">
                            <label>{{ $config['alias'] }}</label> <small>{{ $config['short_desc'] }}</small>
                            <div class="controls">
                                <div class="form-group">
                                    @if($config['input_type'] == 'editor')
                                    {{ Form::textarea($config['key'], $config['value'], array('class' => 'ckeditor')) }}
                                    @elseif($config['input_type'] == 'option')
                                    {{ Form::select($config['key'], $config['option'], $config['value']) }}
                                    @elseif($config['input_type'] == 'textarea')
                                    {{ Form::textarea($config['key'], $config['value'], array('style' => 'width:100%')) }}
                                    @else
                                    <input type="text" name="{{ $config['key'] }}" id="{{ $config['key'] }}" value="{{ $config['value'] }}" class="form-control input-sm" />
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
                @endforeach
            </div>
        </div><!-- /.col-xs-12 -->
        <div class="col-xs-12">
   		{{ Form::submit('Save', array('class' => 'btn btn-primary btn-save btn-sm')) }}
        <a href="{{ URL::to('admin/') }}">Back to home</a>
       	</div>
        </form>
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