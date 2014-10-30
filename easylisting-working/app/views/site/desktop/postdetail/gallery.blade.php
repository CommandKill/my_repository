@if(isset($gallery) && !empty($gallery))
<section id="car-gallery">
	<div class="row text-right" id="gallery_total" style="margin-right:0px;font-weight:bold;">1/{{ count($gallery) }}</div>
    <div class="owl-carousel car-carousel">
@foreach($gallery as $val)
    <div class="car-slide">
        <a href="{{ asset('uploaded/post/'.$post_id.'/gallery/'.$val['name']) }}" class="image-popup" data-toggle="lightbox" data-gallery="columnwrappers" data-parent=".car-carousel">
            <img class="lazyOwl" alt="" data-src="{{ asset('uploaded/post/'.$post_id.'/gallery/512x342-'.$val['name']) }}">
        </a>
    </div>
@endforeach
	</div>
</section>
@endif