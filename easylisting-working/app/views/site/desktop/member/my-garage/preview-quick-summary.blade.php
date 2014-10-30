<section id="quick-summary" class="clearfix">
<div class="col-md-12 col-sm-12 col-xs-12">
    <dl>
        <dt>Location</dt>
        <dd><strong id="preview-address"></strong></dd>
    </dl>
	<hr class="col-lg-12 no-padding">

	@if( $data['seller_verified']['status'] == 1 )
		<p><img src="{{ asset('img/icons/icon-certified-seller@1x.png') }}">Verified Seller</p>
	@endif

</div>
</section>