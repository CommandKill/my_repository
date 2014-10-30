var yearId = '';
var makeId = '';
var modelId = '';

var fuelId = '';
var engineId = '';
var gearId = '';
var doorId = '';
var mileageId = '';
var bodyId = '';
var colorId = '';

var inspected = '';

var q = '';

var dropdownYear;
var dropdownMake;
var dropdownModel;

var dropdownFuel;
var dropdownEngine;
var dropdownGear;
var dropdownDoor;
var dropdownMileage;
var dropdownBody;
var dropdownColor;

var buttonInspected;

var distance;
var hiddenDistance;
var hiddenInspected;

var dropdownProvince;
var dropdownAmphur;
var dropdownDistrict;

var minPrice = '';
var maxPrice = '';
var dropdownMinPrice;
var dropdownMaxPrice;

var holderAddress;
var cdSearchByLocation;

function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

/* Near Me Toggle */
function hide_nearme_dropdown() {
  setTimeout(function() {$('.nearme-option').hide();}, 200);
}

/* Select Distance */
function resetDistance() {
  $('.nearme-option li').removeClass('selected');
}

function initStyle()
{
    // dropdown style
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

  // New Search Box JS
  $('.bootstrap-select-searchbox input').attr('placeholder','Filter');
  $('.bootstrap-select-searchbox').append('<i class="fa fa-search"></i>');


  //iCheck
  if ($('.checkbox').length > 0) {
    $('input').iCheck();
  }

  if ($('.radio').length > 0) {
    $('input').iCheck();
  }

  $('.btn-toggle').click(function(){
    if($(this).hasClass('active')){
        $(this).removeClass('active');
    } else {
        $(this).addClass('active');
    }
    return false;
  });

  // Near Me Dropdown
  $("select#search-area-data").change(function() {
    var selected_option = "";
    $(this).each(function() {
      selected_option += $(this).find(":selected").val();
      //console.log(selected_option);
      if (selected_option === "near-me") {
        $('.group-nearme .fa').show();
        $('.option-current-location').removeClass("location-off");
      } else if (selected_option === "current-location") {
        $('.group-nearme .btn.selectpicker').addClass("use-current-location");
        $('.option-current-location').hide();
        $('.group-nearme .fa').hide();
        //$('.row-location').hide();
      } else {
        $('.group-nearme .btn.selectpicker').removeClass("use-current-location");
        $('.option-current-location').addClass("location-off");
        $('.group-nearme .fa').hide();
        $('.option-current-location').show();
        //$('.row-location').show();
      }
    });
  }).trigger( "change" );



  $('#btn-nearme').click(function(){
    $('.selectpicker').selectpicker('hide');
    $(this).next().toggle();
  });

  $('body').click(function() {
    //Hide the menus if visible
    $('.nearme-option').hide();
  });

  $('.nearme-option').click(function(event){
    event.stopPropagation();
  });

  $('.nearme-distance').click(function(){
    resetDistance();
    $(this).addClass('selected');
    $('.nearme-option').hide();
  });
}

function loadYear(callback) {
  var url = "/api/v1/car/year";
  $.getJSON(url , function( data ) {
    $.each( data.years, function( key, val ) {
     if(yearId == val.id) {
      dropdownYear.append($('<option selected></option>').val(val.id).html(val.year)); 
     }else {
      dropdownYear.append($('<option></option>').val(val.id).html(val.year)); 
     }
    });
    dropdownYear.selectpicker("refresh");//.change();
    if(callback) callback();
  });
}

function loadCarMake(callback) {
  var yearId = $('#year').val();
  var url = "/api/v1/car/make-group";
  // clear
  // dropdown.empty().append('<option value="">Make</option>').selectpicker("refresh");
  $.getJSON(url, {'year_id':yearId}, function(res){
      if(!res.error) {
        var option = '';
        $.each(res.makes, function (key, cat) {
            option += '<optgroup label='+key+'>';
            $.each(cat,function(i,item) {
              if (makeId == item.id) {
                option += '<option value="'+item.id+'" selected data-avaliable="'+item.avaliable+'" data-content="'+item.make+'<small class=\'pull-right\'>( '+item.avaliable+' )</small>">'+item.make+'</option>';
              } else {
                option += '<option value="'+item.id+'" data-avaliable="'+item.avaliable+'" data-content="'+item.make+'<small class=\'pull-right\'>( '+item.avaliable+' )</small>">'+item.make+'</option>';
              }
            });
            option += '</optgroup>';
        });
        dropdownMake.append(option).selectpicker("refresh");
        if(callback) callback();
      }
  });
}

