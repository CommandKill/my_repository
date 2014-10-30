<div class='modal fade' id='modal-content' tabindex='-1'>
    <div class='modal-dialog'>
        <div class='modal-content'>
            {{ Form::open(array('url' => 'admin/content-review/store', 'files' => true)) }}
                <div class='modal-header'>
                    <button aria-hidden='true' class='close' data-dismiss='modal' type='button'>×</button>
                    <h4 class='modal-title' id='myModalLabel'>Create new review</h4>
                </div>
                <div class='modal-body'>
                    <input name="authenticity_token" type="hidden" />
                    <div class='form-group'>
                        <div class='tabbable'>
                            <ul class='nav nav-tabs'>
                                @foreach($data['languages'] as $lang)
                                <li @if($lang['id'] == 1) class='active' @endif >
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
                                <div class='tab-pane @if($lang['id'] == 1) active @endif' id='tab{{ $lang['id'] }}'>
                                    <div class="form-group">
                                        {{ Form::label('title_'.$lang['short_code'], "Title") }}
                                        <div class="controls">
                                            {{ Form::text('title_'.$lang['short_code'], '', array('class' => 'form-control')) }}
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class='modal-footer'>
                    <button class='btn btn-primary btn-sm' type='submit'>Create</button>
                </div>
            {{ Form::close() }}
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div> <!-- /.modal -->
