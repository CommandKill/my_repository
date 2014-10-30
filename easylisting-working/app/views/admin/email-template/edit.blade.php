@extends('admin._layouts.index')
@section('header')
<style>

</style>

@stop
@section('content')

  <div class="row">
    <div class="col-xs-12">
	  <form action="{{ URL::to('admin/email-template/update') }}" id="frmUpdate" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="id" id="id" value="{{ $em->id }}">
      <input name="authenticity_token" type="hidden" />

      <div class='form-group'>
          <label class='control-label' for='title'>Email template name</label>
          <div class='controls'>
              <input class='form-control' minlength='2' required id='key' name='key' placeholder='Title' type='text' value='{{$em->key or ''}}'>
          </div>
      </div>

      <div class='tabbable'>
        <ul class='nav nav-tabs'>
            @foreach($languages as $lang)
            <li @if($lang->id == 1) class='active' @endif >
            <a data-toggle='tab' href='#tab{{ $lang->id }}'>
                <i class='flag flag-{{ $lang->short_code }}'></i>
                {{ $lang->title }}
            </a>
            </li>
            @endforeach
        </ul>
        <br/>
        <div class='tab-content'>
            @foreach($languages as $key=>$lang)
            <div class='tab-pane @if($lang->id == 1) active @endif' id='tab{{ $lang->id }}'>

                <div class='form-group'>
                    <label class='control-label' for='title'>Subject ({{ $lang->short_code }})</label>
                    <div class='controls'>
                        <input class='form-control' minlength='2' id='title_{{ $lang->short_code }}' name='title_{{ $lang->short_code }}' placeholder='Title' type='text' value='{{ $em->template[$key]->subject }}'>
                    </div>
                </div>
                <div class='form-group'>
                    <label class='control-label' for='title'>Template ({{ $lang->short_code }})</label>
                    <div class='controls'>
                        <textarea minlength="2" class='form-control ckeditor' id='template_{{ $lang->short_code }}' 
                          name='template_{{ $lang->short_code }}' rows='10'>{{{ $em->template[$key]['template'] or ''}}}</textarea>
                    </div>
                </div>

            </div>
            @endforeach
        </div>
      </div>

      <button type="submit" class="btn btn-primary btn-save btn-sm">Save</button>
      <a href="{{ URL::to('admin/email-template') }}">Back to all email template</a>
  </form>
  </div><!-- /.row -->

@stop
@section('footer')
<!-- editor ckeditor and config -->
{{ HTML::script('js/plugins/ckeditor/ckeditor.js') }}
{{ HTML::script('js/plugins/ckeditor/adapters/jquery.js') }}
{{ HTML::script('js/editor.js') }}
<script type="text/javascript">
$(function(){
  CKEDITOR.config.height = 500;
  CKEDITOR.config.allowedContent = true;
  // CKEDITOR.baseUrl = "http://easy-listing.com/";
  // CKEDITOR.config.allowedContent = function(){ 
  // allowedContent:
  //   'h1 h2 h3 p blockquote strong em;' +
  //   'a[!href];' +
  //   'img(left,right)[!src,alt,width,height];' +
  //   'table tr th td caption;' +
  //   'span{!font-family};' +
  //   'span{!color};' +
  //   'span(!marker);' +
  //   'del ins'
  // };
  // $('.ckeditor').ckeditor({toolbar_liteToolbar:liteToolbar, toolbar: 'liteToolbar'});
  $('.ckeditor').ckeditor({toolbar_simpleToolbar:simpleToolbar, toolbar: 'simpleToolbar'});
});
</script>
@stop