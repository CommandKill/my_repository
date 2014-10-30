var province_id = '';
var amphur_id = '';
var district_id = '';
var zipcode_id = '';
var year_id = '';
var make_id = '';
var model_id = '';
var submodel_id = '';
var fuel_id = '';
var gear_id = '';
var engine_id = '';
var color_id = '';
var latitude = 13.6840189;
var longitude = 100.61550489999999;
var map;
var marker;
var post_by;
var infowindow;
var myInterval;    
$(function(){


  var elemLatitude = $('#latitude');
  var elemLongitude = $('#longitude');
  var elemAddress = $('#address');


  $("abbr.timeago").timeago();

  function initAddress()
  {
    $.get( "/api/v1/address/province/", function( data ) {
      $dropdown = $('#province');
      $.each( data.provinces, function( key, val ) {
        // console.log('check province '+ province_id + '=' + val.id);
        if(province_id==val.id) {
          $dropdown.append($('<option selected></option>').val(val.id).html(val.province));
        }else {
          $dropdown.append($('<option></option>').val(val.id).html(val.province));
        }
      });
      $dropdown.selectpicker("refresh").change();  
    }, "json" );
  }

    $("#province").change(function(){
        if ($(this).val() != '') {
          $.get( "/api/v1/address/amphur/"+$(this).val(), function( data ) {
            $dropdown = $('#amphur');
            $dropdown.empty().append($('<option  value="" selected></option>').html("District"));
              $.each( data.amphurs, function( key, val ) {
                  if(amphur_id==val.id) {
                      $dropdown.append($('<option selected></option>').val(val.id).html(val.amphur));
                  }else {
                      $dropdown.append($('<option></option>').val(val.id).html(val.amphur));
                  }
              });
              $dropdown.selectpicker("refresh").change();
          }, "json" );
        }
    });


    $("#amphur").change(function(){
      if ($(this).val() != '') {
        $.get( "/api/v1/address/district/"+$(this).val(), function( data ) {
          $dropdown = $('#district');
          $dropdown.empty().append($('<option  value="" selected></option>').html("Sub district"));
            $.each( data.districts, function( key, val ) {
                if(district_id==val.id) {
                    $dropdown.append($('<option selected></option>').val(val.id).html(val.district));
                }else {
                    $dropdown.append($('<option></option>').val(val.id).html(val.district));
                }
                $dropdown.selectpicker("refresh").change();
            });
        }, "json" );
      }
    });

    $("#district").change(function(){
      if ($(this).val() != '') {
        $.get( "/api/v1/address/zipcode/"+$(this).val(), function( data ) {
          $dropdown = $('#zipcode');
          $dropdown.empty().append($('<option value="" selected></option>').html("Zipcode"));
            $.each( data.zipcodes, function( key, val ) {

                if(zipcode_id==val.id) {
                    $dropdown.append($('<option selected></option>').val(val.id).html(val.zipcode));
                }else {
                    $dropdown.append($('<option></option>').val(val.id).html(val.zipcode));
                }
            });
            $dropdown.selectpicker("refresh");
        // $("#zipcode").change();
        }, "json" );
      }
    });

    function mapInitialize() {
        var mapOptions = {
            center: new google.maps.LatLng(latitude, longitude),
            zoom: 15
        };
        map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

        var input = /** @type {HTMLInputElement} */(
          document.getElementById('pac-input'));

        $('#pac-input').keypress(function(event){
        if (event.keyCode == 10 || event.keyCode == 13) 
            event.preventDefault();
        });

        var types = document.getElementById('type-selector');
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(types);

        var autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.bindTo('bounds', map);

        infowindow = new google.maps.InfoWindow();
        marker = new google.maps.Marker({
            map: map,
            draggable: true,
            anchorPoint: new google.maps.Point(0, -29)
        });

        google.maps.event.addListener(autocomplete, 'place_changed', function() {
            infowindow.close();
            marker.setVisible(false);
            var place = autocomplete.getPlace();
            if (!place.geometry) {
              return;
            }
            // If the place has a geometry, then present it on a map.
            if (place.geometry.viewport) {
              map.fitBounds(place.geometry.viewport);
            } else {
              map.setCenter(place.geometry.location);
              map.setZoom(17);  // Why 17? Because it looks good.
            }
            marker.setIcon(/** @type {google.maps.Icon} */({
              url: place.icon,
              size: new google.maps.Size(71, 71),
              origin: new google.maps.Point(0, 0),
              anchor: new google.maps.Point(17, 34),
              scaledSize: new google.maps.Size(35, 35)
            }));
            marker.setPosition(place.geometry.location);
            marker.setVisible(true);

            var address = '';
            if (place.address_components) {
              address = [
                (place.address_components[0] && place.address_components[0].short_name || ''),
                (place.address_components[1] && place.address_components[1].short_name || ''),
                (place.address_components[2] && place.address_components[2].short_name || '')
              ].join(' ');
            }
            elemAddress.val(place.name + ', ' + address);
            infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
            infowindow.open(map, marker);

            elemLatitude.val(marker.position.k);
            elemLongitude.val(marker.position.B);
        });

        // Sets a listener on a radio button to change the filter type on Places
        // Autocomplete.
        function setupClickListener(id, types) {
        var radioButton = document.getElementById(id);
        google.maps.event.addDomListener(radioButton, 'click', function() {
          autocomplete.setTypes(types);
        });
        }

        setupClickListener('changetype-all', []);
        setupClickListener('changetype-address', ['address']);
        setupClickListener('changetype-establishment', ['establishment']);
        setupClickListener('changetype-geocode', ['geocode']);

        var mapCenter = new google.maps.LatLng(latitude,longitude);
        marker.setPosition(mapCenter);
        map.setCenter(mapCenter);
        map.setZoom(13);

        infowindow.setContent('<div><strong>Your location</strong><br>');
        infowindow.open(map, marker);

        google.maps.event.addListener(marker, 'dragend', function(e) {
         // console.log(marker.position);
         elemLatitude.val(marker.position.k);
         elemLongitude.val(marker.position.B);
        });

        elemLatitude.val(marker.position.k);
        elemLongitude.val(marker.position.B);
    }

    function onGeoSuccess(position){
        elemLatitude.val(position.coords.latitude);
        elemLongitude.val(position.coords.longitude);
        var mapCenter = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
        marker.setPosition(mapCenter);
        map.setCenter(mapCenter);
        map.setZoom(17);
    }

    $('#checkbox-use-current-location').on('change', function(){
        if($(this).is(':checked') ) {
			$('#province').prop('disabled', true);
			$('#amphur').prop('disabled', true);
			$('#district').prop('disabled', true);
			$('#zipcode').prop('disabled', true);
			
			$('#province').selectpicker("refresh");
			$('#amphur').selectpicker("refresh");
			$('#district').selectpicker("refresh");
			$('#zipcode').selectpicker("refresh");

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(onGeoSuccess);
            } else {
                error('Geo Location is not supported');
            }
        //$('#map-canvas').show();
        } else {
			$('#province').prop('disabled', false);
			$('#amphur').prop('disabled', false);
			$('#district').prop('disabled', false);
			$('#zipcode').prop('disabled', false);

			$('#province').selectpicker("refresh");
			$('#amphur').selectpicker("refresh");
			$('#district').selectpicker("refresh");
			$('#zipcode').selectpicker("refresh");
	        // $('#map-canvas').hide();
			
        }
    });

   // google.maps.event.addDomListener(window, 'load', mapInitialize);
    google.maps.event.addDomListener(window, "resize", resizingMap());

    $('#modal-post-form').on('show.bs.modal', function() {
      mapInitialize();
        //Must wait until the render of the modal appear, thats why we use the resizeMap and NOT resizingMap!! ;-)
        resizeMap();

        initAddress();
        initCar();
		
		myInterval = setInterval(updateForm,10000); 
		
    })

    $('#address-tab-nav a').click(function(){
        resizeMap();
    });
    function updateForm(){
         var txt_address = '';
         if($('#checkbox-use-current-location').is(':checked') ) {
           txt_address = '';
         } else {
           if ($("#province").val().length > 0) {
             txt_address += ' ' + $("#province option:selected").text();
           }
           if ($("#amphur").val().length > 0) {
             txt_address += ' ' + $("#amphur option:selected").text();
           }
           if ($("#district").val().length > 0) {
             txt_address += ' ' + $("#district option:selected").text();
           }
		 
           $('#hidden_address').val(txt_address);
         }

         $.post( '/post/update',$('#post-form').serialize(), function( data ) {
           if (!data.error) {

           } else {
			  
           }
         });
    }
    function resizeMap() {
        if(typeof map =="undefined") return;
        setTimeout( function(){resizingMap();} , 400);
    }

    function resizingMap() {
        if(typeof map =="undefined") return;
        var center = map.getCenter();
        google.maps.event.trigger(map, "resize");
        map.setCenter(center); 
    }
	// $('#phone').val(function(i, text) {
// 	    return text.replace(/(\d{3})(\d{3})(\d{4})/, '$1-$2-$3');
// 	});
    $('#year').change(function(){
    	if($(this).val()) {
			$(this).parent().find("small").hide();
    	}else {
    		$(this).parent().find( "small" ).show();
    	}
    });
    $("#make").change(function(){
      // $dropdown = $('#model');
      $('#model').empty();
      $('#model').append($('<option value=""></option>').html('Model'));
      $("#submodel").empty();
      $("#submodel").append($('<option value=""></option>').html('Sub model'));
	  // console.log('car make change :: '+$(this).val());
	  	if($(this).val()) {
			$(this).parent().find("small").hide();
	  	}else {
	  		$(this).parent().find( "small" ).show();
	  	}
      if ($(this).val()) {
        $.get( "/api/v1/car/model",{ make_id:$(this).val() }, function( data ) {
          $.each( data.models, function( key, val ) {
           if(model_id==val.id) {
            $('#model').append($('<option selected></option>').val(val.id).html(val.model));
			$('#model').parent().find('small').hide();
           }else {
            $('#model').append($('<option></option>').val(val.id).html(val.model));
           }
          });
          $('#model').selectpicker("refresh").change();
        }, "json" );
      }

    });

     $("#model").change(function(){
      // $dropdown = $('#submodel');
      $('#submodel').empty();
      $('#submodel').append($('<option value=""></option>').html('Sub model'));
	  	if($(this).val()) {
			$(this).parent().find("small").hide();
	  	}else {
	  		$(this).parent().find( "small" ).show();
	  	}
      if ($(this).val()) {
        $.get( "/api/v1/car/sub-model",{ model_id:$(this).val() }, function( data ) {
          $.each( data.submodels, function( key, val ) {
           if(submodel_id==val.id) {
            $('#submodel').append($('<option selected></option>').val(val.id).html(val.sub_model));
           }else {
            $('#submodel').append($('<option></option>').val(val.id).html(val.sub_model));
           }
          });
          $('#submodel').selectpicker("refresh").change();
        }, "json" );
      }
     });

     function initCar()
     {
        $.get( "/api/v1/car/color", function( data ) {
            $dropdown = $('#color');
            $.each( data.colors, function( key, val ) {
             if(color_id==val.id) {
              $dropdown.append($('<option selected></option>').val(val.id).html(val.color)); 
             }else {
              $dropdown.append($('<option></option>').val(val.id).html(val.color)); 
             }
            });
            $dropdown.selectpicker("refresh");
          }, "json" ); 

        $.get( "/api/v1/car/fuel", function( data ) {
            $dropdown = $('#fuel');
			$dropdown.empty();
			$dropdown.append($('<option></option>').html('Petrol')); 
            $.each( data.fuels, function( key, val ) {
             if(fuel_id==val.id) {
              $dropdown.append($('<option selected></option>').val(val.id).html(val.type)); 
             }else {
              $dropdown.append($('<option></option>').val(val.id).html(val.type)); 
             }
            });
            $dropdown.selectpicker("refresh");
          }, "json" ); 

        $.get( "/api/v1/car/gear", function( data ) {
            $dropdown = $('#gear');
			$dropdown.empty();
			$dropdown.append($('<option></option>').html('Gear')); 
            $.each( data.gears, function( key, val ) {
             if(gear_id==val.id) {
              $dropdown.append($('<option selected></option>').val(val.id).html(val.gear)); 
             }else {
              $dropdown.append($('<option></option>').val(val.id).html(val.gear)); 
             }
            });
            $dropdown.selectpicker("refresh");
          }, "json" ); 

        $.get( "/api/v1/car/engine", function( data ) {
            $dropdown = $('#engine');
            $.each( data.engines, function( key, val ) {
             if(engine_id==val.id) {
              $dropdown.append($('<option selected></option>').val(val.id).html(val.size)); 
             }else {
              $dropdown.append($('<option></option>').val(val.id).html(val.size)); 
             }
            });
            $dropdown.selectpicker("refresh");
          }, "json" ); 

        $.get( "/api/v1/car/year", function( data ) {
          $dropdown = $('#year');
          $.each( data.years, function( key, val ) {
           if(year_id==val.id) {
            $dropdown.append($('<option selected></option>').val(val.id).html(val.year));
						// $s->post = $post;
			$dropdown.parent().find('small').hide();			 
           }else {
            $dropdown.append($('<option></option>').val(val.id).html(val.year)); 
			
           }
          });
          $dropdown.selectpicker("refresh");//.change();
        }, "json" );

        $.get( "/api/v1/car/make", function( data ) {
            $dropdown = $('#make');
            $.each( data.makes, function( key, val ) {
             if(make_id==val.id) {
              $dropdown.append($('<option selected></option>').val(val.id).html(val.make));
			  $dropdown.parent().find('small').hide(); 
             }else {
              $dropdown.append($('<option></option>').val(val.id).html(val.make)); 
             }
            });
            $dropdown.selectpicker("refresh").change();
          }, "json" ); 
     }


   //  $('#btn-post-new').click(function(){
   //      // post to add new 
   //      $.post( '/post/store', function( data ) {
   //      // console.log(data);
   //        if (!data.error) {  
   //          $('#hidden_post_id').val(data.post.id);
   //          // $('#modal-post-form').modal('show');
			// $("#hidden_first_post").val('first_post');
			
			// postNewCar(data.post.id);
			
   //        } else {
			//  $("#hidden_first_post").val('');
   //          alert('can not add new post!');
   //        }
   //      });

   //      return false;
   //  });

    $('.btn-delete').click(function(){

      var container = $(this).parent().parent().parent();
      var title = container.find('.caption a').text().trim();
      var listingId = container.find('.caption .listing-id').text().trim();
      $('#report-title').html(title);
      $('#report-id').html(listingId);

      
      var post_id = $(this).data('id');
      $('#delete-listing-id').val(post_id);
        //$('#link-delete-post').attr('href', $(this).data('href'));
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
            // console.log(data);
            // $('#modal-confirm-confirm-to-delete .thankyou-page').show();
            setTimeout("$('#modal-post-form').modal('hide');",500);
        },"json");
      }
    });

    $('#modal-confirm-confirm-to-delete').on('show.bs.modal', function (e) {
      //$('input[name="delete-reason"]').iCheck('uncheck');
      $('input[name="delete-reason"]').prop('checked', false);
      $('#modal-confirm-confirm-to-delete .thankyou-page').hide();
      // $('#delete-listing-id').val('');
    });

    // Disable click when dragging
    function disableClick(){
        $('.owl-carousel .car-slide').css('pointer-events', 'none');
    }
    // Enable click after dragging
    function enableClick(){
        $('.owl-carousel .car-slide').css('pointer-events', 'auto');
    }
	function clearData(){
		
		$("#hidden_first_post").val('');
		
		$("#submit-price").val('');
		$("#mileage").val('');
		$("#phone").val('');
		$("#line_id").val('');
		$("#line_id").val('');
		
		$("#line_id").val('');
		$("#description_en").text('');
		$("#description_th").text('');
		
		$("input[name='part[]']").each(function(){
			var val = $(this).val();
			
			$(this).prop('checked', false);

		});
		
		// $("span.fileinput-button").each(function( i ) {
		// 	// console.log(i);
		//
		// 		$(this).children('img').attr('src','http://easy-listing.local/img/thumb.png');
		//
		// });
	}
	
	$("#submit-price").change(function(){
		if($(this).val().length > 2) {
			$(this).parent().next("small").hide();
		}else {
			$(this).parent().next("small").show();
		}
		
	});
	$("#mileage").change(function(){
		if($(this).val().length > 2) {
			$(this).parent().next("small").hide();
		}else {
			$(this).parent().next("small").show();
		}
	});
	$("#phone").change(function(){
		if($(this).val().length > 6) {
			$(this).parent().next("small").hide();
		}else {
			$(this).parent().next("small").show();
		}
	});
	
	$("#car_not_exist").change(function(){
		if($(this).is(':checked')) {
			console.log('check');
			$('#year option:contains("Year")').prop('selected', true);
			$('#make option:contains("Make")').prop('selected', true);
			$('#year').selectpicker("refresh").change();
			$('#make').selectpicker("refresh").change();
		}
	});
	
    $('.btn-post-edit').click(function(){
		
		clearData();
        // console.log($(this).data('id'));
        var post_id = $(this).data('id');
        // get information
        $.get( "/post/detail/"+post_id, function( data ) {
            if (!data.error) {
				$gallery = data.gallery;
				$lang = data.lang;
				post_by = data.post_by;
				$province = data.province;
				
				var tags = data.tags;
				// console.log(data.post_by);
                data = data.post;
                // console.log(data);
                $('#hidden_post_id').val(data.id);
                $('#hidden_year_id').val(data.year_id);
                $('#hidden_make_id').val(data.make_id);
                $('#hidden_model_id').val(data.model_id);
                $('#hidden_submodel_id').val(data.submodel_id);
                $('#hidden_fuel_id').val(data.fuel_id);
                $('#hidden_gear_id').val(data.gear_id);
                $('#hidden_engine_id').val(data.engine_id);
                $('#hidden_province_id').val(data.province_id);
                $('#hidden_amphur_id').val(data.amphur_id);
                $('#hidden_district_id').val(data.district_id);
                $('#hidden_zipcode_id').val(data.zipcode_id);
                $('#hidden_latitude').val(data.latitude);
                $('#hidden_longitude').val(data.longitude);
                $('#hidden_address').val($province);
                $('#hidden_suggest').val(data.suggest);

                $('#hidden_price').val(data.price);
                $('#hidden_mileage').val(data.mileage);
                $('#hidden_thumbnail').val(data.thumbnail);
                $('#hidden_user_info_addr').val(data.user_info_addr);
				
				
				if(data.suggest!='') {
					$("#suggest").val(data.suggest);
					$("#car_not_exist").prop('checked',true);
				}
				// console.log(tags);
				$.each(tags, function(i,v){
					$('#tags').tagsinput('add',v);
				});
				
				// $("#tags").val(tags);
				$("#tags").tagsinput('refresh');
				
                province_id = (post_by.province_id!=0) ? post_by.province_id : data.province_id;
                amphur_id =  (post_by.amphur_id!=0) ? post_by.amphur_id : data.amphur_id;
                district_id = (post_by.district_id!=0) ? post_by.district_id : data.district_id;
                zipcode_id = (post_by.zipcode_id!=0) ? post_by.zipcode_id : data.zipcode_id;

                if (data.latitude != '' && data.latitude != '0.0000000000000') {
                  latitude = data.latitude;
                }
                if (data.longitude != '' && data.longitude != '0.0000000000000') {
                  longitude = data.longitude;
                }

                year_id = data.year_id;
                make_id = data.make_id;
                model_id = data.model_id;
                submodel_id = data.submodel_id;
                fuel_id = data.fuel_id;
                gear_id = data.gear_id;
                engine_id = data.engine_id;
                color_id = data.color_id;
				// console.log(post_by.phone);
				var phoneNumber = (post_by.phone!=null) ? post_by.phone : data.phone;
				// console.log(data);
				$("#submit-price").val(data.price);
				$("#mileage").val(data.mileage);
				$("#phone").val(phoneNumber);
				$("#line_id").val(data.line_id);
				
				if(data.price) {
					$("#submit-price").parent().next("small").hide();
				}
				if(data.mileage) {
					$("#mileage").parent().next("small").hide();
				}
				if(phoneNumber) {
					$("#phone").parent().next("small").hide();
				}
				$.each($lang,function(k,v){
					if(v.language_id==1) {
						$("#description_en").val(v.description);
						$("#detail_en").text(v.detail);
					}else {
						$("#description_th").val(v.description);
						$("#detail_th").text(v.detail);
					}
				});
				// $("#description_en").tex();
// 				$("#description_en").tex('');

                initAddress();
                initCar();
				
				// $("#preview-gallery").empty();
				// bind parts data
				// console.log('parts '+ data.parts_ids);
				$("input[name='part[]']").each(function(){
					var val = $(this).val();
					if(data.parts_ids!=null) {
						if(data.parts_ids.indexOf(val) > -1) {
							// console.log('contains');
							// $(this).attr('checked');
							$(this).prop('checked', true);
							// $(this).checked = true;
						}
					}
					
				});
				
				// bind gallery to filed
				$.each($gallery,function (i,v) {
							$html = '<div class="col-xs-4 in" style="padding-bottom:24px;padding-left:15px;padding-right:19px;" id="gal_id_'+v.id+'" style="cursor: move">'+
							'<div data-role="'+v.id+'">'+
					          '<span class="preview">'+
							        '<img src="/uploaded/post/'+v.post_id+'/gallery/160x100-'+v.name+'" style="width:111px;height:73px;">'+
					          '</span>'+
					          '<span class="uploadbtn" style="width:110px">'+
					          	'<button class="btn btn-danger btn-remove" data-type="get" data-url="/post/delete-gallery/'+v.post_id+'/'+v.id+'"><i class="glyphicon glyphicon-remove"></i></button>'+
					          '</span>'+
							'</div>'+
							'</div>';
							
							$("div.files").append($html);
				});
				
                $('#modal-post-form').modal('show');

            } else {
                alert('can not add new post!');
            }
        });
        return false;
    });
	// $('#preview-tab a').click(function (e) {
	function initPreview(){
    	$("#preview-gallery").html('');
		
		// console.log(post_by);
		if(post_by!=null) {
			$(".preview-post_by").text(post_by.first_name +' ' + post_by.last_name);
		}
		// console.log('/uploaded/member/'+post_by.id+'/150x150-'+post_by.avatar);
		$("#preview-thumbnail").attr('src','/uploaded/member/'+post_by.id+'/150x150-'+post_by.avatar);
		$("#preview-title").text($( "#make option:selected" ).text() + ' ' + $( "#model option:selected" ).text() + ' ' +  $( "#submodel option:selected" ).text().replace('Sub model', '') + ' ' + $( "#year option:selected" ).text());
		$("#preview-price").text($("#submit-price").val()+' ฿');
		$("#preview-mileage").text($("#mileage").val());
		$("#number").text($("#phone").val() || 'n/a');
		if($("#line_id").val()=='') {
			$("#preview-line_id0").text('');
		}else {
			$("#preview-line_id0").text('Line ID');
		}
		
		$("#preview-line_id").text($("#line_id").val() || '');
		$("#preview-description").text($("#description_en").val());
		$("#preview-detail").text($("#detail_en").text());
		$("#preview-post_id").text($('#hidden_post_id').val());
		$("#preview-year").text($( "#year option:selected" ).text());
		$("#preview-color").text($( "#color option:selected" ).text());
		$("#preview-cgear").text($( "#gear option:selected" ).text());
		$("#preview-fuel").text($( "#fuel option:selected" ).text());
		$("#preview-engine").text($( "#engine option:selected" ).text());
		$("#preview-address").text($('#hidden_address').val());
		
		
	    if ($("span.preview").length > 0) {
        
	        $("span.preview").each(function( i ) {
	          // console.log(i);
	          // if(i!=0) { 
	            $img = $(this).children('img').attr('src');
	            if($img.indexOf("img/thumb.png") == -1) {
	                $img = $img.replace("160x100", "512x342");
	             // console.log($img);
	              $("#preview-gallery").append('<div class="car-slide">' + 
	                '<a href="" class="image-popup" data-toggle="lightbox" data-gallery="multiimages">' + 
	                '<img class="lazyOwl" alt="" data-src="'+$img+'"></a></div>');
	            }
	          // } 
	        });
			
	        if ($('.owl-carousel').length > 0) {
	          var owl = $(".owl-carousel").data('owlCarousel');
	          if (owl) {
	            owl.destroy();
	          }
	          $(".car-carousel").owlCarousel({
	              items : 1,
	              itemsDesktop : [1199,1],
	              itemsDesktopSmall : [979,1],
	              itemsMobile: [479,1],
	              responsiveRefreshRate : 200,
	              // responsiveBaseWidth: ".car-slide",
	              pagination: false,
	              // autoHeight : true,
	              navigation: true,
	              navigationText: ["",""],
	              startDragging: disableClick,
	              beforeMove: enableClick,
	              lazyLoad : true,
	              transitionStyle : false,
	              startDragging: disableClick,
	              beforeMove: enableClick
	          });
	        }
	    } 
	//
				


		
		
	}
	function hideModal(){
		$('#modal-post-form').modal('hide');
		location.reload();
	}
	// $('#modal-post-form').on('shown.bs.modal', function() {
	//     $('#post-form').bootstrapValidator();
	// 	$("#post-form").bootstrapValidator()
	// 	        .on('success.form.bv', function(e) {
	// 	            // Prevent form submission
	//
	// 	            e.preventDefault();
	// 				var txt_address = '';
	// 	            // Get the form instance
	// 	            var $form = $(e.target);
	//
	// 	            // Get the BootstrapValidator instance
	// 	            var bv = $form.data('bootstrapValidator');
	//
	// 	            // Use Ajax to submit form data
	// 		           if($('#checkbox-use-current-location').is(':checked') ) {
	// 		             txt_address = '';
	// 		           } else {
	// 		             if ($("#province").val().length > 0) {
	// 		               txt_address += ' ' + $("#province option:selected").text();
	// 		             }
	// 		             if ($("#amphur").val().length > 0) {
	// 		               txt_address += ' ' + $("#amphur option:selected").text();
	// 		             }
	// 		             if ($("#district").val().length > 0) {
	// 		               txt_address += ' ' + $("#district option:selected").text();
	// 		             }
	// 		             // if ($("#zipcode").val().length > 0) {
	// // 		               txt_address += ' ' + $("#zipcode option:selected").text();
	// // 		             }
	//
	// 		             //console.log(txt_address);
	//
	// 		             $('#hidden_address').val(txt_address);
	// 		           }
	//
	// 		           $.post( '/post/update',$('#post-form').serialize(), function( data ) {
	// 		             if (!data.error) {
	// 		               // $('#hidden_post_id').val(data.id);
	// 		      			       //$(".alert").show('fade');
	// 		      			       //setTimeout(hideModal,3000);
	// 		      			 $("#listingID").text($("#hidden_post_id").val());
	// 		                $('#modal-post-form .thankyou-page').show();
	// 		             } else {
	// 		               alert('can not add new post!');
	// 		             }
	// 		           });
	// 	        });
	// });
	
	
	$("#post-form").submit(function( event ) {
		event.preventDefault();
       var txt_address = '';
       if($('#checkbox-use-current-location').is(':checked') ) {
         txt_address = '';
       } else {
         if ($("#province").val().length > 0) {
           txt_address += ' ' + $("#province option:selected").text();
         }
         if ($("#amphur").val().length > 0) {
           txt_address += ' ' + $("#amphur option:selected").text();
         }
         if ($("#district").val().length > 0) {
           txt_address += ' ' + $("#district option:selected").text();
         }
		 
         $('#hidden_address').val(txt_address);
       }

       $.post( '/post/update',$('#post-form').serialize(), function( data ) {
         if (!data.error) {
           // $('#hidden_post_id').val(data.id);
  			       //$(".alert").show('fade');
  			       //setTimeout(hideModal,3000);
  			 $("#listingID").text($("#hidden_post_id").val());
			 if($("#hidden_first_post").val() !='' && $("#hidden_first_post").val()=='first_post') {
				 $("#success_message").text("Your listing has been successfully submitted and in the queue for approval.");
			 }
            $('.thankyou-page').show();
         } else {
           alert('can not add new post!');
         }
       });
	  
	});
    $('#btn-save').click(function(){
		$("#submit_click").val('1');
		$("#post-form").submit();
        return false;
    });
	$('#modal-post-form').on('hide.bs.modal', function (e) {
		clearInterval(myInterval);
		location.reload();
	});
   $('#account-submit').click(function(){
      var txt_address = '';
      if($('#checkbox-use-current-location').is(':checked') ) {
        txt_address = '';
      } else {
        if ($("#province").val().length > 0) {
          txt_address += ' ' + $("#province option:selected").text();
        }
        if ($("#amphur").val().length > 0) {
          txt_address += ' ' + $("#amphur option:selected").text();
        }
        if ($("#district").val().length > 0) {
          txt_address += ' ' + $("#district option:selected").text();
        }
        if ($("#zipcode").val().length > 0) {
          txt_address += ' ' + $("#zipcode option:selected").text();
        }

        //console.log(txt_address);

        $('#address').val(txt_address);
      }
      return true;
   });

   $('.btn-step').click(function(){
    var index = $(this).data('index');
    $('#navbar-postcar li:eq('+index+') a').click();
    return false;
   });

   $('#navbar-postcar a').click(function (e) {
	 // alert('tab');  
     e.preventDefault()
     // $(this).tab('show');
   });
   //
   $("#btn1").click(function(){
	   
	   	if($("#suggest").val().length > 2) {
			// console.log('suggestt');
	   		$('#navbar-postcar a[href="#tab-basic-infomation"]').tab('show') // Select tab by name
   	   	}else if($("#year option:selected").val()!="" && $("#make option:selected").val() !="" && $("#model option:selected").val() !="") {
   	   		$('#navbar-postcar a[href="#tab-basic-infomation"]').tab('show') // Select tab by name
			// console.log($("#year option:selected").val()+' :: '+$("#make option:selected").val()+'  :: '+$("#model option:selected").val());
   	   	}
   	   // $("#tab-basic-infomation").tab('show');
   });
   $("#btn2").click(function(){
		$('#navbar-postcar a[href="#tab-select-car"]').tab('show') // Select tab by name
   });
   $("#btn3").click(function(){
	   if($("#mileage").val()!='' && $("#submit-price").val()!='') {
		   if($("#mileage").val().length > 2 && $("#submit-price").val().length > 2) {
		   		$('#navbar-postcar a[href="#tab-address"]').tab('show') // Select tab by name
		   }
	   }
   });
   $("#btn4").click(function(){
	   $('#navbar-postcar a[href="#tab-basic-infomation"]').tab('show') // Select tab by name
   	   // $("#tab-basic-infomation").tab('show');
   });
   $("#btn5").click(function(){
	   if($("#phone").val()!='') {
		   if($("#phone").val().length > 7) {
	   			$('#navbar-postcar a[href="#tab-image"]').tab('show') // Select tab by name
   			}
		}
   	   // $("#tab-basic-infomation").tab('show');
   });
   $("#btn6").click(function(){
	   $('#navbar-postcar a[href="#tab-address"]').tab('show') // Select tab by name
   	   // $("#tab-basic-infomation").tab('show');
   });
   $("#btn7").click(function(){
	   
	   	if ($("span.preview").length > 0) {
			
		   $('#navbar-postcar a[href="#tab-preview"]').tab('show') // Select tab by name
	   	   // $("#tab-basic-infomation").tab('show');
	   
		   initPreview();
   		}
	   
   });
   
   $("#btn8").click(function(){
	   $('#navbar-postcar a[href="#tab-image"]').tab('show') // Select tab by name
   	   // $("#tab-basic-infomation").tab('show');
   });
   
   
   function postNewCar(id){
		clearData();
        console.log(id);
        var post_id = id;
        // get information
        $.get( "/post/detail/"+post_id, function( data ) {
            if (!data.error) {
				$gallery = data.gallery;
				$lang = data.lang;
				post_by = data.post_by;
				$province = data.province;
				// console.log(data.post_by);
                data = data.post;
                // console.log(data);
                $('#hidden_post_id').val(data.id);
                $('#hidden_year_id').val(data.year_id);
                $('#hidden_make_id').val(data.make_id);
                $('#hidden_model_id').val(data.model_id);
                $('#hidden_submodel_id').val(data.submodel_id);
                $('#hidden_fuel_id').val(data.fuel_id);
                $('#hidden_gear_id').val(data.gear_id);
                $('#hidden_engine_id').val(data.engine_id);
                $('#hidden_province_id').val(data.province_id);
                $('#hidden_amphur_id').val(data.amphur_id);
                $('#hidden_district_id').val(data.district_id);
                $('#hidden_zipcode_id').val(data.zipcode_id);
                $('#hidden_latitude').val(data.latitude);
                $('#hidden_longitude').val(data.longitude);
                $('#hidden_address').val($province);
                $('#hidden_suggest').val(data.suggest);

                $('#hidden_price').val(data.price);
                $('#hidden_mileage').val(data.mileage);
                $('#hidden_thumbnail').val(data.thumbnail);
                $('#hidden_user_info_addr').val(data.user_info_addr);

				
                province_id = (post_by.province_id!=0) ? post_by.province_id : data.province_id;
                amphur_id =  (post_by.amphur_id!=0) ? post_by.amphur_id : data.amphur_id;
                district_id = (post_by.district_id!=0) ? post_by.district_id : data.district_id;
                zipcode_id = (post_by.zipcode_id!=0) ? post_by.zipcode_id : data.zipcode_id;

                if (data.latitude != '' && data.latitude != '0.0000000000000') {
                  latitude = data.latitude;
                }
                if (data.longitude != '' && data.longitude != '0.0000000000000') {
                  longitude = data.longitude;
                }

                year_id = data.year_id;
                make_id = data.make_id;
                model_id = data.model_id;
                submodel_id = data.submodel_id;
                fuel_id = data.fuel_id;
                gear_id = data.gear_id;
                engine_id = data.engine_id;
                color_id = data.color_id;
				
				$("#submit-price").val(data.price);
				$("#mileage").val(data.mileage);
				$("#phone").val(post_by.phone);
				$("#line_id").val(data.line_id);
				
				if(data.price) {
					$("#submit-price").parent().next("small").hide();
				}
				if(data.mileage) {
					$("#mileage").parent().next("small").hide();
				}
				if(post_by.phone) {
					$("#phone").parent().next("small").hide();
				}
				
				$.each($lang,function(k,v){
					if(v.language_id==1) {
						$("#description_en").text(v.description);
					}else {
						$("#description_th").text(v.description);
					}
				});
				// $("#description_en").tex();
// 				$("#description_en").tex('');

                initAddress();
                initCar();
				
				// $("#preview-gallery").empty();
				// bind parts data
				// console.log('parts '+ data.parts_ids);
				$("input[name='part[]']").each(function(){
					var val = $(this).val();
					if(data.parts_ids!=null) {
						if(data.parts_ids.indexOf(val) > -1) {
							// console.log('contains');
							// $(this).attr('checked');
							$(this).prop('checked', true);
							// $(this).checked = true;
						}
					}
					
				});
				$.each($gallery,function (i,v) {

							$html = '<div class="col-xs-4 in" style="padding-bottom:24px;padding-left:15px;padding-right:19px;" id="gal_id_'+v.id+'" style="cursor: move">'+
							'<div data-role="'+v.id+'">'+
					          '<span class="preview">'+
							        '<img src="/uploaded/post/'+v.post_id+'/gallery/160x100-'+v.name+'" style="width:111px;height:73px;">'+
					          '</span>'+
					          '<span class="uploadbtn" style="width:110px">'+
					          	'<button class="btn btn-danger btn-remove" data-type="get" data-url="/post/delete-gallery/'+v.post_id+'/'+v.id+'"><i class="glyphicon glyphicon-remove"></i></button>'+
					          '</span>'+
							'</div>'+
							'</div>';
							
							$("div.files").append($html);
				});
				
				$('#modal-post-form').modal('show');
            } else {
                alert('can not add new post!');
            }
        });
   }
   
   
   
