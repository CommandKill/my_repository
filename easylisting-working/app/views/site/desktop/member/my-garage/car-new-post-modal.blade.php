<div class='modal fade' id='modal-post-form' tabindex='-1'>
    <div class="modal-dialog" style="width:800px;position:relative">
      <div class='modal-content'>
          <div class='modal-body' style="padding-bottom: 0;min-height:500px; overflow: auto;">
               <div class="col-xs-12 no-padding">

                <form id="post-form" action="/post/file-thumbnail" class="fileupload" method="POST" enctype="multipart/form-data" data-upload-template-id="template-upload" data-download-template-id="template-download">
					<input type="hidden" id="submit_click" name="submit_click" value='0' />
					<input type="hidden" id="hidden_first_post" name="first_post" value='' />
                    <input type="hidden" id="hidden_post_id" name="post_id" value="" />
                    <input type="hidden" id="hidden_year_id" value="" />
                    <input type="hidden" id="hidden_make_id" value="" />
                    <input type="hidden" id="hidden_model_id" value="" />
                    <input type="hidden" id="hidden_submodel_id" value="" />
                    <input type="hidden" id="hidden_fuel_id" value="" />
                    <input type="hidden" id="hidden_gear_id" value="" />
                    <input type="hidden" id="hidden_engine_id" value="" />
                    <input type="hidden" id="hidden_color_id" value="" />
                    <input type="hidden" id="hidden_province_id" value="" />
                    <input type="hidden" id="hidden_amphur_id" value="" />
                    <input type="hidden" id="hidden_district_id" value="" />
                    <input type="hidden" id="hidden_zipcode_id" value="" />
                    <input type="hidden" id="hidden_latitude" value="" />
                    <input type="hidden" id="hidden_longitude" value="" />
                    <input type="hidden" id="hidden_address" name="address" value="" />
                    <input type="hidden" id="hidden_suggest" value="" />
                    <input type="hidden" id="hidden_price" value="" />
                    <input type="hidden" id="hidden_mileage" value="" />
                    <input type="hidden" id="hidden_thumbnail" value="" />
                    <input type="hidden" id="hidden_user_info_addr" value="" />
                    <input type="hidden" id="latitude" name="latitude" value="" />
                    <input type="hidden" id="longitude" name="longitude" value="" />

                  <div class='tabbable'>
                    <ul class="nav nav-pills" id="navbar-postcar">
                        <li class="active"><a role="tab" href='#tab-select-car'><i class="fa fa-car"></i> <span>Select car</span></a></li>
                        <li><a role="tab" href='#tab-basic-infomation'><i class="fa fa-pencil-square-o"></i> <span>Basic Information</span></a></li>
                        <li id="address-tab-nav"><a role="tab" href='#tab-address'><i class="fa fa-map-marker"></i> <span>Address</span></a></li>
                        <li><a role="tab" href='#tab-image'><i class="fa fa-picture-o"></i> <span>Image</span></a></li>
                        <li id="preview-tab"><a href='#tab-preview'><i class="fa fa-check"></i> <span>Preview</span></a></li>

                        <!-- <li id="tab-car-verified"><a href='#tab-car-verified'><i class="fa fa-check"></i> <span>Car Verified</span></a></li> -->
                    </ul>
                    <br/>
                    <div class='tab-content'><!-- tab-content1 <- change class name to this for real using -->
                        <form>
						<div class='tab-pane active' id='tab-select-car'>
                            <div class="form-group">
                                @include('site.desktop.member.my-garage.car-select')
                            </div>
                        </div>
                        <div class='tab-pane' id='tab-basic-infomation'>
                            <div class="form-group">
                                @include('site.desktop.member.my-garage.car-information')
                            </div>
                        </div>
                        <div class='tab-pane' id='tab-address'>
                            <div class="form-group">
                                @include('site.desktop.member.my-garage.car-address')
                            </div>
                        </div>
					</form>
                        <div class='tab-pane' id='tab-image'>
                            <div class="form-group">
                                @include('site.desktop.member.my-garage.car-image')
                            </div>
                        </div>
                        <div class='tab-pane' id='tab-preview'>
                            <div class="form-group">
                                @include('site.desktop.member.my-garage.car-preview')
                            </div>
                        </div>

                        <!-- <div class='tab-pane' id='tab-car-verified'>
                            <div class="form-group">
                                test
                            </div>
                        </div> -->
                    </div>
                </div>
                </form>
                @include('site.desktop.member.my-garage.car-thankyou')
              </div>
          </div>
      </div>
      <a aria-hidden='true' class='btn-close-modal' data-dismiss='modal' type='button'>×</a>
      
    </div>
</div> <!-- /.modal --> 