// function clearDropdownModel()
// {
//   var defaultOption = $('#model option:first');
//   dropdownModel.empty().append(defaultOption).selectpicker("refresh");
// }

function loadCarModel(callback){
    var url = "/api/v1/car/model-group";
    dropdownModel.empty().append('<option value="">Model</option>').selectpicker("refresh");
    $.getJSON(url, {'make_id':makeId}, function(res){
        if(!res.error) {
          var option = '';
          $.each(res.models, function (key, cat) {
            option += '<optgroup label='+key+'>';
            $.each(cat,function(i,item) {
              if (modelId == item.id) {
                option += '<option value="'+item.id+'" data-avaliable="'+item.avaliable+'" selected data-content="'+item.model+'<small class=\'pull-right\'>( '+item.avaliable+' )</small>">'+item.model+'</option>';
              } else {
                option += '<option value="'+item.id+'" data-avaliable="'+item.avaliable+'" data-content="'+item.model+'<small class=\'pull-right\'>( '+item.avaliable+' )</small>">'+item.model+'</option>';
              }
            });
            option += '</optgroup>';
          });
          dropdownModel.append(option).selectpicker("refresh");
          if(callback) callback();
        }
    });
}

// var dropdownFuel;
// var dropdownEngine;
// var dropdownGear;
// var dropdownDoor;
// var dropdownMileage;
// var dropdownBody;
// var dropdownColor;

function loadFuel() {
  var url = "/api/v1/car/fuel";
  $.getJSON(url, function( data ) {
    $.each( data.fuels, function( key, val ) {
     if(fuelId == val.id) {
      dropdownFuel.append($('<option selected></option>').val(val.id).html(val.type)); 
     }else {
      dropdownFuel.append($('<option></option>').val(val.id).html(val.type)); 
     }
    });
    dropdownFuel.selectpicker("refresh");
  }); 
}

function loadGear() {
  var url = "/api/v1/car/gear";
  $.getJSON(url, function( data ) {
    $.each( data.gears, function( key, val ) {
     if(gearId == val.id) {
      dropdownGear.append($('<option selected></option>').val(val.id).html(val.gear)); 
     }else {
      dropdownGear.append($('<option></option>').val(val.id).html(val.gear)); 
     }
    });
    dropdownGear.selectpicker("refresh");
  }); 
}

function loadDoor() {

}

function loadMilage() {

}

function loadEngine() {
  var url = "/api/v1/car/engine";
  $.getJSON(url, function( data ) {
    $.each( data.engines, function( key, val ) {
     if(engineId == val.id) {
      dropdownEngine.append($('<option selected></option>').val(val.id).html(val.size)); 
     }else {
      dropdownEngine.append($('<option></option>').val(val.id).html(val.size)); 
     }
    });
    dropdownEngine.selectpicker("refresh");
  }); 
}

function loadBody() {
  var url = "/api/v1/car/body";
  $.getJSON(url, function( data ) {
    $.each( data.bodies, function( key, val ) {
     if(bodyId == val.id) {
      dropdownBody.append($('<option selected></option>').val(val.id).html(val.body)); 
     }else {
      dropdownBody.append($('<option></option>').val(val.id).html(val.body)); 
     }
    });
    dropdownBody.selectpicker("refresh");
  }); 
}

function loadColor() {
  var url = "/api/v1/car/color";
  $.getJSON(url, function( data ) {
    $.each( data.colors, function( key, val ) {
     if(colorId == val.id) {
      dropdownColor.append($('<option selected></option>').val(val.id).html(val.color)); 
     }else {
      dropdownColor.append($('<option></option>').val(val.id).html(val.color)); 
     }
    });
    dropdownColor.selectpicker("refresh");
  }); 
}


function loadProvince(callback)
{
  var url = "/api/v1/address/province/";
  $.getJSON(url, function( data ) {
    $.each( data.provinces, function( key, val ) {
      if(provinceId == val.id) {
        dropdownProvince.append($('<option value="" selected></option>').val(val.id).html(val.province));
      }else {
        dropdownProvince.append($('<option></option>').val(val.id).html(val.province));
      }
    });
    dropdownProvince.selectpicker("refresh");
    if(callback) callback();  
  });
}

