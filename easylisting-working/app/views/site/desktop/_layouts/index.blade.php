@extends('site.desktop._layouts.default')

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
{{ HTML::style('css/bootstrap.css') }}
{{ HTML::style('css/bootstrap-theme-site.css') }}
{{ HTML::style('css/site.css') }}
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
@yield('head')
@stop

@section('content-wrapper')
<div class="wrapper">
    <div class="navigation">
		@include('site.desktop._partials.header')
		@include('site.desktop._partials.nav')
    </div>
    <div id="page-content">
    	@yield('content')
    </div>
    @include('site.desktop._partials.footer')
    <a href="#back-top-top" class="scroll-to-top">back to top</a>
</div>
@stop

@section('footer-wrapper')

@yield('footer')
<script src="{{ asset('js/site.js') }}"></script>
@stop