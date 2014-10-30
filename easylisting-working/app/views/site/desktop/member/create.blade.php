@extends('site._layouts.easycar')

@section('head')
<!-- datetime picker -->
<link rel="stylesheet" href="{{ asset('css/plugins/bootstrap_datetimepicker/bootstrap-datetimepicker.min.css') }}" >

<!-- date range -->
<link rel="stylesheet" href="{{ asset('css/plugins/bootstrap_daterangepicker/daterangepicker-bs3.css') }}" >

{{ HTML::style('css/plugins/fileinput/fileinput.min.css') }}
{{ HTML::style('css/plugins/select2/select2.css') }}
{{ HTML::style('css/_site/list.css') }}
<!-- gallery file upload -->
{{ HTML::style('css/plugins/fileupload/blueimp-gallery.min.css') }}
{{ HTML::style('css/plugins/fileupload/jquery.fileupload.css') }}
{{ HTML::style('css/plugins/fileupload/jquery.fileupload-ui.css') }}
<!-- CSS adjustments for browsers with JavaScript disabled -->
<noscript>{{ HTML::style('css/plugins/fileupload/jquery.fileupload-noscript.css') }}</noscript>
<noscript>{{ HTML::style('css/plugins/fileupload/jquery.fileupload-ui-noscript.css') }}</noscript>

{{ HTML::style('css/plugins/jgrowl/jquery.jgrowl.min.css') }}

{{ HTML::style('css/_site/create_member.css') }}

@stop

