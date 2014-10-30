<div class='modal fade' id='modal-verify-form' tabindex='-1'>
    <div class="modal-dialog" style="width:800px;position:relative">
      <div class='modal-content'>
          <div class='modal-body' style="padding-bottom: 0; overflow: auto;">
                <div class="col-xs-12 no-padding">

                  <!-- content -->
                  <h1 class="text-center no-border">Seller Verification</h1>
                  <div class="row no-margin margin-bottom">
                    <div class="col-xs-3">
                      <div class="fileupload-buttonbar">
                        <span class="fileinput-button">
                          <img id="file-preview-image-id" src="{{ asset('img/thumb.png') }}" title="placeholder" alt="placeholder" style="width:110px;height:73px;">
                          <input id="thumbnail-id" class="filegallery" type="file" name="thumbnail-id">
                        </span>
                        <div id="thumbnail-file-id" class="files"></div>
                        <span id="uploadbtn-id"></span>
                      </div>
                    </div>
                    <div class="col-xs-9">
                      <h3 class="no-margin margin-bottom" id="title-id-docs">Upload ID</h3>
                    </div>
                  </div>

                  <div class="row no-margin margin-bottom">
                    <div class="col-xs-3">
                      <div class="fileupload-buttonbar">
                        <span class="fileinput-button">
                          <img id="file-preview-image-carOwner" src="{{ asset('img/thumb.png') }}" title="placeholder" alt="placeholder" style="width:110px;height:73px;">
                          <input id="thumbnail-carOwner" class="filegallery" type="file" name="thumbnail-carOwner">
                        </span>
                        <div id="thumbnail-file-carOwner" class="files"></div>
                        <span id="uploadbtn-carOwner"></span>
                      </div>
                    </div>
                    <div class="col-xs-9">
                      <h3 class="no-margin margin-bottom" id="title-car-docs">Upload Car Owner Document</h3>
                    </div>
                  </div>
                  <!-- /content -->

                  <div style="float:left;width: 100%;" class="margin-bottom">
                      <a id="next_add_car" class="btn submit-btn pull-right">Next <i class="glyphicon glyphicon-chevron-right"></i></a>
                  </div>

                </div>
          </div>
      </div>
      <a aria-hidden='true' class='btn-close-modal' data-dismiss='modal' type='button'>×</a>

    </div>
</div> <!-- /.modal -->
