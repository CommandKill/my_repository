@extends('admin._layouts.index')
@section('content')
<div class="row">
	<div class="col-xs-6">

		<div class="panel panel-default">
		  <div class="panel-heading">Browser report</div>
		  <div class="panel-body">
		  	@if ($ga)
		    <table class="table table-hover">
				<tr>
				  <th>Browser &amp; Browser Version</th>
				  <th>Pageviews</th>
				  <th>Visits</th>
				</tr>
				
				@foreach($ga->getResults() as $result)
				<tr>
				  <td>{{ $result }}</td>
				  <td>{{ $result->getPageviews() }}</td>
				  <td>{{ $result->getVisits() }}</td>
				</tr>
				@endforeach
				</table>

				<table>
				<tr>
				  <th>Total Results</th>
				  <td>{{ $ga->getTotalResults() }}</td>
				</tr>
				<tr>
				  <th>Total Pageviews</th>
				  <td>{{ $ga->getPageviews() }}
				</tr>
				<tr>
				  <th>Total Visits</th>
				  <td>{{ $ga->getVisits() }}</td>
				</tr>
				<tr>
				  <th>Results Updated</th>
				  <td>{{ $ga->getUpdated() }}</td>
				</tr>
			</table>
			@endif
		  </div>
		</div>

	</div>
	<div class="col-xs-6">

		<div class="panel panel-default">
		  <div class="panel-heading">Server Information</div>
		  <div class="panel-body">
		  	@if ($sysinfo)
		    <dl>
            <dt>Uptime</dt>
            <dd>{{ $sysinfo['uptime'] or 'n/a' }}</dd>
            <dt>Boot</dt>
            <dd>{{ $sysinfo['boot'] or 'n/a' }}</dd>
            <dt>OS</dt>
            <dd>{{ $sysinfo['info']['OS'] or 'n/a' }} {{ $sysinfo['info']['Kernel'] or 'n/a' }}</dd>
            <dt>Cpu Architecture</dt>
            <dd>{{ $sysinfo['info']['CPUArchitecture'] or 'n/a' }}</dd>
            <dt>Model</dt>
            <dd>{{ $sysinfo['model'] or 'n/a' }}</dd>
            </dl>
            @endif
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