function loadAmphur()
{
  var url = "/api/v1/address/amphur/"+provinceId;
  $.getJSON(url, function( data ) {
    $.each(data.amphurs, function( key, val ) {
      if(amphurId == val.id) {
        dropdownAmphur.append($('<option selected></option>').val(val.id).html(val.amphur));
      }else {
        dropdownAmphur.append($('<option></option>').val(val.id).html(val.amphur));
      }
    });
    dropdownAmphur.selectpicker("refresh").change();
  });
}

function loadDistrict()
{
  var url = "/api/v1/address/district/"+amphurId;
  $.getJSON(url, function( data ) {
    $.each( data.districts, function( key, val ) {
      if(districtId == val.id) {
        dropdownDistrict.append($('<option selected></option>').val(val.id).html(val.district));
      }else {
        dropdownDistrict.append($('<option></option>').val(val.id).html(val.district));
      }
    });
    dropdownDistrict.selectpicker("refresh").change(); 
  });
}

function resetForm(){
  dropdownMake.val('').selectpicker('refresh');
  dropdownModel.val('').selectpicker('refresh');
  dropdownYear.val('').selectpicker('refresh');
  dropdownProvince.val('').selectpicker('refresh');
  dropdownAmphur.val('').selectpicker('refresh');
  dropdownDistrict.val('').selectpicker('refresh');
  dropdownFuel.val('').selectpicker('refresh');
  dropdownGear.val('').selectpicker('refresh');
  dropdownColor.val('').selectpicker('refresh');
  dropdownEngine.val('').selectpicker('refresh');
  dropdownMinPrice.val('').selectpicker('refresh');
  dropdownMaxPrice.val('').selectpicker('refresh');
  dropdownBody.val('').selectpicker('refresh');
  dropdownDoor.val('').selectpicker('refresh');
  dropdownMileage.val('').selectpicker('refresh');
}

function checkInspected()
{
  if(buttonInspected.hasClass('active')) {
    hiddenInspected.val(0);
  } else {
    hiddenInspected.val(1);
  }
}

function onGeoSuccess(position){
  var lat = position.coords.latitude;
  var lng = position.coords.longitude;
  $('#lat').val(lat);
  $('#lon').val(lng);
  console.log(lat, lng);
}

