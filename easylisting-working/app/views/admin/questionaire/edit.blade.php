@extends('admin._layouts.index')
@section('head')
<!-- datetime picker -->
<link rel="stylesheet" href="{{ asset('css/plugins/bootstrap_datetimepicker/bootstrap-datetimepicker.min.css') }}" >

<!-- date range -->
<link rel="stylesheet" href="{{ asset('css/plugins/bootstrap_daterangepicker/daterangepicker-bs3.css') }}" >

<style>
.questions .active {
  display: block;
  background-color: #eee !important;
  padding: 10px;
}
</style>

@stop
@section('content')
<form action="{{ URL::to('admin/questionaire/update') }}" id="frmUpdate" method="POST" enctype="multipart/form-data">

  <div class="row">
      
      <input type="hidden" name="id" id="id" value="{{ $questionaire->id }}">
    <div class="col-md-12">
      <div class="panel panel-default">
          <div class="panel-body">
            <p>
              <strong>Create date </strong> <time class="timeago" datetime="{{ $questionaire->created_at or 'none' }}">-</time><br/>
              <i>(by {{ $questionaire->getRelations()['created_by']->email or 'none' }})</i>
            </p>
            @if( $questionaire->updated_at != '')
            <p>
              <strong>Last modify </strong> <time class="timeago" datetime="{{ $questionaire->updated_at or 'none' }}">-</time><br/>
              <i>(by {{ $questionaire->getRelations()['updated_at']->email or 'none' }})</i>
            </p>
            @endif
          </div><!-- /.box-body -->
          <div class="panel-footer">
              <input type="hidden" id="status" name="status" value="{{ $questionaire->status }}" />
              <button type="submit" class="btn btn-primary btn-sm">Save</button>
              <a href="{{ URL::to('admin/questionaire') }}">Back to questionaire</a>
              <div class="btn-group dropdown pull-right">
                  <button class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown" style="margin-bottom:5px">
                      <i class="icon-globe"></i> <span id="allState">@if($questionaire->status==1) Published @else Unpublish  @endif </span>
                      <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu">
                      <li>
                        <a href="#status" id="changeStatus">@if($questionaire->status == 1)  Unpublish @elseif($questionaire->status == 0) Published  @endif</a>
                      </li>
                  </ul>
              </div>
          </div>  <!-- /panel footer -->
      </div><!-- /.box -->
      <div class="panel panel-default">
          <div class="panel-body">
              <div class="form-group">
                  <label>Questionaire available period</label>
                  <div class="controls">
                      <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" name="available_period" id="available_period" class="form-control" value=" @if($questionaire->available_from!='') {{ $questionaire->available_from }} - {{ $questionaire->available_to }} @endif" minlength="2" required/>
                      </div>
                  </div>
              </div><!-- /.form group -->
          </div><!-- /.box-body -->
      </div><!-- /.panel -->
    </div><!-- /.col-md-4 -->
        <div class="col-md-12">
              <!-- profile -->
              <div class="panel panel-default">
                  <div class="panel-heading">
                      <h3 class="panel-title">Questionaire</h3>
                  </div><!-- /.box-header -->
                <div class="panel-body">
                   <input name="authenticity_token" type="hidden" />

                    <div class='tabbable'>
                        <ul class='nav nav-tabs'>
                            @foreach($languages as $lang)
                            <li @if($lang->id == 2) class='active' @endif >
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
                            <div class='tab-pane @if($lang->id == 2) active @endif' id='tab{{ $lang->id }}'>

                                <div class='form-group'>
                                    <label class='control-label' for='title'>Title</label>
                                    <div class='controls'>
                                        <input class='form-control' minlength='2' required id='title_{{ $lang->short_code }}' name='title_{{ $lang->short_code }}' placeholder='Name' type='text' value='{{ $questionaire->lang[$key]->name }}'>
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
                      <h3 class="panel-title">Question</h3>
                  </div><!-- /.box-header -->
                <div class="panel-body">
                   <input name="authenticity_token" type="hidden" />

                   <div class="row">
                    <div class="col-xs-12">
                      <a href="#modal-content" class="btn btn-default btn-sm btn-add pull-right" data-toggle='modal' role='button'>
                        <i class="glyphicon glyphicon-plus"></i> Add new question</a>
                    </div>
                  </div>

                  @if($question->count() > 0)
                  <ol id="sortable" class="questions" style="overflow: auto">
                    @foreach($question as $num=>$question)
                    <li style='padding:20px;margin:5px 0;border-bottom:solid 4px #f5f5f5;background-color:#fff;' id="order_question_id_{{ $question->id }}">
                      <span class="pull-left">{{ $question->lang[0]->title or '' }}</span>
                      <div class="pull-right">
                        <a class="btn btn-sm btn-default" style="cursor: move"><span class="glyphicon glyphicon-move"></span></a>
                        <a class="btn btn-sm btn-default" href="{{ URL::to('admin/questionaire/question-edit') }}/{{ $questionaire->id }}/{{ $question->id }}"><span class="glyphicon glyphicon-pencil"></span></a>
                        <a class="btn btn-sm btn-default" href="{{ URL::to('admin/questionaire/question-remove') }}/{{ $questionaire->id }}/{{ $question->id }}"><span class="glyphicon glyphicon-remove"></span></a>
                      </div>
                      </li>
                    @endforeach
                  </ol>
              @endif
               </div><!-- /.box-body -->
              </div><!-- /.panel -->
        </div><!-- /.col-md-8 -->


      
  </div><!-- /.row -->

