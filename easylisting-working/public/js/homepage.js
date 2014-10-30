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

    // -------------------------------------------------------
    //  iCheck
    // -------------------------------------------------------

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
    
    // New Search Box JS
    $('.bootstrap-select-searchbox input').attr('placeholder','Filter');
    $('.bootstrap-select-searchbox').append('<i class="fa fa-search"></i>');

    // Make Dropdown
    $("select#make").change(function() {
      var selected_option = "";
      $(this).each(function() {
        selected_option += $(this).find(":selected").text();
        
        if (selected_option !== "Make") {
          //console.log("Enable Model Dropdown");
          $('select#model').prop("disabled", false);
        }
      });
    })
    .trigger( "change" );

    // Near Me Dropdown

    function hide_nearme_dropdown() {
     setTimeout(function() {
        $('.nearme-option').hide();}, 200);
    }

    $("select#search-area-data").change(function() {

      var selected_option = "";
      $(this).each(function() {
        selected_option += $(this).find(":selected").val();
        
        if (selected_option === "near-me") {
          $('.group-nearme .fa').show();
          $('.option-current-location').removeClass("location-off");
        } else if (selected_option === "current-location") {
          $('.group-nearme .btn.selectpicker').addClass("use-current-location");
          $('.option-current-location').hide();
          $('.group-nearme .fa').hide();
        } else {
          $('.group-nearme .btn.selectpicker').removeClass("use-current-location");
          $('.option-current-location').addClass("location-off");
          $('.group-nearme .fa').hide();
          $('.option-current-location').show();
        }
      });
    })
    .trigger( "change" );


    // // Near Me Dropdown
    // $("select#search-area-data").change(function() {

    //   var selected_option = "";
    //   $(this).each(function() {
    //     selected_option += $(this).find(":selected").val();
    //     //console.log(selected_option);
    //     if (selected_option === "near-me") {

    //       $('.group-nearme .fa').show();
    //       $('.option-current-location').removeClass("location-off");
    //     } else if (selected_option === "current-location") {
    //       $('.group-nearme .btn.selectpicker').addClass("use-current-location");
    //       $('.option-current-location').hide();
    //       $('.group-nearme .fa').hide();
    //       //$('.row-location').hide();
    //     } else {
    //       $('.group-nearme .btn.selectpicker').removeClass("use-current-location");
    //       $('.option-current-location').addClass("location-off");
    //       $('.group-nearme .fa').hide();
    //       $('.option-current-location').show();
    //       //$('.row-location').show();
    //     }
    //   });
    // })
    // .trigger( "change" );


    /* Near Me Toggle */

    $('.opt').click(function(){
        if($(this).data('value') != "") {
            $('#distance').val($(this).data('value'));
        }
        
        //console.log($(this).data('value'));
    });

    function onGeoSuccess(position){
        var lat = position.coords.latitude;
        var lng = position.coords.longitude;
        $('#lat').val(lat);
        $('#lon').val(lng);
        //console.log(lat, lng);
    }

    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(onGeoSuccess);
    } else {
      error('Geo Location is not supported');
    }


    var holderAddress = $('#holder-address');
    var cdSearchByLocation = $('#search-by-your-location');
    cdSearchByLocation.on('ifChecked', function(event){
        //console.log("on");
        $('#btn-nearme .fa').removeClass('location-disable');
        $('.row-location').slideUp();
        $('.nearme-distance').removeClass("inactive-distance");
        
    });
    cdSearchByLocation.on('ifUnchecked', function(event){

        // get all params
        var makeId = $('#make').val();
        var modelId = $('#model').val();
        var priceMin = $('#price-min').val();
        var priceMax = $('#price-max').val();
        var distance = $('#distance').val();

        var qstr = '/listing?q=&make='+makeId+'&model='+modelId+'&price-min='+priceMin+'&price-max='+priceMax+'&distance='+distance;
        window.location = window.location.origin + window.location.pathname + qstr;
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

    /* Select Distance */

    function resetDistance() {
      $('.nearme-option li').removeClass('selected');
    }


    $('.nearme-distance').click(function(){
      resetDistance();
      $(this).addClass('selected');
      $('.nearme-option').hide();
    });

    $('#slideshow-items li a').hover(
        function () {
            $('#slideshow-main a').attr('href', $(this).attr('href'));
            $('#slideshow-main img').attr('src', $(this).data('full'));

            $('#slideshow-main .info .title').text($(this).find('.title').text());
            $('#slideshow-main .info .createdate').text($(this).data('createdate'));
            $('#slideshow-main .additional-info').text($(this).find('.desc').text());

            $(this).parent().addClass('active').siblings().removeClass('active');
        },
        function () {
            //$(this).removeClass('active');
        }
    );

    $(".owl-carousel").owlCarousel({

      // autoPlay: 10000, //Set AutoPlay to 3 seconds

      items : 4,
      itemsDesktop : [1199,3],
      itemsDesktopSmall : [979,3]

    });

    var version_api = 'v1';
    var dropdownMake = $('#make');
    var dropdownModel = $('#model');

    function clearDropdownMake() {
        var text = $('#make option[value=""]').text();
        dropdownMake.empty().append('<option value="">'+text+'</option>').selectpicker("refresh");}
    function clearDropdownModel() {
        var text = $('#model option[value=""]').text();
        dropdownModel.empty().append('<option value="">'+text+'</option>').selectpicker("refresh");}
    function loadCarMake(dropdown, callback) {
        clearDropdownMake()
        $.getJSON("/api/"+version_api+"/car/make-group", {'year_id':$('#year').val()}, function(res){
            var html = '';
            if(!res.error) {
                
                $.each(res.makes, function (key, cat) {
                    var group = $('<optgroup>',{label:key});
                    html += '<optgroup label='+key+'>';
                    $.each(cat,function(i,item) {
                        html += '<option value="'+item.id+'" data-avaliable="'+item.avaliable+'" data-content="'+item.make+'<small class=\'pull-right\'>( '+item.avaliable+' )</small>">'+item.make+'</option>';
                    });
                    html += '</optgroup>';
                });

                dropdown.append(html).selectpicker("refresh");
                if(callback) callback();
            }
        });
    }

    function loadCarModel(dropdown, callback){
        clearDropdownModel();
        $.getJSON("/api/"+version_api+"/car/model-group", {'make_id':$('#make').val()}, function(res){
            var html = '';
            if(!res.error) {
                $.each(res.models, function (key, cat) {
                    var group = $('<optgroup>',{label:key});
                    html += '<optgroup label='+key+'>';
                    $.each(cat,function(i,item) {
                        html += '<option value="'+item.id+'" data-avaliable="'+item.avaliable+'" data-content="'+item.model+'<small class=\'pull-right\'>( '+item.avaliable+' )</small>">'+item.model+'</option>';
                    });
                    html += '</optgroup>';
                });

                dropdown.append(html).selectpicker("refresh");
                if(callback) callback();
            }
        });
    }

    function clearAllDropdown(){
        clearDropdownMake();
        clearDropdownModel();
    }

    clearAllDropdown();

    loadCarMake(dropdownMake);
    dropdownMake.change(function(){
        if ($(this).val() != '') {

            val = $('#make').find(":selected").data('avaliable');
            if (val) {
                $('#search-avaliable').text(val);
            } else {
                $('#search-avaliable').text('0');
            }

            loadCarModel(dropdownModel);
        } else {
            clearDropdownModel();
        }
    });

    dropdownModel.change(function(){
        if ($(this).val() != '') {

            val = $('#model').find(":selected").data('avaliable');
            if (val) {
                $('#search-avaliable').text(val);
            } else {
                $('#search-avaliable').text('0');
            }

        }
    });

  var hiddenInspected = $('#inspected');
  var tabInspected = $('#tab-certified');
  var tabAll = $('#tab-all');

  //$('#search-avaliable').text('0');
  
  hiddenInspected.val(0);
  tabInspected.on('click', function(){
    if(!tabInspected.parent().hasClass('active')) {
      hiddenInspected.val(1);
    }
  });
  tabAll.on('click', function(){
    if(!tabAll.parent().hasClass('active')) {
      hiddenInspected.val(0);
    }
  });

    $('.form-search').show();
});