<div class="search-filter row">
    <div class="col-xs-6">
        <h3 class="search-result-txt"><i class="fa fa-search"></i> {{$data['text_page']['search_results']}} <b class="search-count">{{ $total }}</b><h3>
    </div>
    <div class="col-xs-6">
        <div class="sorting">
            <div class="col-xs-6 pull-right no-padding no-margin">
                <select name="sortby" id="sortby">
                    <option value="">{{$data['text_page']['sort_by']}}</option>
                    <option value="distant">{{$data['text_page']['distance']}}</option>
                    <option value="lowest_price">{{$data['text_page']['price']}} ({{$data['text_page']['lowest']}})</option>
                    <option value="highest_price">{{$data['text_page']['price']}} ({{$data['text_page']['highest']}})</option>
                    <option value="mileage">{{$data['text_page']['mileage']}}</option>
                    <option value="year">{{$data['text_page']['year']}}</option>
                    <option value="certified">{{$data['text_page']['inspected_cars']}}</option>
                </select>
            </div>
        </div>
    </div>
</div>
<section class="col-xs-12">
    @if($posts)
    @foreach($posts as $k => $post)
    <div class="car-item row display-lines {{ $k == 0 ? 'promote' : '' }}">
        <div class="col-xs-12 car-item-info">
            <div class="car-item-info-left">
                @if($post['_source']['thumbnail'] != 'null')
                <img class="file-preview-image" src="{{ asset('uploaded/post/'.$post['_source']['id'].'/gallery/330x200-'.$post['_source']['thumbnail']) }}" title="{{ $post['_source']['thumbnail'] }}" alt="{{ $post['_source']['thumbnail'] }}">
                @else
                <img class="file-preview-image" src="{{ asset('img/avatar.jpg') }}" title="placeholder" alt="placeholder">
                @endif

                <!-- <img class="dealer-icon img-circle img-thumbnail" src="{{ asset('uploaded/member/'.$post['_source']['post_by']['id'].'/50x50-'.$post['_source']['post_by']['avatar']) }}" /> -->
            </div>
            <div class="car-item-info-right">
                <!-- <small data-id="{{ $post['_source']['id'] }}">ID {{ $post['_source']['id'] }}</small> -->
                <input type="hidden" id="item-post-id" value="{{ $post['_source']['id'] }}" />
                <header>
                <a href="{{ URL::to(App::getLocale().'/car-detail/'.$post['_source']['id']) }}">
                    {{ $post['_source']['make']['make'] or '' }} {{ $post['_source']['model']['model'] or '' }} {{ $post['_source']['submodel']['sub_model'] or '' }}
                </a>
                </header>
                <ul class="info-extra-list">
                    <li><i class="oo-icon-mini icon-mile"></i> {{$post['_source']['mileage'] or 'n/a'}}</li>
                    <li><i class="oo-icon-mini icon-year"></i>{{$post['_source']['year']['year'] or 'n/a'}}</li>
                    <li><i class="oo-icon-mini icon-gear"></i>{{$post['_source']['gear']['gear'] or 'n/a'}}</li>
                    <li><i class="oo-icon-mini icon-engine"></i> {{$post['_source']['engine']['size'] or 'n/a'}}</li>
                    <li><i class="oo-icon-mini icon-fuel"></i> {{$post['_source']['fuel']['type'] or 'n/a'}}</li>
                    <li><i class="oo-icon-mini icon-colour"></i> {{$post['_source']['color']['color'] or 'n/a'}}</li>
                </ul>

                <!-- Trustee List -->
                <div class="trustee-list">
                    <label class="trustee-label">Trustee List</label>
                    <ul class="trustee-list-info">
                        <li><i class="fa fa-check"></i>Member</li>
                        <li><i class="fa fa-check"></i>
                            @if($post['_source']['seller_verified']['verified'] === 1)
                                Seller Verified
                            @else
                                Not
                            @endif
                        </li>
                        <li><i class="fa fa-check"></i>Inspected</li>
                    </ul>
                </div>

            </div>
        </div>
        <div class="col-xs-12 car-item-desc">
            <div class="btn-reporting pull-left">
                <a href="#report" class="btn-report"><i class="glyphicon glyphicon-flag"></i> {{$data['text_page']['report_this_listing']}}</a>
            </div>
            <div class="btn-group pull-right ">
                <a style="cursor:pointer" class="compare-popover-dismiss btn btn-default" data-toggle="popover" title="Add this car to compare list?" data-carid="{{ $post['_source']['id'] }}" data-cartitle="{{ $post['_source']['make']['make'] or '' }} {{ $post['_source']['model']['model'] or '' }} {{ $post['_source']['submodel']['sub_model'] or '' }}" data-placement="top" data-content="And here's some amazing content. It's very engaging. Right?"><i class="glyphicon glyphicon-transfer"></i> {{$data['text_page']['compare']}}</a>
              <button type="button" class="btn btn-default btn-price">{{ number_format($post['_source']['price']) }} ฿</button>
            </div>
            <div class="pull-right distance-box">
                <i class="oo-icon-mini icon-location"></i> {{ number_format($post['fields']['distance'][0], 2) }} km
            </div>
        </div>
    </div>

    @endforeach
    <input type="hidden" id="comparecar-list" value="" />
    <div class="center">
        {{ $pager->links(); }}
    </div>
    @else
    <p class="text-center">
        <h2><i class="fa fa-frown-o"></i> We found 0 car under this search.</h2>
     Do you want to save the search so we can notify you when the car is listed?<br/>
    <a href="#save" data-toggle="modal" data-target="#modal-under-construction">[SAVE]</a>
    </p>
    @endif
</section>  