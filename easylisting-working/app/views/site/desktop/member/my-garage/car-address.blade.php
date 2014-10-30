<div class="col-xs-4">
	<div class="submit-step">
		<figure class="step-number">3</figure>
		<div class="description">
		    <p> {{ $data['upload_step'][2]['value'] }}</p>
		</div>
	</div>
</div>
<div class="col-xs-8">
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
    <p class="fancy"><span>or</span></p>
	<div class='form-group'>
		<select name="province_id" id="province" data-live-search="true">
			<option value="">Province</option>
		</select>
	</div>
	<div class='form-group'>
		<select name="amphur_id" id="amphur" data-live-search="true">
			<option value="">District</option>
		</select>
	</div>
	<div class='form-group'>
		<select name="district_id" id="district" data-live-search="true">
			<option value="">Sub district</option>
		</select>
	</div>
  <!-- <div class='form-group'>
    <select name="zipcode_id" id="zipcode">
      <option value="">Zipcode</option>
    </select>
  </div> -->
	<div class="form-group">
<div class="row">
        <div class="col-xs-6">
          <div class="input-group">
             <span class="input-group-addon">Phone</span>
             <input type="text" class="form-control" id="phone" name="phone" value="" required>
         </div>
		 <small class="has-required">* Required</small>
        </div>
		<div class="col-xs-6">
          <div class="input-group">
             <span class="input-group-addon">Line Id</span>
             <input type="text" class="form-control" id="line_id" name="line_id" value="">
         </div>
        </div>
        
</div>
    </div>
</div>
  <div class="form-group" style="float:left;width: 100%;">
    <a class="btn-step btn submit-btn pull-left" data-index="1" id="btn4"><i class="glyphicon glyphicon-chevron-left"></i> Prev</a>
    <a class="btn-step btn submit-btn pull-right" data-index="3" id="btn5">Next <i class="glyphicon glyphicon-chevron-right"></i></a>
  </div>