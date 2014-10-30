@extends('admin._layouts.index')
@section('head')
<!-- gallery file upload -->
<link rel="stylesheet" href="{{ asset('css/plugins/fileupload/blueimp-gallery.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/plugins/fileupload/jquery.fileupload.css') }}">
<link rel="stylesheet" href="{{ asset('css/plugins/fileupload/jquery.fileupload-ui.css') }}">
<!-- CSS adjustments for browsers with JavaScript disabled -->
<noscript><link rel="stylesheet" href="{{ asset('css/plugins/fileupload/jquery.fileupload-noscript.css') }}"></noscript>
<noscript><link rel="stylesheet" href="{{ asset('css/plugins/fileupload/jquery.fileupload-ui-noscript.css') }}"></noscript>

<style>

</style>
@stop
@section('content')
{{ Form::open(array(
    'url' => 'admin/member/update',
    'method' => 'post',
    'role' => 'form',
    'id'  => 'frmUpdate'
    )) }}
<!--     <ol class="breadcrumb">
        <li><a href="{{ URL::to('admin/member') }}">All member</a></li>
        <li class="active">update member</li>
    </ol> -->
  <div class="row">

          <div class="col-xs-4">
              <div class="panel panel-default">
                  <div class="panel-body">
                      <p>
                          <strong>Create date </strong> <time class="timeago" datetime="{{ $member->created_at or 'none' }}">-</time><br/>
                      </p>
                      @if( $member->updated_at != '')
                      <p>
                          <strong>Last modify </strong> <time class="timeago" datetime="{{ $member->updated_at or 'none' }}">-</time><br/>
                      </p>
                      @endif

                  </div><!-- /.box-body -->
                  <div class="panel-footer">
                      <button type="submit" class="btn btn-primary btn-save btn-sm" id="btn-submit">Save</button>
                      <!-- <a href="{{ URL::to('admin/member') }}" class="btn btn-default btn-sm">Cancel</a> -->
                
                        <div id="option-control" class="btn-group dropdown pull-right">
                            <button class="btn btn-default btn-sm dropdown-toggle @if($member->status==1) published @else unpublish  @endif" data-toggle="dropdown" style="margin-bottom:5px">
                                <i class="icon-globe"></i> @if($member->status==1) Published @else Unpublish  @endif
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <!-- <li><a id="option-control-preview"><i class="icon-ban-circle"></i> Preview</a></li> -->
                                <!-- <li class="divider"></li> -->
                                <li><a id="option-control-publish">@if($member->status==1) Unpublish @else Published  @endif</a></li>
                                <li class="divider"></li>
                                <li><a id="option-control-delete"><i class="icon-ban-circle"></i> Delete this member?</a></li>
                            </ul>
                            {{ Form::hidden('status', $member->status, array('id'=>'status')) }}
                        </div>

                  </div>  <!-- /panel footer -->
              </div><!-- /.box -->

          <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Avatar</h3>
                </div><!-- /.box-header -->
              <div class="box-body table-responsive">

                <div class="row">
                    <div class="col-sm-12">
                        <div class="file-preview-frame">
                          @if($member->avatar)
                          <img class="file-preview-image" src="{{ $destination_url }}{{ $member->id }}/{{ $avatar_image_size }}_{{ $member->avatar }}" title="" alt="{{ $member->avatar }}"/>
                          @else
                          <img class="file-preview-image" src="{{ asset('img/agent-01.jpg') }}" title="placeholder" alt="placeholder"/>
                          @endif
                      </div>
                      <div class="fileupload-buttonbar">
                          <div class="col-lg-10">
                            <span class="btn btn-primary fileinput-button btn-sm">
                                <i class="glyphicon glyphicon-plus"></i>
                                <span>Select files...</span>
                                <!-- The file input field used as target for the file upload widget -->
                                <input id="thumbnail" type="file" name="thumbnail">
                            </span>
                              <br>
                              <br>

                              <div id="thumbnail-file" class="files"></div>
                              <span id="uploadbtn"></span>

                          </div>
                      </div>
                    </div>
                </div>
                  
              </div><!-- /.box-body -->
          </div><!-- /.box -->


          </div><!-- /.col-xs-4 -->
        <div class="col-xs-8">
  


                <input type="hidden" name="id" id="id" value="{{ $member->id }}">

               <div class="box">
                <div class="box-body table-responsive">


                  <div class="row">

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Email</label>
                            <div class="input-group" style="width: 100%;">
                                <input minlength="2" required class="form-control" id="email" name="email" placeholder="Email" type="text" value='{{ $member->email or '' }}'>
                            </div><!-- /.input group -->
                        </div><!-- /.form group -->
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>First name</label>
                            <div class="input-group" style="width: 100%;">
                                <input minlength="2" required class="form-control" id="first_name" name="first_name" placeholder="First name" type="text" value='{{ $member->first_name or '' }}'>
                            </div><!-- /.input group -->
                        </div><!-- /.form group -->
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Last name</label>
                            <div class="input-group" style="width: 100%;">
                                <input minlength="2" required class="form-control" id="last_name" name="last_name" placeholder="Last name" type="text" value='{{ $member->last_name or '' }}'>
                            </div><!-- /.input group -->
                        </div><!-- /.form group -->
                    </div>

                  </div>

                </div><!-- /.box-body -->
            </div><!-- /.panel -->


                

        </div><!-- /.col-md-8 -->
  </div><!-- /.row -->
{{ Form::close()}} 
@stop
@section('footer')
<!-- update long time to easy to read -->
<script src="{{ asset('js/plugins/jquery.timeago.js') }}"></script>

