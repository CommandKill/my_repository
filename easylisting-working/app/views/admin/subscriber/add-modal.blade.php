<div class='modal fade' id='modal-content' tabindex='-1'>
    <div class='modal-dialog'>
        <div class='modal-content'>
            {{ Form::open(array('url' => 'admin/subscriber/store', 'files' => true)) }}
                <div class='modal-header'>
                    <button aria-hidden='true' class='close' data-dismiss='modal' type='button'>×</button>
                    <h4 class='modal-title' id='myModalLabel'>Create new email</h4>
                </div>
                <div class='modal-body'>
                    <div class='form-group'>
                        <div class="form-group">
                            {{ Form::label('email', "Email") }}
                            <div class="controls">
                                {{ Form::text('email', '', array('class' => 'form-control')) }}
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
