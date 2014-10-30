@extends('site._layouts.easycar')

@section('head')
{{ HTML::style('css/_site/site.css') }}
{{ HTML::style('css/_site/create_member.css') }}
@stop

@section('content')
<div class="container">
  <ol class="breadcrumb">
  <li><a href="{{ URL::to(App::getLocale().'/') }}">Home</a></li>
  <li><a href="{{ URL::to(App::getLocale().'/my-garage') }}">My Garage</a></li>
  <li class="active">Create New</li>
  </ol>
</div>
<div class="container">
    <header><h1>Add Your Car</h1></header>
    <form role="form" method="POST" id="frmSubmit" class="form-submit no-padding form-search" 
    style="border: 0;box-shadow:none;" action="{{ URL::to(App::getLocale().'/my-garage/update-two') }}">
      <div class="row">
        
        <div class="col-lg-5 col-md-5 col-sm-6 col-lg-offset-2 col-md-offset-2 col-sm-offset-1">


          <section id="profile-address">
          <input type="hidden" name="amphur_hidden" id="amphur_hidden" value="{{ $content->amphur_id or 0 }}" />
          <input type="hidden" name="province_hidden" id="province_hidden" value="{{ $content->province_id or 0}}" />
          <input type="hidden" name="district_hidden" id="district_hidden" value="{{ $content->district_id or 0 }}" />
          <input type="hidden" name="zipcode_hidden" id="zipcode_hidden" value="{{ $content->zipcode_id or 0 }}" />
          <input type="hidden" name="id" id="id" value="{{ $id }}">

          <header><h2>Address Information</h2></header>
          <div class="row">
             <div class="col-md-12">
              <div class="form-group">
                <div class="checkbox switch" id="agent-switch" data-agent-state="is-agent">
                     <label>
                         <b>Use your profile address?</b> <input type="checkbox" @if($content->user_info_addr==1) checked @endif name="same_address" id="same_address" value="1">
                     </label>
                 </div>
              </div>
                 <div class="form-group">
                     <label>Place on map</label> <span class="link-arrow geo-location">Get My Position</span>
                     <div id="submit-map" style="width: 100%;height: 220px"></div>
                 </div><!-- /.form group -->

             </div>
             <div class="col-md-6 col-sm-6">
                 <div class="form-group">
                     <label>Latitude</label>
                     <div class="input-group" style="width: 100%;">
                         <input minlength="2" style="background:none; padding:6px 12px 6px 12px;" class="form-control col-md-6" id="lat" name="lat" placeholder="Latitude" type="text" value='{{ $content->latitude or '' }}'>
                     </div>
                 </div>
             </div>
             <div class="col-md-6 col-sm-6">
                 <div class="form-group">
                     <label>Longitude</label>
                     <div class="input-group" style="width: 100%;">
                         <input minlength="2" style="background:none; padding:6px 12px 6px 12px;"  class="form-control col-md-6" id="lng" name="lng" placeholder="Longitude" type="text" value='{{ $content->longitude or '' }}'>
                     </div>
                 </div>
             </div>
             <br/>
          </div>
          <div class="row">
              <div class="col-md-6 col-sm-6">
                  <div class="form-group">
                      <label for="address">Your address</label>
                      <textarea class="form-control" id="address" rows="12" name="address">{{ $content->address }}</textarea>
                  </div>
              </div>
              <div class="col-md-6 col-sm-6">
                  <div class="form-group">
                      <label for="province">Province</label>
                      <select name="province" id="province" data-live-search="true">
                          <option value=""></option>
                      </select>
                  </div>
                  <div class="form-group">
                      <select name="amphur" id="amphur" data-live-search="true">
                          <option value="">-</option>
                      </select>
                  </div>
                  <div class="form-group">
                      <select name="district" id="district" data-live-search="true">
                          <option value="">-</option>
                      </select>
                  </div>
                  <div class="form-group">
                      <label for="zipcode">Zip code</label>
                      <select name="zipcode" id="zipcode" data-live-search="true">
                          <option value="">-</option>
                      </select>
                  </div>
              </div>
          </div>
          </section>


        </div>
        <div class="col-lg-3 col-md-3 col-sm-4">
          <div class="submit-step">
              <figure class="step-number">2</figure>
              <div class="description">
                  <h4>Add your Address</h4>
                  <p>Choose from a packages one that suit your need. If you have chosen package before,
                      it will be automatically selected.
                  </p>
              </div>
              <button type="submit" id="formSubmitButton" class="btn btn-default btn-sm btn-block search-btn">Go to Step 3</button>
          </div>
        </div>

      </div>
    </form>
</div>
@stop

@section('footer')
{{ HTML::script('js/plugins/iCheck/icheck.min.js') }}

