<div class="col-xs-4">
	<div class="submit-step">
		<figure class="step-number">1</figure>
		<div class="description">
		    <p> {{ $data['upload_step'][0]['value'] }}</p>
		</div>

		{{--
            <div class="">
		    	<a id="verify-car" class="btn submit-btn">Verify a car</a>
			</div>
        --}}

	</div>
</div>
<div class="col-xs-8">
	<div class='form-group'>
		<select name="year_id" id="year" data-live-search="true" required>
			<option value="">Year</option>
		</select>
		<small class="has-required">* Required</small>
	</div>

	<div class='form-group'>
		<select name="make_id" id="make" data-live-search="true" required>
			<option value="">Make</option>
		</select>
		<small class="has-required">* Required</small>
	</div>
	<div class='form-group'>
		<select name="model_id" id="model" data-live-search="true" required>
			<option value="">Model</option>
		</select>
		<small class="has-required">* Required</small>
	</div>
	<div class='form-group'>
		<select name="submodel_id" id="submodel" data-live-search="true">
			<option value="">Submodel</option>
		</select>
	</div>
	<div class='form-group'>
		<select name="gear_id" id="gear" data-live-search="true">
			<option value="">Gear</option>
		</select>
	</div>
	<div class='form-group'>
		<select name="fuel_id" id="fuel" data-live-search="true">
			<option value="">Fuel</option>
		</select>
	</div>
	<div class='form-group'>
		<select name="engine_id" id="engine" data-live-search="true">
			<option value="">Engine</option>
		</select>
	</div>
	<div class='form-group'>
		<select name="color_id" id="color" data-live-search="true">
			<option value="">Color</option>
		</select>
	</div>
	<div class="form-group">
		<label class='control-label' for='car_not_exist'>
			<input type="checkbox" id="car_not_exist" name="car_not_exist" value="yes"/> Don't have your car in list? suggest us</label>
			<input type="text" class="form-control" id="suggest" name="suggest">
		<!-- <textarea class="form-control" rows="1" id="suggest" name="suggest"></textarea> -->
	</div>
	<div class="form-group pull-right">
		<a class="btn-step btn submit-btn" id="btn1" data-index="1">Next <i class="glyphicon glyphicon-chevron-right"></i></a>
	</div>
</div>