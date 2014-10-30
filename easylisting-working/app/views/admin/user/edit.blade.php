@extends('admin._layouts.index')
@section('head')
<style>

</style>
<!-- gallery file upload -->
<link rel="stylesheet" href="{{ asset('css/plugins/fileupload/blueimp-gallery.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/plugins/fileupload/jquery.fileupload.css') }}">
<link rel="stylesheet" href="{{ asset('css/plugins/fileupload/jquery.fileupload-ui.css') }}">
<!-- CSS adjustments for browsers with JavaScript disabled -->
<noscript><link rel="stylesheet" href="{{ asset('css/plugins/fileupload/jquery.fileupload-noscript.css') }}"></noscript>
<noscript><link rel="stylesheet" href="{{ asset('css/plugins/fileupload/jquery.fileupload-ui-noscript.css') }}"></noscript>
@stop
@section('content')
    <div class="row">
        <div class="col-xs-4">
            <div class="panel panel-default">
              <div class="panel-body">
                    <p>
                    <strong>Create date </strong> <time class="timeago" datetime="{{ $user->created_at or 'none' }}">-</time>
                     @if( $user->updated_at )
                    <p>
                    <strong>Last modify </strong> <time class="timeago" datetime="{{ $user->updated_at or 'none' }}">-</time>
                    </p>
                    @endif
              </div><!-- /.box-body -->
          </div><!-- /.box -->

          <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Avatar</h3>
                </div><!-- /.box-header -->
              <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="file-preview-frame">
                          @if($user->avatar)
                          <img class="file-preview-image" src="{{ $avatar_url }}{{ $user->avatar }}" title="" alt="{{ $user->avatar }}"/>
                          @else
                          <img class="file-preview-image" src="{{ asset('img/agent-01.jpg') }}" title="placeholder" alt="placeholder"/>
                          @endif
                      </div>
                      <div class="fileupload-buttonbar">
                          <div class="col-lg-10">
                            <span class="btn btn-success fileinput-button btn-sm">
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
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">User information of <b>
                        @if ($user->email == Sentry::getUser()->email)
                        Your
                        @else
                        {{ $user->email }}'s
                        @endif</b>
                    </h3>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                    {{ Form::open(array(
                    'action' => array('UserController@update', $user->id),
                    'method' => 'put',
                    'class' => 'form-horizontal',
                    'role' => 'form'
                    )) }}

                    <div class="form-group {{ ($errors->has('firstName')) ? 'has-error' : '' }}" for="firstName">
                        {{ Form::label('edit_firstName', 'First Name', array('class' => 'col-sm-4 control-label')) }}
                        <div class="col-sm-8">
                            {{ Form::text('firstName', $user->first_name, array('class' => 'form-control', 'placeholder' => 'First Name', 'id' => 'edit_firstName'))}}
                        </div>
                        {{ ($errors->has('firstName') ? $errors->first('firstName') : '') }}
                    </div>

                    <div class="form-group {{ ($errors->has('lastName')) ? 'has-error' : '' }}" for="lastName">
                        {{ Form::label('edit_lastName', 'Last Name', array('class' => 'col-sm-4 control-label')) }}
                        <div class="col-sm-8">
                            {{ Form::text('lastName', $user->last_name, array('class' => 'form-control', 'placeholder' => 'Last Name', 'id' => 'edit_lastName'))}}
                        </div>
                        {{ ($errors->has('lastName') ? $errors->first('lastName') : '') }}
                    </div>

                    <div class="form-group">
                        {{ Form::label('edit_memberships', 'Group Memberships', array('class' => 'col-sm-4 control-label'))}}
                        <div class="col-sm-8">
                            <label class="checkbox-inline">
                                <input type="radio" name="activated" value='1'
                                {{ ($user->activated == 1) ? 'checked="checked"' : '' }} > Activate
                            </label>
                            <label class="checkbox-inline">
                                <input type="radio" name="activated" value='0'
                                {{ ($user->activated == 0) ? 'checked="checked"' : '' }} > Inativate
                            </label>
                        </div>
                    </div>

                    {{-- @if (Sentry::getUser()->hasAccess('user')) --}}
                    <div class="form-group">
                        {{ Form::label('edit_memberships', 'Group Memberships', array('class' => 'col-sm-4 control-label'))}}
                        <div class="col-sm-8">
                            @foreach ($allGroups as $group)
                            <label class="checkbox-inline">
                                <input type="checkbox" name="groups[{{ $group->id }}]" value='1'
                                {{ (in_array($group->name, $userGroups) ? 'checked="checked"' : '') }} > {{ $group->name }}
                            </label>
                            
                            <button type="button" class="btn btn-sm btn-default permission-detail" data-toggle="popover" title="Permission for {{ $group->name }}" 
                            data-content="@foreach($group->permissions as $k => $v) {{ $k }} <br/> @endforeach">
                            <span class="glyphicon glyphicon-exclamation-sign"></span> </button>
  
                            @endforeach
                        </div>
                    </div>
                    {{-- @endif --}}

                    <div class="form-group">
                        <label class="col-sm-4 control-label">Permission <i>(*this will override permission in group)</i></label>
                        <div class="col-sm-8">
                            <table class="table">
                                @foreach($permissions as $key=>$value)
                                <tr>
                                    <td><label for="permission[{{$key}}]" style="width: 100%;">{{ $key }}</label></td>
                                    <td>{{ Form::checkbox('permission['.$key.']', $value, $value, array('id'=>'permission['.$key.']')) }}</td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                        
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-8">
                            {{ Form::hidden('id', $user->id) }}
                            {{ Form::submit('Submit Changes', array('class' => 'btn btn-success btn-sm'))}}
                        </div>
                    </div>
                    {{ Form::close()}}
                </div><!-- /.box-body -->
            </div><!-- /.box -->
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Change Password</h3>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                    {{ Form::open(array(
                    'action' => array('UserController@update', $user->id),
                    'class' => 'form-horizontal',
                    'role' => 'form'
                    )) }}


                    <div class="form-group {{ $errors->has('oldPassword') ? 'has-error' : '' }}">
                        {{ Form::label('oldPassword', 'Old Password', array('class' => 'col-sm-4 control-label')) }} <!-- sr-only -->
                        <div class="col-sm-8">
                            <label class="checkbox-inline">
                                {{ Form::password('oldPassword', array('class' => 'form-control', 'placeholder' => 'Old Password')) }}
                            </label>
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('newPassword') ? 'has-error' : '' }}">
                        {{ Form::label('newPassword', 'New Password', array('class' => 'col-sm-4 control-label')) }}
                        <div class="col-sm-8">
                            <label class="checkbox-inline">
                                {{ Form::password('oldPassword', array('class' => 'form-control', 'placeholder' => 'New Password')) }}
                            </label>
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('newPassword_confirmation') ? 'has-error' : '' }}">
                        {{ Form::label('newPassword_confirmation', 'Confirm New Password', array('class' => 'col-sm-4 control-label')) }}
                        <div class="col-sm-8">
                            <label class="checkbox-inline">
                                {{ Form::password('newPassword_confirmation', array('class' => 'form-control', 'placeholder' => 'Confirm New Password')) }}
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-8">
                            {{ Form::submit('Change Password', array('class' => 'btn btn-success btn-sm'))}}
                        </div>
                    </div>

                    {{ ($errors->has('oldPassword') ? '<br />' . $errors->first('oldPassword') : '') }}
                    {{ ($errors->has('newPassword') ?  '<br />' . $errors->first('newPassword') : '') }}
                    {{ ($errors->has('newPassword_confirmation') ? '<br />' . $errors->first('newPassword_confirmation') : '') }}

                    {{ Form::close() }}
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col-xs-8 -->


    </div>
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
<script type="text/javascript">
$(function(){
        
    $(".timeago").timeago();

    $('.permission-detail').popover({
      trigger: 'focus',
      html: true
    })

    var url = "{{ URL::to('admin/users/file-thumbnail') }}";
    $('#thumbnail').fileupload({
        url: url,
        limitMultiFileUploads:1,
        dataType: 'json',
        autoUpload: false,
        formData: {id: {{ $user->id }} , imagesize: $("#imagesize").val()},
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
});
</script>
@stop