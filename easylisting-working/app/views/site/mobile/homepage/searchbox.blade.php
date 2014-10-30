<div class="search-box-wrapper">
    <div class="search-box-inner">
        <div class="search-box main">
            <form role="form" class="form-search form-promotion" action="{{ URL::to(App::getLocale().'/listing') }}">
                <h2 class="title">Search Your Cars  </h2>
                <div class="form-group">
                    <button type="button" class="btn btn-default btn-toggle active" id="btn-certified"><span class="icon icon-certified"></span> Certified cars</button>

                    <span id="btn-information" class="btn-info" data-container="body" data-toggle="popover" data-placement="right" data-content="Find certified pre-owned vehicles in your area"></span>
                </div>
                <div class="form-group clearfix">
                    <input type="text" class="form-control" id="search-box-smart-search" name="q" placeholder="Smart search box">
                </div>
                <div class="form-group">
                    <select name="make" id="make" data-live-search="true">
                        <option value="">{{ trans('site.make') }}</option>
                    </select>
                </div>
                <div class="form-group">
                    <select name="model" id="model" data-live-search="true">
                        <option value="">{{ trans('site.model') }}</option>
                    </select>
                </div>
                <div class="form-group row">
                    <div class="col-xs-6 pull-left min-price-wrapper">
                        <select name="min-price" id="min-price">
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
                    <div class="col-xs-6 pull-right max-price-wrapper">
                        <select name="max-price" id="max-price">
                            <option>Max price</option>
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
                <div class="form-group" style="margin: 10px 15px 9px 10px;clear:both">
                    <div class="checkbox switch" id="search-by-your-location" style="text-align:left">
                        <label>
                            <input type="checkbox" id="search-by-your-location-data" name="search-by-your-location-data" checked>  Use Current Location
                        </label>
                    </div>
                </div>
                <div id="search-area" class="">
                <div class="form-group">
                    <select name="destination" id="search-area-data">
                        <option value="">Distant</option>
                        <option value="5">Within 5 kilometres</option>
                        <option value="10" selected>Within 10 kilometres</option>
                        <option value="25">Within 25 kilometres</option>
                        <option value="50">Within 50 kilometres</option>
                        <option value="100">Within 100 kilometres</option>
                        <option value="150">Within 150 kilometres</option>
                        <option value="200">Within 200 kilometres</option>
                    </select>
                </div>
                </div>
                <div class="form-group">
                    <div id="cars-found-number" class="txt-found-number1">0 cars found</div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-default btn-sm btn-block search-btn">Search</button>
                </div>
                <div class="form-group">
                    <a href="{{ URL::to(App::getLocale().'/listing') }}">Advanced search</a>
                </div>
            </form><!-- /#form-map -->
        </div>
    </div>
</div><!-- /.search-box-wrapper -->