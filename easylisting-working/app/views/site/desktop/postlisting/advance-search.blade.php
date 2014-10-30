<section id="search-advance">
    <form role="form" id="form-advance" class="form-search" action="#" style="display:none">

        <input type="hidden" name="distance_in_km" id="distance" value="{{ $distance or '' }}" />
        <input type="hidden" name="lat" id="lat" value="{{ $lat or '' }}" />
        <input type="hidden" name="lon" id="lon" value="{{ $lon or '' }}" />
        <input type="hidden" name="inspected" id="inspected" value="" />
<!--         <input type="hidden" id="hidden_year_id" value="" />
        <input type="hidden" id="hidden_make_id" value="" />
        <input type="hidden" id="hidden_model_id" value="" />
        <input type="hidden" id="hidden_submodel_id" value="" />
        <input type="hidden" id="hidden_fuel_id" value="" />
        <input type="hidden" id="hidden_gear_id" value="" />
        <input type="hidden" id="hidden_engine_id" value="" />
        <input type="hidden" id="hidden_color_id" value="" />
        <input type="hidden" id="hidden_province_id" value="" />
        <input type="hidden" id="hidden_amphur_id" value="" />
        <input type="hidden" id="hidden_district_id" value="" /> -->

       <!-- New Advance Search -->

        <!-- row top -->
        <div class="row-adv-search-top form-group col-md-12 col-sm-12 col-xs-12">
        <!-- col1 -->
        <div class="col-md-4 col-sm-4 col-xs-12">

            <div class="form-group">
                <i class="fa fa-search"></i>
                <input type="text" class="form-control" id="search-box-smart-search" name="q" placeholder="{{$data['text_page']['search']}}">
            </div>


            <div class="form-group">
                <select name="year" id="year">
                    <option value="">{{$data['text_page']['year']}}</option>
                </select>
            </div>

            <div class="form-group">
                <select name="make" id="make" data-live-search="true" class="select-make">
                    <option value="">{{$data['text_page']['make']}}</option>
                </select>
                <select name="model" id="model" data-live-search="true" class="select-model" disabled>
                    <option value="">{{$data['text_page']['model']}}</option>
                </select>
            </div>

            <div class="form-group clearfix group-nearme">

              <button type="button" class="btn btn-default btn-toggle active" id="btn-nearme">{{$data['text_page']['near_me']}} <i class="fa fa-map-marker"></i> <span class="caret"></span></button>
              
              <div class="nearme-option bootstrap-select">
                  <div class="dropdown-menu open animation-fade-out" style="max-height: 275px; overflow: hidden; min-height: 111px;display: block; width: 100%; background: #FAFAFA; border-radius: 0px; border: none; ">

                  <ul class="dropdown-menu inner selectpicker animation-fade-out" role="menu" style="position:relative;max-height: 275px; overflow-y: auto; min-height: 111px;border:none;width:100%; ">

                    <li>
                      <div class="checkbox switch" id="search-by-your-location" style="text-align:left">
                          <label>
                              <input type="checkbox" id="search-by-your-location-data" checked>  {{$data['text_page']['use_curent_location']}}
                          </label>
                      </div>


                    </li>



                    <li rel="1" class="nearme-distance"><div class="div-contain"><div class="divider"></div></div>
                        <dt><span class="text">{{$data['text_page']['distance']}}</span></dt>
                        <a tabindex="0" class="opt" style="" data-value="all">
                        <span class="opt">{{-- $data['text_page']['show_all'] --}}</span>
                        </a>
                    </li>

                    <li rel="2" class="nearme-distance">
                        <a tabindex="0" class="opt" style="" data-value="5">
                        <span class="opt">{{$data['text_page']['within']}} 5 {{$data['text_page']['kilometres']}}</span>
                        </a>
                    </li>

                    <li rel="3" class="nearme-distance selected">
                        <a tabindex="0" class="opt " style="" data-value="10">
                        <span class="text">{{$data['text_page']['within']}} 10 {{$data['text_page']['kilometres']}}</span>
                        </a>
                    </li>


                    <li rel="4" class="nearme-distance">
                        <a tabindex="0" class="opt " style="" data-value="25">
                        <span class="text">{{$data['text_page']['within']}} 25 {{$data['text_page']['kilometres']}}</span>
                        </a>
                    </li>


                    <li rel="5" class="nearme-distance">
                        <a tabindex="0" class="opt " style="" data-value="50">
                        <span class="text">{{$data['text_page']['within']}} 50 {{$data['text_page']['kilometres']}}</span>
                        </a>
                    </li>


                    <li rel="6" class="nearme-distance"><a tabindex="0" class="opt " style="" data-value="100"><span class="text">{{$data['text_page']['within']}} 100 {{$data['text_page']['kilometres']}}</span></a></li>


                    <li rel="7" class="nearme-distance"><a tabindex="0" class="opt " style="" data-value="150"><span class="text">{{$data['text_page']['within']}} 150 {{$data['text_page']['kilometres']}}</span></a></li>


                    <li rel="8" class="nearme-distance"><a tabindex="0" class="opt " style="" data-value="200"><span class="text">{{$data['text_page']['within']}} 200 {{$data['text_page']['kilometres']}}</span></a></li>

                  </ul>
                  </div>
              </div>
          </div>

          <div class="form-group">
            <select name="min_price" id="price-min" class="select-price-min">
                <option value="">{{$data['text_page']['min_price']}}</option>
                <option value="50000">50,000 ฿</option>
                <option value="100000">100,000 ฿</option>
                <option value="150000">150,000 ฿</option>
                <option value="200000">200,000 ฿</option>
                <option value="250000">250,000 ฿</option>
                <option value="300000">300,000 ฿</option>
                <option value="350000">350,000 ฿</option>
                <option value="400000">400,000 ฿</option>
                <option value="450000">450,000 ฿</option>
                <option value="500000">500,000 ฿</option>
                <option value="50000">550,000 ฿</option>
                <option value="600000">600,000 ฿</option>
                <option value="650000">650,000 ฿</option>
                <option value="700000">700,000 ฿</option>
                <option value="750000">750,000 ฿</option>
                <option value="800000">800,000 ฿</option>
                <option value="850000 ">850,000 ฿</option>
                <option value="900000">900,000 ฿</option>
                <option value="950000">950,000 ฿</option>
                <option value="1000000">1,000,000 ฿</option>
                <option value="2000000">2,000,000 ฿</option>
                <option value="3000000">3,000,000 ฿</option>
                <option value="4000000">4,000,000 ฿</option>
                <option value="5000000">5,000,000 ฿</option>
                <option value="6000000">6,000,000 ฿</option>
                <option value="7000000">7,000,000 ฿</option>
                <option value="8000000">8,000,000 ฿</option>
                <option value="9000000">9,000,000 ฿</option>
                <option value="10000000">10,000,000 ฿</option>
            </select>
            <select name="max_price" id="price-max" class="select-price-max">
                <option value="">{{$data['text_page']['max_price']}}</option>
                <option value="50000">50,000 ฿</option>
                <option value="100000">100,000 ฿</option>
                <option value="150000">150,000 ฿</option>
                <option value="200000">200,000 ฿</option>
                <option value="250000">250,000 ฿</option>
                <option value="300000">300,000 ฿</option>
                <option value="350000">350,000 ฿</option>
                <option value="400000">400,000 ฿</option>
                <option value="450000">450,000 ฿</option>
                <option value="500000">500,000 ฿</option>
                <option value="50000">550,000 ฿</option>
                <option value="600000">600,000 ฿</option>
                <option value="650000">650,000 ฿</option>
                <option value="700000">700,000 ฿</option>
                <option value="750000">750,000 ฿</option>
                <option value="800000">800,000 ฿</option>
                <option value="850000 ">850,000 ฿</option>
                <option value="900000">900,000 ฿</option>
                <option value="950000">950,000 ฿</option>
                <option value="1000000">1,000,000 ฿</option>
                <option value="2000000">2,000,000 ฿</option>
                <option value="3000000">3,000,000 ฿</option>
                <option value="4000000">4,000,000 ฿</option>
                <option value="5000000">5,000,000 ฿</option>
                <option value="6000000">6,000,000 ฿</option>
                <option value="7000000">7,000,000 ฿</option>
                <option value="8000000">8,000,000 ฿</option>
                <option value="9000000">9,000,000 ฿</option>
                <option value="10000000">10,000,000 ฿</option>
            </select>

          </div>

        </div>
        <!-- ./col1 -->

        <!-- col2 -->
        <div class="col-md-8 col-sm-8 col-xs-12">
            
            <div class="advance-filter-top col-md-12 col-sm-12 col-xs-12">
            <div class="col-md-4 col-sm-12 col-xs-12 filter-certified">
                <button type="button" class="btn btn-default btn-toggle active" id="btn-certified">{{$data['text_page']['inspected_cars']}}</button>

                <span id="btn-information" class="btn-info" data-container="body" data-toggle="popover" data-placement="right" data-html="true" data-content="{{$data['text_page']['inspected_cars_tips']}}"><i class="fa fa-question-circle"></i></span>
            </div>


            <div class="col-md-4 col-sm-12 col-xs-12">
                <select name="new_used" id="">
                    <option value="">{{$data['text_page']['new_n_used']}}</option>
                    <option value="">{{$data['text_page']['new']}}</option>
                    <option value="">{{$data['text_page']['used']}}</option>
                </select>
            </div>

            <div class="col-md-4 col-sm-12 col-xs-12">
                <select name="seller" id="">
                    <option value="">{{$data['text_page']['all_sellers']}}</option>
                    <option value="">{{$data['text_page']['private']}}</option>
                    <option value="">{{$data['text_page']['trade']}}</option>
                    <option value="">{{$data['text_page']['dealer']}}</option>
                </select>
            </div>
            </div>

            <div class="advance-filter-bottom col-md-12 col-sm-12 col-xs-12">

                <div class="col-md-6 col-sm-6 col-xs-12">

                    <select name="engine_size" id="engine" data-live-search="true" class="select-group-top">
                        <option value="">{{$data['text_page']['engine']}}</option>
                    </select>

                    <select name="fuel" id="fuel" class="select-group-middle">
                        <option value="">{{$data['text_page']['fuel']}}</option>
                    </select>

                    <select name="gear" id="gear" class="select-group-middle">
                        <option value="">{{$data['text_page']['transmission']}}</option>
                    </select>

                    <select name="door" id="door" class="select-group-middle">
                        <option value="">{{$data['text_page']['door']}}</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                    </select>


                    <select name="mileage" id="mileage" class="select-group-bottom">
                        <option value="">{{$data['text_page']['mileage']}}</option>
                        <option value="10000">{{$data['text_page']['up_to']}} 10,000 {{$data['text_page']['kilometres']}}</option>
                        <option value="20000">{{$data['text_page']['up_to']}} 20,000 {{$data['text_page']['kilometres']}}</option>
                        <option value="30000">{{$data['text_page']['up_to']}} 30,000 {{$data['text_page']['kilometres']}}</option>
                        <option value="40000">{{$data['text_page']['up_to']}} 40,000 {{$data['text_page']['kilometres']}}</option>
                        <option value="50000">{{$data['text_page']['up_to']}} 50,000 {{$data['text_page']['kilometres']}}</option>
                        <option value="60000">{{$data['text_page']['up_to']}} 60,000 {{$data['text_page']['kilometres']}}</option>
                        <option value="70000">{{$data['text_page']['up_to']}} 70,000 {{$data['text_page']['kilometres']}}</option>
                        <option value="80000">{{$data['text_page']['up_to']}} 80,000 {{$data['text_page']['kilometres']}}</option>
                        <option value="80000">{{$data['text_page']['up_to']}} 90,000 {{$data['text_page']['kilometres']}}</option>
                        <option value="100000">{{$data['text_page']['up_to']}} 100,000 {{$data['text_page']['kilometres']}}</option>
                        <option value="110000">{{$data['text_page']['up_to']}} 110,000 {{$data['text_page']['kilometres']}}</option>
                        <option value="120000">{{$data['text_page']['up_to']}} 120,000 {{$data['text_page']['kilometres']}}</option>
                        <option value="130000">{{$data['text_page']['up_to']}} 130,000 {{$data['text_page']['kilometres']}}</option>
                        <option value="140000">{{$data['text_page']['up_to']}} 140,000 {{$data['text_page']['kilometres']}}</option>
                        <option value="150000">{{$data['text_page']['up_to']}} 150,000 {{$data['text_page']['kilometres']}}</option>
                        <option value="160000">{{$data['text_page']['up_to']}} 160,000 {{$data['text_page']['kilometres']}}</option>
                        <option value="170000">{{$data['text_page']['up_to']}} 170,000 {{$data['text_page']['kilometres']}}</option>
                        <option value="180000">{{$data['text_page']['up_to']}} 180,000 {{$data['text_page']['kilometres']}}</option>
                        <option value="190000">{{$data['text_page']['up_to']}} 190,000 {{$data['text_page']['kilometres']}}</option>
                        <option value="200000">{{$data['text_page']['over']}} 200,000 {{$data['text_page']['kilometres']}}</option>
                    </select>

                </div>

                <div class="col-md-6 col-sm-6 col-xs-12">
                    
                    <select name="body" id="body" class="select-group-top">
                        <option value="">{{$data['text_page']['body_type']}}</option>
                    </select>

                    <select name="color" id="color" class="select-group-bottom">
                        <option value="">{{$data['text_page']['colour']}}</option>
                    </select>

                </div>

            </div>


        </div>
        <!-- ./col2 -->


        </div>
        <!-- ./row top -->


        <!-- row location -->

        <div class="row-location form-group col-md-12 col-sm-12 col-xs-12">
        
            <div class="col-md-4 col-sm-12 col-xs-12">
                <select name="province" id="province" data-live-search="true">
                    <option value="">{{$data['text_page']['province']}}</option>
                </select>
            </div>

            <div class="col-md-4 col-sm-12 col-xs-12">
                <select name="amphur" id="amphur" data-live-search="true">
                    <option value="">{{$data['text_page']['district']}}</option>
                </select>
            </div>

            <div class="col-md-4 col-sm-12 col-xs-12">
                <select name="district" id="district" data-live-search="true">
                    <option value="">{{$data['text_page']['subdistrict']}}</option>
                </select>
            </div>
        

        </div>
        <!-- ./row location -->




        <!-- row bottom -->
        <div class="row-adv-search-bottom form-group col-md-12 col-sm-12 col-xs-12">
            <div class="pull-left">
                <a href="#savesearch" id="save_search"><i class="fa fa-bookmark"></i> {{$data['text_page']['save_this_search']}}</a>
                <a href="{{ URL::to(App::getLocale().'/mysearch') }}" id="my_search"><i class="fa fa-heart"></i> {{$data['text_page']['my_searches']}}</a>
            </div>

            <div class="pull-right">

                <div class="form-group form-submit">
                    <a href="{{ URL::to(App::getLocale().'/listing') }}" id="reset_search"><i class="fa fa-repeat"></i> {{$data['text_page']['reset_search']}}</a>
                    <button type="submit" class="btn btn-default btn-sm btn-block search-btn">{{$data['text_page']['btn_search']}}<br>
                    <span>{{sprintf($data['text_page']['cars_available'], '<span id="search-avaliable">'.$data['car_avaliable'].'</span>') }}</span>
                    </button>
                </div>
            </div>

        </div>
        <!-- ./row bottom -->




        <!-- ./New Advance Search -->

    </form><!-- /#form-map -->
</section><!-- /#search-advance-->