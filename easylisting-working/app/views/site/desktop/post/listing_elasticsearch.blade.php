@extends('site._layouts.easycar')

@section('head')
{{ HTML::style('css/plugins/jquery-slider/jquery.slider.min.css') }}
{{ HTML::style('css/plugins/owl-carousel/owl.carousel.css') }}
{{-- HTML::style('css/plugins/owl-carousel/owl.theme.css') --}}
{{ HTML::style('css/plugins/jgrowl/jquery.jgrowl.min.css') }}
{{ HTML::style('css/_site/list.css') }}
@stop

@section('content')
        <!-- Breadcrumb -->
        <div class="container">
            <ol class="breadcrumb">
                <li><a href="{{ URL::to(App::getLocale().'/') }}">Home</a></li>
                <li class="active">Cars Listing</li>
            </ol>
        </div>
        <!-- end Breadcrumb -->
		
        <div class="container">
            <div class="col-lg-8 col-md-8 col-sm-12">
                <div class="row">
                    <h1 style="margin: 0 0 20px 0;">Find my car</h1>
                    <div class="col-sm-12">
                        <div class="row">
                        @include('site.car.advance-search-elasticsearch')
                        </div>  
                    </div>
                    <div class="col-sm-12">
                        <div class="row">
                            @include('site.car.list_elasticsearch')
                        </div> 
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="row">
                    <div class="col-sm-12 col-xs-12">

                        <div class="col-lg-12 col-md-12 col-sm-6">
                            @include('site.widgets.howto')
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-6">
                            @include('site.widgets.feature-car')
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-6">
                            @include('site.widgets.latest-car')
                        </div>
                    </div>
                    <!-- <div class="col-sm-12" style="background:#ddd">22</div>  -->
                </div>
            </div>
        </div><!-- /.container -->
@stop

