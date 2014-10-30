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
    <form role="form" method="POST" id="frmSubmit" class="form-submit form-search no-padding" 
    style="border: 0;box-shadow:none;" action="{{ URL::to(App::getLocale().'/my-garage/update-one') }}">
 	<div class="row">
 		
 		<div class="col-lg-3 col-md-3 col-sm-4 col-lg-offset-3 col-md-offset-3 col-sm-offset-2">
	
			<div class="row search-car-by">
				<header class="title">Search your car in system by</header>
				<div class="col-md-12 col-xs-12">
					<div class='form-group'>
					<label class='control-label' for='year'>Year</label>
					<select name="year" id="year" class="form-control" required data-live-search="true"></select>
					</div> 
					<div class='form-group'>
					<label class='control-label' for='make'>Make</label>
					<select name="make" id="make" data-live-search="true"></select>
					</div>
					<div class='form-group'>
					<label class='control-label' for='model'>Model</label>
					<select name="model" id="model" data-live-search="true"></select>
					</div>
				</div>
			</div>

			<header><h2>Basic Information</h2></header>
			<div class="form-group">
				<label class="control-label">Choose your car</label>
				<select name="car_available" id="car_available" required></select>
			</div>
			<div class="form-group">
				<label class='control-label' for='title'>Colors</label>
				<select name="color" id="color" class="form-control"  data-live-search="true"></select>	
			</div>
			<div class="form-group">
				<label class='control-label' for='title'>Parts</label>
				<select name="parts[]" id="parts" multiple class="form-control" data-live-search="true"></select>
			</div>
 		</div>
 		<div class="col-lg-3 col-md-3 col-sm-4">
			<div class="submit-step">
                <figure class="step-number">1</figure>
                <div class="description">
                    <h4>Select Your Car model year and make</h4>
                    <p>Choose from a packages one that suit your need. If you have chosen package before,
                        it will be automatically selected.
                    </p>
                </div>
                <button type="submit" id="formSubmitButton" class="btn btn-default btn-sm btn-block search-btn">Go to Step 2</button>
            </div>
 		</div>
			
		<input type="hidden" name="id" id="id" value="{{ $id }}">
		
		<input type="hidden" name="year_hidden" id="year_hidden" value="{{ $car->year }}">
		<input type="hidden" name="make_hidden" id="make_hidden" value="{{ $car->make }}">
		<input type="hidden" name="model_hidden" id="model_hidden" value="{{ $car->model }}">

		<input type="hidden" name="car_available_hidden" id="car_available_hidden" value="{{ $content->car_id }}">
		<input type="hidden" name="color_hidden" id="color_hidden" value="{{ $content->car_color }}">
		<input type="hidden" name="parts_hidden" id="parts_hidden" value="{{ $content->car_parts }}">

 	</div>
 	</form>
 </div>
@stop

