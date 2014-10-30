@extends('admin._layouts.index')
@section('head')
<!-- datetime picker -->
{{ HTML::style('css/plugins/bootstrap_datetimepicker/bootstrap-datetimepicker.min.css'); }}
<!-- date range -->
{{ HTML::style('css/plugins/bootstrap_daterangepicker/daterangepicker-bs3.css'); }}

<!-- gallery file upload -->
{{ HTML::style('css/plugins/fileupload/blueimp-gallery.min.css'); }}
{{ HTML::style('css/plugins/fileupload/jquery.fileupload.css'); }}
{{ HTML::style('css/plugins/fileupload/jquery.fileupload-ui.css'); }}

<!-- CSS adjustments for browsers with JavaScript disabled -->
<noscript>{{ HTML::style('css/plugins/fileupload/jquery.fileupload-noscript.css'); }}</noscript>
<noscript>{{ HTML::style('css/plugins/fileupload/jquery.fileupload-ui-noscript.css'); }}</noscript>
<style>
.section,
.tabbable li.active a:hover,
.tabbable li.active a {
  background-color: #eee;
  padding: 10px;
}
</style>
@stop
@section('content')
<div class="row">
    <div class="col-xs-12">

		{{ Form::open(array('url' => array('admin/content-review/update', $data['page']->id), 'method' => 'post', 'files' => true)) }}
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <p>
                        <strong>Create date </strong> <time class="timeago" datetime="{{ $data['page']->created_at }}">-</time><br/>
                        <i>(by {{ $data['page']->post_by->email }})</i>
                    </p>
                    @if( isset($data['page']->modify_by->email) )
                    <p>
                        <strong>Last modify </strong> <time class="timeago" datetime="{{ $data['page']->updated_at }}">-</time><br/>
                        <i>(by {{ $data['page']->modify_by->email }})</i>
                    </p>
                    @endif
                </div>
                <div class="panel-footer">
                    {{ Form::submit('Save', array('class' => 'btn btn-primary btn-save btn-sm')) }}
                    <a href="{{ URL::to('admin/content-review') }}">Back to all page</a>
                    <div id="option-control" class="btn-group dropdown pull-right">
                        <button name="status" class="btn btn-default btn-sm dropdown-toggle @if($data['page']->status==1) published @else unpublish  @endif" data-toggle="dropdown" style="margin-bottom:5px">
                            <i class="icon-globe"></i> @if($data['page']->status==1) Published @else Unpublish  @endif
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a id="option-control-publish">@if($data['page']->status==1) Unpublish @else Published  @endif</a></li>
                            <li class="divider"></li>
                            <li><a id="option-control-delete"><i class="icon-ban-circle"></i> Delete this page?</a></li>
                        </ul>
                        {{ Form::hidden('status', $data['page']->status, array('id'=>'statusx')) }}
                    </div>
                </div>
            </div><!-- /.box -->

            {{ Notification::showAll() }}

            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="form-group">
                        <label>Slug</label> <small>example: hello-world</small>
                        <div class="controls">
                            <div class="form-group">
                                <input type="text" name="slug" id="slug" value="{{ $data['page']->slug }}" class="form-control" />
                            </div>
                        </div>
                    </div><!-- /.form group -->
                    <div class="form-group">
                        <label>Publish date</label>
                        <div class="controls">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input type="text" name="publish" id="publish" value="{{ $data['page']->publish }}" class="form-control" />
                            </div>
                        </div>
                    </div><!-- /.form group -->
                    <div class="form-group">
                        <label>Content available period</label>
                        <div class="controls">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input type="text" name="available_period" id="available_period" class="form-control" value="{{ $data['available_period'] }}" />
                            </div>
                        </div>
                    </div><!-- /.form group -->
                    <div class="form-group">
                        <label for="promoted">Featured</label>
                        <div class="controls">
                            <input type="checkbox" name="promoted" id="promoted" {{ isset($data['page']->promoted) && $data['page']->promoted != 0 ? 'checked' : '' }} />
                        </div>
                    </div>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col-xs-4 -->
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Review </h3>
                </div><!-- /.box-header -->
                <div class="panel-body">
                    <div class='tabbable'>
						<ul class='nav nav-tabs'>
						    @foreach($data['languages'] as $lang)
						    <li @if($lang['id'] == 1) class='active' @endif >
						    <a data-toggle='tab' href='#tab{{ $lang['id'] }}'>
						        <i class='flag flag-{{ $lang['short_code'] }}'></i>
						        {{ $lang['title'] }}
						    </a>
						    </li>
						    @endforeach
						</ul>  
						<br/>
                        <div class='tab-content'>
                            @foreach($data['languages'] as $lang)
                            <div class='tab-pane @if($lang['id'] == 1) active @endif' id='tab{{ $lang['id'] }}'>

                                <a class="btn btn-default btn-sm pull-right preview-link"
                                   data-toggle="modal"
                                   data-target="#myPreviewModal"
                                   data-link="{{ URL::to($lang['short_code'].'/p') }}/{{ $data['page']['slug'] }}">
                                    <i class='glyphicon glyphicon-globe'></i> {{ URL::to($lang['short_code'].'/p') }}/{{ $data['page']['slug'] }}
                                </a>
                                <br style="clear:both" />
                                <div class="form-group">
                                    {{ Form::label('title_'.$lang['short_code'], "Title") }}
                                    <div class="controls">
                                        {{ Form::text('title_'.$lang['short_code'], 
                                        isset($data['page']->lang[$lang['id']]) ? $data['page']->lang[$lang['id']]['title'] : '', 
                                        array('class' => 'form-control')) }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{ Form::label('short_desc_'.$lang['short_code'], "Short description") }}
                                    <div class="controls">
                                        {{ Form::text('short_desc_'.$lang['short_code'], 
                                        isset($data['page']->lang[$lang['id']]) ? $data['page']->lang[$lang['id']]['short_desc'] : '', 
                                        array('class' => 'form-control')) }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{ Form::label('body_'.$lang['short_code'], "Content") }}
                                    <div class="controls">
                                        {{ Form::textarea('body_'.$lang['short_code'], 
                                        isset($data['page']->lang[$lang['id']]) ? $data['page']->lang[$lang['id']]['body'] : '', 
                                        array('class' => 'ckeditor')) }}
                                    </div>
                                </div>

                            </div>
                            @endforeach
                        </div>


                    </div>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col-xs-8 -->

        {{ Form::close() }}

