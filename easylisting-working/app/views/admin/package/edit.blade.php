@extends('admin._layouts.index')
@section('head')
<style>

</style>
<!-- datetime picker -->
<link rel="stylesheet" href="{{ asset('css/plugins/bootstrap_datetimepicker/bootstrap-datetimepicker.min.css') }}" >

<!-- date range -->
<link rel="stylesheet" href="{{ asset('css/plugins/bootstrap_daterangepicker/daterangepicker-bs3.css') }}" >
@stop
@section('content')
  <div class="row">
    <div class="col-xs-12">

<form action="{{ URL::to('admin/package/update') }}" id="frmUpdate" method="POST" enctype="multipart/form-data">
<section class="content">
  <ol class="breadcrumb">
  <li><a href="{{ URL::to('admin/package') }}">Package</a></li>
  <li class="active">Update</li>
  </ol>
  <div class="row">
      
      <input type="hidden" name="id" id="id" value="{{ $package->id }}">
    <div class="col-md-12">
      <div class="panel panel-default">
          <div class="panel-body">
            <p>
            <strong>Create date </strong> <time class="timeago" datetime="{{ $package->created_at or 'none' }}">-</time><br/>
            <i>(by {{ $package->getRelations()['created_by']->email or 'none' }})</i>
            </p>
            @if( $package->updated_at != '')
            <p>
            <strong>Last modify </strong> <time class="timeago" datetime="{{ $package->updated_at or 'none' }}">-</time><br/>
            <i>(by {{ $package->getRelations()['updated_at']->email or 'none' }})</i>
            </p>
            @endif
          </div><!-- /.box-body -->
          <div class="panel-footer">
              <input type="hidden" id="status" name="status" value="{{ $package->status }}" />
              <button type="submit" class="btn btn-primary btn-sm">Save</button>
              <a href="{{ URL::to('admin/package') }}" >Back to all package</a>
              <div class="btn-group dropdown pull-right">
                  <button class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown" style="margin-bottom:5px">
                      <i class="icon-globe"></i> <span id="allState">@if($package->status==1) Published @else Unpublish  @endif </span>
                      <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu">
                      <li><a href="#status" id="changeStatus">@if($package->status == 1)  Unpublish @elseif($package->status == 0) Published  @endif</a></li>
                      <li class="divider"></li>
                      <li><a href="{{ URL::to('admin/package/remove') }}/{{ $package->id }}"><i class="icon-ban-circle"></i> Delete this package?</a></li>
                  </ul>
              </div>
          </div>  <!-- /panel footer -->
      </div><!-- /.box -->
      <div class="panel panel-default">
          <div class="panel-body">
              <div class="form-group">
                  <label>Package available period</label>
                  <div class="controls">
                      <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" name="available_period" id="available_period" class="form-control" value=" @if($package->available_from!='') {{ $package->available_from }} - {{ $package->available_to }} @endif" minlength="2" required/>
                      </div>
                  </div>
              </div><!-- /.form group -->
          </div><!-- /.box-body -->
      </div><!-- /.panel -->
      <div class="panel panel-default">
          <div class="panel-body">
            <div class="form-group">
                  <label>Price</label>
                  <div class="controls">
                      <input class='form-control' type="text" id="price" name="price" value="{{ $package->price }}" />
                  </div><!-- /.input group -->
              </div><!-- /.form group -->
          </div><!-- /.box-body -->
      </div><!-- /.panel -->
    </div><!-- /.col-md-12 -->
        <div class="col-md-12">
              <!-- profile -->
              <div class="panel panel-default">
                  <div class="panel-heading">
                      <h3 class="panel-title">Package</h3>
                  </div><!-- /.box-header -->
                <div class="panel-body">
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
                            @foreach($languages as $key=>$lang)
                            <div class='tab-pane @if($lang->id == 1) active @endif' id='tab{{ $lang->id }}'>

                                <div class='form-group'>
                                    <label class='control-label' for='title'>Title ({{ $lang->short_code }})</label>
                                    <div class='controls'>
                                        <input class='form-control' minlength='2' required id='title_{{ $lang->short_code }}' name='title_{{ $lang->short_code }}' placeholder='Title' type='text' value='{{ isset($package->lang[$key]) ? $package->lang[$key]->name : '' }}'>
                                    </div>
                                </div>

                            </div>
                            @endforeach
                        </div>
                    </div>
                    
               </div><!-- /.box-body -->
              </div><!-- /.panel -->

                            <!-- profile -->
              <div class="panel panel-default">
                  <div class="panel-heading">
                      <h3 class="panel-title">Package information</h3>
                  </div><!-- /.box-header -->
                <div class="panel-body">
                   <input name="authenticity_token" type="hidden" />

                   <div class="row">
                    <div class="col-xs-12">
                      <a href="#modal-content" class="btn btn-default btn-sm btn-add pull-right" data-toggle='modal' role='button'>
                        <i class="glyphicon glyphicon-plus"></i> Add new option</a>
                    </div>
                  </div>

                  @if($package->detail->count() > 0)

                    <div class='tabbable'>
                        <ul class='nav nav-tabs'>
                            @foreach($languages as $lang)
                            <li @if($lang->id == 1) class='active' @endif >
                            <a data-toggle='tab' href='#tab-information{{ $lang->id }}'>
                                <i class='flag flag-{{ $lang->short_code }}'></i>
                                {{ $lang->title }}
                            </a>
                            </li>
                            @endforeach
                        </ul>
                        <br/>
                        <div class='tab-content'>
                            @foreach($languages as $key=>$lang)
                            <div class='tab-pane @if($lang->id == 1) active @endif' id='tab-information{{ $lang->id }}'>

                              @foreach($package->detail as $option)

                                @if($lang->id == $option->language_id)

                                <div class="row">
                                  <div class="col-md-6">

                                    <div class='form-group'>
                                        <label class='control-label' for='title'>Option ({{ $lang->short_code }})</label>
                                        <div class='controls'>
                                            <input class='form-control' minlength='2' required id='option_{{ $lang->short_code }}_{{ $option->id }}' name='option_{{ $lang->short_code }}_{{ $option->id }}' placeholder='Option' type='text' value='{{ $option->name }}'>
                                        </div>
                                    </div>

                                  </div>
                                  <div class="col-md-6">

                                    <div class='form-group'>
                                        <label class='control-label' for='title'>Value ({{ $lang->short_code }})</label>
                                        <div class='controls'>
                                            <input class='form-control' minlength='1' required id='value_{{ $lang->short_code }}_{{ $option->id }}' name='value_{{ $lang->short_code }}_{{ $option->id }}' placeholder='Value' type='text' value='{{ $option->value }}'>
                                        </div>
                                    </div>

                                  </div>
                                </div>

                              @endif

                              @endforeach

                            </div>
                            @endforeach
                        </div>
                    </div>
              @endif
               </div><!-- /.box-body -->
              </div><!-- /.panel -->
        </div><!-- /.col-md-8 -->


      
  </div><!-- /.row -->

