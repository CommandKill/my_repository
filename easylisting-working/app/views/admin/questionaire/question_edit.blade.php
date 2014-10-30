@extends('admin._layouts.index')
@section('head')
<style>
.questions .active {
  display: block;
  background-color: #eee !important;
  padding: 10px;
}
</style>

@stop
@section('content')
<form action="{{ URL::to('admin/questionaire/question-update') }}" id="frmUpdate" method="POST" enctype="multipart/form-data">


  <div class="row">
      
      <input type="hidden" name="questionaire_id" id="questionaire_id" value="{{ $questionaire_id }}">
    <input type="hidden" name="question_id" id="question_id" value="{{ $question->id }}">
    <div class="col-md-12">
      <div class="">
          <input type="hidden" id="status" name="status" value="{{ $question->status }}" />
          <div class="btn-group dropdown pull-right">
              <button class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown" style="margin-bottom:5px">
                  <i class="icon-globe"></i> <span id="allState">@if($question->status==1) Published @else Unpublish  @endif </span>
                  <span class="caret"></span>
              </button>
              <ul class="dropdown-menu">
                  <li><a href="#preview"><i class="icon-ban-circle"></i> Preview</a></li>
                  <li><a href="#status" id="changeStatus">@if($question->status == 1)  Unpublish @elseif($question->status == 0) Published  @endif</a></li>
                  <li class="divider"></li>
                  <li><a href="{{ URL::to('admin/question/remove') }}/{{ $question->id }}"><i class="icon-ban-circle"></i> Delete this question?</a></li>
              </ul>
          </div>
      </div>
    </div><!-- /.col-md-12 -->
    <div class="col-md-12">
      <div class="panel panel-default">
          <div class="panel-heading">
              <h3 class="panel-title">Question</h3>
          </div>
        <div class="panel-body">

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
                            <label class='control-label' for='title'>Title ({{ $lang->short_code }})</label>
                            <div class='controls'>
                                <input class='form-control' minlength='2' required id='title_{{ $lang->short_code }}' name='title_{{ $lang->short_code }}' placeholder='Name' type='text' value='{{ $question->lang[$key]->title }}'>
                            </div>
                        </div>

                    </div>
                    @endforeach
                </div>
            </div>
            
       </div>
      </div>
      <div class="panel panel-default">
          <div class="panel-heading">
              <h3 class="panel-title">Answer</h3>
          </div>
        <div class="panel-body">
           <input name="authenticity_token" type="hidden" />

           <div class="row">
            <div class="col-xs-12">
              <a href="#" id="btnAddNewAnswer" class="btn btn-default btn-sm btn-add pull-right" >
                <i class="glyphicon glyphicon-plus"></i> Add new answer</a>
            </div>
          </div>

          @if($answer->count() > 0)
          <ol id="sortable" style="overflow: auto">
            @foreach($answer as $num=>$answer)
            <li style='padding:20px;margin:5px 0;overflow: auto;border-bottom:solid 4px #f5f5f5;background-color:#fff;' id="order_answer_id_{{ $answer->id }}">
              
              <div class="pull-left">
                @if ($answer->illustration)
              
                <img src="{{$thumbnail_path}}/thumb_{{$answer->illustration}}" title="" />
              <br/>
              @endif
                {{ $answer->lang[0]->title or '' }}
              </div>
              <div class="pull-right">
                <a class="btn btn-sm btn-default" style="cursor: move"><span class="glyphicon glyphicon-move"></span></a>
                <a class="btn btn-sm btn-default btn-edit" 
                data-id="{{ $answer->id or '' }}"
                ><span class="glyphicon glyphicon-pencil"></span></a>
                <a class="btn btn-sm btn-default" href="{{ URL::to('admin/questionaire/answer-remove') }}/{{ $questionaire_id }}/{{ $question->id }}/{{ $answer->id }}"><span class="glyphicon glyphicon-remove"></span></a>
              </div>
              </li>
            @endforeach
          </ol>
            @endif
       </div><!-- /.box-body -->
      </div><!-- /.panel -->
      <button type="submit" class="btn btn-primary btn-sm">Save</button>
      <a href="{{ URL::to('admin/questionaire/edit/'.$questionaire_id) }}">Back to questionaire</a>
    </div><!-- /.col-md-12 -->
  </div><!-- /.row -->

</form>

