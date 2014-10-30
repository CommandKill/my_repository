@extends('site..desktop._layouts.index')

@section('head')
{{ HTML::style('css/plugins/bootstrap-select/bootstrap-select.min.css') }}
{{ HTML::style('css/dropdown.css') }}
<style>
#map-canvas {
  height: 200px;
  width:475px;
  margin: 0px;
  padding: 0px
}
.fancy {
  margin: 20px 0 40px 0;
}
.fancy span:before , .fancy span:after{
  width:220px;
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
  height: 32px;
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
@stop

@section('content')

<div class="container">
    <div class="row page">
        <div class="col-xs-3">
            @include('site.desktop._partials.member_nav')
        </div>
        <div class="col-xs-9">
          <form role="form" id="frmProfile" method="POST" action="{{ URL::to(App::getLocale().'/address') }}">
          <input type="hidden" name="id" id="id" value="{{ $member->id }}"> 

          <section id="profile-address">
              <input type="hidden" id="lat" name="lat" value='{{ $member->latitude or '' }}'>
              <input type="hidden" id="lng" name="lng" value='{{ $member->longitude or '' }}'>
              <input type="hidden" id="address" name="address" value='{{ $member->address or '' }}'>
              <header><h1>Address</h1></header>
              <div class="row">
                <div class="col-md-6">

                  {{ Notification::showAll() }}

                  <div class="form-group">
                    <label for="checkbox-use-current-location"><input type="checkbox" name="use_current_location" id="checkbox-use-current-location" value=""/> <span class="link-arrow geo-location">Use current location</span></label> 
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
                </div>
              </div>
              <p class="fancy" style="width:475px;"><span>OR</span></p>
              <div class="row" id="address-detail-area"> 
                 <div class="col-xs-8">
                    <div class="form-group">
                      <select name="province" id="province" class="selectpicker">
                            <option value="" >Province</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="amphur" id="amphur">
                            <option value="" >District</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="district" id="district">
                            <option value="" >Subdistrict</option>
                        </select>
                    </div>
                    <!-- <div class="form-group">
                        <select name="zipcode" id="zipcode">
                            <option value="" >Select a zipcode</option>
                        </select>
                    </div> -->
                  <div class="form-group clearfix">
                       <button type="submit" class="btn submit-btn" id="account-submit">Update</button>
                   </div>
                 </div>
              </div>
          </section>
          </form>

        </div>
    </div>
</div>
@stop

@section('footer')
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places"></script>
{{ HTML::script('js/plugins/bootstrap_select/bootstrap-select.min.js') }}
<script type='text/javascript'>
$(function(){
    // -------------------------------------------------------
    // Dropdown style
    // -------------------------------------------------------
    var select = $('select');
    if (select.length > 0 ){
        select.selectpicker({dropupAuto:false});
    }

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

  var _latitude = 13.6840189;
  var _longitude = 100.61550489999999;
  var map;
  var marker;
  var infowindow;
  var inputLat = $('#lat');
  var inputLng = $('#lng');

  if (inputLat.val() != '' && inputLat.val() != '0.0000000000000') {
    _latitude = inputLat.val();
  }
  if (inputLng.val() != '' && inputLng.val() != '0.0000000000000') {
    _longitude = inputLng.val();
  }

  function initialize(latitude,longitude) {
    var mapOptions = {
      center: new google.maps.LatLng(latitude, longitude),
      zoom: 15
    };
    map = new google.maps.Map(document.getElementById('map-canvas'),
      mapOptions);

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
      //$('#address').val(place.name + ', ' + address);
      infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
      infowindow.open(map, marker);

      inputLat.val(marker.position.k);
      inputLng.val(marker.position.B);
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
       inputLat.val(marker.position.k);
       inputLng.val(marker.position.B);
    });

    inputLat.val(marker.position.k);
    inputLng.val(marker.position.B);
  }

  google.maps.event.addDomListener(window, 'load', initialize(_latitude,_longitude));

  function onGeoSuccess(position){
      inputLat.val(position.coords.latitude);
      inputLng.val(position.coords.longitude);
      var mapCenter = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
      marker.setPosition(mapCenter);
      map.setCenter(mapCenter);
      map.setZoom(17);
  }

  $('#checkbox-use-current-location').on('change', function(){
    if($(this).is(':checked') ) {
      if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(onGeoSuccess);
      } else {
          error('Geo Location is not supported');
      }
      //$('#map-canvas').show();
    } else {
      //$('#map-canvas').hide();
    }
  });

  // $('.geo-location').on("click", function(){
  //   if (navigator.geolocation) {
  //       navigator.geolocation.getCurrentPosition(onGeoSuccess);
  //   } else {
  //       error('Geo Location is not supported');
  //   }
  //   //return false;
  // });



   var province_id = '{{ $member->province_id }}';
   var amphur_id = '{{ $member->amphur_id }}';
   var district_id = '{{ $member->district_id }}';
   var zipcode_id = '{{ $member->zipcode_id }}';
  
  
  $.get( "/api/v1/address/province/", function( data ) {
    $dropdown = $('#province');
    $.each( data.provinces, function( key, val ) {
      if(province_id==val.id) {
        $dropdown.append($('<option value="" selected></option>').val(val.id).html(val.province));
      }else {
        $dropdown.append($('<option></option>').val(val.id).html(val.province));
      }
    });
    $dropdown.selectpicker("refresh").change();  
  }, "json" );

   $("#province").change(function(){
      $dropdown = $('#amphur');
      $dropdown.empty().append($('<option value="" selected></option>').html("District"));
      if ($(this).val() != "") {
        console.log($(this).val());
        $.get( "/api/v1/address/amphur/"+$(this).val(), function( data ) {
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
      $dropdown = $('#district');
      $dropdown.empty().append($('<option value="" selected></option>').html("Subdistrict"));
      if ($(this).val() != "") {
        $.get( "/api/v1/address/district/"+$(this).val(), function( data ) {
          $.each( data.districts, function( key, val ) {
            if(district_id==val.id) {
              $dropdown.append($('<option selected></option>').val(val.id).html(val.district));
            }else {
              $dropdown.append($('<option></option>').val(val.id).html(val.district));
            }
          });
          $dropdown.selectpicker("refresh").change(); 
        }, "json" );
      }
   });
   
   // $("#district").change(function(){
   //    $dropdown = $('#zipcode');
   //    $dropdown.empty().append($('<option value="" selected></option>').html("Select zipcode"));
   //    if ($(this).val() != "") {
   //      $.get( "/api/v1/address/zipcode/"+$(this).val(), function( data ) {
   //
   //        $.each( data.zipcodes, function( key, val ) {
   //
   //          if(zipcode_id==val.id) {
   //              $dropdown.append($('<option selected></option>').val(val.id).html(val.zipcode));
   //          }else {
   //            $dropdown.append($('<option></option>').val(val.id).html(val.zipcode));
   //          }
   //      });
   //      $dropdown.selectpicker("refresh").change();
   //     }, "json" );
   //    }
   // });


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
});
</script>
@stop
