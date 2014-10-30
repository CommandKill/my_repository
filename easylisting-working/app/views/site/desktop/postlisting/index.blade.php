@extends('site.desktop._layouts.index')

@section('head')
{{ HTML::style('css/plugins/jquery-slider/jquery.slider.min.css') }}
{{ HTML::style('css/plugins/owl-carousel/owl.carousel.css') }}
{{-- HTML::style('css/plugins/owl-carousel/owl.theme.css') --}}
{{ HTML::style('css/plugins/bootstrap-select/bootstrap-select.min.css') }}
{{ HTML::style('css/plugins/jgrowl/jquery.jgrowl.min.css') }}
{{ HTML::style('css/dropdown.css') }}
<style>
.car-report-item-questionaire .question {
  color: #000;
  font-size: 18px;
}
.car-report-item-questionaire label{
  font-weight: normal;
  color:#000;
}
.car-report-title {
    border-bottom: 0px;
    padding: 20px 20px 0px 40px;
    color: #141414;
}
.car-report-item-info{
    background: #efeeee;
    padding: 30px 40px 30px 40px;
}
.car-report-item-info-left {
    float: left;
    width: 200px;
}
.car-report-item-info-right {
    float: right;
    width: 290px;
}
.car-report-item-info-left img {
    width:100%;
}
.car-report-item-info-right header{
    font-size: 22px;    
}
.car-report-item-questionaire {
    float: left;
    width: 100%;
   padding: 15px 40px 15px 40px; 
}
.car-report-item-questionaire strong {
    margin: 0 0 10px 0;
    display: block;
    font-size: 18px;

}
.car-report-item-questionaire .report-answer {
    float: left;
    width: 200px;
    margin: 10px 10px 5px 10px;
}
.thankyou-page {
  position: absolute;
  top: 80px;
  left: 0;
  width: 100%;
  height: 100%;
  background: #fff;
  margin: 0;
  text-align: center;
  padding-top: 172px;
  display: none;
}

.listing-page {
    margin-top: 30px;
    margin-bottom: 30px;
}
.car-item {
    padding: 0px;
}
.car-item-info {
    padding: 0px;
}
.car-item-info-left {
    float: left;
    height: 220px;
    width: 330px;
    position: relative;
}
.car-item-info-right {
    float: right;
    height: 220px;
    width: 410px;
    padding: 14px;
}
.car-item .car-item-info-left .dealer-icon {
    position: absolute;
    bottom: 10px;
    left: 10px;
}
.car-item .car-item-desc{
    height: 52px;
    border-bottom-left-radius: 2px;
    border-bottom-right-radius: 2px;
    background: #F9F9F9;
    border-top: 2px solid #E5E5E5;
    padding-top: 6px;
    font-weight: lighter;
}
.car-item-desc .arrow {
    top:auto !important;
}
.car-item.display-lines{
    border: 2px solid #E5E5E5;
    margin-bottom: 20px;
    border-radius: 4px;
}
.car-item .car-item-desc .btn {
    box-shadow: none;
    webkit-box-shadow: none;
    font-weight: lighter;
    padding: 5px 26px;
    margin-top: 2px;
}
.car-item .car-item-desc .btn-price:hover,
.car-item .car-item-desc .btn-price {
    background: #06A2E7 !important;
    color: #ffffff !important;
    border: 1px solid #06A2E7;
    font-size: 14px;
}

.car-item .car-item-desc .btn-reporting,
.car-item .car-item-desc .distance-box{
    margin-top: 10px;
    margin-right: 20px;
}
.info-extra-list {

}
.info-extra-list li {
    width: 119px;
    float: left;
    margin: 4px;
    /*color: #141414;*/
    font-weight: lighter;
}
.info-extra-list li i {
    margin-right: 10px;
}
.file-preview-image {
    width: 330px;
    height: 220px;
}
.pagination li a{
    padding: 8px 14px !important;
}
.pagination > .active > a, .pagination > .active > span {
    padding: 8px 14px !important;
    background: #06A2E7 !important;
    border: 1px solid #06A2E7;
    color: #ffffff;

}
.btn-close-modal {
    background: red;
    width: 28px;
    height: 28px;
    text-align: center;
    position: absolute;
    right: -10px;
    top: -10px;
    color: #fff;
    font-size: 25px;
    border-radius: 50%;
    border: solid 2px;
    line-height: 20px;
    cursor: pointer;
    -webkit-box-shadow: 0 1px 14px rgba(0, 0, 0, 0.5);
    box-shadow: 0 1px 4px rgba(0, 0, 0, 0.5);
}
</style>
@stop

@section('content')
<div class="container listing-page">
    <div class="col-xs-9">
        <div class="row">
            <h1 style="margin: 0 0 20px 0;">{{$data['text_page']['find_your_next_car']}}</h1>
            <div class="col-xs-12">
                <div class="row">
                @include('site.desktop.postlisting.advance-search')
                </div>  
            </div>
            <div class="col-xs-12">
                <div class="row">
                    @include('site.desktop.postlisting.list')
                </div> 
            </div>
        </div>
    </div>
    <div class="col-xs-3">
        <div class="row">
            <div class="col-xs-12">
                <div class="col-xs-12">
                    @include('site.desktop.widgets.howto')
                </div>
            </div>
        </div>
    </div>
</div>
@include('site.desktop.postlisting.report-modal')
@stop

@section('footer')
{{ HTML::script('js/plugins/bootstrap_select/bootstrap-select.min.js') }}
{{ HTML::script('js/plugins/owl-carousel/owl.carousel.min.js') }}
{{ HTML::script('js/plugins/iCheck/icheck.min.js') }}
{{ HTML::script('js/plugins/jgrowl/jquery.jgrowl.min.js') }}
{{ HTML::script('js/advance-search.js') }}
{{ HTML::script('js/listing.js') }}
<script type="text/javascript">

$(function(){
	
    function getUrlVars()
    {
        var vars = [], hash;
        var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('#');
      // alert(hashes);
      return hashes[0];
      // alert(hashes[0]);
  //      for(var i = 0; i < hashes.length; i++)
  //      {
  //          hash = hashes[i].split('=');
  //          vars.push(hash[0]);
  //          vars[hash[0]] = hash[1];
  //      }
  //      return vars;
    }
    $("#save_search").click(function(){
      // alert(getUrlVars());
      // alert('click');
      // '{{ $total }}'
      // '{{ $result_ids }}'
      var data = getUrlVars();
      data += '&result_count={{ $total }}&result_ids={{ $result_ids }}';
      // console.log(data);
      if (data.indexOf("/listing") >= 0) {
        alert('Please choose at least one filter in advance search');
      }else {
        // alert(data);
        //console.log(data);
        $.post( "{{ URL::to(App::getLocale().'/save-search') }}", data)
        .done(function( data ) {
          // var json = $.parseJSON(data);
          $.jGrowl(data.msg);
            },"json");
      }
      return false;
    });
});	
	
</script>
@stop
