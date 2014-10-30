@extends('site.desktop._layouts.index')
@section('head')
<!-- gallery file upload -->
{{ HTML::style('css/plugins/fileupload/blueimp-gallery.min.css'); }}
{{ HTML::style('css/plugins/fileupload/jquery.fileupload.css'); }}
{{ HTML::style('css/plugins/fileupload/jquery.fileupload-ui.css'); }}

<!-- CSS adjustments for browsers with JavaScript disabled -->
<noscript>{{ HTML::style('css/plugins/fileupload/jquery.fileupload-noscript.css'); }}</noscript>
<noscript>{{ HTML::style('css/plugins/fileupload/jquery.fileupload-ui-noscript.css'); }}</noscript>

{{ HTML::style('css/plugins/bootstrap-select/bootstrap-select.min.css') }}
{{ HTML::style('css/dropdown.css') }}
{{ HTML::style('css/create_member.css'); }}
{{ HTML::style('css/plugins/owl-carousel/owl.carousel.css') }}
{{ HTML::style('css/plugins/bootstrapvalidator/css/bootstrapValidator.min.css') }}
<!-- tagsinput -->
{{ HTML::style('css/plugins/tagsinput/bootstrap-tagsinput.css'); }}

<style>
.car-report-item-questionaire .question {
  color: #000;
  font-size: 18px;
}
.car-report-item-questionaire label{
  font-weight: normal;
  color:#000;
}
.car-report-title {
    border-bottom: 0px;
    padding: 20px 20px 0px 40px;
    color: #141414;
}
.car-report-item-info{
    background: #efeeee;
    padding: 30px 40px 30px 40px;
}
.car-report-item-info-left {
    float: left;
    width: 200px;
}
.car-report-item-info-right {
    float: right;
    width: 290px;
}
.car-report-item-info-left img {
    width:100%;
}
.car-report-item-info-right header{
    font-size: 22px;    
}
.car-report-item-questionaire {
    float: left;
    width: 100%;
   padding: 15px 40px 15px 40px; 
}
.car-report-item-questionaire strong {
    margin: 0 0 10px 0;
    display: block;
    font-size: 18px;

}
.car-report-item-questionaire .report-answer {
    float: left;
    width: 200px;
    margin: 10px 10px 5px 10px;
}


