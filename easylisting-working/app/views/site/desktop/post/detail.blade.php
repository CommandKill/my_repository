@extends('site._layouts.easycar')

@section('head')
{{ HTML::style('css/plugins/jquery-slider/jquery.slider.min.css') }}
{{ HTML::style('css/plugins/owl-carousel/owl.carousel.css') }}
{{-- HTML::style('css/plugins/owl-carousel/owl.theme.css') --}}
{{ HTML::style('css/_site/list.css') }}
{{ HTML::style('css/_site/detail.css') }}
{{ HTML::style('css/plugins/jgrowl/jquery.jgrowl.min.css') }}

{{ HTML::style('css/plugins/lightbox/ekko-lightbox.css') }}

@stop

@section('content')
<!-- Breadcrumb -->
<div class="container">
    <ol class="breadcrumb">
        <li><a href="{{ URL::to(App::getLocale().'/') }}">Home</a></li>
        <li><a href="{{ URL::to(App::getLocale().'/listing') }}">Cars Listing</a></li>
        <li class="active">Cars detail</li>
    </ol>
</div>
<div class="affix" data-offset-top="400" id="inspection" style="z-index:99;margin-top:250px;display:none;">
  <a href="#aa"><img src="{{ asset('newassets/widget-inspection@1x.png') }}"></a>