<div class='modal fade' id='modal-content' tabindex='-1'>
  <div class='modal-dialog'>
    <div class='modal-content'>
      <form class="form validate-form" id="frmCreate" style="margin-bottom: 0;" method="post" action="{{ URL::to('admin/questionaire/answer-store') }}" accept-charset="UTF-8" enctype="multipart/form-data">
        <div class='modal-header'>
         <button aria-hidden='true' class='close' data-dismiss='modal' type='button'>×</button>
         <h4 class='modal-title' id='myModalLabel'>Create new answer</h4>
        </div>
        <div class='modal-body'>
        <input name="authenticity_token" type="hidden" />
        <input name="questionaire_id" type="hidden" value="{{ $questionaire_id }}" />
        <input name="question_id" type="hidden" value="{{ $question->id }}" />


          <div class="row">
            <div class="col-md-12">

              <div class='form-group'>
                  <label class='control-label' for='title'>Answer ({{ $lang->short_code }})</label>
                  <div class='controls'>
                      <input type="file" name="answer_illustration" id="answer_illustration" multiple='false' />
                      <small>file: xxxx</small>
                  </div>
                  <small id="illustration-name"></small>
                  <a href="#" style="display:none" id="remove-illustration">Remove</a>
              </div>

            </div>
          </div>
          <hr/>
            <div class='tabbable'>
                <ul class='nav nav-tabs'>
                    @foreach($languages as $lang)
                    <li @if($lang->id == 2) class='active' @endif >
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
                    <div class='tab-pane @if($lang->id == 2) active @endif' id='tab-add-option{{ $lang->id }}'>

                      <div class="row">
                        <div class="col-md-12">

                          <div class='form-group'>
                              <label class='control-label' for='title'>Answer ({{ $lang->short_code }})</label>
                              <div class='controls'>
                                  <input class='form-control' minlength='2' required id='answer_{{ $lang->short_code }}' name='answer_{{ $lang->short_code }}' placeholder='Question' type='text' value=''>
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
        <input type="hidden" name="action" id="action" value="add" />
        <input type="hidden" name="answer_id" id="answer_id" value="" />
        <input type="hidden" name="illustration" id="illustration" value="" />
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div> <!-- /.modal -->

@stop
@section('footer')
{{ HTML::script('js/plugins/bootstrap_datetimepicker/bootstrap-datetimepicker.min.js') }}
{{ HTML::script('js/plugins/bootstrap_daterangepicker/moment.js') }}

{{ HTML::script('js/plugins/bootstrap_daterangepicker/daterangepicker.js') }}
<script type="text/javascript">
$(function(){
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

            $.post( "{{ URL::to('admin/questionaire/update-answer-order') }}", data).done(function( data ) {

            }, "json");
        }
    });

    $('.btn-edit').click(function(){
      var answer_id = $(this).data('id');
      // get answer detail
      $.getJSON("{{ URL::to('admin/questionaire/answer-detail') }}", {answer_id:answer_id}, function(data){
        if (data.error == 0) {
          var answer = data.answer;
          $.each(answer.lang, function(i,v){
            //console.log(v.title);

            if (v.language_id == 1) {
              $('#answer_en').val(v.title);
            } else if (v.language_id == 2) {
              $('#answer_th').val(v.title);
            }            

          });

          $('#frmCreate').attr('action', '{{ URL::to('admin/questionaire/answer-update-store') }}');
          $('#myModalLabel').text('Edit answer');
          $('#action').val('edit');
          $('#answer_id').val(answer_id);
          if (answer.illustration) {
            $('#illustration-name').text(answer.illustration);
            $('#illustration').val(answer.illustration);
            $('#remove-illustration').show();
          }
          
          $('#modal-content').modal('show');
            
        }
      });
      return false;
    });

    $('#btnAddNewAnswer').click(function(){
      $('#answer_th').val('');
      $('#answer_en').val('');
      $('#frmCreate').attr('action', '{{ URL::to('admin/questionaire/answer-store') }}');
      $('#myModalLabel').text('Add new answer');
      $('#action').val('add');
      $('#illustration-name').text('');
      $('#illustration').val('');
      $('#modal-content').modal('show');
      return false;
    });

    $('#remove-illustration').click(function(){
      $('#illustration-name').text('');
      $('#illustration').val('');
      return false;
    });

    //modal-content-edit
});
</script>
@stop