.thankyou-page {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: #fff;
  margin: 0;
  text-align: center;
  padding-top: 172px;
  display: none;
}
.preview-content{
  padding-top: 10px;
    background: #f1f1f1;
    background: -moz-linear-gradient(top, #f1f1f1 0%, white 80%);
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #f1f1f1), color-stop(80%, white));
    background: -webkit-linear-gradient(top, #f1f1f1 0%, white 80%);
    background: -o-linear-gradient(top, #f1f1f1 0%, white 80%);
    background: -ms-linear-gradient(top, #f1f1f1 0%, white 80%);
    background: linear-gradient(to bottom, #f1f1f1 0%, white 80%);
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#f1f1f1', endColorstr='#ffffff',GradientType=0 );
}
.fileupload-buttonbar .start {
  position: absolute;
top: 18px;
left: 35px;
}
.progress {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 4px;
  border-radius: 0px;
}
.fileinput-button{
  display: block;
  overflow: visible;
}
.filegallery {
  width:100%;
  height: 100%;
  font-size: 11px !important;
}
.fileupload-buttonbar {
  position: relative;
  margin-bottom: 24px;
  width:110px;
}
.btn-remove {
position: absolute;
top: -15px;
/*right: -18px;*/
right:20px;
background: none !important;
width: 28px;
height: 28px;
text-align: center;
color: red !important;
font-size: 19px;
border-radius: 50%;
border: solid 2px;
/* line-height: 9px; */
cursor: pointer;
/* -webkit-box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5); */
/* box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5); */
padding: 0px;
}
.submit-btn {
  background: #1ca5ba;
}
.thumbnail {
  position: relative;
  min-height: 300px;
}
.action-box {
  position: absolute;
  bottom: 4px;
  width: 217px;
}
.listing-id,
.label-default {
  display: block;
  background: #ffffff;
  color:#cccccc;
  text-align: left;
}
.btn-close-modal {
/*    background: red;
    width: 28px;
    height: 28px;
    text-align: center;
    position: absolute;
    right: -10px;
    top: -10px;
    color: #fff;
    font-size: 43px;
    border-radius: 50%;
    border: solid 2px;
    line-height: 28px;
    cursor: pointer;
    -webkit-box-shadow: 0 1px 14px rgba(0, 0, 0, 0.5);
    box-shadow: 0 1px 4px rgba(0, 0, 0, 0.5);*/
background: red;
width: 28px;
height: 28px;
text-align: center;
position: absolute;
right: -10px;
top: -10px;
color: #fff;
font-size: 25px;
border-radius: 50%;
border: solid 2px;
line-height: 22px;
cursor: pointer;
-webkit-box-shadow: 0 1px 14px rgba(0, 0, 0, 0.5);
box-shadow: 0 1px 4px rgba(0, 0, 0, 0.5);
font-family: sans-serif !important;
}
.btn-close-modal:hover{
   color: #fff;
}
#map-canvas {
  height: 200px;
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
background-color: #4d90fe;
padding: 6px 0 0 0;
color: #fff;
font-size: 8px;
}

#pac-input {
  background-color: #fff;
  padding: 0 11px 0 13px;
  width: 120px;
  font-family: Roboto;
  font-size: 11px;
  font-weight: 300;
  text-overflow: ellipsis;
      color: #000;
      height: 32px;
}

#pac-input:focus {
  border-color: #4d90fe;
  margin-left: -1px;
  padding-left: 14px;  /* Regular padding-left + 1. */
  width: 401px;
}

.pac-container {
    background-color: #FFF;
    z-index: 200;
    position: fixed;
    display: inline-block;
    float: left;
}
.modal{
    z-index: 200;   
}
.modal-backdrop{
    z-index: 100;        
}​

#type-selector {
  color: #fff;
  background-color: #4d90fe;
  padding: 5px 11px 0px 11px;
}

#type-selector label {
  font-family: Roboto;
  font-size: 11px;
  font-weight: 300;
}
.has-required {
	margin-bottom:0;
	margin-top:5px;
	color:#b94a48;
	font-size:85%;
	display:block;
}
.tag {
	background-color: #033c73;
}
</style>
@stop
@section('content')

    <div class="container">
    	<div class="row page">
            <div class="col-md-3 col-sm-3">
                @include('site.desktop._partials.member_nav')
            </div>
            <div class="col-md-9 col-sm-9">
                <section id="my-cars">
                    <header>
                        <h1>My Cars</h1>
                        <!-- <a href="{{ URL::to(App::getLocale().'/my-garage/create') }}" class="btn btn-default pull-right">Add New</a> -->
                        <a href="#new-post" class="btn submit-btn" id="btn-post-new"><i class="glyphicon glyphicon-plus"></i> Post new car</a>
                    </header>
                    <br />
                    <div class="row">

                    @if($data['posts']->count() > 0)
                    @foreach($data['posts'] as $c)

                    <div class="col-xs-4">
                        <div class="garage-item">
                            <div class="thumbnail">
                              <span class="label label-default">Created <abbr class="timeago" title="{{ $c->created_at }}">{{ $c->created_at }}</abbr></span>
							  <span class="label label-default">
								  @if($c->status==4)
								  Waiting for approval
								  @elseif ($c->status==5)
								  	Draft
								  @else 
								  
								   Expired <abbr class="time" title="{{ $c->available_to }}">{{ $c->available_to }}</abbr>
							   	  @endif
							   </span> 
                              @if($c->thumbnail != 'null' and $c->thumbnail != '')
                              <img class="file-preview-image" src="{{ asset('uploaded/post/'.$c->id.'/gallery/330x200-'.$c->thumbnail) }}" title="{{ $c->thumbnail }}" alt="{{ $c->thumbnail }}">
                              @else
                              <img class="file-preview-image" src="{{ asset('img/car-empty.jpg') }}" title="" alt="">
                              @endif
                              <div class="caption">
                                <span class="listing-id">ID {{$c->id}}</span>
                                <h3 style="margin: 0;">
                                  <a href="{{ URL::to(App::getLocale().'/car-detail/'.$c->id) }}">
                                    {{ $c->make->make or 'Untitled' }} {{ $c->model->model or '' }} {{ $c->submodel->sub_model or '' }} {{ $c->year->year or '' }}
                                  </a>
                                </h3>
                              </div>
                                <div class="action-box">
                                  <div class="btn-group">
                                    <a href="#edit" data-id="{{ $c->id }}" class="btn btn-default btn-post-edit" class="edit btn btn-default">
                                        <i class="fa fa-pencil"></i></a>
                                    <a href="#delete" data-id="{{ $c->id }}" data-href="{{ URL::to(App::getLocale().'/my-garage/destroy/'.$c->id) }}" 
                                          data-toggle="modal" data-target="#modal-confirm-confirm-to-delete" 
                                          class='btn btn-default btn-delete'><i class="delete fa fa-trash-o"></i></a>
                                  </div>
                                   <button type="button" class="btn btn-default pull-right">{{ number_format($c->price) }} ฿</button>
                                </div>


                                @if(!$c->car_verified)
                                  <div>
                                    <a class="verify-car" href="javascript:void(0);" data-car-id="{{$c->id}}">Verify Car</a>
                                  </div>
                                @else
                                  @if(  $c->car_verified->verified == 0 )
                                    <div class="red-green">
                                      <a class="verify-car" href="javascript:void(0);" data-car-id="{{$c->id}}">Waiting verify</a>
                                    </div>
                                  @else
                                    <div class="text-green">
                                      Verified
                                    </div>
                                  @endif
                                @endif


                            </div>


                        </div>
                    </div>

                    @endforeach
                    @endif
                  

                    </div>
                    <div class="center">{{ $data['posts']->links() }}</div>
                </section>
            </div>
    	</div>
    </div>

    @include('site.desktop.member.mygarage-delete-modal')
  
    @include('site.desktop.member.my-garage.car-new-post-modal')

    @include('site.desktop.member.my-garage.seller-verification-modal')

    @include('site.desktop.member.my-garage.verify-form-modal')
    