</form>

<div class='modal fade' id='modal-content' tabindex='-1'>
  <div class='modal-dialog'>
    <div class='modal-content'>
      <form class="form validate-form" id="frmCreate" style="margin-bottom: 0;" method="post" action="{{ URL::to('admin/questionaire/question-store') }}" accept-charset="UTF-8">
        <div class='modal-header'>
         <button aria-hidden='true' class='close' data-dismiss='modal' type='button'>×</button>
         <h4 class='modal-title' id='myModalLabel'>Create new question</h4>
        </div>
        <div class='modal-body'>
        <input name="authenticity_token" type="hidden" />
        <input name="questionaire_id" type="hidden" value="{{ $questionaire->id }}" />

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
                        <div class="col-md-12">

                          <div class='form-group'>
                              <label class='control-label' for='title'>Question</label>
                              <div class='controls'>
                                  <input class='form-control' minlength='2' required id='question_{{ $lang->short_code }}' name='question_{{ $lang->short_code }}' placeholder='Question' type='text' value=''>
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
         <button class='btn btn-primary btn-sm' type='submit'>Save</button>
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div> <!-- /.modal -->
@stop
@section('footer')
{{ HTML::script('js/plugins/jquery.timeago.js') }}

{{ HTML::script('js/plugins/bootstrap_datetimepicker/bootstrap-datetimepicker.min.js') }}
{{ HTML::script('js/plugins/bootstrap_daterangepicker/moment.js') }}

{{ HTML::script('js/plugins/bootstrap_daterangepicker/daterangepicker.js') }}

<script type="text/javascript">
$(function(){

    $(".timeago").timeago();

    $("#available_period").daterangepicker({
        format: "YYYY/MM/DD"
    }, function(start, end) {
        // return $("#daterange2").parent().find("input").first().val(start.format("MMMM D, YYYY") + " - " + end.format("MMMM D, YYYY"));
    });

    $("a#changeStatus").click(function(){
        if($.trim($("#allState").text())== "Published" ) {
          $("#status").val(0);
          $("#allState").text("Unpublish");
          $(this).text("Published");
        }else {
          $("#status").val(1);
          $("#allState").text("Published");
          $(this).text("Unpublish");
        }
    });

    // add sortable to question
    $( "#sortable" ).sortable({
        placeholder: "ui-state-highlight list-group-item active",
        stop: function( event, ui ) {

            var data = $(this).sortable("serialize");

            $.post( "{{ URL::to('admin/questionaire/update-question-order') }}", data).done(function( data ) {

            }, "json");
        }
    });
});
</script>
@stop