$(function(){

  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(onGeoSuccess);
  } else {
    error('Geo Location is not supported');
  }

  inspected = getParameterByName('inspected');
  hiddenInspected = $('#inspected');
  buttonInspected = $('#btn-certified');
  
  buttonInspected.on('click', function(){
    if(buttonInspected.hasClass('active')) {
      hiddenInspected.val(0);
    } else {
      hiddenInspected.val(1);
    }
  });

  if(inspected == 1) {
    buttonInspected.addClass('active');
  } else {
    buttonInspected.removeClass('active')
  }


  // $('#reset_search').click(function(){
  //   resetForm();
  //   return false;
  // });

  initStyle();

  //$('#search-avaliable').text('0');

  // popover ? at inspected car button
  $('#btn-information').popover({trigger: 'hover'});

  dropdownMake = $('#make');
  dropdownModel = $('#model');
  dropdownYear = $('#year');

  dropdownProvince = $('#province');
  dropdownAmphur = $('#amphur');
  dropdownDistrict = $('#district');

  dropdownFuel = $('#fuel');
  dropdownGear = $('#gear');
  dropdownColor = $('#color');
  dropdownEngine = $('#engine');
  dropdownBody = $('#body');
  dropdownDoor = $('#door');
  dropdownMileage = $('#mileage');

  hiddenDistance = $('#distance');

  holderAddress = $('#holder-address');
  cdSearchByLocation = $('#search-by-your-location');

  dropdownMinPrice = $('#price-min');
  dropdownMaxPrice = $('#price-max');

  yearId = getParameterByName('year');
  makeId = getParameterByName('make');
  modelId = getParameterByName('model');
  distance = getParameterByName('distance_in_km');

  provinceId = getParameterByName('province');
  amphurId = getParameterByName('amphur');
  districtId = getParameterByName('district');

  minPrice = getParameterByName('min_price');
  maxPrice = getParameterByName('max_price');

  fuelId = getParameterByName('fuel');
  gearId = getParameterByName('gear');
  colorId = getParameterByName('color');
  engineId = getParameterByName('engine_size');
  bodyId = getParameterByName('body');
  doorId = getParameterByName('door');
  mileageId = getParameterByName('mileage');

  q = getParameterByName('q');
  $('#search-box-smart-search').val(q);

  loadFuel();
  loadGear();
  loadColor();
  loadEngine();
  loadBody();

  if(doorId != '') {
    dropdownDoor.val(doorId).selectpicker('refresh');
  }

  if(mileageId != '') {
    dropdownMileage.val(mileageId).selectpicker('refresh');
  }
  

  if (minPrice != '') {
    dropdownMinPrice.val(minPrice).selectpicker('refresh');
  }
  if (maxPrice != '') {
    dropdownMaxPrice.val(maxPrice).selectpicker('refresh');
  }


  loadYear();
  loadCarMake(function(){
    if (dropdownMake.val() != '') {
      dropdownMake.change();
    }
  });

  //loadCarModel();

  // dropdownAmphur.val('').selectpicker('refresh');

  //clear value in dropdown
  //dropdownMake.val('').selectpicker('refresh');
  //dropdownModel.val('').selectpicker('refresh');
  dropdownMake.change(function(){
    if (dropdownMake.val() != '') {
      makeId = dropdownMake.val();
      loadCarModel(function(){
        if (modelId != '') {
          dropdownModel.change();
        }
      });
      dropdownModel.prop("disabled", false);
      var val = dropdownMake.find(":selected").data('avaliable');
      if (val) {
          $('#search-avaliable').text(val);
      } else {
          $('#search-avaliable').text('0');
      }
    }
  });

  dropdownModel.change(function(){
    var val = dropdownModel.find(":selected").data('avaliable');
    if (val) {
        $('#search-avaliable').text(val);
    } else {
        $('#search-avaliable').text('0');
    }
  });

    // Make Dropdown
  // $("select#make").change(function() {
  // var selected_option = "";
  // $(this).each(function() {
  //   selected_option += $(this).find(":selected").text();
    
  //   if (selected_option !== "Make") {
  //     //console.log("Enable Model Dropdown");
  //     $('select#model').prop("disabled", false);
  //   }
  // });
  // })
  // .trigger( "change" );

  loadProvince(function(){
    if (provinceId != '') {
      // cdSearchByLocation.iCheck('check');
      cdSearchByLocation.iCheck('uncheck');
      dropdownProvince.change();
    }
  });
  dropdownProvince.change(function(){
    if ($(this).val() != '') {
      provinceId = $(this).val();
      loadAmphur();
    }
  });
  dropdownAmphur.change(function(){
    if ($(this).val() != '') {
      amphurId = $(this).val();
      loadDistrict()
    }
  });

  cdSearchByLocation.on('ifChecked', function(event){
    //console.log("on");
    $('#btn-nearme .fa').removeClass('location-disable');
    $('.row-location').slideUp();
    $('.nearme-distance').removeClass("inactive-distance");
    
    // reset address info
    dropdownProvince.val('').selectpicker('refresh');
    dropdownAmphur.val('').selectpicker('refresh');
    dropdownDistrict.val('').selectpicker('refresh');
    
  });
  cdSearchByLocation.on('ifUnchecked', function(event){
    //console.log("off");
    $('#btn-nearme .fa').addClass('location-disable');
    $('.row-location').slideDown();
    $('.nearme-distance').addClass("inactive-distance");
    hide_nearme_dropdown();

  });
  //cdSearchByLocation.iCheck('check');
  cdSearchByLocation.iCheck('check', function(){
    if ($('#search-by-your-location-data').prop('checked')) {
      //console.log("on");
      $('#btn-nearme .fa').removeClass('location-disable');
      $('.row-location').slideUp();
      $('.nearme-distance').removeClass("inactive-distance");
    } else {
      //console.log("off");
      $('#btn-nearme .fa').addClass('location-disable');
      $('.row-location').slideDown();
      $('.nearme-distance').addClass("inactive-distance");

    }
  });

  $('.nearme-distance .opt').click(function(){
    if($(this).data('value') != "") {
        $('#distance').val($(this).data('value'));
    }
    //console.log($(this).data('value'));
  });

  if (distance != 10 && distance != '') {
    hiddenDistance.val(distance);
    $('.nearme-distance').removeClass('selected');
    $('.nearme-distance a[data-value='+distance+']').parent().addClass('selected');
  }

  $('.form-search').show();

});