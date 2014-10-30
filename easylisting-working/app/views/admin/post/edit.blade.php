@extends('admin._layouts.index')
@section('head')
<!-- datetime picker -->
{{ HTML::style('css/plugins/bootstrap_datetimepicker/bootstrap-datetimepicker.min.css'); }}
<!-- date range -->
{{ HTML::style('css/plugins/bootstrap_daterangepicker/daterangepicker-bs3.css'); }}
<style>
.section,
.tabbable li.active a:hover,
.tabbable li.active a {
  background-color: #eee;
  padding: 10px;
}
.list-group-item .name {
width: 50px
overflow:hidden;
display: block;
}
.list-group-item .progress {
height: 4px;
margin: 4px;
}
#map-canvas {
  height: 400px;
  width:100%;
  margin: 0px;
  padding: 0px
}
.controls {
  margin-top: 16px;
  border: 1px solid transparent;
  border-radius: 2px 0 0 2px;
  box-sizing: border-box;
  -moz-box-sizing: border-box;
  height: 32px;
  outline: none;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
}

#pac-input {
  background-color: #fff;
  padding: 0 11px 0 13px;
  width: 220px;
  font-family: Roboto;
  font-size: 15px;
  font-weight: 300;
  text-overflow: ellipsis;
}

#pac-input:focus {
  border-color: #4d90fe;
  margin-left: -1px;
  padding-left: 14px;  /* Regular padding-left + 1. */
  width: 401px;
}

.pac-container {
  font-family: Roboto;
}

#type-selector {
  color: #fff;
  background-color: #4d90fe;
  padding: 5px 11px 0px 11px;
}

#type-selector label {
  font-family: Roboto;
  font-size: 13px;
  font-weight: 300;
}
</style>

<!-- ekko-lightbox -->
{{ HTML::style('css/plugins/ekko-lightbox/ekko-lightbox.min.css'); }}

<!-- gallery file upload -->
{{ HTML::style('css/plugins/fileupload/blueimp-gallery.min.css'); }}
{{ HTML::style('css/plugins/fileupload/jquery.fileupload.css'); }}
{{ HTML::style('css/plugins/fileupload/jquery.fileupload-ui.css'); }}

<!-- CSS adjustments for browsers with JavaScript disabled -->
<noscript>{{ HTML::style('css/plugins/fileupload/jquery.fileupload-noscript.css'); }}</noscript>
<noscript>{{ HTML::style('css/plugins/fileupload/jquery.fileupload-ui-noscript.css'); }}</noscript>

<!-- tagsinput -->
{{ HTML::style('css/plugins/tagsinput/bootstrap-tagsinput.css'); }}

@stop
@section('content')

