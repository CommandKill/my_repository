@extends('admin._layouts.index')
@section('head')
<!-- datetime picker -->
{{ HTML::style('css/plugins/bootstrap_datetimepicker/bootstrap-datetimepicker.min.css'); }}
<!-- date range -->
{{ HTML::style('css/plugins/bootstrap_daterangepicker/daterangepicker-bs3.css'); }}

<!-- tagsinput -->
{{ HTML::style('css/plugins/tagsinput/bootstrap-tagsinput.css'); }}
<style>

</style>

@stop
@section('content')
<div class="row">
    <div class="col-xs-12">

		{{ Form::open(array('url' => array('admin/content-blog/update', $data['page']->id), 'method' => 'post', 'files' => true)) }}
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <p>
                        <strong>Create date </strong> <time class="timeago" datetime="{{ $data['page']->created_at }}">-</time><br/>
                        <i>(by {{ $data['page']->post_by->email }})</i>
                    </p>
                    @if( isset($data['page']->modify_by->email) )
                    <p>
                        <strong>Last modify </strong> <time class="timeago" datetime="{{ $data['page']->updated_at }}">-</time><br/>
                        <i>(by {{ $data['page']->modify_by->email }})</i>
                    </p>
                    @endif
                </div>
                <div class="panel-footer">
                    {{ Form::submit('Save', array('class' => 'btn btn-primary btn-save btn-sm')) }}
                    <a href="{{ URL::to('admin/content-blog') }}">Back to all blog</a>
                    <div id="option-control" class="btn-group dropdown pull-right">
                        <button name="status" class="btn btn-default btn-sm dropdown-toggle @if($data['page']->status==1) published @else unpublish  @endif" data-toggle="dropdown" style="margin-bottom:5px">
                            <i class="icon-globe"></i> @if($data['page']->status==1) Published @else Unpublish  @endif
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a id="option-control-publish">@if($data['page']->status==1) Unpublish @else Published  @endif</a></li>
                            <li class="divider"></li>
                            <li><a id="option-control-delete"><i class="icon-ban-circle"></i> Delete this blog?</a></li>
                        </ul>
                        {{ Form::hidden('status', $data['page']->status, array('id'=>'statusx')) }}
                    </div>
                </div>
            </div><!-- /.box -->

            {{ Notification::showAll() }}

            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="form-group">
                        <label>Slug</label> <small>example: hello-world</small>
                        <div class="controls">
                            <div class="form-group">
                                <input type="text" name="slug" id="slug" value="{{ $data['page']->slug }}" class="form-control" />
                            </div>
                        </div>
                    </div><!-- /.form group -->
                    <div class="form-group">
                        <label>Publish date</label>
                        <div class="controls">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input type="text" name="publish" id="publish" value="{{ $data['page']->publish }}" class="form-control" />
                            </div>
                        </div>
                    </div><!-- /.form group -->
                    <div class="form-group">
                        <label>Content available period</label>
                        <div class="controls">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input type="text" name="available_period" id="available_period" class="form-control" value="{{ $data['available_period'] }}" />
                            </div>
                        </div>
                    </div><!-- /.form group -->
                  <div class="form-group">
                        <label for="promoted">Featured</label>
                        <div class="controls">
                            <input type="checkbox" name="promoted" id="promoted" {{ isset($data['page']->promoted) && $data['page']->promoted != 0 ? 'checked' : '' }} />
                        </div>
                    </div>
                      <div class="form-group">
                        <label for="tags">Tags</label>
                        <div class="controls">
                          <input type="text" id="tags" name="tags" value="{{ $data['page']->tags_line or '' }}" placeholder="Tags">
                        </div>
                      </div>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col-xs-4 -->
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Blog </h3>
                </div><!-- /.box-header -->
                <div class="panel-body">
                    <div class='tabbable'>
						<ul class='nav nav-tabs'>
						    @foreach($data['languages'] as $lang)
						    <li @if($lang['id'] == 2) class='active' @endif >
						    <a data-toggle='tab' href='#tab{{ $lang['id'] }}'>
						        <i class='flag flag-{{ $lang['short_code'] }}'></i>
						        {{ $lang['title'] }}
						    </a>
						    </li>
						    @endforeach
						</ul>  
						<br/>
                        <div class='tab-content'>
                            @foreach($data['languages'] as $lang)
                            <div class='tab-pane @if($lang['id'] == 2) active @endif' id='tab{{ $lang['id'] }}'>

                                <a class="btn btn-default btn-sm pull-right preview-link"
                                   data-toggle="modal"
                                   data-target="#myPreviewModal"
                                   data-link="{{ URL::to($lang['short_code'].'/b') }}/{{ $data['page']['slug'] }}">
                                    <i class='glyphicon glyphicon-globe'></i> {{ URL::to($lang['short_code'].'/b') }}/{{ $data['page']['slug'] }}
                                </a>
                                <br style="clear:both" />
                                <div class="form-group">
                                    {{ Form::label('title_'.$lang['short_code'], "Title") }}
                                    <div class="controls">
                                        {{ Form::text('title_'.$lang['short_code'], 
                                        isset($data['page']->lang[$lang['id']]) ? $data['page']->lang[$lang['id']]['title'] : '', 
                                        array('class' => 'form-control')) }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{ Form::label('short_desc_'.$lang['short_code'], "Short description") }}
                                    <div class="controls">
                                        {{ Form::text('short_desc_'.$lang['short_code'], 
                                        isset($data['page']->lang[$lang['id']]) ? $data['page']->lang[$lang['id']]['short_desc'] : '', 
                                        array('class' => 'form-control')) }}
                                    </div>
                                </div>

                                <div class="form-group">
                                    {{ Form::label('body_'.$lang['short_code'], "Content") }}
                                    <div class="controls">
                                        {{ Form::textarea('body_'.$lang['short_code'], 
                                        isset($data['page']->lang[$lang['id']]) ? $data['page']->lang[$lang['id']]['body'] : '', 
                                        array('class' => 'ckeditor')) }}
                                    </div>
                                </div>

                            </div>
                            @endforeach
                        </div>


                    </div>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col-xs-8 -->

        {{ Form::close() }}
    </div>

