@if($content->gallery->count()>0)
<section id="car-gallery">
    <div class="owl-carousel car-carousel">
@foreach($content->gallery as $gal)
    <div class="car-slide row">
        <a href="{{ asset('uploaded/car/'.$content->id.'/gallery/'.$gal->name) }}" class="image-popup" data-toggle="lightbox" data-gallery="multiimages">
            <!-- <div class="overlay"><h3>Right side view</h3></div> -->
            <img class="lazyOwl" alt="" data-src="{{ asset('uploaded/car/'.$content->id.'/gallery/'.$gal->name) }}">
        </a>
    </div><!-- /.car-slide -->
@endforeach
</section>
@endif


