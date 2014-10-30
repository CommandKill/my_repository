<!DOCTYPE html>
<html lang="{{ $data['locale'] }}">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title>{{ $data['page_title'] or ''}} {{ $data['text']['site'] or ':)' }}</title>
<meta name="description" content="{{ $data['description'] }}">
<meta name="author" content="{{ trans('site.site_author') }}">
<link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
@yield('head-wrapper')
</head>
<body>
@yield('content-wrapper')
@yield('footer-wrapper')
</body>
</html>