@extends('site._layouts.easycar')

@section('head')
{{ HTML::style('css/plugins/jquery-slider/jquery.slider.min.css') }}
{{ HTML::style('css/plugins/owl-carousel/owl.carousel.css') }}
{{-- HTML::style('css/plugins/owl-carousel/owl.theme.css') --}}
{{ HTML::style('css/_site/list.css') }}
@stop

@section('content')
        <!-- Breadcrumb -->
        <div class="container">
            <ol class="breadcrumb">
                <li><a href="{{ URL::to(App::getLocale().'/') }}">Home</a></li>
                <li class="active">Cars Listing</li>
            </ol>
        </div>
        <!-- end Breadcrumb -->
		
        <div class="container">
            <div class="col-lg-8 col-md-8 col-sm-12">
                <div class="row">
                    <h1 style="margin: 0 0 20px 0;">Find my car</h1>
                    <div class="col-sm-12">
                        <div class="row">
                        @include('site.car.advance-search')
                        </div>  
                    </div>
                    <div class="col-sm-12">
                        <div class="row">
                            @include('site.car.list')
                        </div> 
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="row">
                    <div class="col-sm-12 col-xs-12">

                        <div class="col-lg-12 col-md-12 col-sm-6">
                            @include('site.widgets.howto')
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-6">
                            @include('site.widgets.feature-car')
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-6">
                            @include('site.widgets.latest-car')
                        </div>
                    </div>
                    <!-- <div class="col-sm-12" style="background:#ddd">22</div>  -->
                </div>
            </div>
        </div><!-- /.container -->
@stop

@section('footer')
{{ HTML::script('js/plugins/iCheck/icheck.min.js') }}
{{ HTML::script('js/plugins/jshashtable-2.1_src.js') }}
{{ HTML::script('js/plugins/jquery.numberformatter-1.2.3.js') }}
{{ HTML::script('js/plugins/simplae-javascript-templating.min.js') }}
{{ HTML::script('js/plugins/jquery.dependclass.min.js') }}
{{ HTML::script('js/plugins/draggable.min.js') }}
{{ HTML::script('js/plugins/jquery.slider.min.js') }}
{{ HTML::script('js/plugins/owl-carousel/owl.carousel.min.js') }}
{{ HTML::script('js/_site/list.js') }}
<script type="text/javascript">

</script>
@stop