@section('content')
        <!-- Breadcrumb -->
        <div class="container">
            <ol class="breadcrumb">
                <li><a href="{{ URL::to(App::getLocale().'/') }}">Home</a></li>
				<li><a href="{{ URL::to(App::getLocale().'/my-garage') }}">My Garage</a></li>
                <li class="active">Create New</li>
            </ol>
        </div>
        <!-- end Breadcrumb -->
        <div class="container">
            <div class="row">
                <div class="block">
                        <div class="col-md-9 col-sm-9">
                            <section id="submit-form">
								<form role="form" id="frmSubmit" class="form-submit" action="{{ URL::to(App::getLocale().'/my-garage/update') }}">
								    <input type="hidden" name="id" id="id" value="{{ $id }}">

                                    <div class="row">
                                        <div class="col-md-8">
                                            <section id="basic-information">
                                                <header><h2>Add Detail</h2></header>
                                                <div class="form-group">
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
                                                        <br class="block clearfix">
                                                        <div class='tab-content'>
                                                            @foreach($languages as $lang)
                                                            <div class='tab-pane @if($lang->id == 1) active @endif' id='tab{{ $lang->id }}'>
                                                                <div class="form-group">
                                                                    <label>Title ({{ $lang->short_code }})</label>
                                                                    <div class="">
                                                                        <input minlength="2" required class="form-control" id="title_{{ $lang->short_code }}" name="title_{{ $lang->short_code }}" placeholder="Title" type="text" value='{{{ $lang->xcdata->title or ''}}}'>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Short Description ({{ $lang->short_code }})</label>
                                                                    <div class="">
                                                                        <input minlength="2" required class="form-control" id="description_{{ $lang->short_code }}" name="description_{{ $lang->short_code }}" placeholder="Short Description" type="text" value='{{{ $lang->xcdata->description or ''}}}'>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Full Description ({{ $lang->short_code }})</label>
                                                                    <div class="">
                                                                        <textarea minlength="2" required class='form-control ckeditor' id='detail_{{ $lang->short_code }}' name='detail_{{ $lang->short_code }}' rows='10'>{{{ $lang->xcdata->detail or 'Full Content'}}}</textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div><!-- /.form-group -->

                                            </section><!-- /#basic-information -->
                                        </div>
                                        <div class="col-md-4">
                                            <section id="filethumbnail">
                                                <header><h2>Thumbnails</h2></header>
                                                <div class="row">
                                                    <div class="form-group">
                                                        <div class="file-preview-frame">
                                                            @if($content->thumbnail != 'null')
                                                            <img class="file-preview-image" src="{{ asset('uploaded/car/'.$id.'/150x150_'.$content->thumbnail) }}" title="{{ $content->thumbnail }}" alt="{{ $content->thumbnail }}">
                                                            @else
                                                            <img class="file-preview-image" src="http://placehold.it/300x300" title="placeholder" alt="placeholder">
                                                            @endif
                                                        </div>

                                                        <div class="fileupload-buttonbar">
                                                            <div class="col-lg-10">
                                                                <span class="btn btn-success fileinput-button">
                                                                    <i class="glyphicon glyphicon-plus"></i>
                                                                    <span>Select files...</span>
                                                                    <!-- The file input field used as target for the file upload widget -->
                                                                    <input id="thumbnail" type="file" name="thumbnail">
                                                                </span>
                                                                <br>
                                                                <br>
                                                                <!-- The global progress bar -->
                                                                <!-- <div id="progress" class="progress">
                                                                    <div class="progress-bar progress-bar-success"></div>
                                                                </div> -->
                                                                <!-- The container for the uploaded files -->
                                                                <div id="thumbnail-file" class="files"></div>
                                                                <span id="uploadbtn"></span>
                                                                <!-- <span class="btn btn-primary fileinput-button">
                                                                    <i class="glyphicon glyphicon-upload"></i>
                                                                    <span>Add files...</span>
                                                                    <input type="file" name="files" id="files">
                                                                </span>
                                                                <button type="submit" class="btn btn-primary start">
                                                                  <i class="glyphicon glyphicon-upload"></i>
                                                                  <span>Start upload</span>
                                                                </button> -->
                                                            </div>
                                                            <!-- The global progress state -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </section>
						                    <div class="form-group">
						                        <label>Available From</label>
						                        <div class="controls">
						                            <div class="input-group">
						                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" name="available_from" id="available_from" value="{{ $content->available_from }} " class="form-control input-sm" minlength="2" required />
						                            </div>
						                        </div>
						                    </div><!-- /.form group -->
						                    <div class="form-group">
						                        <label>Available To</label>
						                        <div class="controls">
						                            <div class="input-group">
						                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" name="available_to" id="available_to" value="{{ $content->available_to }} " class="form-control input-sm" minlength="2" required />
						                            </div>
						                        </div>
						                    </div><!-- /.form group -->
                                            <div class="form-group">
                                                <label for="submit-price">Price</label>
                                                <div class="input-group">
													
                                                    <input type="text" class="form-control" id="submit-price" name="price" value="{{ $content->price }}" pattern="\d*" required><span class="input-group-addon">฿</span>
                                                   
                                                </div>
                                            </div><!-- /.form-group -->
                                            <div class="form-group">
                                                <label for="submit-price">Mileage</label>
                                                <div class="input-group">

                                                    <input type="text" class="form-control" id="mileage" name="Mileage" value="{{ $content->mileage }}" pattern="\d*" required>
                                                    <span class="input-group-addon">km</span>
                                                </div>
                                            </div><!-- /.form-group -->
											
                                            <div class="form-group">
                                                <label for="tags">Tags</label>
                                                <div class="input-group">
                                                    <input type="hidden" id="tags" name="tags" value="{{ $content->tag }}" />
                                                    <div id="tags_val"></div>
                                                </div><!-- /.input group -->
                                            </div><!-- /.form group -->
											<div class="forn-group">
	                                            <div class="checkbox switch" id="today-switch" data-agent-state="is-today">
	                                                 <label>
	                                                     <b>Today views report?</b> <input type="checkbox" @if($content->today_report==1) checked @endif name="today_report" id="today_report" value="1">
	                                                 </label>
	                                             </div>
											</div>
											<div class="forn-group">
	                                            <div class="checkbox switch" id="verify-switch" data-agent-state="is-verify">
	                                                 <label>
	                                                     <b>Want to certify your car?</b> <input type="checkbox" @if($content->verify==1) checked @endif name="verify" id="verify" value="1">
	                                                 </label>
													 <figure>You will be contacted by our representatives to certify your car.</figure>
	                                             </div>
											</div>
                                            
                                        </div>
                                    </div><!-- /.row -->



								</form>
								

								
                                <section class="block" id="gallery">
                                    <header><h2>Gallery</h2></header>
                                    <div class="center">
                                        <div class="form-group">
						                  <form class="fileupload" id="fileupload1" action="{{ URL::to(App::getLocale().'/my-garage/fileupload') }}"
						                        method="POST"
						                        enctype="multipart/form-data"
						                        data-upload-template-id="template-upload"
						                        data-download-template-id="template-download">
						                      <input type="hidden" name='id' id='id' value='{{ $id }}'>
						                      <!-- <noscript><input type="hidden" name="redirect" value="{{ URL::to('admin/ad') }}"></noscript> -->

						                      <div class="row fileupload-buttonbar">
						                          <div class="col-lg-10">
						                              <span class="btn btn-success fileinput-button">
						                                  <i class="glyphicon glyphicon-plus"></i>
						                                  <span>Add files...</span>
						                                  <input type="file" name="files[]" multiple>
						                              </span>
						                              <button type="submit" class="btn btn-primary start">
						                                  <i class="glyphicon glyphicon-upload"></i>
						                                  <span>Start upload</span>
						                              </button>
						                              <button type="reset" class="btn btn-warning cancel">
						                                  <i class="glyphicon glyphicon-ban-circle"></i>
						                                  <span>Cancel upload</span>
						                              </button>
						                              <button type="button" class="btn btn-danger delete">
						                                  <i class="glyphicon glyphicon-trash"></i>
						                                  <span>Delete</span>
						                              </button>
						                              <input type="checkbox" class="toggle">
						                              <!-- The global file processing state -->
						                              <span class="fileupload-process"></span>
						                          </div>
						                          <!-- The global progress state -->
						                          <div class="col-lg-2 fileupload-progress fade">
						                              <!-- The global progress bar -->
						                              <div class="progress progress-striped active" role="progressbar" aria-valuemin="0"
						                                   aria-valuemax="100">
						                                  <div class="progress-bar progress-bar-success" style="width:0%;"></div>
						                              </div>
						                              <!-- The extended global progress state -->
						                              <div class="progress-extended">&nbsp;</div>
						                          </div>
						                      </div><!-- /.row -->
						                      <!-- <ul id="sortable"> -->
						                      <!-- The table listing the files available for upload/download -->
						<!--                      <div class="row">-->
						                      <ul id="sortable" class="gallery-listing files row" style="overflow: auto">
						                          @if($gallery->count()>0)
						                          @foreach($gallery as $gal)
						                          <li class="list-group-item file-preview-frame template-download col-md-2 fade in row" id="gal_id_{{ $gal->id }}" style="cursor: move">
						                            <span class="preview">
						                                <a href="{{ App::getLocale() }}/uploaded/car/{{ $id }}/gallery/thumb_{{ $gal->name }}" title="{{ $gal->name }}" data-gallery="gallery" download="{{ $gal->name }}">
						                                    <img src="{{ asset('uploaded/car/'.$id.'/gallery/'.$gal->name) }}" style="height:120px" /></a>
						                            </span>
													<br />
													<span class="pull-left">
						                                <button class="btn btn-danger delete" data-type="get"
						                                        data-url="{{ URL::to(App::getLocale().'/my-garage/delete-gallery') }}/{{ $id }}/{{ $gal->id }}">
						                                    <i class="glyphicon glyphicon-trash"></i>
						                                    <!-- <span>Delete</span> -->
						                                </button>
						                                <input type="checkbox" name="delete" value="1" class="toggle">
													</span>
						                          </li>
						                          @endforeach
						                          @endif
						                      </ul>
						<!--                      </div>-->
						                  </form>
                                            <figure class="note"><strong>Hint:</strong> You can upload all images at once!</figure>
                                        </div>
                                    </div>
                                </section>
								
                                <hr>
                            </section>
                        </div><!-- /.col-md-9 -->
                        <div class="col-md-3 col-sm-3">
                            <aside class="submit-step">
                                <figure class="step-number">3</figure>
                                <div class="description">
                                    <h4>Enter Information About Car</h4>
                                    <p>Type information about your property. Be descriptive.
                                    </p>
                                </div>
                            </aside><!-- /.submit-step -->
                        </div><!-- /.col-md-3 -->
                    </div>
            </div><!-- /.row -->
            <div class="row">
                    <div class="block">
                        <div class="col-md-9 col-sm-9">
                            <div class="center">
                                <div class="form-group">
                                    <button type="submit" id="formSubmitButton" class="btn btn-default large">Proceed to Payment</button>
                                </div><!-- /.form-group -->
                                <figure class="note block">By clicking the “Proceed to Payment” or “Submit” button you agree with our <a href="{{ URL::to(App::getLocale().'/p') }}/terms-and-conditions" target="_blank">Terms and conditions</a></figure>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3">
                            <aside class="submit-step">
                                <figure class="step-number">4</figure>
                                <div class="description">
                                    <h4>Review Information and Proceed to Payment</h4>
                                    <p>Carefully check entered information and than click button to submit them.
                                    </p>
                                </div>
                            </aside><!-- /.submit-step -->
                        </div><!-- /.col-md-3 -->
                    </div>
                </div>
        </div><!-- /.container -->
		
		<div class="modal fade" id="previewContent" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		  <div class="modal-dialog modal-lg">
		    <div class="modal-content">
				  <div class="modal-header">
		          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		          <h4 class="modal-title" id="myModalLabel">Data Preview</h4>
		        </div>
		        <div class="modal-body">
					<p>Car : {{ $car->vehicle }} Year : {{ $car->year }} </p>
					<p>Color : <span style="background-color:#{{ $carcolors->colorHEX }}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span></p>
					<p>Parts : {{ $content->car_parts }}</p>
					
					<p>Address : {{ $content->address }} , @if(isset($province))  {{ $province->name }} @else none @endif , @if(isset($amphur)) {{ $amphur->name }} @else none @endif , @if(isset($district)) {{ $district->name }} @else none @endif , @if(isset($zipcode)) {{ $zipcode->zipcode }} @else none @endif</p>
					
		        </div>
				  <div class="modal-footer">
		          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		          <button type="button" id="submitProcess" class="btn btn-primary">Save changes</button>
		        </div>
		    </div>
		  </div>
		</div>

