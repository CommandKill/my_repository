<div class="alert alert-success" role="alert" style="display:none">
<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
<h2>Update Successfully</h2>
</div>
<!-- <div class="col-xs-3">
<div class="submit-step">
	<figure class="step-number">5</figure>
	<div class="description">
	    <p>{{ $data['upload_step'][4]['value'] }}</p>
	</div>
</div>
</div> -->

<div class="col-xs-12 preview-content">
    <header class="car-title">
        <h1 style="color:#1B5184;" id="preview-title"></h1>
		<small style="color:#1B5184;" id="preview-description"></small>
        <span class="actions">
            <!-- <a href="#" class="fa fa-print"></a> -->
			<span class="tag price" id="preview-price"> </span>
        </span>
    </header>
    <div class="row">
        <div class="col-xs-8">
            @include('site.desktop.member.my-garage.preview-gallery')

            <div class="row">
                <div class="col-xs-12">
                    <section id="description">
                        <header>
                            <h2>Car Description</h2>
                        </header>
                        <div class="col-md-4 col-sm-4">
                            <span><img src="{{ asset('img/icons/icon-mile@1x.png') }}"><span id="preview-mileage"></span>กม. &nbsp;</span>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <span> <img src="{{ asset('img/icons/icon-year@1x.png') }}"> <span id="preview-year"></span>&nbsp;</span>
                        </div>
                        <div class="col-md-4 col-sm-4"> 

                                <span> <img src="{{ asset('img/icons/icon-gear@1x.png') }}"> <span id="preview-cgear"></span> &nbsp;</span>
                        </div>
                        <br />
                        <div class="col-md-4 col-sm-4">     
                                <span><img src="{{ asset('img/icons/icon-engine@1x.png') }}"> <span id="preview-engine"></span></span>
                        </div>
                        <div class="col-md-4 col-sm-4">     
                                <span><img src="{{ asset('img/icons/icon-fuel@1x.png') }}"> <span id="preview-fuel"></span></span>
                        </div>
                        <div class="col-md-4 col-sm-4">     

                                <span><img src="{{ asset('img/icons/icon-colour@1x.png') }}"> <span id="preview-color"></span></span>
                            
                        </div>
                        <hr style="width:100%;margin-top:60px">
                        <p id="preview-detail"></p>
                    </section>
                </div>
            </div>
        </div>
        <div class="col-xs-4">

            @include('site.desktop.member.my-garage.preview-quick-summary')
            @include('site.desktop.member.my-garage.preview-agent')

        </div>
    </div>
</div>
<div class="form-group" style="float:left;width: 100%;">
<a class="btn-step btn submit-btn pull-left" data-index="3" id="btn8"><i class="glyphicon glyphicon-chevron-left"></i> Prev</a>
<!-- <input type="submit" class="btn-step btn submit-btn pull-right"  value="Submit" /> -->
<button class="btn-step btn submit-btn pull-right" id="btn-save" type="submit">Submit</button>
</div>