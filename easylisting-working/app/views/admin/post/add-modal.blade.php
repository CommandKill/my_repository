<div class='modal fade' id='modal-content' tabindex='-1'>
    <div class='modal-dialog'>
        <div class='modal-content'>
            {{ Form::open(array('url' => 'admin/post/store', 'files' => true)) }}
                <div class='modal-header'>
                    <button aria-hidden='true' class='close' data-dismiss='modal' type='button'>×</button>
                    <h4 class='modal-title' id='myModalLabel'>Create new post</h4>
                </div>
                <div class='modal-body'>
                    <input name="authenticity_token" type="hidden" />
                      <div class="form-group">
                        <div class="">
                          <select name="year" id="year" class="form-control" required>
                            <option value="" >Select a year</option>
                          </select><br/>
                          <select name="make" id="make" class="form-control" required>
                            <option value="" >Select a make</option>
                          </select><br/>
                          <select name="model" id="model" class="form-control" required>
                            <option value="" >Select a model</option>
                          </select><br/>
                          <select name="submodel" id="submodel" class="form-control" required>
                            <option value="" >Select a sub model</option>
                          </select>
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