<div class="col-xs-12">
    <h4>Optional</h4>

    <div class="form-horizontal section">
      <div class="form-group">
        <label for="thumbnail" class="col-sm-3 control-label">Thumbnail</label>
        <div class="col-sm-9">
          
          <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="file-preview-frame">
                            @if($data['page']->thumbnail != 'null' && $data['page']->thumbnail != '')
                            <img class="file-preview-image" src="{{ sprintf($data['thumbnail_url'], $data['page']->thumbnail) }}" title="{{ $data['page']->thumbnail }}" alt="{{ $data['page']->thumbnail }}">
                            @else   
                            <img class="file-preview-image" src="{{ asset('img/car-empty.jpg') }}" title="placeholder" alt="placeholder">
                            @endif
                        </div>
                        <div class="fileupload-buttonbar">
                          <span class="btn btn-success fileinput-button btn-xs">
                            <i class="glyphicon glyphicon-plus"></i>
                            <span>Select files...</span>
                            <input id="thumbnail" type="file" name="thumbnail">
                          </span>
                          <div id="thumbnail-file" class="files"></div>
                          <span id="uploadbtn"></span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                       
                    </div>
                </div>
            </div>
          </div><!-- /.panel -->
        </div>
      </div>
    </div>  
</div>  

    </div>

</div><!-- /.row -->
@include('admin.review.preview-modal')
@stop
@section('footer')
@include('admin.post.edit-gallery-upload-template')
<!-- update long time to easy to read -->
{{ HTML::script('js/plugins/jquery.timeago.js') }}
<!-- datetime picker -->
{{ HTML::script('js/plugins/bootstrap_datetimepicker/bootstrap-datetimepicker.min.js') }}
{{ HTML::script('js/plugins/bootstrap_daterangepicker/moment.js') }}
<!-- date range -->
{{ HTML::script('js/plugins/bootstrap_daterangepicker/daterangepicker.js') }}
<!-- editor ckeditor and config -->
{{ HTML::script('js/plugins/ckeditor/ckeditor.js') }}
{{ HTML::script('js/plugins/ckeditor/adapters/jquery.js') }}
{{ HTML::script('js/editor.js') }}