@section('footer')
{{ HTML::script('js/plugins/iCheck/icheck.min.js') }}
{{ HTML::script('js/plugins/jshashtable-2.1_src.js') }}
{{ HTML::script('js/plugins/jquery.numberformatter-1.2.3.js') }}
{{ HTML::script('js/plugins/simplae-javascript-templating.min.js') }}
{{ HTML::script('js/plugins/jquery.dependclass.min.js') }}
{{ HTML::script('js/plugins/draggable.min.js') }}
{{ HTML::script('js/plugins/jquery.slider.min.js') }}
{{ HTML::script('js/plugins/owl-carousel/owl.carousel.min.js') }}
{{ HTML::script('js/plugins/jgrowl/jquery.jgrowl.min.js') }}
{{ HTML::script('js/_site/list.js') }}
<script type="text/javascript">
$(function(){
    
    $('#btn-information').popover({
        trigger: 'hover'
    });

    var version_api = 'v2';

    function loadCarMake(dropdown, callback) {
        clearDropdownMake()
        $.getJSON("/api/"+version_api+"/car/make", {'year':$('#year').val()}, function(res){
            var html = '';
            if(!res.error) {
                $.each(res.makes, function(k,v){ html += '<option value="'+v.make+'" data-content="'+v.make+'<small class=\'pull-right\'>( '+v.avaliable+' )</small>">'+v.make+'</option>'; });
                dropdown.append(html).selectpicker("refresh");
                if(callback) callback();
            }
        });
    }

    function loadCarModel(dropdown, callback){
        clearDropdownModel();
        $.getJSON("/api/"+version_api+"/car/model", {'year':$('#year').val(), 'make':$('#make').val()}, function(res){
            var html = '';
            if(!res.error) {
                $.each(res.models, function(k,v){ html += '<option value="'+v.model+'" data-content="'+v.model+'<small class=\'pull-right\'>( '+v.avaliable+' )</small>">'+v.model+'</option>'; });
                dropdown.append(html).selectpicker("refresh");
                if(callback) callback();
            }
        });
    }

    function loadCarColor(dropdown, callback){
        clearDropdownColor();
        $.getJSON("/api/"+version_api+"/car/color", {'make':$('#make').val(), 'model':$('#model').val()}, function(res){
            var html = '';
            if(!res.error) {
                $.each(res.colors, function(k,v){ html += '<option value="'+v.id+'" data-content="<span style=\'width:30px;height:10px;display:inline-block;background:#'+v.colorHEX+';maring-right:10px;\'></span> <span>'+v.colorName+'</span>">'+v.colorName+'</option>'; });
                dropdown.append(html).selectpicker("refresh");
                if(callback) callback();
            }
        });
    }

    function loadCarYear(dropdown, callback){
        clearDropdownYear();
        $.getJSON("/api/"+version_api+"/car/year", function(res){
            var html = '';
            if(!res.error) {
                $.each(res.year, function(k,v){ html += '<option value="'+v+'">'+v+'</option>'; });
                dropdown.append(html).selectpicker("refresh");
                if(callback) callback();
            }
        });
    }

    function loadCarFuel(dropdown, callback){
        clearDropdownFuel();
        $.getJSON("/api/"+version_api+"/car/fuel", function(res){
            var html = '';
            if(!res.error) {
                $.each(res.fuels, function(k,v){ html += '<option value="'+v+'">'+v+'</option>'; });
                dropdown.append(html).selectpicker("refresh");
                if(callback) callback();
            }
        });
    }

    function loadCarTransmission(dropdown, callback){
        clearDropdownTransmission();
        $.getJSON("/api/"+version_api+"/car/transmission", function(res){
            var html = '';
            if(!res.error) {
                $.each(res.transmission, function(k,v){ html += '<option value="'+v+'">'+v+'</option>'; });
                dropdown.append(html).selectpicker("refresh");
                if(callback) callback();
            }
        });
    }

    function loadCarDoor(dropdown, callback){
        clearDropdownDoor();
        $.getJSON("/api/"+version_api+"/car/door", function(res){
            var html = '';
            if(!res.error) {
                $.each(res.door, function(k,v){ html += '<option value="'+v+'">'+v+'</option>'; });
                dropdown.append(html).selectpicker("refresh");
                if(callback) callback();
            }
        });
    }

    function loadCarBody(dropdown, callback){
        clearDropdownBody();
        $.getJSON("/api/"+version_api+"/car/body", function(res){
            var html = '';
            if(!res.error) {
                $.each(res.body, function(k,v){ html += '<option value="'+v+'">'+v+'</option>'; });
                dropdown.append(html).selectpicker("refresh");
                if(callback) callback();
            }
        });
    }

    function loadProvince(dropdown, callback){

      clearDropdownProvince();
      $.getJSON("/api/v1/address/province", function(res){
          var html = '';
          if(!res.error) {
              $.each(res.provinces, function(k,v){html += '<option value="'+v.id+'">'+v.province+'</option>'; });
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

    function clearDropdownMake() {dropdownMake.empty().append('<option value="">Make</option>').selectpicker("refresh");}
    function clearDropdownModel() {dropdownModel.empty().append('<option value="">Model</option>').selectpicker("refresh");}
    function clearDropdownColor() {dropdownColor.empty().append('<option value="">Color</option>').selectpicker("refresh");}
    function clearDropdownFuel() {dropdownFuel.empty().append('<option value="">Fuel</option>').selectpicker("refresh");}
    function clearDropdownYear() {dropdownYear.empty().append('<option value="">Year</option>').selectpicker("refresh");}
    function clearDropdownTransmission() {dropdownTransmission.empty().append('<option value="">Transmission</option>').selectpicker("refresh");}
    function clearDropdownDoor() {dropdownDoor.empty().append('<option value="">Door</option>').selectpicker("refresh");}
    function clearDropdownBody() {dropdownBody.empty().append('<option value="">Body</option>').selectpicker("refresh");}

    function clearDropdownProvince() {dropdownProvince.empty().append('<option value="">Province</option>').selectpicker("refresh");}
    function clearDropdownAmphur() {dropdownAmphur.empty().append('<option value="">Amphur</option>').selectpicker("refresh");}
    function clearDropdownDistrict() {dropdownDistrict.empty().append('<option value="">Distance</option>').selectpicker("refresh");}
    function clearDropdownZipcode() {dropdownZipcode.empty().append('<option value="">Zipcode</option>').selectpicker("refresh");}

    function clearAllDropdown(){
        clearDropdownMake();
        clearDropdownModel();
        clearDropdownColor();
        clearDropdownYear();
        clearDropdownFuel();
        clearDropdownTransmission();
        clearDropdownDoor();
        clearDropdownBody();

        clearDropdownProvince();
        clearDropdownAmphur();
        clearDropdownDistrict();
        clearDropdownZipcode();
    }
	
	var queryStringToJSON = function (url) {
	    if (url === '')
	        return '';
	    var pairs = (url || location.search).slice(1).split('&');
	    var result = {};
	    for (var idx in pairs) {
	        var pair = pairs[idx].split('=');
	        if (!!pair[0])
	            result[pair[0].toLowerCase()] = decodeURIComponent(pair[1] || '');
	    }
	    return result;
	}
	
	function getUrlVars()
	{
	    var vars = [], hash;
	    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('#');
		// alert(hashes);
		return hashes[0];
		// alert(hashes[0]);
// 	    for(var i = 0; i < hashes.length; i++)
// 	    {
// 	        hash = hashes[i].split('=');
// 	        vars.push(hash[0]);
// 	        vars[hash[0]] = hash[1];
// 	    }
// 	    return vars;
	}
	$("#save_search").click(function(){
		// alert(getUrlVars());
		alert('click');
		// '{{ $total }}'
		// '{{ $result_ids }}'
		var data = getUrlVars();
		console.log(data);
		if (data.indexOf("/listing") >= 0) {
			alert('Please choose your car first');
		}else {
			// alert(data);
			console.log(data);
			// $.post( "{{ URL::to(App::getLocale().'/save-search') }}", data)
// 			.done(function( data ) {
// 				var json = $.parseJSON(data);
// 				$.jGrowl(json.status);
// 	        },"json");
		}
		return false;
	});
    var dropdownYear = $('#year');
    var dropdownMake = $('#make');
    var dropdownModel = $('#model');
    var dropdownColor = $('#color');
    var dropdownFuel = $('#fual');
    var dropdownTransmission = $('#gear');
    var dropdownDoor = $('#number_of_door');
    var dropdownBody = $('#body_type');

    var dropdownProvince = $('#province');
    var dropdownAmphur = $('#amphur');
    var dropdownDistrict = $('#district');
    var dropdownZipcode = $('#zipcode');

    clearAllDropdown();

    loadCarMake(dropdownMake);
    dropdownMake.change(function(){
        if ($(this).val() != '') {
            loadCarModel(dropdownModel);
        } else {
            clearDropdownModel();
        }
    });
    dropdownModel.change(function(){
         if ($(this).val() != '') {
            loadCarColor(dropdownColor);
        } else {
            clearDropdownColor();
        }       
    });

    loadCarYear(dropdownYear);
    loadCarFuel(dropdownFuel);
    loadCarTransmission(dropdownTransmission);
    loadCarDoor(dropdownDoor);
    loadCarBody(dropdownBody);

    function populateData(callback){
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

    populateData();
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

    $('#btn-submit').click(function(){

        // $.each(params, function(i,param){
        //     $('<input />').attr('type', 'hidden')
        //         .attr('name', param.name)
        //         .attr('value', param.value)
        //         .appendTo('#form-advance');
        // });

        $('<input />').attr('type', 'hidden')
                .attr('name', 'order')
                .attr('value', $('#order').val())
                .appendTo('#form-advance');
        $('<input />').attr('type', 'hidden')
                .attr('name', 'sortby')
                .attr('value', $('#sortby').val())
                .appendTo('#form-advance');

        return true;
    });

});
</script>
@stop