@stop

@section('footer')
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}

	<li class="list-group-item file-preview-frame col-md-2 template-upload fade">
		<span class="preview">
		</span>
		<span class="pull-left">
            {% if (!i && !o.options.autoUpload) { %}
                <button class="btn btn-primary start" disabled>
                    <i class="glyphicon glyphicon-upload"></i>
                    <!-- <span>Start</span> -->
                </button>
            {% } %}
            {% if (!i) { %}
                <button class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <!-- <span>Cancel</span> -->
                </button>
            {% } %}
		</span>
	</li>
{% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
	<li class="template-download file-preview-frame col-md-2 fade row" id="gal_id_{%=file.id%}">
		<span class="preview">
            {% if (file.thumbnailUrl) { %}
                <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}" style="height:120px"></a>
            {% } %}
		</span>
		<span class="pull-left">
            {% if (file.deleteUrl) { %}
                <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                    <i class="glyphicon glyphicon-trash"></i>
                    <!-- <span>Delete</span> -->
                </button>
                <input type="checkbox" name="delete" value="1" class="toggle">
            {% } else { %}
                <button class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <!-- <span>Cancel</span> -->
                </button>
            {% } %}
		</span>
	</li>
{% } %}
</script>

<script src="{{ asset('js/jquery-ui-1.10.3.min.js') }}"></script>

