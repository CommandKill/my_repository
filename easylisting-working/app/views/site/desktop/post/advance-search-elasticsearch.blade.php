<section id="search-advance">
    <form role="form" id="form-advance" class="form-search" action="#">

        <div class="form-group col-md-4 col-sm-4 col-xs-12">
            <button type="button" class="btn btn-default btn-toggle active" id="btn-certified"><span class="icon icon-certified"></span> Certified cars</button>

            <span id="btn-information" class="btn-info" data-container="body" data-toggle="popover" data-placement="right" data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus."></span>
        </div>
        <div class="form-group col-md-4 col-sm-4 col-xs-12">
            <select name="car_type">
                <option value="all" selected>All cars</option>
                <option value="private">Private</option>
                <option value="trade">Trade</option>
            </select>
        </div>
        <div class="form-group col-md-4 col-sm-4 col-xs-12">
            <!-- <div class="row"> -->
                <a href="#" id="save_search" class="col-md-6 col-xs-6 btn-plan icon-save-search">Save search</a>
                <a href="{{ URL::to(App::getLocale().'/mysearch') }}" class="col-md-6 col-xs-6 btn-plan icon-my-search">My searches</a>
            <!-- </div> -->
        </div>
        <div class="form-group col-md-12 col-sm-12 col-xs-12">
            <input type="text" class="form-control" id="search-box-smart-search" name="q" placeholder="Smart search box" value="{{ $inputs['q'] or '' }}">
        </div>
        <div class="form-group col-md-12 col-sm-12 col-xs-12">
            <div class="checkbox switch" id="search-by-your-location" style="text-align:left">
                <label>
                    <input type="checkbox" id="search-by-your-location-data" checked>  Use Current Location
                </label>
            </div>
        </div>

        <div id="holder-address">
            <div class="form-group col-md-4 col-sm-4 col-xs-12">
                <select name="province" id="province" data-live-search="true">
                    <option value="">Province</option>
                </select>
            </div>
            <div class="form-group col-md-4 col-sm-4 col-xs-12">
                <select name="amphur" id="amphur" data-live-search="true">
                    <option value="">District</option>
                </select>
            </div>
            <div class="form-group col-md-4 col-sm-4 col-xs-12">
                <select name="district" id="district" data-live-search="true">
                    <option value="">Subdistrict</option>
                </select>
            </div>
        </div>
        <div class="form-group col-md-4 col-sm-4 col-xs-12">
            <select name="year" id="year">
                <option value="">Year</option>
            </select>
        </div>
        <div class="form-group col-md-4 col-sm-4 col-xs-12">
            <select name="make" id="make" data-live-search="true">
                <option value="">Make</option>
            </select>
        </div>
        <div class="form-group col-md-4 col-sm-4 col-xs-12">
            <select name="model" id="model" data-live-search="true">
                <option value="">Model</option>
            </select>
        </div>
        <div class="form-group col-md-4 col-sm-4 col-xs-12">
            <select name="engine_size" data-live-search="true">
                <option value="">Engine</option>
            </select>
        </div>
        <div class="form-group col-md-4 col-sm-4 col-xs-12">
            <select name="fuel" id="fual">
                <option value="">Fuel Type</option>
            </select>
        </div>
        <div class="form-group col-md-4 col-sm-4 col-xs-12">
            <select name="gear" id="gear">
                <option value="">Transmission</option>
            </select>
        </div>
        <div class="form-group col-md-4 col-sm-4 col-xs-12">
            <select name="door" id="number_of_door">
                <option value="">Door</option>
            </select>
        </div>
        <div class="form-group col-md-4 col-sm-4 col-xs-12">
            <select name="mileage" id="mileage">
                <option value="">Mileage</option>
                <option value="10000">up to 10,000 km</option>
                <option value="20000">up to 20,000 km</option>
                <option value="30000">up to 30,000 km</option>
                <option value="40000">up to 40,000 km</option>
                <option value="50000">up to 50,000 km</option>
                <option value="60000">up to 60,000 km</option>
                <option value="70000">up to 70,000 km</option>
                <option value="80000">up to 80,000 km</option>
                <option value="80000">up to 90,000 km</option>
                <option value="100000">up to 100,000 km</option>
                <option value="110000">up to 110,000 km</option>
                <option value="120000">up to 120,000 km</option>
                <option value="130000">up to 130,000 km</option>
                <option value="140000">up to 140,000 km</option>
                <option value="150000">up to 150,000 km</option>
                <option value="160000">up to 160,000 km</option>
                <option value="170000">up to 170,000 km</option>
                <option value="180000">up to 180,000 km</option>
                <option value="190000">up to 190,000 km</option>
                <option value="200000">over 200,000 km</option>
            </select>
        </div>
        <div class="form-group col-md-4 col-sm-4 col-xs-12">
            <select name="body" id="body_type">
                <option value="">Body type</option>
            </select>
        </div>
        <div class="form-group col-md-4 col-sm-4 col-xs-12">
            <select name="color" id="color">
                <option value="">Colour</option>
            </select>
        </div>
        <div class="form-group col-md-4 col-sm-4 col-xs-12">
            <select name="distance_in_km" id="destination">
                <option value="">Distance</option>
                <option value="5">Within 5 kilometres</option>
                <option value="10" selected>Within 10 kilometres</option>
                <option value="25">Within 25 kilometres</option>
                <option value="50">Within 50 kilometres</option>
                <option value="100">Within 100 kilometres</option>
                <option value="150">Within 150 kilometres</option>
                <option value="200">Within 200 kilometres</option>
            </select>
        </div>
        <div class="form-group col-md-4 col-sm-4 col-xs-12">
            <div class="col-md-6 col-sm-6 col-xs-12 pull-left min-price-wrapper">
                <select name="min_price" id="min-price">
                    <option value="">Min price</option>
                    <option value="50000">50,000 ฿</option>
                    <option value="100000">100,000 ฿</option>
                    <option value="150000">150,000 ฿</option>
                    <option value="200000">200,000 ฿</option>
                    <option value="400000">400,000 ฿</option>
                    <option value="600000">600,000 ฿</option>
                    <option value="800000">800,000 ฿</option>
                    <option value="1000000">1,000,000 ฿</option>
                    <option value="2000000">2,000,000 ฿</option>
                    <option value="4000000">4,000,000 ฿</option>
                    <option value="6000000">6,000,000 ฿</option>
                    <option value="8000000">8,000,000 ฿</option>
                    <option value="10000000">10,000,000 ฿</option>
                </select>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12 pull-right max-price-wrapper">
                <select name="max_price" id="max-price">
                    <option value="">Max price</option>
                    <option value="50000">50,000 ฿</option>
                    <option value="100000">100,000 ฿</option>
                    <option value="150000">150,000 ฿</option>
                    <option value="200000">200,000 ฿</option>
                    <option value="400000">400,000 ฿</option>
                    <option value="600000">600,000 ฿</option>
                    <option value="800000">800,000 ฿</option>
                    <option value="1000000">1,000,000 ฿</option>
                    <option value="2000000">2,000,000 ฿</option>
                    <option value="4000000">4,000,000 ฿</option>
                    <option value="6000000">6,000,000 ฿</option>
                    <option value="8000000">8,000,000 ฿</option>
                    <option value="10000000">10,000,000 ฿</option>
                </select>
            </div>
        </div>
        <div class="form-group col-md-4 col-sm-4 col-sm-offset-3 col-xs-12 text-center">
            <div class="txt-found-number2 pull-left"><i class="oo-icon icon-mileage"></i> <span id="cars-found-number">{{ $total }}</span> cars found</div>
        </div>
        <div class="form-group col-md-4 col-sm-offset-1 col-sm-4 col-xs-12">
            <button type="submit" class="btn btn-default btn-sm btn-block search-btn" id="btn-submit">Search</button>
        </div>
        
        <!-- <div class="form-group col-md-3 col-sm-3 col-xs-12"> -->
            <a href="{{ URL::to(App::getLocale().'/listing') }}" style="margin-right: 15px;" class="pull-right"><span class="glyphicon glyphicon-repeat"></span> Reset</a>
        <!-- </div> -->


    </form><!-- /#form-map -->
</section><!-- /#search-advance-->