//    $("#post-form").sisyphus({
//    	timeout: 10,
// 	autoRelease: true,
// 	onSave: function() {
//
//         var txt_address = '';
//         if($('#checkbox-use-current-location').is(':checked') ) {
//           txt_address = '';
//         } else {
//           if ($("#province").val().length > 0) {
//             txt_address += ' ' + $("#province option:selected").text();
//           }
//           if ($("#amphur").val().length > 0) {
//             txt_address += ' ' + $("#amphur option:selected").text();
//           }
//           if ($("#district").val().length > 0) {
//             txt_address += ' ' + $("#district option:selected").text();
//           }
//
//           $('#hidden_address').val(txt_address);
//         }
//
//         $.post( '/post/update',$('#post-form').serialize(), function( data ) {
//           if (!data.error) {
//             // $('#hidden_post_id').val(data.id);
//    			       //$(".alert").show('fade');
//    			       //setTimeout(hideModal,3000);
//    			 // $("#listingID").text($("#hidden_post_id").val());
// //  			 if($("#hidden_first_post").val() !='' && $("#hidden_first_post").val()=='first_post') {
// //  				 $("#success_message").text("Your listing has been successfully submitted and in the queue for approval.");
// //  			 }
// //              $('.thankyou-page').show();
//           } else {
//             // alert('can not add new post!');
//           }
//         });
//
// 		// $("#post-form").submit();
// 	}
//    });
   
});