<form class="form-horizontal" role="form" method="post">
  <div class="panel panel-default">
      <div class="panel-body">
          <p>
              <strong>Create date </strong> <time class="timeago" datetime="{{ $data['post']->created_at }}">-</time><br/>
              <i>(by {{ $data['post']->post_by->email }})</i>
          </p>
          @if( isset($data['post']->modify_by->email) )
          <p>
              <strong>Last modify </strong> <time class="timeago" datetime="{{ $data['post']->updated_at }}">-</time><br/>
              <i>(by {{ $data['post']->modify_by->email }})</i>
          </p>
          @endif
          @if( isset($data['post_form']) && $data['post_form'] != '')
          <p>
          <strong>Post from</strong> {{$data['post_form']}}
          </p>
          @endif
      </div>
      <div class="panel-footer">
          {{ Form::submit('Save', array('class' => 'btn btn-primary btn-save btn-sm')) }}
          <a href="{{ URL::to('admin/post') }}">Back to all page</a>
          <div id="option-control" class="btn-group dropdown pull-right">
              <button name="status" class="btn btn-default btn-sm dropdown-toggle @if($data['post']->status==1) published @else unpublish  @endif" data-toggle="dropdown" style="margin-bottom:5px">
                  <i class="icon-globe"></i>
                  @if($data['post']->status==0) 
                    Unpublish
                    @elseif($data['post']->status==1)
                    Published 
                    @elseif($data['post']->status==2)
                    Lock
                    @elseif($data['post']->status==3)
                    Deleted
                    @else 
                    Waiting for approve
                    @endif
                  <span class="caret"></span>
              </button>
              <ul class="dropdown-menu">
                  <li><a id="option-control-publish">@if($data['post']->status==1) Unpublish @else Published  @endif</a></li>
                  <li class="divider"></li>
                  <li><a id="option-control-delete"><i class="icon-ban-circle"></i> Delete this post?</a></li>
              </ul>
              {{ Form::hidden('status', $data['post']->status, array('id'=>'statusx')) }}
          </div>
      </div>
  </div><!-- /.box -->

  {{ Notification::showAll() }}

  <div class="form-group">
    <label for="publish" class="col-sm-3 control-label">Publish date</label>
    <div class="col-sm-9">
      <div class="input-group">
          <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" name="publish" id="publish" value="{{ $data['post']->publish }} " class="form-control" minlength="2" required />
      </div>
    </div>
  </div>
  <div class="form-group">
    <label for="available_period" class="col-sm-3 control-label">Content available period</label>
    <div class="col-sm-9">
      <div class="input-group">
          <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" name="available_period" id="available_period" class="form-control" value=" @if($data['post']->available_from!='') {{ $data['post']->available_from }} - {{ $data['post']->available_to }} @endif" minlength="2" required/>
      </div>
    </div>
  </div>

  <hr>

  <div class='tabbable'>
    <ul class='nav nav-tabs'>
        @foreach($data['languages'] as $key=>$lang)
        <li class="pull-right @if($lang['id'] == 2) active @endif">
        <a data-toggle='tab' href='#tab{{ $lang['id'] }}'>
            <i class='flag flag-{{ $lang['short_code'] }}'></i>
            {{ $lang['title'] }}
        </a>
        </li>
        @endforeach
    </ul>
    <div class='tab-content section'>
        @foreach($data['languages'] as $key=>$lang)
        <div class='tab-pane @if($lang['id'] == 2) active @endif' id='tab{{ $lang['id'] }}'>

