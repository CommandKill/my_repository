<!DOCTYPE html>
<html lang="{{ $data['locale'] }}">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, maximum-scale=1.0" />
<title>{{ trans('site.site_name') }}</title>
<meta name="description" content="{{ $data['description'] }}">
<meta name="author" content="{{ trans('site.site_author') }}">
<link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
<link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('css/bootstrap-theme-mobile-site.css') }}">
@yield('head-wrapper')
</head>
<body>
@yield('content-wrapper')
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
@yield('footer-wrapper')
</body>
</html>