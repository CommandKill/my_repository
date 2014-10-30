<div class="col-xs-4">
	<div class="submit-step">
		<figure class="step-number">2</figure>
		<div class="description">
		    <p> {{ $data['upload_step'][1]['value'] }}</p>
		</div>
	</div>
</div>
<div class="col-xs-8">
	<div class="form-group">
        <label for="submit-price">Price</label>
        <div class="input-group">
			
            <input type="number" class="form-control" id="submit-price" name="price" value="" min="2" required><span class="input-group-addon">฿</span>
        </div>
		<small class="has-required">* Required</small>
    </div>
    <div class="form-group">
        <label for="submit-price">Mileage</label>
        <div class="input-group">
            <input type="number" class="form-control" id="mileage" name="mileage" value="" min="2" pattern="\d*"  data-bv-notempty-message="The field is required" required>
            <span class="input-group-addon">km</span>
			
        </div>
		<small class="has-required">* Required</small>
    </div>
    <div class="form-group">
    	@foreach ($data['carbase_part'] as $key => $value)
    	<label class="col-xs-6" style="font-weight:normal !important;">
		  <input type="checkbox" name="part[]" value="{{ $value['id'] }}"> {{ $value['lang'][0]['title'] }}
		</label>
    	@endforeach
    </div>
    <hr>
    <div class="form-group">
		<div class='tabbable'>
		    <ul class="nav nav-tabs">
		    @foreach($data['languages'] as $key=>$lang)
	        <li class="@if($lang['id'] == 2) active @endif">
	        <a data-toggle='tab' href='#tab{{ $lang['id'] }}'>
	            <i class='flag flag-{{ $lang['short_code'] }}'></i>
	            {{ $lang['title'] }}
	        </a>
	        </li>
	        @endforeach
		    </ul>

		    <br/>
		    <div class='tab-content' >
		    	@foreach($data['languages'] as $key=>$lang)
		        <div class='tab-pane @if($lang['id'] == 2) active @endif' id='tab{{ $lang['id'] }}'>
		            <div class="form-group">
						<label for="description_{{ $lang['short_code'] }}">Short description</label>
		                <input type="text" class="form-control" name="description_{{ $lang['short_code'] }}" id="description_{{ $lang['short_code'] }}">
		            </div>
		            <div class="form-group">
						<label for="detail_{{ $lang['short_code'] }}">Full description</label>
		                <textarea class="form-control" name="detail_{{ $lang['short_code'] }}" id="detail_{{ $lang['short_code'] }}"  rows="3"></textarea>
		            </div>
		        </div>
		        @endforeach
		    </div>
		</div>
    </div>
	<div class="form-group">
        <label for="tags">Tags</label>
            <input type="text" class="form-control" id="tags" name="tags" value="" />	
	</div>
</div>
<div class="form-group" style="float:left;width: 100%;">
<a class="btn-step btn submit-btn pull-left" data-index="0" id="btn2"><i class="glyphicon glyphicon-chevron-left"></i> Prev</a>
<a class="btn-step btn submit-btn pull-right" data-index="2" id="btn3">Next <i class="glyphicon glyphicon-chevron-right"></i></a>
</div>