<!-- mask fror file input -->
<script src="{{ asset('js/plugins/fileinput/fileinput.min.js') }}"></script>

<!-- selection, tags -->
<script src="{{ asset('js/plugins/select2/select2.js') }}"></script>

<!-- editor ckeditor and config -->
<script src="{{ asset('js/plugins/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('js/plugins/ckeditor/adapters/jquery.js') }}"></script>
<script src="{{ asset('js/_admin/editor.js') }}"></script>

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

{{ HTML::script('js/plugins/jgrowl/jquery.jgrowl.min.js') }}
{{ HTML::script('js/plugins/validate/jquery.validate.min.js') }}

<!-- datetime picker -->
<script src="{{ asset('js/plugins/bootstrap_datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ asset('js/plugins/bootstrap_daterangepicker/moment.js') }}"></script>
<!-- date range -->
<script src="{{ asset('js/plugins/bootstrap_daterangepicker/daterangepicker.js') }}"></script>

<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
<!--[if (gte IE 8)&(lt IE 10)]>
<script src="{{ asset('js/plugins/fileupload/jquery.xdr-transport.js') }}"></script>
<![endif]-->

<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script src="{{ asset('js/plugins/markerwithlabel_packed.js') }}"></script>
<script src="{{ asset('js/plugins/custom-map.js') }}"></script>
{{ HTML::script('js/plugins/iCheck/icheck.min.js') }}