@section('footer')
<script type="text/javascript">
$(function(){
    function loadCarYear(dropdown, callback){
    	console.log('loadCarYear');
        clearDropdownYear()
        $.getJSON("/api/v1/car/year/", function(res){
            var html = '';
            if(!res.error) {
                $.each(res.years, function(k,v){ html += '<option value="'+v.year+'">'+v.year+'</option>'; });
                dropdown.append(html).selectpicker("refresh");
                if(callback) callback();
            }
        });
    }

    function loadCarMake(dropdown, callback) {
    	console.log('loadCarMake');
        clearDropdownMake()
        $.getJSON("/api/v1/car/make", {'year':$('#year').val()}, function(res){
            var html = '';
            if(!res.error) {
                $.each(res.makes, function(k,v){ html += '<option value="'+v.make+'">'+v.make+'</option>'; });
                dropdown.append(html).selectpicker("refresh");
                if(callback) callback();
            }
        });
    }

    function loadCarModel(dropdown, callback){
    	console.log('loadCarModel');
        clearDropdownModel();
        $.getJSON("/api/v1/car/model", {'year':$('#year').val(), 'make':$('#make').val()}, function(res){
            var html = '';
            if(!res.error) {
                $.each(res.models, function(k,v){ html += '<option value="'+v.model+'">'+v.model+'</option>'; });
                dropdown.append(html).selectpicker("refresh");
                if(callback) callback();
            }
        });
    }

    function loadCar(dropdown, callback){
    	console.log('loadCar');
        clearDropdownCar();
        $.getJSON("/api/v1/car/car", {'year':$('#year').val(), 'make':$('#make').val(), 'model':$('#model').val()}, function(res){
            var html = '';
            if(!res.error) {
                $.each(res.cars, function(k,v){ html += '<option value="'+v.id+'">'+v.trim+'</option>'; });
                dropdown.append(html).selectpicker("refresh");
                if(callback) callback();
            }
        });
    }

    function loadCarColor(dropdown, callback){
    	console.log('loadCarColor');
        clearDropdownColor();
        $.getJSON("/api/v1/car/color", {'car_id':$('#car_available').val()}, function(res){
            var html = '';
            if(!res.error) {
                $.each(res.colors, function(k,v){ html += '<option value="'+v.id+'" data-content="<span style=\'width:30px;height:10px;display:inline-block;background:#'+v.hex+';maring-right:10px;\'></span> <span>'+v.name+'</span>">'+v.name+'</option>'; });
                dropdown.append(html).selectpicker("refresh");
                if(callback) callback();
            }
        });
    }

    function loadCarParts(dropdown, callback){
    	console.log('loadCarParts');
        clearDropdownParts();
        $.getJSON("/api/v1/car/parts", function(res){
            var html = '';
            if(!res.error) {
                $.each(res.parts, function(k,v){ html += '<option value="'+v.id+'">'+v.part+'</option>'; });
                dropdown.append(html).selectpicker("refresh");
                if(callback) callback();
            }
        });
    }

    function clearDropdownYear() {dropdownYear.empty().append('<option value="">Year</option>').selectpicker("refresh");}
    function clearDropdownMake() {dropdownMake.empty().append('<option value="">Make</option>').selectpicker("refresh");}
    function clearDropdownModel() {dropdownModel.empty().append('<option value="">Model</option>').selectpicker("refresh");}
    function clearDropdownCar() {dropdownCar.empty().append('<option value="">Car avaliable</option>').selectpicker("refresh");}
    function clearDropdownColor() {dropdownColor.empty().append('<option value="">Color</option>').selectpicker("refresh");}
    function clearDropdownParts() {dropdownParts.empty().append('<option value="">Parts</option>').selectpicker("refresh");}

    function clearAllDropdown(){
        clearDropdownYear();
        clearDropdownMake();
        clearDropdownModel();
        clearDropdownCar();
        clearDropdownColor();
        clearDropdownParts();
    }

    var dropdownYear = $('#year');
    var dropdownMake = $('#make');
    var dropdownModel = $('#model');
    var dropdownCar = $('#car_available');
    var dropdownColor = $('#color');
    var dropdownParts = $('#parts');
    
    clearAllDropdown();

    // init data
    function initData(callback){
    	loadCarYear(dropdownYear, function(){
			dropdownYear.selectpicker('val', $('#year_hidden').val());
			loadCarMake(dropdownMake, function(){
				dropdownMake.selectpicker('val', $('#make_hidden').val());
				loadCarModel(dropdownModel, function(){
					dropdownModel.selectpicker('val', $('#model_hidden').val());
	                loadCar(dropdownCar, function(){
	                	dropdownCar.selectpicker('val', $('#car_available_hidden').val());
	                	loadCarColor(dropdownColor, function(){
	                		dropdownColor.selectpicker('val', $('#car_color_hidden').val());
	                	});
	                	loadCarParts(dropdownParts, function(){
	                		if($('#parts_hidden').val().indexOf(",") > 0) {
	                			console.log($('#parts_hidden').val().split(','));
	                			dropdownParts.selectpicker('val', $('#parts_hidden').val().split(','));
	                		} else {
	                			dropdownParts.selectpicker('val', $('#parts_hidden').val());
	                		}
	                	});

	                	// finish all init
	                	if(callback) callback();
	                });
	            });
			});
		});
    }

    initData(function(){
	    dropdownYear.change(function(){
	        if ($(this).val() != '') {
	            loadCarMake(dropdownMake);
	        } else {
	            clearDropdownMake();
	            clearDropdownModel();
	        }
	    });

	    dropdownMake.change(function(){
	        if ($(this).val() != '') {
	            loadCarModel(dropdownModel, function(){
	                loadCar(dropdownCar);
	            });
	        } else {
	            clearDropdownModel();
	        }
	    });

	    dropdownModel.change(function(){
	        if ($(this).val() != '') {
	            loadCar(dropdownCar);
	        }
	    });

	    dropdownCar.change(function(){
	        if ($(this).val() != '') {
	            loadCarColor(dropdownColor);
	            loadCarParts(dropdownParts);
	        }
	    });
    });

 //    $( "#formSubmitButton" ).click(function() {
	//   $( "#frmSubmit" ).submit();
	// });

});
</script>
@stop
