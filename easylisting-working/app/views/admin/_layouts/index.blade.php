@extends('admin._layouts.default')

@section('head-wrapper')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@yield('head')
@stop

@include('admin._partials.header')

@section('content-wrapper')

<div class="container" role="main">
  <div class="row">
    <div class="col-xs-3">

        @include('admin._partials.nav')

    </div>
    <div class="col-xs-9" style="min-height:700px;">
      
      <div class="row">
        <div class="col-xs-12">
          <div class="page-title">
            <!-- <div class="page-title"  data-spy="affix" data-offset-top="20"> -->
          <h2>{{ $data['title'] }}</h2>
          <small>{{ $data['description'] }}</small>
          </div>
        </div>
        
      </div>
      
      @yield('content')

    </div>
  </div>

  <footer>
    <div class="row">
      <div class="col-xs-12">

        @include('admin._partials.footer')

      </div>
    </div>

  </footer>

</div>

@stop

@section('footer-wrapper')
@yield('footer')
<script src="{{ asset('js/admin.js') }}"></script>
@stop