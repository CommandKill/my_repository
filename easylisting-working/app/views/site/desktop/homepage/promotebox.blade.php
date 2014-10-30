@if (isset($promotes) && $promotes->count() > 0)

<div id="promote-box">

	<div class="col-xs-12" id="slideshow-main">

        <div class="car">
            <a href="{{ URL::to(App::getLocale().'/promote/'.$promotes[0]['id']) }}">
                <div class="car-image">
                    @if ( $promotes[0]['thumbnail'] != 'null' )
                  	<img src="{{ sprintf($promotes_image_file_template, $promotes[0]['id'], $promotes[0]['thumbnail']) }}" alt="" />
                  	@else
                  	<img src="{{ asset('img/blog-empty.jpg') }}" alt="" class="pull-right"/>
                  	@endif
                </div>
                <div class="overlay">
                    <div class="info">
                        <h3 class="title">{{ $promotes[0]['lang'][0]['title'] }}</h3>
                        <figure class="createdate">{{ $promotes[0]['created_at'] }}</figure>
                    </div>
                </div>
            </a>
        </div>

	</div>

	<div class="col-xs-12" id="slideshow-items">
	    <ul>
	    	@foreach($promotes as $promote)
	        <li class="active col-xs-4">
	            <a href="{{ URL::to(App::getLocale().'/promote/'.$promote['id']) }}" 
	            	data-createdate="{{ $promote['created_at'] }}" 
	            	data-full="{{ sprintf($promotes_image_file_template, $promote['id'], $promote['thumbnail']) }}">

					           @if ( $promote['thumbnail'] != 'null' )
                  	<img src="{{ sprintf($promotes_image_file_template, $promote['id'], $promote['thumbnail']) }}" alt="" class="pull-right"/>
                  	@else
                  	<img src="{{ asset('img/blog-empty.jpg') }}" alt="" class="pull-right"/>
                  	@endif

	            	<strong class="title">{{Str::limit($promote['lang'][0]['title'],35,'...')  }}</strong>
	            	<p class="desc">{{ $promote['lang'][0]['description'] }}</p>
	        	</a>
	        </li>
	        @endforeach
	    </ul>
	</div>

</div>
@endif