</div>
<div class="container">
    <div class="row">
        <div class="col-lg-9 col-md-12 col-sm-12">
            <header class="car-title">
                <h1 style="color:#1B5184;">{{ $title }}</h1>
                <figure>{{ $description }}</figure>
                <span class="actions">
                    <!-- <a href="#" class="fa fa-print"></a> -->
					<span class="tag price">{{ $content->price }} ฿</span>
                </span>
            </header>
            <div class="row">
                <div class="col-md-8 col-sm-8">
                    @include('site.car.gallery')

                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <section id="description">
                                <header>
									<div class="pull-right">
										<a href="#inspect" class="inspection"><img src="{{ asset('newassets/icon-inspection-on@1x.png') }}">&nbsp; inspect this car</a>&nbsp;
					                    @if ($member_info)
					                        <!-- <span class="title-add">Add to bookmark</span>
					                        <span class="title-added">Added</span> -->
											<img src="{{ asset('newassets/icon-fav-off@1x.png') }}" id="fav_icon">&nbsp;<a href="#favorite" class="favourite" data-bookmark-state="{{ $car_favorite_added? 'added':'empty' }}"> Favourite this car</a>
					                    @endif
										
									</div>
									<h2>Car Description</h2>
								</header>
								<div class="col-md-4 col-sm-4">
							        <span><img src="{{ asset('newassets/icon-mile-detailpage@1x.png') }}"> {{ $content->mileage or 'n/a' }} กม. &nbsp;</span>
								</div>
								<div class="col-md-4 col-sm-4">
							        <span> <img src="{{ asset('newassets/icon-year-detailpage@1x.png') }}"> {{ $content->car_information->year or 'n/a' }}&nbsp;</span>
								</div>
								<div class="col-md-4 col-sm-4">	

							            <span> <img src="{{ asset('newassets/Gear-detailpage@1x.png') }}"> {{ $content->car_information->transmissionType or 'n/a' }} &nbsp;</span>
								</div>
								<br />
								<div class="col-md-4 col-sm-4">		
							            <span><img src="{{ asset('newassets/icon-engine-detailpage@1x.png') }}"> {{ $content->car_information->engineSize or 'n/a'  }}</span>
								</div>
								<div class="col-md-4 col-sm-4">		
							            <span><img src="{{ asset('newassets/icon-petrol-detailpage@1x.png') }}"> {{ $content->car_information->engineFuelType or 'n/a' }}</span>
								</div>
								<div class="col-md-4 col-sm-4">		

							            <span><img src="{{ asset('newassets/icon-colour-detailpage@1x.png') }}"> {{ $content->color->colorName or 'n/a' }}</span>
									
								</div>
								<hr style="width:100%;margin-top:60px">
								{{ $detail }}
                            </section>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4">
                    <div class="row">
                        <!-- <div class="col-md-12 col-sm-12"> -->
                            <!-- <header><h2>Map</h2></header> -->
                            <!-- <div class="car-detail-map-wrapper"> -->
                                <!-- <div class="car-detail-map" id="car-detail-map"></div> -->
                            <!-- </div> -->
                        <!-- </div> -->
                        @if($content->video)
                        <div class="col-md-12 col-sm-12">
                            <section id="video-presentation">
                                <!-- <header><h2>Video</h2></header> -->
                                <!-- <img alt="" src="/img/video.jpg" style="width: 100%;"> -->
                                <iframe width="100%" height="166" src="//www.youtube.com/embed/{{$content->video}}" frameborder="0" allowfullscreen></iframe>
                            </section>
                        </div>
                        @endif
                    </div>
                    @include('site.car.quick-summary')
	                @include('site.car.agent')
	   
                </div>
                <!-- <div class="col-md-12 col-sm-12">
                    <section id="comments">
                        <header><h2>Comments</h2></header>
                        <div id="fb-root"></div>
                        <script>(function(d, s, id) {
                          var js, fjs = d.getElementsByTagName(s)[0];
                          if (d.getElementById(id)) return;
                          js = d.createElement(s); js.id = id;
                          js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=743515462367605&version=v2.0";
                          fjs.parentNode.insertBefore(js, fjs);
                        }(document, 'script', 'facebook-jssdk'));</script>
                        <div class="fb-comments" data-href="http://nattapongkm.com" data-numposts="5" data-width="100%" data-colorscheme="light"></div>
                    </section>
                </div> -->
            </div>
        </div>
        <div class="col-lg-3 col-md-12 col-sm-12">
            <div class="row">
                <div class="col-lg-12 col-md-4 col-sm-6">
                    @include('site.widgets.howto')
                </div>
                <div class="col-lg-12 col-md-4 col-sm-6">
                    @include('site.widgets.feature-car')
                </div>
                <div class="col-lg-12 col-md-4 col-sm-6">
                    @include('site.widgets.latest-car')
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('footer')

 {{ HTML::script('js/jquery-ui-1.10.3.min') }}
{{ HTML::script('js/plugins/owl-carousel/owl.carousel.min.js') }}
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
{{ HTML::script('js/plugins/markerwithlabel_packed.js') }}
{{ HTML::script('js/plugins/custom-map.js') }}
{{ HTML::script('js/plugins/jgrowl/jquery.jgrowl.min.js') }}
{{ HTML::script('js/plugins/lightbox/ekko-lightbox.js') }}
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
	
    // Disable click when dragging
    function disableClick(){
        $('.owl-carousel .car-slide').css('pointer-events', 'none');
    }
    // Enable click after dragging
    function enableClick(){
        $('.owl-carousel .car-slide').css('pointer-events', 'auto');
    }

    if ($('.owl-carousel').length > 0) {
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
            beforeMove: enableClick
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
    // -------------------------------------------------------
    // Set Bookmark button attribute
    // -------------------------------------------------------

		    var bookmarkButton = $(".favourite");

		    if (bookmarkButton.data('bookmark-state') == 'empty') {
		        bookmarkButton.text('Favourite this car');
				$("#fav_icon").attr('src',"{{ asset('newassets/icon-fav-off@1x.png') }}");
		    } else if (bookmarkButton.data('bookmark-state') == 'added') {
		        bookmarkButton.text('Remove from favourite');
				$("#fav_icon").attr('src',"{{ asset('newassets/icon-fav-on@1x.png') }}");
		    }

		    function saveFavoriteSatatus(){

		    }
		//
		    bookmarkButton.on("click", function() {

		        $.get('/car-favorite/{{ $id }}', function($res){
		            if (bookmarkButton.data('bookmark-state') == 'empty') {
		                bookmarkButton.data('bookmark-state', 'added');
		                bookmarkButton.text('Remove from favourite');
						$("#fav_icon").attr('src',"{{ asset('newassets/icon-fav-on@1x.png') }}");
		            } else if (bookmarkButton.data('bookmark-state') == 'added') {
		                bookmarkButton.data('bookmark-state', 'empty');
		                bookmarkButton.text('Favourite this car');
						$("#fav_icon").attr('src',"{{ asset('newassets/icon-fav-off@1x.png') }}");
		            }
		        });

		    });

    if ($('body').hasClass('navigation-fixed-bottom')){
        $('#page-content').css('padding-top',$('.navigation').height());
    }
	
	$(document).delegate('*[data-toggle="lightbox"]', 'click', function(event) {
	    event.preventDefault();
	    $(this).ekkoLightbox();
	});
	
    function createMap(lat, lng) {
        var subtractPosition = 0;
        var mapWrapper = $('#car-detail-map.float');

        if (document.documentElement.clientWidth > 1200) {
            subtractPosition = 0.013;
        }
        if (document.documentElement.clientWidth < 1199) {
            subtractPosition = 0.006;
        }
        if (document.documentElement.clientWidth < 979) {
            subtractPosition = 0.001;
        }
        if (document.documentElement.clientWidth < 767) {
            subtractPosition = 0;
        }

        var mapCenter = new google.maps.LatLng(lat,lng);

        if ( $("#car-detail-map").hasClass("float") ) {
            mapCenter = new google.maps.LatLng(lat,lng - subtractPosition);
            mapWrapper.css('width', mapWrapper.width() + mapWrapper.offset().left )
        }

        var mapOptions = {
            zoom: 15,
            center: mapCenter
        };
        // var mapOptions = {
        //     zoom: 15,
        //     center: mapCenter,
        //     disableDefaultUI: false,
        //     scrollwheel: false,
        //     styles: mapStyles
        // };
        var mapElement = document.getElementById('car-detail-map');
        var map = new google.maps.Map(mapElement, mapOptions);

        var pictureLabel = document.createElement("img");
        pictureLabel.src = "/img/marker-types/garage.png";
        var markerPosition = new google.maps.LatLng(lat,lng);
        var marker = new MarkerWithLabel({
            position: markerPosition,
            map: map,
            icon: '/img/marker.png',
            labelContent: pictureLabel,
            labelAnchor: new google.maps.Point(50, 0),
            labelClass: "marker-style"
        });
    }

    var lat = {{ $content->latitude}};
    var lng = {{ $content->longitude}};
    google.maps.event.addDomListener(window, 'load', createMap(lat,lng));
	
	
});
</script>
@stop
