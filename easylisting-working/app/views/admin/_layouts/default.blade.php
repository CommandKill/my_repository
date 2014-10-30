<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Content management system</title>
<meta name="description" content="">
<meta name="author" content="">
<link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
<link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('css/bootstrap-theme-admin.css') }}">
@yield('head-wrapper')
</head>
<body>
@yield('content-wrapper')
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/jquery-ui-1.10.4.custom.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
@yield('footer-wrapper')
</body>
</html>