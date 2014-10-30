<div class="search-box-wrapper" style="width:275px;">
    <div class="search-box-inner">
        <div class="search-box main">
            <form role="form" style="display: none" class="form-search form-promotion" action="{{ URL::to(App::getLocale().'/listing') }}">
                <h2 class="title">{{$data['text_page']['find_your_next_car']}}</h2>
                  
                  <input type="hidden" name="distance_in_km" id="distance" value="10" />
                  <input type="hidden" name="lat" id="lat" value="" />
                  <input type="hidden" name="lon" id="lon" value="" />

                  <input type="hidden" name="inspected" id="inspected" value="" />
                 <!-- New Search Box -->

                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                  <li class="tab-all active"><a href="#all" id="tab-all" role="tab" data-toggle="tab">{{$data['text_page']['all_cars']}}</a></li>
                  <li class="tab-cert"><a href="#certified" id="tab-certified" role="tab" data-toggle="tab"><i></i> {{$data['text_page']['inspected_cars']}}</a></li>
                </ul>


                <!-- Tab panes -->
                <div class="tab-content">

                      <div class="form-group">
                          <i class="fa fa-search"></i>
                          <input type="text" class="form-control" id="search-box-smart-search" name="q" placeholder="{{$data['text_page']['search']}}">
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
                                              {{-- <!-- <a tabindex="0" class="opt" style="" data-value="all">
                                              <span class="opt">{{$data['text_page']['show_all']}}</span>
                                              </a> --> --}}
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


                <div class="form-group form-submit">
                    <button type="submit" class="btn btn-default btn-sm btn-block search-btn">{{$data['text_page']['btn_search']}}<br>
                      <span>{{sprintf($data['text_page']['cars_available'], '<span id="search-avaliable">'.$data['car_avaliable'].'</span>') }}</span>
                    </button>
                </div>
                <div class="form-group">
                    <a href="{{ URL::to(App::getLocale().'/listing') }}">{{$data['text_page']['advanced_search']}}</a>
                </div>

                <!-- New Search Box -->


            </form><!-- /#form-map -->
        </div>
    </div>
</div><!-- /.search-box-wrapper -->