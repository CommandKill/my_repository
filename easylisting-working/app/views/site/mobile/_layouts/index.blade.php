@extends('site.mobile._layouts.default')

@section('head-wrapper')
<meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="Expires" content="0" />
<meta property="fb:admins" content="{{ $data['fb:admins'] or '' }}" />
<meta property="og:site_name" content="{{ $data['og:site_name'] or '' }}" />
<meta property="article:author" content="{{ $data['article:author'] or '' }}" />
<meta property="og:type" content="{{ $data['og:type'] or '' }}" />
<meta property="og:image" content="{{ $data['og:image'] or '' }}" />
<meta property="og:url" content="{{ $data['og:url'] or '' }}" />
<meta property="og:title" content="{{ $data['og:title'] or '' }}" />
<meta property="og:description" content="{{ $data['og:description'] or '' }}" />
@yield('head')
{{ HTML::style('css/plugins/sidr/jquery.sidr.light.css') }}
{{ HTML::style('css/mobile-site.css') }}
@stop
@section('content-wrapper')
@include('site.mobile._partials.nav')
@include('site.mobile._partials.header')
<div id="page-content">
@yield('content')
</div>
@include('site.mobile._partials.footer')
<a href="#back-top-top" class="scroll-to-top">back to top</a>
@stop

@section('footer-wrapper')
@yield('footer')
{{ HTML::script('js/plugins/jquery.sidr.min.js') }}
{{ HTML::script('js/mobile-site.js') }}
@stop