@extends('admin._layouts.index')
@section('header')
<style>

</style>

@stop
@section('content')
  <div class="row">
    <div class="col-xs-12">
        <div class='modal fade' id='modal-content' tabindex='-1'>
          <div class='modal-dialog'>
            <div class='modal-content'>
              <form class="form validate-form" id="frmCreate" style="margin-bottom: 0;" method="post" action="{{ URL::to('admin/package/store') }}" accept-charset="UTF-8">
                <div class='modal-header'>
                 <button aria-hidden='true' class='close' data-dismiss='modal' type='button'>×</button>
                 <h4 class='modal-title' id='myModalLabel'>Create new package</h4>
                </div>
                <div class='modal-body'>
                <input name="authenticity_token" type="hidden" />

                    <div class='tabbable'>
                        <ul class='nav nav-tabs'>
                            @foreach($languages as $lang)
                            <li @if($lang->id == 1) class='active' @endif >
                            <a data-toggle='tab' href='#tab{{ $lang->id }}'>
                                <i class='flag flag-{{ $lang->short_code }}'></i>
                                {{ $lang->title }}
                            </a>
                            </li>
                            @endforeach
                        </ul>
                        <br/>
                        <div class='tab-content'>
                            @foreach($languages as $lang)
                            <div class='tab-pane @if($lang->id == 1) active @endif' id='tab{{ $lang->id }}'>

                                <div class='form-group'>
                                    <label class='control-label' for='title'>Title ({{ $lang->short_code }})</label>
                                    <div class='controls'>
                                        <input class='form-control' minlength='2' required id='title_{{ $lang->short_code }}' name='title_{{ $lang->short_code }}' placeholder='Title' type='text' value=''>
                                    </div>
                                </div>

                            </div>
                            @endforeach
                        </div>
                    </div>

                </div>
                <div class='modal-footer'>
                 <button class='btn btn-default btn-sm' data-dismiss='modal' type='button'>Close</button>
                 <button class='btn btn-primary btn-sm' type='submit'>Save</button>
                </div>
              </form>
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div> <!-- /.modal -->
        <!-- all user list -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">All Packages
				</h3>
                                                
            </div><!-- /.box-header -->
            <div class="panel-body table-responsive">
				<div class="row">
					<div class="col-xs-12">
						<a href="#modal-content" class="btn btn-default btn-sm btn-add" data-toggle='modal' role='button'>
                            <i class="glyphicon glyphicon-plus"></i> Add new package
                        </a><br/>
					</div>
				</div>
                <br>
                @if($list->count())  
                <table class="table table-bordered table-striped">
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Available period</th>
                        <th>Price</th>
                        <th>Status</th>
						<th>Action</th>
                    </tr>
                    @foreach($list as $l)
                    <tr>
                        <td>{{ $l->id }}</td>
                        <td><b>{{ isset($l->lang[0])? $l->lang[0]->name : '' }}</b></td>
                        <td>{{ Format::simpleDate($l->available_from) }} <br>to<br> {{ Format::simpleDate($l->available_to) }}</td>
                        <td>{{ $l->price }}</td>
                        <td>{{ array_search($l->status, $status) }}</td>
                        <td><a href="{{ URL::to('admin/package/edit') }}/{{ $l->id }}" class="btn btn-default btn-sm">edit</a>
                            <a href="{{ URL::to('admin/package/destroy') }}/{{ $l->id }}" class="btn btn-default btn-sm">delete</a></td>
                    </tr>
                    @endforeach
                </table>
				{{ $list->links() }}
                @else
                <span class='no-data'>No data</span>
                @endif
            </div><!-- /.box-body -->
        </div><!-- /.box -->

    </div>
  </div>
@stop
@section('footer')
<script type="text/javascript">
$(function(){

});
</script>
@stop