@extends('site.desktop._layouts.index')

@section('head')
{{ HTML::style('css/plugins/jquery-slider/jquery.slider.min.css') }}
{{ HTML::style('css/plugins/owl-carousel/owl.carousel.css') }}
{{ HTML::style('css/plugins/jgrowl/jquery.jgrowl.min.css') }}
{{ HTML::style('css/plugins/lightbox/ekko-lightbox.css') }}

<style>
.detail-page {
    margin-top: 30px;
    margin-bottom: 30px;

}
.fb-share-button {
	float:left;
}
.g-plus {
	float:left;
}
.twitter-share-button {
	float:left;
	margin-left:8px;
}
#our-guides .oo-icon {
    top: -5px;
}

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
right: -18px;
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
.btn-delete-post {
	border:1px solid #DBDEDF;
	border-radius:3px;
	width:145px;
/*	height:29px;*/
}
</style>
@stop

@section('content')

<div class="affix" data-offset-top="400" id="inspection" style="z-index:99;margin-top:250px;display:none;">
  <a href="#aa"><img src="{{ asset('img/icons/widget-inspection@1x.png') }}"></a>
</div>
<div class="container">
    <div class="row detail-page">
        <div class="col-xs-9" id="printable">
            <header class="car-title">
                <h1 style="color:#1B5184;">{{ $title }}</h1>
				<small> {{ $description }}</small>
                <span class="actions">
                    <!-- <a href="#" class="fa fa-print"></a> -->
					<span class="tag price">{{ $price }} ฿</span>
					<i style="margin-right:10px;background:url('{{ asset('img/icons/icon-year@1x.png')}}') 0 0 no-repeat;"></i>
                </span>
            </header>
            <div class="row">
                <div class="col-xs-8">
                    @include('site.desktop.postdetail.gallery')

                    <div class="row">
                        <div class="col-xs-12">
                            <section id="description">
                                <header>
                                    <div class="pull-right" style="margin-top:5px;">
                                        <a href="#inspect" class="inspection"><img src="{{ asset('img/icons/icon-inspection-on@1x.png') }}">&nbsp; inspect this car</a>&nbsp;
                                        @if (Session::get('member.id'))
                                            <!-- <span class="title-add">Add to bookmark</span>
                                            <span class="title-added">Added</span> -->
                                            <img src="{{ asset('img/icons/icon-fav-off@1x.png') }}" id="fav_icon">&nbsp;<a href="#favorite" class="favourite" data-bookmark-state="{{ $car_favorite_added ? 'added':'empty' }}"> Favourite this car</a>
                                        @endif
                                        
                                    </div>
                                    <h2>Car Description</h2>
                                </header>
                                <div class="col-md-4 col-sm-4">
                                    <span><img src="{{ asset('img/icons/icon-mile@1x.png') }}"> {{ $mileage or 'n/a' }} กม. &nbsp;</span>
                                </div>
                                <div class="col-md-4 col-sm-4">
                                    <span> <img src="{{ asset('img/icons/icon-year@1x.png') }}"> {{ $year or 'n/a' }}&nbsp;</span>
                                </div>
                                <div class="col-md-4 col-sm-4"> 

                                        <span> <img src="{{ asset('img/icons/icon-gear@1x.png') }}"> {{ $cgear or 'n/a' }} &nbsp;</span>
                                </div>
                                <br />
                                <div class="col-md-4 col-sm-4">     
                                        <span><img src="{{ asset('img/icons/icon-engine@1x.png') }}"> {{ $engine or 'n/a'  }}</span>
                                </div>
                                <div class="col-md-4 col-sm-4">     
                                        <span><img src="{{ asset('img/icons/icon-fuel@1x.png') }}"> {{ $fuel or 'n/a' }}</span>
                                </div>
                                <div class="col-md-4 col-sm-4">     

                                        <span><img src="{{ asset('img/icons/icon-colour@1x.png') }}"> {{ $color or 'n/a' }}</span>
                                    
                                </div>
                                <hr style="width:100%;margin-top:60px">
                                <figure>{{ $detail }}</figure>
                            </section>
                        </div>
                    </div>
                </div>
                <div class="col-xs-4">

                    @include('site.desktop.postdetail.quick-summary')
	                @include('site.desktop.postdetail.agent')
	   
                </div>
				
				@include('site.desktop.member.mygarage-delete-modal')
				
            </div>
        </div>
        <div class="col-xs-3">
            <div class="row">
                <div class="col-xs-12">
                    @include('site.desktop.widgets.howto')
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('footer')

{{ HTML::script('js/plugins/owl-carousel/owl.carousel.min.js') }}
 {{ HTML::script('js/plugins/jgrowl/jquery.jgrowl.min.js') }}
{{ HTML::script('js/plugins/ekko-lightbox/ekko-lightbox.js') }}
{{ HTML::script('js/plugins/prints/jQuery.print.js') }}

