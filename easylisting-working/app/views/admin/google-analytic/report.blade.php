<table>
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