</form>
</section>
<div class='modal fade' id='modal-content' tabindex='-1'>
  <div class='modal-dialog'>
    <div class='modal-content'>
      <form class="form validate-form" id="frmCreate" style="margin-bottom: 0;" method="post" action="{{ URL::to('admin/package/option-store') }}" accept-charset="UTF-8">
        <div class='modal-header'>
         <button aria-hidden='true' class='close' data-dismiss='modal' type='button'>×</button>
         <h4 class='modal-title' id='myModalLabel'>Create new option</h4>
        </div>
        <div class='modal-body'>
        <input name="authenticity_token" type="hidden" />
        <input name="package_id" type="hidden" value="{{ $package->id }}" />

            <div class='tabbable'>
                <ul class='nav nav-tabs'>
                    @foreach($languages as $lang)
                    <li @if($lang->id == 1) class='active' @endif >
                    <a data-toggle='tab' href='#tab-add-option{{ $lang->id }}'>
                        <i class='flag flag-{{ $lang->short_code }}'></i>
                        {{ $lang->title }}
                    </a>
                    </li>
                    @endforeach
                </ul>
                <br/>
                <div class='tab-content'>
                    @foreach($languages as $lang)
                    <div class='tab-pane @if($lang->id == 1) active @endif' id='tab-add-option{{ $lang->id }}'>

                      <div class="row">
                        <div class="col-md-6">

                          <div class='form-group'>
                              <label class='control-label' for='title'>Option ({{ $lang->short_code }})</label>
                              <div class='controls'>
                                  <input class='form-control' minlength='2' required id='option_{{ $lang->short_code }}' name='option_{{ $lang->short_code }}' placeholder='Option' type='text' value=''>
                              </div>
                          </div>

                        </div>
                        <div class="col-md-6">

                          <div class='form-group'>
                              <label class='control-label' for='title'>Value ({{ $lang->short_code }})</label>
                              <div class='controls'>
                                  <input class='form-control' minlength='2' required id='value_{{ $lang->short_code }}' name='value_{{ $lang->short_code }}' placeholder='Value' type='text' value=''>
                              </div>
                          </div>

                        </div>
                      </div>

                    </div>
                    @endforeach
                </div>
            </div>

        </div>
        <div class='modal-footer'>
         <button class='btn btn-default btn-sm' data-dismiss='modal' type='button'>Close</button>
         <button class='btn btn-success btn-sm' type='submit'>Save</button>
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div> <!-- /.modal -->

    </div>
  </div>
@stop
@section('footer')
<!-- update long time to easy to read -->
<script src="{{ asset('js/plugins/jquery.timeago.js') }}"></script>

<!-- datetime picker -->
<script src="{{ asset('js/plugins/bootstrap_datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ asset('js/plugins/bootstrap_daterangepicker/moment.js') }}"></script>
<!-- date range -->
<script src="{{ asset('js/plugins/bootstrap_daterangepicker/daterangepicker.js') }}"></script>

<script type="text/javascript">
$(function(){
  $(".timeago").timeago();
    $("#available_period").daterangepicker({
        format: "YYYY/MM/DD"
    }, function(start, end) {
        // return $("#daterange2").parent().find("input").first().val(start.format("MMMM D, YYYY") + " - " + end.format("MMMM D, YYYY"));
    });
});
</script>
@stop