<!-- gallery file upload -->
<script src="{{ asset('js/plugins/fileupload/vendor/jquery.ui.widget.js') }}"></script>
<script src="{{ asset('js/plugins/fileupload/tmpl.min.js') }}"></script>
<script src="{{ asset('js/plugins/fileupload/load-image.min.js') }}"></script>
<script src="{{ asset('js/plugins/fileupload/canvas-to-blob.min.js') }}"></script>
<script src="{{ asset('js/plugins/fileupload/jquery.blueimp-gallery.min.js') }}"></script>
<script src="{{ asset('js/plugins/fileupload/jquery.iframe-transport.js') }}"></script>
<script src="{{ asset('js/plugins/fileupload/jquery.fileupload.js') }}"></script>
<script src="{{ asset('js/plugins/fileupload/jquery.fileupload-process.js') }}"></script>
<script src="{{ asset('js/plugins/fileupload/jquery.fileupload-image.js') }}"></script>
<script src="{{ asset('js/plugins/fileupload/jquery.fileupload-audio.js') }}"></script>
<script src="{{ asset('js/plugins/fileupload/jquery.fileupload-video.js') }}"></script>
<script src="{{ asset('js/plugins/fileupload/jquery.fileupload-validate.js') }}"></script>
<script src="{{ asset('js/plugins/fileupload/jquery.fileupload-ui.js') }}"></script>

<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}

    <li class="list-group-item template-upload fade">
        <span class="preview">
        </span>
        <span class="name">
            {%=file.name%}
            <strong class="error text-danger"></strong>
        </span>
        <span>
            <p class="size">Processing...</p>
            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
        </span>
        <span>
            {% if (!i && !o.options.autoUpload) { %}
                <button class="btn btn-primary start" disabled>
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>Start</span>
                </button>
            {% } %}
            {% if (!i) { %}
                <button class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel</span>
                </button>
            {% } %}
        </span>
    </li>
{% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <li class="template-download fade row" id="gal_id_{%=file.id%}">
        <span class="preview col-md-2">
            {% if (file.thumbnailUrl) { %}
                <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
            {% } %}
        </span>
        <span class="name col-md-5" style="overflow: auto">

            {% if (file.url) { %}
                <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
            {% } else { %}
                <span>{%=file.name%}</span>
            {% } %}

            {% if (file.error) { %}
                <div><span class="label label-danger">Error</span> {%=file.error%}</div>
            {% } %}
        </span>
        <span class="size col-md-2">{%=o.formatFileSize(file.size)%}</span>
        <span class="col-md-3">
            {% if (file.deleteUrl) { %}
                <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                    <i class="glyphicon glyphicon-trash"></i>
                    <span>Delete</span>
                </button>
                <input type="checkbox" name="delete" value="1" class="toggle">
            {% } else { %}
                <button class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel</span>
                </button>
            {% } %}
        </span>
    </li>
{% } %}
</script>


