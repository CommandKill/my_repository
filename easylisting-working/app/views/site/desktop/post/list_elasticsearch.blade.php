<div class="search-filter row">
    <div class="col-md-6 col-sm-6 col-xs-6">
        <h3 class="search-result-txt"><i class="fa fa-search"></i> Search Results <b class="search-count">{{ $total }}</b><h3>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-6">
        <div class="sorting">
            <!-- <div class="form-group">
                <button type="button" class="btn btn-default" name="compareButton" id="compareButton">Compare Car</button>
            </div> -->

<!--             <div class="col-sm-5 col-sm-5 col-xs-12 pull-left no-padding no-margin">
                <select name="order" id="order">
                    <option value="">Order By</option>
                    <option value="asc">Ascending</option>
                    <option value="desc">Descending</option>
                </select>
            </div> -->
            <div class="col-sm-6 col-sm-6 col-xs-12 pull-right no-padding no-margin">
                <select name="sortby" id="sortby">
                    <option value="">Sort By</option>
                    <option value="distant">Distance</option>
                    <option value="lowest_price">Price (lowest)</option>
                    <option value="highest_price">Price (highest)</option>
                    <option value="mileage">Mileage</option>
                    <option value="year">Year</option>
<!--                     <option value="make">Make</option>
                    <option value="model">Model</option> -->
                    <option value="certified">Certified</option>
                </select>
            </div><!-- /.form-group -->
        </div>
    </div>
</div>
<section class="col-md-12">
    @if($posts)
    @foreach($posts as $k => $post)
    <div class="car-item row display-lines {{ $k == 0 ? 'promote' : '' }}" style="margin-bottom:10px;padding-bottom:10px">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding file-preview-image-holder">
                    @if($post['_source']['thumbnail'] != 'null')
                    <img class="file-preview-image" src="{{ asset('uploaded/car/'.$post['_source']['id'].'/800x600_'.$post['_source']['thumbnail']) }}" title="{{ $post['_source']['thumbnail'] }}" alt="{{ $post['_source']['thumbnail'] }}">
                    @else
                    <img class="file-preview-image" src="{{ asset('img/avatar.jpg') }}" title="placeholder" alt="placeholder">
                    @endif
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
                    <div class="owl-demo">
                        @foreach($post['_source']['gallery'] as $image)
                        <div class="item">
                            <a href="#"><img class="lazyOwl" data-src="{{ asset('uploaded/car/'.$post['_source']['id'].'/gallery/thumb_'.$image) }}" title="" alt="" ></a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 car-item-desc">
            <header>
                <a href="{{ URL::to(App::getLocale().'/car-detail/'.$post['_source']['id']) }}">{{ $post['_source']['lang']['en']['title'] }}</a><br/>
                {{ Str::limit($post['_source']['lang']['en']['description'], 70) }}
            </header>
            
            <div class="row car-info">
                <div class="col-lg-7 col-md-8 col-sm-8 col-xs-12">
                    <ul class="info-extra-list">
                        <li><i class="oo-icon-mini icon-mile"></i> {{$post['_source']['mileage'] or 'n/a'}}</li>
                        <li><i class="oo-icon-mini icon-year"></i>{{$post['_source']['information']['year'] or 'n/a'}}</li>
                        <li><i class="oo-icon-mini icon-gear"></i>{{$post['_source']['information']['transmissionType'] or 'n/a'}}</li>
                        <li><i class="oo-icon-mini icon-engine"></i> {{$post['_source']['information']['engineSize'] or 'n/a'}}</li>
                        <li><i class="oo-icon-mini icon-fuel"></i> {{$post['_source']['information']['engineFuelType'] or 'n/a'}}</li>
                        <li><i class="oo-icon-mini icon-colour"></i> {{$post['_source']['color']['colorName'] or 'n/a'}}</li>
                    </ul>
                </div>
                <div class="col-lg-5 col-md-4 col-sm-4 col-xs-12">

                   
                </div>
            </div>

            <div class="row car-info-sub">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <ul class="left-side">
                        <li><img class="dealer-icon" src="{{ asset('img/dealer-sample-icon.png') }}" /></li>
                        <li><!-- <span style="margin-right:20px;">ID N1408{{ $post['_source']['id'] }}</span> --><a href="#report">Report spam</a></li>
                        <li></li>
                    </ul>
                    
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    
                    <!-- <div style="clear:both;padding: 10px 0 0 0;"> -->

                        <ul class="right-side">
                            <li><div class="tag price pull-right" style="margin-bottom: 10px;">{{ number_format($post['_source']['price']) }} ฿</div></li>
                            <li><a style="cursor:pointer" class="compare-popover-dismiss pull-right" data-toggle="popover" title="Add this car to compare list?" data-carid="{{ $post['_source']['id'] }}" data-cartitle="{{ $post['_source']['lang']['en']['title'] }}" data-placement="top" data-content="And here's some amazing content. It's very engaging. Right?"><i class="oo-icon-mini icon-compare"></i> Compare</a></li>
                            <li><div class="pull-right"><i class="oo-icon-mini icon-location"></i> {{ number_format($post['fields']['distance'][0], 2) }} kilometers</div></li>
                        </ul>

                    <!-- </div> -->
                    
                </div>
            </div> 
        </div>



    </div>

    @endforeach
    <input type="hidden" id="comparecar-list" value="" />
    <div class="center">
        <ul class="pagination">
            {{ $pager->links(); }}
        </ul>
    </div>
    @else
    <p class="text-center">
        <h2><i class="fa fa-frown-o"></i> We found 0 car under this search.</h2>
     Do you want to save the search so we can notify you when the car is listed?<br/>
    <a href="#save" data-toggle="modal" data-target="#modal-under-construction">[SAVE]</a>
    </p>
    @endif


</section>
    <div class='modal fade' id='modal-under-construction' tabindex='-1'>
      <div class='modal-dialog'>
        <div class='modal-content'>
          <!-- <form class="form-search validate-form no-padding" id="frmDelete" method="post" action="#" accept-charset="UTF-8"> -->
            <div class='modal-header'>
             <button aria-hidden='true' class='close' data-dismiss='modal' type='button'>×</button>
             <h4 class='modal-title' id='myModalLabel'>Under construction</h4>
            </div>
            <div class='modal-body' style="padding-bottom: 0;">
                 <div class='form-group'>
                    <label class='control-label'>...</label>
                 </div> 
            </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div> <!-- /.modal -->     