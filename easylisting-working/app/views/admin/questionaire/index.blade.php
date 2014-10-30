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
              <form class="form validate-form" id="frmCreate" style="margin-bottom: 0;" method="post" action="{{ URL::to('admin/questionaire/store') }}" accept-charset="UTF-8">
                <div class='modal-header'>
                 <button aria-hidden='true' class='close' data-dismiss='modal' type='button'>×</button>
                 <h4 class='modal-title' id='myModalLabel'>Create new questionaire</h4>
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

        <div class="row">
            <div class="col-xs-12">
                <a href="#modal-content" class="btn btn-default btn-sm btn-add" data-toggle='modal' role='button'>
                    <i class="glyphicon glyphicon-plus"></i> Add new questionaire
                </a><br/>
            </div>
        </div>
        <br>
        @if($list->count())  
        <table class="table table-bordered table-hover">
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Available period</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            @foreach($list as $l)
            <tr>
                <td>{{ $l->id }}</td>
                <td><b>{{ $l->lang[0]->name }}</b></td>
                <td><ul>
                    <li><b>Start :</b> {{ Format::simpleDate($l->available_from) }}</li>
                    <li><b>End :</b> {{ Format::simpleDate($l->available_to) }}</li>
                    </ul>
                </td>
                <td>{{-- array_search($l->status, $status) --}}
                    @if ($l->status == $data['status']['active'])
                    <button type="button" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-globe"></span> Online</button>
                    @elseif ($l->status == $data['status']['inactive'])
                    <button type="button" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-globe"></span> Offline</button>
                    @elseif ($l->status == $data['status']['lock'])
                    <button type="button" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-lock"></span> Lock</button>
                    @endif
                </td>
                <td>
                    <div class="btn-group">
                        <a href="{{ URL::to('admin/questionaire/edit') }}/{{ $l->id }}" type="button" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-pencil"></span> Edit</a>
                        <a type="button" href="{{ URL::to('admin/questionaire/destroy') }}/{{ $l->id }}" class="btn btn-default btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span> Delete</a>
                    </div>
                </td>
            </tr>
            @endforeach
        </table>
        {{ $list->links() }}
        @else
        <span class='no-data'>No data</span>
        @endif

    </div>

</div><!-- /.row -->
@stop
@section('footer')
<script type="text/javascript">
$(function(){

});
</script>
@stop