<script id="template-upload-1" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
  <tr class="template-upload fade">
      <td>
          <span class="preview"></span><br />
          <p class="size">Processing...</p>
          <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
      </td>
      <td>
          {% if (!i && !o.options.autoUpload) { %}
              <button class="btn btn-primary start" disabled>
                  <i class="glyphicon glyphicon-upload"></i>
                  <span>Start</span>
              </button>
          {% } %}
          {% if (!i) { %}
              <button class="btn btn-warning cancel">
                  <i class="glyphicon glyphicon-ban-circle"></i>
                  <span>Cancel</span>
              </button>
          {% } %}
      </td>
  </tr>

{% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download-1" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
  <tr class="template-download fade">
      <td>
          <div class="file-preview-frame">
              {% if (file.thumbnailUrl) { %}
            <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img class="file-preview-image" src="{%=file.thumbnailUrl%}"></a>
            {% } %}
          </div>
      </td>
      <td>
          <span class="size">{%=o.formatFileSize(file.size)%}</span>
      </td>
  </tr>
{% } %}
</script>

<!-- selection, tags -->


<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
<!--[if (gte IE 8)&(lt IE 10)]>
<script src="{{ asset('js/plugins/fileupload/jquery.xdr-transport.js') }}"></script>
<![endif]-->

<script type="text/javascript">
$(function(){

  $(".timeago").timeago();

  $('#btn-submit').click(function(){
    $("#frmUpdate").submit();
    return false;
  });
    
  // add validation to form
  $("#frmUpdate").validate({
        submitHandler: function(form) { 
            $.jGrowl("Saving...");
            $.post( "{{ URL::to('admin/member/update') }}", $(form).serialize())
            .done(function( data ) {
                var json = $.parseJSON(data);
                $.jGrowl(json.status, {theme:  'manilla'});

              },"json");
        }
    });

    var url = "{{ URL::to('admin/member/file-thumbnail') }}";
    $('#thumbnail').fileupload({
        url: url,
        limitMultiFileUploads:1,
        dataType: 'json',
        autoUpload: false,
        formData: {id: {{ $member->id }} , imagesize: $("#imagesize").val()},
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
                    data.context = $('<button id="btn-upload" />').addClass('btn btn-primary start').append('<i class="glyphicon glyphicon-upload"></i> Upload')
                        .appendTo("#uploadbtn")
                        .click(function () {
                            // data.context = $('<p/>').text('Uploading...').replaceAll($(this));
                            data.submit();
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


    $("#option-control .dropdown-menu li a").click(function(){
        var id = $(this).attr('id');
        var $status = $('#status');
        if (id == 'option-control-preview') {
            alert("in progress");
        } else if(id == 'option-control-publish'){
            var btn = $("#option-control .btn:first-child");
            if (btn.hasClass('published')) {
                btn.html('<i class="icon-globe"></i> Unpublish <span class="caret"></span>');
                btn.val('unpublish');
                btn.removeClass('published').addClass('unpublish');
                $status.val(0);
                $(this).text('Published');
            } else {
                btn.html('<i class="icon-globe"></i> Published <span class="caret"></span>');
                btn.val('published');
                btn.removeClass('unpublish').addClass('published');
                $status.val(1);
                $(this).text('Unpublish');
            }
        } else if(id == 'option-control-delete'){
            if(confirm('Are you sure?')){
                alert("in progress");
            }
        }
    });

});
</script>
@stop