<script type="text/javascript">
$(function(){
    // -------------------------------------------------------
    //  Owl Carousel
    // -------------------------------------------------------
    // $('#number').toggle(function() {
    //     $(this).find('span').text( $(this).data('last') );
    // },function() {
    //     $(this).find('span').text( 'XXXX' );
    // })
    // .click();
    // $("#number").click(function(){
        $("#number").click(function() {
            var el = $(this);
            if (el.text() == el.data("last")) {
                el.text(el.data("first"));
            }else {
                el.text(el.data("last"));
            }
        });
    // });
    
	var owl = $(".car-carousel");
	
    // Disable click when dragging
    function disableClick(){
        $('.owl-carousel .car-slide').css('pointer-events', 'none');
    }
    // Enable click after dragging
    function enableClick(){
        $('.owl-carousel .car-slide').css('pointer-events', 'auto');
    }

	function afterAction(){
		
		// console.log('next '+ this.owl.currentItem);
		var current = this.owl.currentItem+1;
		$("#gallery_total").text(current+'/'+this.owl.owlItems.length);
	    // updateResult(".owlItems", this.owl.owlItems.length);
	    // updateResult(".currentItem", this.owl.currentItem);
	    // updateResult(".prevItem", this.prevItem);
	    // updateResult(".visibleItems", this.owl.visibleItems);
	    // updateResult(".dragDirection", this.owl.dragDirection);
	  }
	
    if ($('.owl-carousel').length > 0) {
	
		var total_gal = '{{ count($gallery) }}';
        $(".car-carousel").owlCarousel({
            items : 1,
            itemsDesktop : [1199,1],
            itemsDesktopSmall : [979,1],
            itemsMobile: [479,1],
            // responsiveBaseWidth: ".car-slide",
            pagination: false,
            // autoHeight : true,
            navigation: true,
            navigationText: ["",""],
            startDragging: disableClick,
            beforeMove: enableClick,
            lazyLoad : true,
            transitionStyle : 'fade',
            startDragging: disableClick,
            beforeMove: enableClick,
			afterAction : afterAction
        });
		
		
		$(".owl-next").click(function(){
			// console.log('next'+ this.owl.currentItem);
		});
		
		$(".owl-prev").click(function(){
			// console.log('prev'+ this.owl.currentItem);
		});
    }
    // -------------------------------------------------------
    // inspection
    // -------------------------------------------------------
    $("#inspection").hide();
    var inspection = $(".inspection");

    inspection.click(function(){
        // $('#inspection').hide('slide', {direction: 'right'}, 1000);
        $(this).hide();
        $("#inspection").show('fold', 5000);
        

    });
    // $.jGrowl('ข้อความของท่านถูกส่งแล้ว');
    $("#form-contact-agent").submit(function( event ) {
        $.jGrowl('ข้อความของท่านถูกส่งแล้ว');
        $("#message_modal").modal("hide");
        
        event.preventDefault();
      // alert( "Handler for .submit() called." );
      // post jquery here
     
        
        // 
      
    });
	
	// print
	
	$("#print_page").click(function(){
		$.print("#printable");
	});
	
    // -------------------------------------------------------
    // Set Bookmark button attribute
    // -------------------------------------------------------

            var bookmarkButton = $(".favourite");

            if (bookmarkButton.data('bookmark-state') == 'empty') {
                bookmarkButton.text('Favourite this car');
                $("#fav_icon").attr('src',"{{ asset('img/icons/icon-fav-off@1x.png') }}");
            } else if (bookmarkButton.data('bookmark-state') == 'added') {
                bookmarkButton.text('Remove from favourite');
                $("#fav_icon").attr('src',"{{ asset('img/icons/icon-fav-on@1x.png') }}");
            }

            function saveFavoriteSatatus(){

            }
        //
            bookmarkButton.on("click", function() {

                $.get('/car-favorite/{{ $post_id }}', function($res){
					$.jGrowl($res.msg);
                    if (bookmarkButton.data('bookmark-state') == 'empty') {
                        bookmarkButton.data('bookmark-state', 'added');
                        bookmarkButton.text('Remove from favourite');
                        $("#fav_icon").attr('src',"{{ asset('img/icons/icon-fav-on@1x.png') }}");
                    } else if (bookmarkButton.data('bookmark-state') == 'added') {
                        bookmarkButton.data('bookmark-state', 'empty');
                        bookmarkButton.text('Favourite this car');
                        $("#fav_icon").attr('src',"{{ asset('img/icons/icon-fav-off@1x.png') }}");
                    }
                });

            });
			
	$("#share_email").on("show.bs.modal",function(e){
		
		$("#waiting").html("");
		
	});		
	$("#share_email_form").submit(function(e){
		e.preventDefault();
		
		$("#waiting").html("Mail sending...");
		
        $.post( "{{ URL::to(App::getLocale().'/car-share-email') }}",$(this).serialize(), function( data ) {
  		  $("#waiting").html(data.msg);
  		  $.jGrowl(data.msg);
		  
		  // if (!data.error) {
		  // 				 $("#share_email").modal('hide');
		  //           } else {
		  // 			  // $.jGrowl(data.msg);
		  //             // alert('can not send email right now!');
		  //           }
		  
		  $("#share_email").modal('hide'); 
		  
        });
		
	});		
	
    if ($('body').hasClass('navigation-fixed-bottom')){
        $('#page-content').css('padding-top',$('.navigation').height());
    }
   
	
    $(document).delegate('*[data-toggle="lightbox"]', 'click', function(event) {
        event.preventDefault();
        $(this).ekkoLightbox();
    });
	
    $('.btn-delete').click(function(){
		
      $('#report-title').html('{{ $title }}');
      $('#report-id').html('{{ $post_id }}');

      $('#delete-listing-id').val('{{ $post_id }}');
    });

    $('#btn-confirm-delete-listing').click(function(){
      var $form = $('#delete-form');
      var data = $form.serialize();

      if (!$form[0].checkValidity())
      {
        //console.log('no pass');
      } else {
        // cancels the form submission
        event.preventDefault();
        // console.log('pass');
        $.post( "/my-garage/delete-listing", data)
        .done(function( data ) {
            console.log(data);
            $('#modal-confirm-confirm-to-delete .thankyou-page').show();
            setTimeout("$('#modal-post-form').modal('hide');",2000);
        },"json");
      }
    });
	
});
</script>
@stop