<!--<script src="{{ asset('js/plugins/browser-detection/jquery.browser.min.js') }}"></script>-->
<script type="text/javascript">
$(function(){
	
    // $('.ckeditor').ckeditor({toolbar_liteToolbar:simpleToolbar, toolbar: 'liteToolbar'});
    $('.ckeditor').ckeditor({toolbar_simpleToolbar:simpleToolbar, toolbar: 'simpleToolbar'});
    // $('.ckeditor').ckeditor({toolbar_fullToolbar:simpleToolbar, toolbar: 'fullToolbar'});
    // CKEDITOR.timestamp='ABCD'; for test refresh editor
	// test
    $('#fileupload1').fileupload({
 		filesContainer: $('ul.files'),
 		uploadTemplateId: "template-upload",
 		downloadTemplateId: "template-download",
		previewMaxWidth: 160,
		previewMaxHeight: 120
    });
	//  Pricing Tables in Submit page

    if($('.submit-pricing').length >0 ){
        $('.buttons .btn').click(function() {
                $('.submit-pricing .buttons td').each(function () {
                    $(this).removeClass('package-selected');
                });
                $(this).parent().css('opacity','1');
                $(this).parent().addClass('package-selected');

            }
        );
    }
	$('#available_from').datetimepicker({pickTime: false});
	$('#available_to').datetimepicker({pickTime: false});
	
    // // $("#files").fileinput({showCaption: false});
    $("#tags").select2({tags:["red", "green", "blue", "orange", "white", "black", "purple", "cyan", "teal"]});
	
'use strict';
// // Change this to the location of your server-side upload handler:
	var url = "{{ URL::to(App::getLocale().'/my-garage/file-thumbnail') }}";
	$('#thumbnail').fileupload({
	    url: url,
		limitMultiFileUploads:1,
	    dataType: 'json',
		autoUpload: false,
		formData: {id: {{ $id }} , imagesize: $("#imagesize").val()},
		add: function (e, data) {
				if (data.files && data.files[0]) {
			        var reader = new FileReader();
			        reader.onload = function(e) {
			            $('.file-preview-image').attr('src', e.target.result);
			        }
			        reader.readAsDataURL(data.files[0]);
				}
				$("#uploadbtn").empty();
				
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

		
	// add validation to form
	$("#frmSubmit").validate({
		submitHandler: function(form) {
			$("#previewContent").modal();
			// $.jGrowl("Saving...");
			// 		  	$.post( "{{ URL::to(App::getLocale().'/my-garage/update') }}", $(form).serialize())
			// 		  	.done(function( data ) {
			// 	var json = $.parseJSON(data);
			// 	$.jGrowl(json.status);
			// 		      	// alert(data);
			// 		      },"json");
		},
        errorPlacement: function(error, element) {
            if (element.attr("name") == "Mileage" 
                || element.attr("name") == "price"
                || element.attr("name") == "available_from"
                || element.attr("name") == "available_to") {
              error.insertAfter(element.parent());
            } else {
              error.insertAfter(element);
            }
        }
	});

	$( "#formSubmitButton" ).click(function() {
		// alert('click');
	  $( "#frmSubmit" ).submit();
	});
	$("#submitProcess").click(function(){
		
		$.jGrowl("Saving...");
	  	$.post( "{{ URL::to(App::getLocale().'/my-garage/update') }}", $("#frmSubmit").serialize())
	  	.done(function( data ) {
			var json = $.parseJSON(data);
			$.jGrowl(json.status);
	      	// alert(data);
			if(json.status=='Update Success') {
				window.location = "{{ URL::to(App::getLocale().'/my-garage') }}";
			}
	      },"json");
		  
	});
	// add sortable to gallery
	$( "#sortable" ).sortable({
		placeholder: "ui-state-highlight list-group-item file-preview-frame col-md-2 template-upload fade in active",
		stop: function( event, ui ) {

		    var data = $(this).sortable("serialize");

		  	$.post( "{{ URL::to(App::getLocale().'/my-garage/update-gallery-order') }}",data)
		  	.done(function( data ) {
				// var json = $.parseJSON(data);
// 				$.jGrowl(json.status);
		      	// alert(data);
		      },"json");

			// alert(data);
		}
	});

});
</script>
@stop
