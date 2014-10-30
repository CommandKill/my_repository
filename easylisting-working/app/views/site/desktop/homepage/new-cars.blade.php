<header class="section-title"><h2>New cars for you</h2></header>
<div class="row new-cars">
    @foreach($posts as $post)
    <div class="col-xs-3">
        <div class="car">
            <a href="{{ URL::to(App::getLocale().'/car-detail/'.$post['id']) }}">
                <div class="car-image">
                    @if ( $post['thumbnail'] != 'null' )
                    <img src="{{ sprintf($post_image_file_template, $post['id'], $post['thumbnail']) }}" alt="" />
                    @else
                    <img src="{{ asset('img/blog-empty.jpg') }}" alt="" class="pull-right"/>
                    @endif
                </div>
                <div class="tag price">{{ $post['price'] or '' }}฿</div>
                <div class="overlay">
                    <div class="info">
                        <h3>{{ $post['make']['make'] or '' }} {{ $post['model']['model'] or '' }} {{ $post['submodel']['sub_model'] or '' }}</h3>
                        <!-- <figure>OVER LAND CRD 2.8 AT</figure> -->
                    </div>
                </div>
            </a>
        </div>
    </div>
    @endforeach
</div>