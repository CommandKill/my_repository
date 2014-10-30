@extends('site.desktop._layouts.index')
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
@stop
@section('footer')
{{-- HTML::script('js/sample.js') --}}
<script type="text/javascript">
$(function(){
  
});
</script>
@stop