@stop

@section('footer')
@include('site.desktop.member.my-garage.post-gallery-upload-template')

{{ HTML::script('js/jquery-ui-1.10.4.custom.min.js') }}

{{ HTML::script('js/plugins/owl-carousel/owl.carousel.min.js') }}

{{ HTML::script('js/plugins/jquery.timeago.js') }}
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places"></script>
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
{{ HTML::script('js/plugins/bootstrap_select/bootstrap-select.min.js') }}

<!-- tagsinput -->
{{ HTML::script('js/plugins/typeahead.min.js') }}
{{ HTML::script('js/plugins/tagsinput/bootstrap-tagsinput.min.js') }}

<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
<!--[if (gte IE 8)&(lt IE 10)]>
<script src="{{ asset('js/plugins/fileupload/jquery.xdr-transport.js') }}"></script>
<![endif]-->
{{ HTML::script('js/img_upload2.js') }}
{{ HTML::script('js/mygarage.js') }}
{{ HTML::script('js/seller_verified.js') }}
<script type='text/javascript'>
$(function(){
    // -------------------------------------------------------
    // Dropdown style
    // -------------------------------------------------------
    var select = $('select');
    if (select.length > 0 ){
        select.selectpicker({dropupAuto:false});
    }
	
    // New Search Box JS
    $('.bootstrap-select-searchbox input').attr('placeholder','Filter');
    $('.bootstrap-select-searchbox').append('<i class="fa fa-search"></i>');
	
    var bootstrapSelect = $('.bootstrap-select');
    var dropDownMenu = $('.dropdown-menu');

    bootstrapSelect.on('shown.bs.dropdown', function () {
        dropDownMenu.removeClass('animation-fade-out');
        dropDownMenu.addClass('animation-fade-in');
    });

    bootstrapSelect.on('hide.bs.dropdown', function () {
        dropDownMenu.removeClass('animation-fade-in');
        dropDownMenu.addClass('animation-fade-out');
    });

    bootstrapSelect.on('hidden.bs.dropdown', function () {
        var _this = $(this);
        $(_this).addClass('open');
        setTimeout(function() {
            $(_this).removeClass('open');
        }, 100);
    });

    select.change(function() {
        if ($(this).val() != '') {
            $('.form-search .bootstrap-select.open').addClass('selected-option-check');
        }else {
            $('.form-search  .bootstrap-select.open').removeClass('selected-option-check');
        }
    });
	
	var url  = "{{ URL::to('/tags/all') }}?{{Carbon::now()->timestamp}}";
    var tags_class = new Bloodhound({
      datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
      queryTokenizer: Bloodhound.tokenizers.whitespace,
      prefetch: {
        url: url,
        filter: function(list) {
          return $.map(list, function(tag) {
            return { name: tag }; });
        }
      }
    });
    tags_class.initialize();

    $('#tags').tagsinput({
      typeaheadjs: {
        name: 'tags_class',
        displayKey: 'name',
        valueKey: 'name',
        source: tags_class.ttAdapter()
      }
    });
	
});
</script>

@stop
