@extends('site.desktop._layouts.index')
@section('head')
<style>
.setup-panel li.active a {
    /*background-color: #ccc;*/
}
.setup-panel li a {
    width: 50px;
    height: 50px;
    padding: 20px;
    line-height: 10px;
    font-size: 20px;
    border-radius: 500px 500px 500px 500px;
    min-height: 50px;
    /*float: left;*/
    color: #fff;
    background-color: #eee;
    margin: 0 auto;
}
.line{
position: relative;
top: 25px;
left: 0;
margin: 0;
}
.setup-content h1{
	border: none;
}
.price {
	position: absolute;
top: 11px;
right: 30px;
}
label {
	font-weight: lighter;
}
.caption h3{
	margin: 0 !important;
}
.thumbnail{
	min-height: 280px;
}
</style>
@stop
@section('content')
<div class="row">
<div class="col-xs-12">
<div class="container page">
    <div class="row detail-page">
        <div class="col-xs-9">
            <header class="car-title">
                <h1 style="color:#1B5184;">{{ $data['page_title'] }}</h1>
            </header>
	        <div class="row">
	            <div class="col-xs-12">
	                <div class="row">
	                    <div class="row form-group">
	                        <div class="col-xs-12">
	                        	<hr class="line"/>
	                            <ul class="nav nav-pills nav-justified setup-panel">
	                                @foreach ($questionaire->question as $key => $value) 
	                                <li class="{{$key == 0?'active':''}}"><a href="#step-{{$key}}">{{$key+1}}</a></li>
	                                @endforeach
	                                <li class="submit"><a href="#step-{{$key+1}}">{{$key+2}}</a></li>
	                            </ul>
	                        </div>
	                    </div>
	                    @foreach ($questionaire->question as $key => $value) 
	                    <div class="row setup-content" id="step-{{$key}}">
	                        <div class="col-xs-12">
	                            <div class="col-md-12">
	                                <h1 class="question">{{ $value->lang[0]->title }}</h1>
	                                @foreach ($value->answer as $key_answer => $value_answer)
	                                <div>
	                                    @if ($value_answer->illustration)
	                                    <img src="{{$thumbnail_path}}/thumb_{{$value_answer->illustration}}" title="" />
	                                    @endif
	                                    <input type="radio" id="answer-{{$key}}}-{{$key_answer}}" name="answer-answer-{{$key}}}" /> 
	                                    <label for="answer-{{$key}}}-{{$key_answer}}">{{ $value_answer->lang[0]->title }}</label><br/>
	                                </div>
	                                <!-- <hr/> -->
	                                @endforeach
	                                <br/>
	                                <button class="btn submit-btn next pull-right" data-current="#step-{{$key}}" data-next="#step-{{$key+1}}">Next <i class="glyphicon glyphicon-chevron-right"></i></button>
	                            </div>
	                        </div>
	                    </div>
	                    @endforeach
	                    <div class="row setup-content" id="step-{{$key+1}}">
	                        <div class="col-xs-12">
	                            <div class="col-md-12 text-center">
	                                <h1>Result</h1>
	                                <div id="result-cars"></div>
	                            </div>
	                        </div>
	                    </div>
	                </div> 
	            </div>
	        </div>
        </div>
        <div class="col-xs-3">
            <div class="row">
                <div class="col-xs-12">
                    @include('site.desktop.widgets.howto')
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<div id="template-car-item" style="display:none">
	
	  <div class="col-xs-6">
	    <div class="thumbnail">
	      <img src="#car-image#" title="placeholder" alt="placeholder">
	      <div class="caption">
	        <a href="#car-link#"><h3>#car-title#</h3></a>
	        <p><button class="btn btn-default price" role="button">#car-price#</button></p>
	      </div>
	    </div>
	  </div>
	
</div>
@stop
@section('footer')
{{-- HTML::script('js/sample.js') --}}
<script type="text/javascript">
$(document).ready(function() {
    
    var navListItems = $('ul.setup-panel li a'),
        allWells = $('.setup-content');

    allWells.hide();

    navListItems.click(function(e)
    {
        e.preventDefault();
        var $target = $($(this).attr('href')),
            $item = $(this).closest('li');
        
        if (!$item.hasClass('disabled')) {
            navListItems.closest('li').removeClass('active');
            $item.addClass('active');
            allWells.hide();
            $target.show();
        }
    });
    
    $('ul.setup-panel li.active a').trigger('click');
    
    // DEMO ONLY //
    // $('#activate-step-2').on('click', function(e) {
    //     $('ul.setup-panel li:eq(1)').removeClass('disabled');
    //     $('ul.setup-panel li a[href="#step-2"]').trigger('click');
    //     $(this).remove();
    // })   

    $('.next').click(function(){
        var sObj = $(this);
        var currentId = sObj.data('current');
        var nextId = sObj.data('next');
        // console.log($(currentId));
        // console.log($('ul.setup-panel li a[href="'+nextId+'"]'));
        // $('ul.setup-panel li a[href="'+nextId+'"]').removeClass('disabled');
        $('ul.setup-panel li a[href="'+nextId+'"]').trigger('click');
    }); 

    $('.submit').click(function(){
        var sObj = $(this);
        // sObj.text('processing...');
        // get car search from question
        $.get('/wizard/car-from-question', function(data){
            if(data.error == false) {
                $('#result-cars').empty();
                $.each(data.data, function(i,car){

                	console.log(car);

                    var thumbmail = '{{ asset("img/car-empty.jpg") }}';
                    if(car.thumbnail != 'null' && car.thumbnail != '') {
                        thumbmail = '{{ asset("uploaded/post") }}/' + car.id + '/320x200-' + car.thumbnail;
                    }
                    var link = '{{ URL::to(App::getLocale()."/car-detail") }}/'+car.id;
                    var content = $('#template-car-item').html();
                    content = content.replace('#car-image#', thumbmail);
                    content = content.replace('#car-title#', car.make['make'] + ' ' + car.model['model'] + ' ' + car.submodel['sub_model']);
                    content = content.replace('#car-link#', link);
                    content = content.replace('#car-price#', car.price);
                    $('#result-cars').append(content);

                    // sObj.text('Check again');
                });
            }
            
        });
    });
});


</script>
@stop