<!--           <div class="form-group">
            <label for="title_{{ $lang['short_code'] }}" class="col-sm-3 control-label">Title</label>
            <div class="col-sm-9">

              <input minlength="2" required class="form-control" id="title_{{ $lang['short_code'] }}" name="title_{{ $lang['short_code'] }}" placeholder="Title" type="text" value='{{{ $data['post']->lang[$lang['id']]['title'] or ''}}}'>

            </div>
          </div>
 -->
          <div class="form-group">
            <label for="description_{{ $lang['short_code'] }}" class="col-sm-3 control-label">Short Description</label>
            <div class="col-sm-9">

              <input minlength="2" class="form-control" id="description_{{ $lang['short_code'] }}" name="description_{{ $lang['short_code'] }}" placeholder="Short Description" type="text" value='{{{ $data['post']->lang[$lang['id']]['description'] or ''}}}'>

            </div>
          </div>

          <div class="form-group">
            <label for="detail_{{ $lang['short_code'] }}" class="col-sm-3 control-label">Full Description</label>
            <div class="col-sm-9">

              <textarea minlength="2" required class='form-control ckeditor' id='detail_{{ $lang['short_code'] }}' name='detail_{{ $lang['short_code'] }}' rows='10'>{{{ $data['post']->lang[$lang['id']]['detail'] or ''}}}</textarea>
              
            </div>
          </div>

        </div>
        @endforeach
    </div>
  </div>
  <hr>

  <div class="form-group">
    <label for="price" class="col-sm-3 control-label">Price</label>
    <div class="col-sm-9">
      <div class="input-group" style="width: 100%;">
          <span class="input-group-addon">$</span>
          <input class="form-control text-right" type="number" name="price" id="price" value="{{ $data['post']->price }}" minlength="2" required/>
          <span class="input-group-addon">.00</span>
      </div><!-- /.input group -->
    </div>
  </div>

  <div class="form-group">
    <label for="mileage" class="col-sm-3 control-label">Mileage</label>
    <div class="col-sm-9">
      <input minlength="2" class="form-control" id="mileage" name="mileage" placeholder="Mileage" type="text" value='{{ $data['post']->mileage or ''}}'>
    </div>
  </div>

  <div class="form-group">
    <label for="phone" class="col-sm-3 control-label">Phone</label>
    <div class="col-sm-9">
      <input minlength="2" class="form-control" id="phone" name="phone" placeholder="Phone" type="text" value='{{ $data['post']->phone or ''}}'>
    </div>
  </div>

  <div class="form-group">
    <label for="tags" class="col-sm-3 control-label">Tags</label>
    <div class="col-sm-9">
      <input type="text" id="tags" name="tags" value="{{ $data['post']->tags_line or '' }}" placeholder="Tags">
    </div>
  </div>

  <hr>

  <div class="form-group">
    <label for="tags" class="col-sm-3 control-label">Car information</label>
    <div class="col-sm-9">
      <select name="year" id="year" class="form-control">
        <option value="" >Select a year</option>
      </select><br/>
      <select name="make" id="make" class="form-control">
        <option value="" >Select a make</option>
      </select><br/>
      <select name="model" id="model" class="form-control">
        <option value="" >Select a model</option>                               
      </select><br/>
      <select name="submodel" id="submodel" class="form-control">
        <option value="" >Select a sub model</option>                               
      </select>
    </div>
  </div>
  <div class="form-group">
    <label for="gear" class="col-sm-3 control-label">&nbsp;</label>
    <div class="col-sm-9">
      <select name="gear" id="gear" class="form-control">
        <option value="" >Select a gear</option>                               
      </select><br/>
      <select name="fuel" id="fuel" class="form-control">
        <option value="" >Select a fuel</option>                               
      </select><br/>
      <select name="engine" id="engine" class="form-control">
        <option value="" >Select a engine</option>                               
      </select><br/>
      <select name="color" id="color" class="form-control">
        <option value="" >Select a color</option>                               
      </select>
    </div>
  </div>
  <div class="form-group">
    <label for="tags" class="col-sm-3 control-label">Car parts</label>
    <div class="col-sm-9">
      @foreach ($data['parts'] as $value)
      <div class="checkbox col-sm-6">
        <label>
          @if(is_array($data['post']->parts_ids) && in_array($value['lang'][0]['id'], $data['post']->parts_ids))
          <input type="checkbox" checked name="parts[]" id="" value="{{ $value['lang'][0]['id'] }}"> {{ $value['lang'][0]['title'] }}
          @else
          <input type="checkbox" name="parts[]" id="" value="{{ $value['lang'][0]['id'] }}"> {{ $value['lang'][0]['title'] }}
          @endif
        </label>
      </div>
      @endforeach
    </div>
  </div>

    <div class="form-group">
    <label for="phone" class="col-sm-3 control-label">Suggest car (din't have car in list)</label>
    <div class="col-sm-9">
      <input minlength="2" class="form-control" id="suggest" name="suggest" placeholder="Suggest" type="text" value='{{ $data['post']->suggest or ''}}'>
    </div>
  </div>

  
  <hr><!-- <div class="form-group">
    <label for="tags" class="col-sm-3 control-label">Place on map</label>
    <div class="col-sm-9">
      <button class="btn btn-success btn-save btn-xs geo-location">
        <span class="glyphicon glyphicon-screenshot"></span> Get My Position</button>
    </div>
  </div>
  <div class="form-group">
      <input id="pac-input" class="controls" type="text" placeholder="Enter a location">
      <div id="type-selector" class="controls">
        <input type="radio" name="type" id="changetype-all" checked="checked">
        <label for="changetype-all">All</label>

        <input type="radio" name="type" id="changetype-establishment">
        <label for="changetype-establishment">Establishments</label>

        <input type="radio" name="type" id="changetype-address">
        <label for="changetype-address">Addresses</label>

        <input type="radio" name="type" id="changetype-geocode">
        <label for="changetype-geocode">Geocodes</label>
      </div>
      <div id="map-canvas"></div>
  </div>
  <div class="form-group">
    <label for="tags" class="col-sm-3 control-label">Latitude, Longitude</label>
    <div class="col-sm-9">
      <input minlength="2" class="col-sm-6" id="lat" name="lat" placeholder="Enter Latitude" type="text" value='{{ $data['post']->latitude or '' }}'>
      <input minlength="2" class="col-sm-6" id="lng" name="lng" placeholder="Enter Longitude" type="text" value='{{ $data['post']->longitude or '' }}'>
    </div>
  </div> -->
<!--   <div class="form-group">
    <label for="tags" class="col-sm-3 control-label">Address</label>
    <div class="col-sm-9">
      <input minlength="2" class="form-control" id="address" name="address" placeholder="Address" type="text" value='{{ $data['post']->address or '' }}'>
    </div>
  </div> -->
  <div class="form-group">
    <label for="tags" class="col-sm-3 control-label">Address</label>
    <div class="col-sm-9">
      <select name="province" id="province" class="form-control">
          <option value="" >Select a province</option>
      </select><br/>
      <select name="amphur" id="amphur" class="form-control">
          <option value="" >Select a district</option>
      </select><br/>
      <select name="district" id="district" class="form-control">
          <option value="" >Select a sub district</option>
      </select><br/>
<!--       <select name="zipcode" id="zipcode" class="form-control">
          <option value="" >Select a zipcode</option>
      </select> -->
    </div>
  </div>

  <hr>

  <div class="form-group">
    <label for="tags" class="col-sm-3 control-label">Post by</label>
    <div class="col-sm-9">
      <!-- <img src="{{ asset('img/client-01.jpg') }}" width="80" alt="..." class=""> -->
      <a href="#link-to-profile">{{ $data['post']['post_by']->first_name }}  {{ $data['post']['post_by']->last_name }} ({{ $data['post']['post_by']->email }})</a>
    </div>
  </div>

<!--   <hr>

  <div class="form-group" style="clear:both">
    <div class="col-sm-offset-3 col-sm-10">
      <button type="submit" class="btn btn-primary">Save</button>
      <a href="{{ URL::to('/admin/post') }}">Back to all post</a>
    </div>
  </div> -->
</form>

<h4>Gallery</h4>

<div class="form-horizontal section">

  <div class="form-group">
    {{--<label for="thumbnail" class="col-sm-3 control-label">Gallery</label>--}}
    <div class="col-sm-12">

      <div class="panel panel-default">
        <!-- <div class="panel-heading">
            <h3 class="panel-title">Management</h3>
        </div> -->
        <div class="panel-body">

            <form class="gallery" id="gallery" action="{{ URL::to('admin/post/fileupload') }}"
              method="POST"
              enctype="multipart/form-data"
              data-upload-template-id="template-upload"
              data-download-template-id="template-download">
              <input type="hidden" name='id' id='id' value='{{ $data['post']->id }}'>

                <div class="row fileupload-buttonbar">
                    <div class="col-lg-4">
                        <span class="btn btn-success fileinput-button btn-xs">
                            <i class="glyphicon glyphicon-plus"></i>
                            <span>Add files...</span>
                            <input type="file" name="files[]" multiple>
                        </span>
                        {{--<button type="submit" class="btn btn-primary start btn-xs">--}}
                            {{--<i class="glyphicon glyphicon-upload"></i>--}}
                            {{--<span>Start upload</span>--}}
                        {{--</button>--}}
                        {{--<button type="reset" class="btn btn-warning cancel btn-xs">--}}
                            {{--<i class="glyphicon glyphicon-ban-circle"></i>--}}
                            {{--<span>Cancel upload</span>--}}
                        {{--</button>--}}
                        {{--<button type="button" class="btn btn-danger delete btn-xs">--}}
                            {{--<i class="glyphicon glyphicon-trash"></i>--}}
                            {{--<span>Delete</span>--}}
                        {{--</button>--}}
                        {{--<input type="checkbox" class="toggle">--}}
                        <span class="fileupload-process"></span>
                    </div>
                    <div class="col-lg-8 fileupload-progress fade">
                        <div class="progress progress-striped active" role="progressbar" aria-valuemin="0"
                             aria-valuemax="100">
                            <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                        </div>
                        <div class="progress-extended">&nbsp;</div>
                    </div>
                </div>
                <ul id="sortable" class="gallery-listing files row" style="overflow: auto">
                    @if($data['gallery']->count()>0)
                    @foreach($data['gallery'] as $gal)
                    <li class="template-download fade in row col-xs-4" id="gal_id_{{ $gal->id }}" style="cursor: move">
                      <span class="preview col-md-12">
                          <a href="{{ sprintf($data['gallery_thumbnail_url'], $gal->name) }}" 
                            title="{{ $gal->name }}" 
                            data-gallery="gallery" 
                            download="{{ $gal->name }}">
                              <img src="{{ sprintf($data['gallery_thumbnail_url'], $gal->name) }}" width="100%"/>
                          </a>
                      </span>
                      <span class="name col-md-12" style="overflow: hidden">
                          <a href="{{ sprintf($data['gallery_thumbnail_url'], $gal->name) }}" 
                            title="{{ $gal->name }}" 
                            data-gallery="gallery" 
                            download="{{ $gal->name }}">
                            {{ $gal->name }}
                          </a>
                      </span>
                      <span class='size col-md-12'>
                          {{ $gal->size }}
                      </span>
                      <span class="col-md-12">
                          <button class="btn btn-danger btn-xs delete" 
                                  data-type="get"
                                  data-url="{{ sprintf($data['gallery_delete_url'], $gal->id) }}">
                                  <i class="glyphicon glyphicon-trash"></i>
                                  {{--<span>Delete</span>--}}
                          </button>
                          {{--<input type="checkbox" name="delete" value="1" class="toggle">--}}
                      </span>
                    </li>
                    @endforeach
                    @endif
                </ul>

            </form>
        </div><!-- /.box-body -->
      </div><!-- /.box -->

    </di>
  </div>
</div>  


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

<!-- tagsinput -->
{{ HTML::script('js/plugins/typeahead.min.js') }}
{{ HTML::script('js/plugins/tagsinput/bootstrap-tagsinput.min.js') }}

<!-- ekko-lightbox -->
{{ HTML::script('js/plugins/ekko-lightbox/ekko-lightbox.min.js') }}

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

<!-- <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places"></script> -->

<script type="text/javascript">
$(function(){
  $(".timeago").timeago();

  var tags = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    prefetch: {
      url: '{{ URL::to('/tags/all') }}?{{Carbon::now()->timestamp}}',
      filter: function(list) {
        return $.map(list, function(tag) {
          return { name: tag }; });
      }
    }
  });
  tags.initialize();

  $('#tags').tagsinput({
    typeaheadjs: {
      name: 'tags',
      displayKey: 'name',
      valueKey: 'name',
      source: tags.ttAdapter()
    }
  });

  $('#publish').datetimepicker();
  $("#available_period").daterangepicker({
      format: "YYYY/MM/DD"
  }, function(start, end) {
      // return $("#daterange2").parent().find("input").first().val(start.format("MMMM D, YYYY") + " - " + end.format("MMMM D, YYYY"));
  });
  
  // $("#available_period").daterangepicker();

  // $('.ckeditor').ckeditor({toolbar_liteToolbar:simpleToolbar, toolbar: 'liteToolbar'});
  $('.ckeditor').ckeditor({toolbar_simpleToolbar:simpleToolbar, toolbar: 'simpleToolbar'});
  // $('.ckeditor').ckeditor({toolbar_fullToolbar:simpleToolbar, toolbar: 'fullToolbar'});
  // CKEDITOR.timestamp='ABCD'; for test refresh editor

  $('#thumbnail').fileupload({
    url: '{{ URL::to('admin/post/file-thumbnail') }}',
    limitMultiFileUploads:1,
    dataType: 'json',
    autoUpload: false,
    formData: {id: {{ $data['post']['id'] }} },
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

  $('#gallery').fileupload({
    filesContainer: $('ul.files'),
    uploadTemplateId: "template-upload",
    downloadTemplateId: "template-download"
  });

  // add sortable to gallery
  $( "#sortable" ).sortable({
    placeholder: "ui-state-highlight list-group-item active col-xs-4",
    stop: function( event, ui ) {

        var data = $(this).sortable("serialize");

        $.post( "{{ URL::to('admin/post/update-gallery-order') }}",data)
        .done(function( data ) {
        // var json = $.parseJSON(data);
            //$.jGrowl(json.status);
            // alert(data);
          },"json");
    }
  });

  // lightbox
  $(document).delegate('*[data-toggle="lightbox"]', 'click', function(event) {
      event.preventDefault();
      $(this).ekkoLightbox();
  }); 

  $('.link-to-toolkit').click(function(){
    obj = $(this);
    var dest = obj.data('dest');
    var src = obj.data('src');
    var dest_size = obj.data('dest-size');
    var url_params = '{{ URL::to('admin/cropper-editor') }}?src='+src+'&dest='+dest+'&dest_size='+dest_size;
    $('#content-preview').attr('src', url_params);
  });

  // Set url for cropper toolkit brefore open modal
  $('#model-toolkit').on('show.bs.modal', function (e) {
    
  })

  // Tags
  // var tags = new Bloodhound({
  //   datumTokenizer: Bloodhound.tokenizers.obj.whitespace('text'),
  //   queryTokenizer: Bloodhound.tokenizers.whitespace,
  //   prefetch: '{{ URL::to('/tags/all') }}'
  // });
  // tags.initialize();

  // elt = $('#tags');
  // elt.tagsinput({
  //   //confirmKeys: [13, 44],
  //   trimValue: true,
  //   maxChars: 8,
  //   maxTags: 10,
  //   tagClass: function(item) {
  //     return 'label label-info';
  //   },
  //   itemValue: 'value',
  //   itemText: 'text',
  //   typeaheadjs: {
  //     name: 'tags',
  //     displayKey: 'text',
  //     source: tags.ttAdapter()
  //   },
  //   typeahead: {
  //     source: ['Amsterdam', 'Washington', 'Sydney', 'Beijing', 'Cairo']
  //   },
  //   freeInput: false
  // });
  // // Set default value
  
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
  
  var year = '{{ $data['post']->year_id }}';
  var make = '{{ $data['post']->make_id }}';
  var model = '{{ $data['post']->model_id }}';
  var submodel = '{{ $data['post']->submodel_id }}';
  var fuel = '{{ $data['post']->fuel_id }}';
  var gear = '{{ $data['post']->gear_id }}';
  var engine = '{{ $data['post']->engine_id }}';
  var color = '{{ $data['post']->color_id }}';
  
  $.get( "/api/v1/car/color", function( data ) {
      $.each( data.colors, function( key, val ) {
       if(color==val.id) {
        $("#color").append($('<option selected></option>').val(val.id).html(val.color)); 
       }else {
        $("#color").append($('<option></option>').val(val.id).html(val.color)); 
       }
      });
    }, "json" ); 

  $.get( "/api/v1/car/fuel", function( data ) {
      $.each( data.fuels, function( key, val ) {
       if(fuel==val.id) {
        $("#fuel").append($('<option selected></option>').val(val.id).html(val.type)); 
       }else {
        $("#fuel").append($('<option></option>').val(val.id).html(val.type)); 
       }
      });
    }, "json" ); 

  $.get( "/api/v1/car/gear", function( data ) {
      $.each( data.gears, function( key, val ) {
       if(gear==val.id) {
        $("#gear").append($('<option selected></option>').val(val.id).html(val.gear)); 
       }else {
        $("#gear").append($('<option></option>').val(val.id).html(val.gear)); 
       }
      });
    }, "json" ); 

  $.get( "/api/v1/car/engine", function( data ) {
      $.each( data.engines, function( key, val ) {
       if(engine==val.id) {
        $("#engine").append($('<option selected></option>').val(val.id).html(val.size)); 
       }else {
        $("#engine").append($('<option></option>').val(val.id).html(val.size)); 
       }
      });
    }, "json" ); 

  $.get( "/api/v1/car/year", function( data ) {
	  $.each( data.years, function( key, val ) {
		 if(year==val.id) {
		 	$("#year").append($('<option selected></option>').val(val.id).html(val.year)); 
		 }else {
		 	$("#year").append($('<option></option>').val(val.id).html(val.year)); 
	 	 }
	  });
	  $("#year").change();
  }, "json" );

  $.get( "/api/v1/car/make",{ year:$(this).val() }, function( data ) {
      $.each( data.makes, function( key, val ) {
       if(make==val.id) {
        $("#make").append($('<option selected></option>').val(val.id).html(val.make)); 
       }else {
        $("#make").append($('<option></option>').val(val.id).html(val.make)); 
       }
      });
      $("#make").change();
    }, "json" ); 
  
  $("#make").change(function(){

 	  $("#model").empty();
 	  $("#model").append($('<option value=""></option>').html('Select a model'));
    $("#submodel").empty();
    $("#submodel").append($('<option value=""></option>').html('Select a sub model'));

    if ($(this).val()) {
      $.get( "/api/v1/car/model",{ make_id:$(this).val() }, function( data ) {
        $.each( data.models, function( key, val ) {
         if(model==val.id) {
          $("#model").append($('<option selected></option>').val(val.id).html(val.model));
         }else {
          $("#model").append($('<option></option>').val(val.id).html(val.model));
         }
        });
        $("#model").change();
      }, "json" );
    }


  });

   $("#model").change(function(){
    $("#submodel").empty();
    $("#submodel").append($('<option value=""></option>').html('Select a sub model'));
    if ($(this).val()) {
      $.get( "/api/v1/car/sub-model",{ model_id:$(this).val() }, function( data ) {
        $.each( data.submodels, function( key, val ) {
         if(submodel==val.id) {
          $("#submodel").append($('<option selected></option>').val(val.id).html(val.sub_model));
         }else {
          $("#submodel").append($('<option></option>').val(val.id).html(val.sub_model));
         }
        });
      }, "json" );
    }
   });

  
   var province_id = '{{ $data['post']->province_id }}';
   var amphur_id = '{{ $data['post']->amphur_id }}';
   var district_id = '{{ $data['post']->district_id }}';
   var zipcode_id = '{{ $data['post']->zipcode_id }}';
  
  
  $.get( "/api/v1/address/province/", function( data ) {
	  
	  $.each( data.provinces, function( key, val ) {

		 if(province_id==val.id) {
		 	$("#province").append($('<option selected></option>').val(val.id).html(val.province));
		 }else {
		 	$("#province").append($('<option></option>').val(val.id).html(val.province));
	 	 }
	  });
	  $("#province").change();
  }, "json" );

   $("#province").change(function(){

        if($(this).val() != "") {
           $("#amphur").empty().append($('<option value="" selected></option>').html("Select amphur"));

           $.get( "/api/v1/address/amphur/"+$(this).val(), function( data ) {

              $.each( data.amphurs, function( key, val ) {

                 if(amphur_id==val.id) {
                    $("#amphur").append($('<option selected></option>').val(val.id).html(val.amphur));
                 }else {
                    $("#amphur").append($('<option></option>').val(val.id).html(val.amphur));
                 }
              });

              $("#amphur").change();
           }, "json" );
        }

   });
   
   
   $("#amphur").change(function(){
	   if($(this).val() != '') {
           $("#district").empty().append($('<option value="" selected></option>').html("Select district"));
           $.get( "/api/v1/address/district/"+$(this).val(), function( data ) {

              $.each( data.districts, function( key, val ) {

                 if(district_id==val.id) {
                    $("#district").append($('<option selected></option>').val(val.id).html(val.district));
                 }else {
                    $("#district").append($('<option></option>').val(val.id).html(val.district));
                 }
              });

              $("#district").change();
           }, "json" );
	   }
   });
   
   $("#district").change(function(){
	   $("#zipcode").empty().append($('<option value="" selected></option>').html("Select zipcode"));
	   $.get( "/api/v1/address/zipcode/"+$(this).val(), function( data ) {
	  
	 	  $.each( data.zipcodes, function( key, val ) {

	 		 if(zipcode_id==val.id) {
	 		 	$("#zipcode").append($('<option selected></option>').val(val.id).html(val.zipcode));
	 		 }else {
	 		 	$("#zipcode").append($('<option></option>').val(val.id).html(val.zipcode));
	 	 	 }
	 	  });
		  
		  // $("#zipcode").change();
	   }, "json" );
   });
   
   // $("#zipcode").change(function(){
   // 	   $("#zipcode").empty().append($('<option selected></option>').html("Select zipcode"));
   // 	   $.get( "/api/v1/address/zipcode/"+$(this).val(), function( data ) {
   //
   // 	 	  $.each( data.zipcodes, function( key, val ) {
   //
   // 	 		 if(zipcode_id==val.id) {
   // 	 		 	$("#zipcode").append($('<option selected></option>').val(val.id).html(val.zipcode));
   // 	 		 }else {
   // 	 		 	$("#zipcode").append($('<option></option>').val(val.id).html(val.zipcode));
   // 	 	 	 }
   // 	 	  });
   //
   // 		  $("#zipcode").change();
   // 	   }, "json" );
   // });
  
  
  // var _latitude = 13.6840189;
  // var _longitude = 100.61550489999999;
  // var map;
  // var marker;
  // var infowindow;
  // var inputLat = $('#lat');
  // var inputLng = $('#lng');

  // if (inputLat.val() != '' && inputLat.val() != '0.0000000000000') {
  //   _latitude = inputLat.val();
  // }
  // if (inputLng.val() != '' && inputLng.val() != '0.0000000000000') {
  //   _longitude = inputLng.val();
  // }

  // function initialize(latitude,longitude) {
  //   var mapOptions = {
  //     center: new google.maps.LatLng(latitude, longitude),
  //     zoom: 15
  //   };
  //   map = new google.maps.Map(document.getElementById('map-canvas'),
  //     mapOptions);

  //   var input = /** @type {HTMLInputElement} */(
  //       document.getElementById('pac-input'));

  //   $('#pac-input').keypress(function(event){
  //     if (event.keyCode == 10 || event.keyCode == 13) 
  //         event.preventDefault();
  //   });

  //   var types = document.getElementById('type-selector');
  //   map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
  //   map.controls[google.maps.ControlPosition.TOP_LEFT].push(types);

  //   var autocomplete = new google.maps.places.Autocomplete(input);
  //   autocomplete.bindTo('bounds', map);

  //   infowindow = new google.maps.InfoWindow();
  //   marker = new google.maps.Marker({
  //     map: map,
  //     draggable: true,
  //     anchorPoint: new google.maps.Point(0, -29)
  //   });

  //   google.maps.event.addListener(autocomplete, 'place_changed', function() {
  //     infowindow.close();
  //     marker.setVisible(false);
  //     var place = autocomplete.getPlace();
  //     if (!place.geometry) {
  //       return;
  //     }
  //     // If the place has a geometry, then present it on a map.
  //     if (place.geometry.viewport) {
  //       map.fitBounds(place.geometry.viewport);
  //     } else {
  //       map.setCenter(place.geometry.location);
  //       map.setZoom(17);  // Why 17? Because it looks good.
  //     }
  //     marker.setIcon(/** @type {google.maps.Icon} */({
  //       url: place.icon,
  //       size: new google.maps.Size(71, 71),
  //       origin: new google.maps.Point(0, 0),
  //       anchor: new google.maps.Point(17, 34),
  //       scaledSize: new google.maps.Size(35, 35)
  //     }));
  //     marker.setPosition(place.geometry.location);
  //     marker.setVisible(true);

  //     var address = '';
  //     if (place.address_components) {
  //       address = [
  //         (place.address_components[0] && place.address_components[0].short_name || ''),
  //         (place.address_components[1] && place.address_components[1].short_name || ''),
  //         (place.address_components[2] && place.address_components[2].short_name || '')
  //       ].join(' ');
  //     }
  //     $('#address').val(place.name + ', ' + address);
  //     infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
  //     infowindow.open(map, marker);

  //     inputLat.val(marker.position.k);
  //     inputLng.val(marker.position.B);
  //   });

  //   // Sets a listener on a radio button to change the filter type on Places
  //   // Autocomplete.
  //   function setupClickListener(id, types) {
  //     var radioButton = document.getElementById(id);
  //     google.maps.event.addDomListener(radioButton, 'click', function() {
  //       autocomplete.setTypes(types);
  //     });
  //   }

  //   setupClickListener('changetype-all', []);
  //   setupClickListener('changetype-address', ['address']);
  //   setupClickListener('changetype-establishment', ['establishment']);
  //   setupClickListener('changetype-geocode', ['geocode']);

  //   var mapCenter = new google.maps.LatLng(latitude,longitude);
  //   marker.setPosition(mapCenter);
  //   map.setCenter(mapCenter);
  //   map.setZoom(13);

  //   infowindow.setContent('<div><strong>Your location</strong><br>');
  //   infowindow.open(map, marker);

  //   google.maps.event.addListener(marker, 'dragend', function(e) {
  //      // console.log(marker.position);
  //      inputLat.val(marker.position.k);
  //      inputLng.val(marker.position.B);
  //   });

  //   inputLat.val(marker.position.k);
  //   inputLng.val(marker.position.B);
  // }

  // google.maps.event.addDomListener(window, 'load', initialize(_latitude,_longitude));

  // function onGeoSuccess(position){
  //     inputLat.val(position.coords.latitude);
  //     inputLng.val(position.coords.longitude);
  //     var mapCenter = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
  //     marker.setPosition(mapCenter);
  //     map.setCenter(mapCenter);
  //     map.setZoom(17);
  // }

  // $('.geo-location').on("click", function(){
  //   if (navigator.geolocation) {
  //       navigator.geolocation.getCurrentPosition(onGeoSuccess);
  //   } else {
  //       error('Geo Location is not supported');
  //   }
  //   return false;
  // });

});
</script>
@stop