<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script src="{{ asset('js/plugins/markerwithlabel_packed.js') }}"></script>
<script src="{{ asset('js/plugins/custom-map.js') }}"></script>
<script type="text/javascript">
$(function(){
  var _latitude = 48.87;
  var _longitude = 2.29;

  function success(position) 
  {
      $('#lat').val(position.coords.latitude);
      $('#lng').val(position.coords.longitude);

      initSubmitMap(position.coords.latitude, position.coords.longitude);
  }

  $('.geo-location').on("click", function() 
  {
      if (navigator.geolocation) {
          $('#submit-map').addClass('fade-map');
          navigator.geolocation.getCurrentPosition(success);
      } else {
          error('Geo Location is not supported');
      }
  });

  if ($('#lat').val() != '0.0000000000000') {
    _latitude = $('#lat').val();
  } else {
    $('.geo-location').click();
  }

  if ($('#lng').val() != '0.0000000000000') {
    _longitude = $('#lng').val();
  } else {
  }

  google.maps.event.addDomListener(window, 'load', initSubmitMap(_latitude,_longitude));
  function initSubmitMap(_latitude,_longitude){
      var mapCenter = new google.maps.LatLng(_latitude,_longitude);
      var mapOptions = {
          zoom: 15,
          center: mapCenter,
          disableDefaultUI: false,
          //scrollwheel: false,
          // styles: mapStyles
      };
      var mapElement = document.getElementById('submit-map');
      var map = new google.maps.Map(mapElement, mapOptions);
      var marker = new MarkerWithLabel({
          position: mapCenter,
          map: map,
          icon: '/img/marker.png',
          labelAnchor: new google.maps.Point(50, 0),
          draggable: true
      });
      $('#submit-map').removeClass('fade-map');

      google.maps.event.addListener(marker, 'dragend', function(e) {
         console.log(marker.position);
         $('#lat').val(marker.position.k);
         $('#lng').val(marker.position.A);
      })
  }

  function loadProvince(dropdown, callback){
      clearDropdownProvince();
      $.getJSON("/api/v1/address/province", function(res){
          var html = '';
          if(!res.error) {
              $.each(res.provinces, function(k,v){ html += '<option value="'+v.id+'">'+v.province+'</option>'; });
              dropdown.append(html).selectpicker("refresh");
              if(callback) callback();
          }
      });
  }

  function loadAmphur(dropdown, callback){
      clearDropdownAmphur();
      $.getJSON("/api/v1/address/amphur/"+$('#province').val(), function(res){
          var html = '';
          if(!res.error) {
              $.each(res.amphurs, function(k,v){ html += '<option value="'+v.id+'">'+v.amphur+'</option>'; });
              dropdown.append(html).selectpicker("refresh");
              if(callback) callback();
          }
      });
  }

  function loadDistrict(dropdown, callback){
      clearDropdownDistrict();
      $.getJSON("/api/v1/address/district/"+$('#amphur').val(), function(res){
          var html = '';
          if(!res.error) {
              $.each(res.districts, function(k,v){ html += '<option value="'+v.id+'">'+v.district+'</option>'; });
              dropdown.append(html).selectpicker("refresh");
              if(callback) callback();
          }
      });
  }

  function loadZipcode(dropdown, callback){
      clearDropdownZipcode();
      $.getJSON("/api/v1/address/zipcode/"+$('#district').val(), function(res){
          var html = '';
          if(!res.error) {
              $.each(res.zipcodes, function(k,v){ html += '<option value="'+v.id+'">'+v.zipcode+'</option>'; });
              dropdown.append(html).selectpicker("refresh");
              if(callback) callback();
          }
      });
  }

  function clearDropdownProvince() {dropdownProvince.empty().append('<option value="">Province</option>').selectpicker("refresh");}
  function clearDropdownAmphur() {dropdownAmphur.empty().append('<option value="">Amphur</option>').selectpicker("refresh");}
  function clearDropdownDistrict() {dropdownDistrict.empty().append('<option value="">District</option>').selectpicker("refresh");}
  function clearDropdownZipcode() {dropdownZipcode.empty().append('<option value="">Zipcode</option>').selectpicker("refresh");}

  function clearAllDropdown(){
      clearDropdownProvince();
      clearDropdownAmphur();
      clearDropdownDistrict();
      clearDropdownZipcode();
  }

  var dropdownProvince = $('#province');
  var dropdownAmphur = $('#amphur');
  var dropdownDistrict = $('#district');
  var dropdownZipcode = $('#zipcode');

  clearAllDropdown();

  function initData(callback){
      loadProvince(dropdownProvince, function(){

        dropdownProvince.selectpicker('val', $('#province_hidden').val());
        if ($('#province_hidden').val() > 0) {

          loadAmphur(dropdownAmphur, function(){
            dropdownAmphur.selectpicker('val', $('#amphur_hidden').val());
            if ($('#amphur_hidden').val() > 0) {

              loadDistrict(dropdownDistrict,function(){
                dropdownDistrict.selectpicker('val', $('#district_hidden').val());
                if ($('#district_hidden').val() > 0) {

                  loadZipcode(dropdownZipcode,function(){
                    dropdownZipcode.selectpicker('val', $('#zipcode_hidden').val());

                    if(callback) callback();
                  });

                }

              });

            }

          });
        }
      });
  }

  initData();
  //loadProvince(dropdownProvince);
  dropdownProvince.change(function(){
      if ($(this).val() != '') {
          loadAmphur(dropdownAmphur);
      } else {
          clearDropdownAmphur();
          clearDropdownDistrict();
          clearDropdownZipcode();
      }
  });

  dropdownAmphur.change(function(){
    if ($(this).val() != '') {
          loadDistrict(dropdownDistrict);
      } else {
          clearDropdownDistrict();
          clearDropdownZipcode();
      }
  });

  dropdownDistrict.change(function(){
    if ($(this).val() != '') {
          loadZipcode(dropdownZipcode);
      } else {
          clearDropdownZipcode();
      }
  });

});
</script>
@stop
