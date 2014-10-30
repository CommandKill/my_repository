@extends('site.desktop._layouts.index')

@section('head')

<!-- gallery file upload -->
{{ HTML::style('css/plugins/fileupload/blueimp-gallery.min.css') }}
{{ HTML::style('css/plugins/fileupload/jquery.fileupload.css') }}
{{ HTML::style('css/plugins/fileupload/jquery.fileupload-ui.css') }}

<!-- CSS adjustments for browsers with JavaScript disabled -->
<noscript>{{ HTML::style('css/plugins/fileupload/jquery.fileupload-noscript.css') }}</noscript>
<noscript>{{ HTML::style('css/plugins/fileupload/jquery.fileupload-ui-noscript.css') }}</noscript>

{{ HTML::style('css/dropdown.css') }}

@stop

@section('content')
<div class="container">
    <div class="row page">
        <div class="col-md-3 col-sm-3">
            @include('site.desktop._partials.member_nav')
        </div>
        <div class="col-md-9 col-sm-9">
            <header><h1>Profile</header>
            <div class="col-md-3 col-sm-4 row">
                <div>
                    @if($member->avatar && $member->avatar != '')
                    <img class="img-thumbnail img-circle file-preview-image" style="width:128px;margin-bottom:10px" src="{{ $destination_url }}{{ $member->id }}/150x150-{{ $member->avatar }}" title="" alt="{{ $member->avatar }}" />
                    @else
                    <img class="img-circle img-thumbnail" src="{{ asset('img/agent-01.jpg') }}" title="placeholder" alt="placeholder"/>
                    @endif
                </div>
                <div class="fileupload-buttonbar" style="margin-top:15px;">
                    <div class="col-lg-10">
                      <span class="btn btn-default fileinput-button btn-xs">
                          <i class="glyphicon glyphicon-plus"></i>
                          <span>Select file...</span>
                          <input id="thumbnail" type="file" name="thumbnail">
                      </span><br><br>
                      <div id="thumbnail-file" class="files"></div>
                      <span id="uploadbtn"></span>
                    </div>
                </div>
            </div>
            <form role="form" id="frmProfile" method="POST" action="{{ URL::to(App::getLocale().'/profile') }}">
            <input type="hidden" name="id" id="id" value="{{ $member->id }}"> 
            <div class="col-md-9 col-sm-8">

              {{ Notification::showAll() }}

                <dt><label for="first_name">First name</label></dt>
                <dd><div class="form-group">
                {{ $errors->first('name') }}
                 <input type="text" class="form-control" id="first_name" name="first_name" required value="{{ $member->first_name }}">
                </div></dd>

                <dt><label for="last_name">Last name</label></dt>
                <dd><div class="form-group">
                     {{ $errors->first('name') }}
                     <input type="text" class="form-control" id="last_name" name="last_name" required value="{{ $member->last_name }}">
                 </div></dd>

                <dt><label for="first_name">Screen name</label></dt>
                <dd><div class="form-group">
                {{ $errors->first('username') }}
                 <input type="text" class="form-control" id="username" name="username" required value="{{ $member->username }}">
                </div></dd>

                <dt><label for="email">Email</label></dt>
                <dd><div class="form-group">
                 {{ $errors->first('email') }}
                 <input type="text" class="form-control" id="email" name="email" value="{{ $member->email }}" required>
                </div></dd>

                <!-- <dt></dt>
                <dd>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" @if($member->public_email=='1')checked @endif name="public_email" id="public_email" value="1">  Make your email public?
                  </label>
                </div>
                </dd> -->
                <!-- <dt><label for="email_secondary">Second Email:</label> <small>*use for recovery email</small></dt>
                <dd><div class="form-group">
                 {{ $errors->first('email_secondary') }}
                 <input type="text" class="form-control" id="email_secondary" name="email_secondary" value="{{ $member->email_secondary }}" >
                </div></dd> -->

                <dt><label for="form-account-email">Phone</label></dt>
                <dd><div class="form-group">
                 {{ $errors->first('phone') }}
                 <input type="text" class="form-control" id="phone" name="phone" value="{{ $member->phone }}" required>
                </div></dd>
				
                <dt><label for="form-account-email">Line ID</label></dt>
                <dd><div class="form-group">
                 {{ $errors->first('line_id') }}
                 <input type="text" class="form-control" id="line_id" name="line_id" value="{{ $member->line_id }}" />
                </div></dd>

                <!-- <dt><label for="form-account-email">About Me</label></dt>
                <dd>
                    <div class="form-group">
                         <textarea class="form-control" id="about_me" rows="5" name="about_me">{{ $member->about_me }}</textarea>
                    </div>
                </dd> -->
                <!-- <dt><label for="form-account-email">My Social Network</label></dt>
                <dd>
                    <div class="form-group">
                         <div class="input-group">
                             <span class="input-group-addon"><i class="fa fa-twitter"></i></span>
                             <input type="text" class="form-control" id="twitter_account" name="twitter_account" value="{{ $member->twitter_account }}">
                         </div>
                     </div>
                     <div class="form-group">
                         <div class="input-group">
                             <span class="input-group-addon"><i class="fa fa-facebook"></i></span>
                             <input type="text" class="form-control" id="facebook_account" name="facebook_account" value="{{ $member->facebook_account }}">
                         </div>
                     </div>
                </dd> -->
                <dt></dt>
                <dd>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" id="receive_newsletter" name="receive_newsletter" @if($member->receive_newsletter=='1')checked @endif value="1">  Subscribe to our newsletter
                  </label>
                </div>
                </dd>
                <div class="form-group clearfix">
                   <button type="submit" class="btn submit-btn" id="account-submit">Update</button>
               </div>

            </div>
            </form>

            <div class="col-md-12 col-sm-12">
              <header><h2>Link with facebook</h2></header>
              <div class="form-group">
                  @if($member->facebook_id!='')
                  <a href="{{ $member->facebook_link }}" target="_blank">
                      <img src="https://graph.facebook.com/{{ $member->facebook_id }}/picture"></a>
                      <a href="{{ URL::to(App::getLocale().'/unlink-facebook') }}" class="btn btn-warning">Unlink</a>
                  @else 
                  <a href="{{ URL::to('/link-with-facebook') }}" class=""><img src="{{ asset('img/facebook-login-button.png') }}" height="50"/></a>
                  @endif
              </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('footer')
<!-- gallery file upload -->
{{ HTML::script('js/plugins/fileupload/vendor/jquery.ui.widget.js') }}
{{ HTML::script('js/plugins/fileupload/jquery.iframe-transport.js') }}
{{ HTML::script('js/plugins/fileupload/jquery.fileupload.js') }}

<script type='text/javascript'>
$(function(){
    // Change this to the location of your server-side upload handler:
    var url = "{{ URL::to(App::getLocale().'/file-thumbnail?id='.$member->id) }}";
    $('#thumbnail').fileupload({
        url: url,
        limitMultiFileUploads:1,
        dataType: 'json',
        autoUpload: false,
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