</div><!-- /.row -->
@include('admin.blog.preview-modal')
@stop
@section('footer')
<!-- update long time to easy to read -->
{{ HTML::script('js/plugins/jquery.timeago.js') }}
<!-- datetime picker -->
{{ HTML::script('js/plugins/bootstrap_datetimepicker/bootstrap-datetimepicker.min.js') }}
{{ HTML::script('js/plugins/bootstrap_daterangepicker/moment.js') }}
<!-- date range -->
{{ HTML::script('js/plugins/bootstrap_daterangepicker/daterangepicker.js') }}
<!-- editor ckeditor and config -->
{{ HTML::script('js/plugins/ckeditor/ckeditor.js') }}
{{ HTML::script('js/plugins/ckeditor/adapters/jquery.js') }}
{{ HTML::script('js/editor.js') }}

<!-- tagsinput -->
{{ HTML::script('js/plugins/typeahead.min.js') }}
{{ HTML::script('js/plugins/tagsinput/bootstrap-tagsinput.min.js') }}

<script type="text/javascript">
$(function(){
	$(".timeago").timeago();
	$('#publish').datetimepicker();
	$("#available_period").daterangepicker({
	    format: "YYYY/MM/DD"
	}, function(start, end) {
	    // return $("#daterange2").parent().find("input").first().val(start.format("MMMM D, YYYY") + " - " + end.format("MMMM D, YYYY"));
	});

      var tags = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: {
          url: '{{ URL::to('/tags/all') }}?{{Carbon::now()->timestamp}}',
          filter: function(list) {
            return $.map(list, function(tag) {
              return { name: tag }; });
          }
        }
      });
      tags.initialize();

      $('#tags').tagsinput({
        typeaheadjs: {
          name: 'tags',
          displayKey: 'name',
          valueKey: 'name',
          source: tags.ttAdapter()
        }
      });

	CKEDITOR.config.height = 450;
    // $('.ckeditor').ckeditor({toolbar_liteToolbar:simpleToolbar, toolbar: 'liteToolbar'});
    $('.ckeditor').ckeditor({toolbar_simpleToolbar:simpleToolbar, toolbar: 'simpleToolbar'});
    // $('.ckeditor').ckeditor({toolbar_fullToolbar:simpleToolbar, toolbar: 'fullToolbar'});
    // CKEDITOR.timestamp='ABCD'; for test refresh editor

    $("#option-control .dropdown-menu li a").click(function(){
        var id = $(this).attr('id');
        if (id == 'option-control-preview') {
            alert("in progress");
        } else if(id == 'option-control-publish'){
            var btn = $("#option-control .btn:first-child");
            if (btn.hasClass('published')) {
                btn.html('<i class="icon-globe"></i> Unpublish <span class="caret"></span>');
                btn.val('unpublish');
                btn.removeClass('published').addClass('unpublish');
                $('#statusx').val(0);
            } else {
                btn.html('<i class="icon-globe"></i> Published <span class="caret"></span>');
                btn.val('published');
                btn.removeClass('unpublish').addClass('published');
                $('#statusx').val(1);
            }
        } else if(id == 'option-control-delete'){
            if(confirm('Are you sure?')){
                alert("in progress");
            }
        }
    });
    $('.preview-link').click(function(){
        var l = $(this).data('link');
        $('#content-preview').attr('src', l);
        $('#full-preview-link').attr('href', l).html(l);
    });
});
</script>
@stop