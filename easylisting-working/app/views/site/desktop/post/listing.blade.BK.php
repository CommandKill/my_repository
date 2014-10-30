@extends('site.desktop._layouts.index')
@section('content')
<div class="row">
<div class="col-xs-12">
<b>{{ $data['title'] }}</b>
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