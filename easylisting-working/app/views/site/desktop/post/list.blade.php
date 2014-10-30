<div class="search-filter row">
	<div class="col-md-6 col-sm-6 col-xs-6">
	    <h3 class="search-result-txt"><i class="fa fa-search"></i> Search Results <b class="search-count">{{ $total }}</b><h3>
	</div>
	<div class="col-md-6 col-sm-6 col-xs-6">
	    <div class="sorting">
	        <!-- <div class="form-group">
	            <button type="button" class="btn btn-default" name="compareButton" id="compareButton">Compare Car</button>
	        </div> -->

            <div class="col-sm-5 col-sm-5 col-xs-12 pull-left no-padding no-margin">
                <select name="order">
                    <option value="">Order By</option>
                    <option value="1">Ascending</option>
                    <option value="2">Descending</option>
                </select>
            </div>
	        <div class="col-sm-6 col-sm-6 col-xs-12 pull-right no-padding no-margin">
	            <select name="sort">
	                <option value="">Sort By</option>
                    <option value="near">Distant</option>
                    <option value="lowest_price">Price (lowest)</option>
                    <option value="highest_price">Price (highest)</option>
                    <option value="mileage">Mileage</option>
                    <option value="year">Year</option>
                    <option value="make">Make</option>
                    <option value="model">Model</option>
                    <option value="certified">Certified</option>
	            </select>
	        </div><!-- /.form-group -->
	    </div>
	</div>
</div>
<section class="col-md-12">
    @if($total > 0)
    @foreach($posts as $post)
    <div class="car-item row display-lines" style="margin-bottom:10px;padding-bottom:10px">
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding file-preview-image-holder">
                    @if($post->thumbnail != 'null')
                    <img class="file-preview-image" src="{{ asset('uploaded/car/'.$post->id.'/800x600_'.$post->thumbnail) }}" title="{{ $post->thumbnail }}" alt="{{ $post->thumbnail }}">
                    @else
                    <img class="file-preview-image" src="{{ asset('img/avatar.jpg') }}" title="placeholder" alt="placeholder">
                    @endif
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
					<div class="owl-demo">
						@foreach($post->gallery as $image)
						<div class="item">
          					<a href="#"><img class="lazyOwl" data-src="{{ asset('uploaded/car/'.$post->id.'/gallery/thumb_'.$image->name) }}" title="{{ $post->thumbnail }}" alt="{{ $post->thumbnail }}" ></a>
          				</div>
						@endforeach
          			</div>
				</div>
				
			</div>
		</div>
		<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 car-item-desc">
			<header>
				<a href="{{ URL::to(App::getLocale().'/car-detail/'.$post->id) }}">{{ $post->data[0]->title }}</a>
			</header>
			
			<div class="row car-info">
                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                    <ul class="info-extra-list">
                        <li><b>Driver wheel</b> {{$post->car_information['drivenWheels']}}</li>
                        <li><b>Gear</b> {{$post->car_information['transmissionType']}} ({{$post->car_information['transmissionGears']}} speed)</li>
                        <li><b>Door</b> {{$post->car_information['numberOfDoors']}}</li>
                        <li><b>Engine</b> {{$post->car_information['engineSize']}}</li>
                        <li><b>Gear</b> {{$post->car_information['transmissionType']}}</li>
                        <li><b>Type</b> {{$post->car_information['vehicleType']}}</li>
                    </ul>
                </div>
                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                    <p>
                        {{ $post->data[0]->description }} 
                        <a href="{{ URL::to(App::getLocale().'/car-detail/'.$post->id) }}" class="link-arrow">Read More</a>
                    </p>
                   
                </div>
            </div>

            <div class="row car-info-sub">
            	<div class="col-lg-6 col-md-4 col-sm-4 col-xs-4">
            		<img class="dealer-icon" src="{{ asset('img/dealer-sample-icon.png') }}" />
            	</div>
            	<div class="col-lg-6 col-md-8 col-sm-8 col-xs-8">
                    <div class="tag price pull-right">{{ number_format($post->price) }} ฿</div><br/>
                    <div style="clear:both;padding: 10px 0 0 0;">
					   <a style="cursor:pointer" class="compare-popover-dismiss pull-right" data-toggle="popover" title="Add this car to compare list?" data-carid="{{ $post->id }}" data-cartitle="{{ $post->title }}" data-placement="top" data-content="And here's some amazing content. It's very engaging. Right?">Compare +</a>
                       <a href="#report" class="pull-right" style="margin: 0 20px 0 0;">Report abuse/spam</a>
                    </div>
                    <span class="pull-right">Distance: 22 kilometers</span>
            	</div>
        	</div> 
		</div>
    </div>
    @endforeach
    @endif
    <input type="hidden" id="comparecar-list" value="" />
    <div class="center">
        <ul class="pagination">
            {{ $pagination }}
        </ul><!-- /.pagination-->
    </div><!-- /.center-->
</section><!-- /#properties-->