<!-- gallery file upload -->
{{ HTML::script('js/plugins/fileupload/vendor/jquery.ui.widget.js') }}
{{ HTML::script('js/plugins/fileupload/tmpl.min.js') }}
{{ HTML::script('js/plugins/fileupload/load-image.min.js') }}
{{ HTML::script('js/plugins/fileupload/canvas-to-blob.min.js') }}
{{ HTML::script('js/plugins/fileupload/jquery.blueimp-gallery.min.js') }}
{{ HTML::script('js/plugins/fileupload/jquery.iframe-transport.js') }}
{{ HTML::script('js/plugins/fileupload/jquery.fileupload.js') }}
{{ HTML::script('js/plugins/fileupload/jquery.fileupload-process.js') }}
{{ HTML::script('js/plugins/fileupload/jquery.fileupload-image.js') }}
{{ HTML::script('js/plugins/fileupload/jquery.fileupload-audio.js') }}
{{ HTML::script('js/plugins/fileupload/jquery.fileupload-video.js') }}
{{ HTML::script('js/plugins/fileupload/jquery.fileupload-validate.js') }}
{{ HTML::script('js/plugins/fileupload/jquery.fileupload-ui.js') }}

<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
<!--[if (gte IE 8)&(lt IE 10)]>
<script src="{{ asset('js/plugins/fileupload/jquery.xdr-transport.js') }}"></script>
<![endif]-->


<script type="text/javascript">
$(function(){
	$(".timeago").timeago();
	$('#publish').datetimepicker();
	$("#available_period").daterangepicker({
	    format: "YYYY/MM/DD"
	}, function(start, end) {
	    // return $("#daterange2").parent().find("input").first().val(start.format("MMMM D, YYYY") + " - " + end.format("MMMM D, YYYY"));
	});

	CKEDITOR.config.height = 450;
    // $('.ckeditor').ckeditor({toolbar_liteToolbar:simpleToolbar, toolbar: 'liteToolbar'});
    $('.ckeditor').ckeditor({toolbar_simpleToolbar:simpleToolbar, toolbar: 'simpleToolbar'});
    // $('.ckeditor').ckeditor({toolbar_fullToolbar:simpleToolbar, toolbar: 'fullToolbar'});
    // CKEDITOR.timestamp='ABCD'; for test refresh editor

    $("#option-control .dropdown-menu li a").click(function(){
        var id = $(this).attr('id');
        if (id == 'option-control-preview') {
            alert("in progress");
        } else if(id == 'option-control-publish'){
            var btn = $("#option-control .btn:first-child");
            if (btn.hasClass('published')) {
                btn.html('<i class="icon-globe"></i> Unpublish <span class="caret"></span>');
                btn.val('unpublish');
                btn.removeClass('published').addClass('unpublish');
                $('#statusx').val(0);
            } else {
                btn.html('<i class="icon-globe"></i> Published <span class="caret"></span>');
                btn.val('published');
                btn.removeClass('unpublish').addClass('published');
                $('#statusx').val(1);
            }
        } else if(id == 'option-control-delete'){
            if(confirm('Are you sure?')){
                alert("in progress");
            }
        }
    });
    $('.preview-link').click(function(){
        var l = $(this).data('link');
        $('#content-preview').attr('src', l);
        $('#full-preview-link').attr('href', l).html(l);
    });

  $('#thumbnail').fileupload({
    url: '{{ URL::to('admin/content-review/file-thumbnail') }}',
    limitMultiFileUploads:1,
    dataType: 'json',
    autoUpload: false,
    formData: {id: {{ $data['page']['id'] }} },
    add: function (e, data) {
      if (data.files && data.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('.file-preview-image').attr('src', e.target.result);
        }
        reader.readAsDataURL(data.files[0]);
      }
      $("#uploadbtn").empty(); // clear data first
      data.context = $('<div/>').addClass('progress').attr('id','progress').append($('<div/>').addClass('progress-bar progress-bar-success')).appendTo("#uploadbtn");
          data.context = $('<button/>').addClass('btn btn-primary start').append('<i class="glyphicon glyphicon-upload"></i> Upload')
              .appendTo("#uploadbtn")
              .click(function () {
                  // data.context = $('<p/>').text('Uploading...').replaceAll($(this));
                  data.submit();
                  return false;
              });
      },
    done: function (e, data) {
      $.each(data.result.files, function (index, file) {
      $(".file-preview-image").attr('src', file.thumbnailUrl);
      $("#uploadbtn").empty();
          // $('<p/>').text(file.name).appendTo('#thumbnail-file');
      });
    },
    progressall: function (e, data) {
      var progress = parseInt(data.loaded / data.total * 100, 10);
      $('#progress .progress-bar').css(
          'width',
          progress + '%'
      );
    }
  }).prop('disabled', !$.support.fileInput)
      .parent().addClass($.support.fileInput ? undefined : 'disabled');
});
</script>
@stop