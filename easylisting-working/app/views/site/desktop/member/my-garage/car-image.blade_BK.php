
<div class="col-xs-4">
	<div class="submit-step">
		<figure class="step-number">4</figure>
		<div class="description">
		    <p> {{ $data['upload_step'][3]['value'] }}</p>
		</div>
	</div>
</div>
<div class="col-xs-8" style="padding: 24px 5px 0px 18px;border: dashed #ccc 2px;border-radius: 4px;margin-bottom:10px;">
  <div class="form-group">
	  <div class="col-xs-4">

	      <div class="fileupload-buttonbar">
	        <span class="fileinput-button">
	          <img id="file-preview-image99" src="{{ asset('img/thumb.png') }}" title="placeholder" alt="placeholder" style="width:110px;height:73px;">
	          <input id="thumbnail99" class="filethumbnail" type="file" name="thumbnail">
	        </span>
	        <div id="thumbnail-file99" class="files"></div>
	        <span id="uploadbtn99"></span>
	      </div>
	  </div>
	  
    @for($i=0;$i<12;$i++)

    <div class="col-xs-4">

        <div class="fileupload-buttonbar" data-role="{{ $i }}">
          <span class="fileinput-button">
            <img id="file-preview-image{{$i}}" src="{{ asset('img/thumb.png') }}" title="placeholder" alt="placeholder" style="width:110px;height:73px;">
            <input id="thumbnail{{$i}}" class="filegallery" type="file" name="gallery[]">
          </span>
          <div id="thumbnail-file{{$i}}" class="files"></div>
          <span id="uploadbtn{{$i}}"></span>
        </div>
    </div>

    @endfor
  </div>
</div>
<div class="form-group" style="float:left;width: 100%;">
<a class="btn-step btn submit-btn pull-left" data-index="2" id="btn6"><i class="glyphicon glyphicon-chevron-left"></i> Prev</a>
<a class="btn-step btn submit-btn pull-right" data-index="4" id="btn7">Next <i class="glyphicon glyphicon-chevron-right"></i></a>
</div>
@include('site.desktop.member.my-garage.post-gallery-upload-template')

