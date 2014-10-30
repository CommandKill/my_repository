<section id="search-advance">
    <form role="form" id="form-advance" class="form-search" action="#">

        <div class="form-group col-md-4 col-sm-4 col-xs-12">
            <button type="button" class="btn btn-default btn-toggle active" id="btn-certified"><span class="icon icon-certified"></span> Certified cars</button>

            <span id="btn-information" class="btn-info" data-container="body" data-toggle="popover" data-placement="right" data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus."></span>
        </div>
        <div class="form-group col-md-4 col-sm-4 col-xs-12">
            <select name="enginetype">
                <option value="all" selected>All cars</option>
                <option value="private">Private</option>
                <option value="trade">Trade</option>
            </select>
        </div>
        <div class="form-group col-md-4 col-sm-4 col-xs-12">
            <!-- <div class="row"> -->
                <a href="#" class="col-md-6 col-xs-6 btn-plan icon-save-search">Saved searches</a>
                <a href="#" class="col-md-6 col-xs-6 btn-plan icon-my-search">My searches</a>
            <!-- </div> -->
        </div>
        <div class="form-group col-md-12 col-sm-12 col-xs-12">
            <input type="text" class="form-control" id="search-box-smart-search" name="q" placeholder="Smart search box" value="">
        </div>
        <div class="form-group col-md-12 col-sm-12 col-xs-12">
            <div class="checkbox switch" id="search-by-your-location" style="text-align:left">
                <label>
                    <input type="checkbox" id="search-by-your-location-data" name="search-by-your-location-data" checked>  Use Current Location
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
            <select name="engine" data-live-search="true">
                <option value="">Engine</option>
                <option value="1.0">1.0</option>
                <option value="1.2">1.2</option>
                <option value="1.3">1.3</option>
                <option value="1.4">1.4</option>
                <option value="Not Available">Not Available</option>
            </select>
        </div>
        <div class="form-group col-md-4 col-sm-4 col-xs-12">
            <select name="fual" id="fual">
                <option value="">Fuel Type</option>
                <option id="Diesel">Diesel</option>
                <option id="Electric">Electric</option>
                <option id="Flex-Fuel (Premium Unleaded Recommended/E85)">Flex-Fuel (Premium Unleaded Recommended/E85)</option>
                <option id="Flex-Fuel (Premium Unleaded Required/E85)">Flex-Fuel (Premium Unleaded Required/E85)</option>
                <option id="Flex-Fuel (Premium Unleaded/E85)">Flex-Fuel (Premium Unleaded/E85)</option>
                <option id="Flex-Fuel (Unleaded/E85)">Flex-Fuel (Unleaded/E85)</option>
                <option id="Natural Gas">Natural Gas</option>
                <option id="Not Available">Not Available</option>
                <option id="Premium Unleaded (Recommended)">Premium Unleaded (Recommended)</option>
                <option id="Premium Unleaded (Required)">Premium Unleaded (Required)</option>
                <option id="Regular Unleaded">Regular Unleaded</option>
            </select>
        </div>
        <div class="form-group col-md-4 col-sm-4 col-xs-12">
            <select name="gear" id="gear">
                <option value="">Transmission</option>
                <option value="Automatic">เกียร์ Automatic</option>
                <option value="Automated Manual">เกียร์ Automated Manual</option>
                <option value="Manual">เกียร์ Manual</option>
                <option value="Manual">เกียร์ Direct Drive</option>
                <option value="Manual">Unknown</option>
            </select>
        </div>
        <div class="form-group col-md-4 col-sm-4 col-xs-12">
            <select name="door" id="number_of_door">
                <option value="">Door</option>
                <option value="4">4 ประตู</option>
                <option value="3">3 ประตู</option>
                <option value="2">2 ประตู</option>
                <option value="Not Available">Not Available</option>
            </select>
        </div>
        <div class="form-group col-md-4 col-sm-4 col-xs-12">
            <select name="mileage" id="mileage">
                <option value="">Mileage</option>
                <option value="1">up to 10,000 km</option>
                <option value="1">up to 20,000 km</option>
                <option value="1">up to 30,000 km</option>
                <option value="1">up to 40,000 km</option>
                <option value="1">up to 50,000 km</option>
                <option value="1">up to 60,000 km</option>
                <option value="1">up to 70,000 km</option>
                <option value="1">up to 80,000 km</option>
                <option value="1">up to 90,000 km</option>
                <option value="1">up to 100,000 km</option>
                <option value="1">up to 110,000 km</option>
                <option value="1">up to 120,000 km</option>
                <option value="1">up to 130,000 km</option>
                <option value="1">up to 140,000 km</option>
                <option value="1">up to 150,000 km</option>
                <option value="1">up to 160,000 km</option>
                <option value="1">up to 170,000 km</option>
                <option value="1">up to 180,000 km</option>
                <option value="1">up to 190,000 km</option>
                <option value="1">over 200,000 km</option>
            </select>
        </div>
        <div class="form-group col-md-4 col-sm-4 col-xs-12">
            <select name="body" id="body_type">
                <option value="">Body type</option>
                <option value="saloon">saloon</option>
                <option value="estate">estate</option>
                <option value="coupe">coupe</option>
                <option value="Not Available">Not Available</option>
            </select>
        </div>
        <div class="form-group col-md-4 col-sm-4 col-xs-12">
            <select name="color" id="color">
                <option value="">Colour</option>
                <option value="1">Colour 1</option>
                <option value="2">Colour 2</option>
            </select>
        </div>
        <div class="form-group col-md-4 col-sm-4 col-xs-12">
            <select name="near" id="destination">
                <option value="">Distance</option>
                <option>Within 5 kilometres</option>
                <option selected>Within 10 kilometres</option>
                <option>Within 25 kilometres</option>
                <option>Within 50 kilometres</option>
                <option>Within 100 kilometres</option>
                <option>Within 150 kilometres</option>
                <option>Within 200 kilometres</option>
            </select>
        </div>
        <div class="form-group col-md-4 col-sm-4 col-xs-12">
            <div class="col-md-6 col-sm-6 col-xs-12 pull-left min-price-wrapper">
                <select name="min-price" id="min-price">
                    <option>Min price</option>
                    <option>50,000 ฿</option>
                    <option>100,000 ฿</option>
                    <option>150,000 ฿</option>
                    <option>200,000 ฿</option>
                    <option>400,000 ฿</option>
                    <option>600,000 ฿</option>
                    <option>800,000 ฿</option>
                    <option>1,000,000 ฿</option>
                    <option>2,000,000 ฿</option>
                    <option>4,000,000 ฿</option>
                    <option>6,000,000 ฿</option>
                    <option>8,000,000 ฿</option>
                    <option>10,000,000 ฿</option>
                </select>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12 pull-right max-price-wrapper">
                <select name="max-price" id="max-price">
                    <option>Max price</option>
                    <option>50,000 ฿</option>
                    <option>100,000 ฿</option>
                    <option>150,000 ฿</option>
                    <option>200,000 ฿</option>
                    <option>400,000 ฿</option>
                    <option>600,000 ฿</option>
                    <option>800,000 ฿</option>
                    <option>1,000,000 ฿</option>
                    <option>2,000,000 ฿</option>
                    <option>4,000,000 ฿</option>
                    <option>6,000,000 ฿</option>
                    <option>8,000,000 ฿</option>
                    <option>10,000,000 ฿</option>
                </select>
            </div>
        </div>
        <div class="form-group col-md-4 col-sm-4 col-xs-12">
            <button type="submit" class="btn btn-default btn-sm btn-block search-btn">Search</button>
        </div>
        <div class="form-group col-md-6 col-sm-6 col-sm-offset-3 col-xs-12" style="margin-bottom: 0;">
            <div id="cars-found-number" class="txt-found-number2">32,546 cars found</div>
        </div>
        <div class="form-group col-md-3 col-sm-3 col-xs-12">
            <a href="{{ URL::to(App::getLocale().'/listing') }}" class="pull-right"><span class="glyphicon glyphicon-repeat"></span> Reset</a>
        </div>


    </form><!-- /#form-map -->
</section><!-- /#search-advance-->