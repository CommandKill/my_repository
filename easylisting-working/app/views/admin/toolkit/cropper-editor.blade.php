@extends('admin._layouts.default')
@section('head-wrapper')
<!-- cropper -->
{{ HTML::style('css/plugins/cropper/cropper.min.css'); }}
<style>

.eg-container {
  padding-top: 15px;
  padding-bottom: 15px;
}

.eg-main {
  max-height: 480px;
  margin-bottom: 30px;
}

.eg-wrapper {
  background-color: #f7f7f7;
  border: 1px solid #eee;
  box-shadow: inset 0 0 3px #f7f7f7;
  height: 480px;
  width: 100%;
  overflow: hidden;
}

.eg-wrapper img {
  width: 100%;
}

.eg-preview {
  margin-bottom: 15px;
}

.preview {
  float: left;
  margin-right: 15px;
  margin-bottom: 15px;
  overflow: hidden;
  background: #f7f7f7;
}

.preview-lg {
  width: 290px;
  height: 160px;
}

.preview-md {
  width: 145px;
  height: 90px;
}

.preview-sm {
  width: 72.5px;
  height: 45px;
}

.preview-xs {
  width: 36.25px;
  height: 22.5px;
}

.eg-data {
  padding-right: 15px;
}

.eg-data .input-group {
  width: 100%;
  margin-bottom: 15px;
}

.eg-data .input-group-addon {
  min-width: 65px;
}

.eg-button {
  margin-bottom: 15px;
}

.eg-button > .btn {
  margin-right: 15px;
}

.eg-input .input-group {
  margin-bottom: 15px;
}

.eg-input .input-group .btn {
  width: 140px;
}
</style>
@stop
@section('content-wrapper')

<div class="container-fluid eg-container" id="basic-example">
    <div class="row eg-main">
      
      <div class="col-sm-12">
        <div class="eg-preview clearfix col-sm-offset-4">
          <!-- <div class="preview preview-lg"></div>
          <div class="preview preview-md"></div>
          <div class="preview preview-sm"></div>
          <div class="preview preview-xs"></div> -->

          <div class="preview" style="width:{{ $dest_width or '100' }}px;height:{{ $dest_height or '100'}}px"></div>
        </div>
        <div class="eg-data" style="display:none">
          <div class="input-group">
            <span class="input-group-addon">X</span>
            <input class="form-control" id="dataX" type="text" placeholder="x">
          </div>
          <div class="input-group">
            <span class="input-group-addon">Y</span>
            <input class="form-control" id="dataY" type="text" placeholder="y">
          </div>
          <div class="input-group">
            <span class="input-group-addon">Width</span>
            <input class="form-control" id="dataW" type="text" placeholder="width">
          </div>
          <div class="input-group">
            <span class="input-group-addon">Height</span>
            <input class="form-control" id="dataH" type="text" placeholder="height">
          </div>
        </div>
      </div>
      <div class="col-sm-12">
        <div class="eg-wrapper">
          <img class="cropper" src="{{ $src }}" alt="Picture">
        </div>
      </div>
    </div>
    <div class="clearfix" style="display:none">
      <div class="eg-button">
        <button id="reset" type="button" class="btn btn-warning">Reset</button>
        <button id="reset-deep" type="button" class="btn  btn-warning">Reset (deep)</button>
        <button id="release" type="button" class="btn btn-primary">Release</button>
        <button id="destroy" type="button" class="btn btn-danger">Destroy</button>
        <button id="setData" type="button" class="btn btn-primary">Set Data</button>
      </div>
      <div class="row eg-input">
        <div class="col-md-6">
          <div class="input-group">
            <input class="form-control" id="showData" type="text" value="data...">
            <span class="input-group-btn">
              <button class="btn btn-info" id="getData" type="button">Get Data</button>
            </span>
          </div>
          <div class="input-group">
            <input class="form-control" id="showInfo" type="text" value="Info...">
            <span class="input-group-btn">
              <button class="btn btn-info" id="getImgInfo" type="button">Get Image Info</button>
            </span>
          </div>
        </div>
        <div class="col-md-6">
          <div class="input-group">
            <input class="form-control" id="aspectRatio" name="aspectRatio" type="text" value="auto">
            <span class="input-group-btn">
              <button class="btn btn-primary" id="setAspectRatio" type="button">Set Aspect Ratio</button>
            </span>
          </div>
          <div class="input-group">
            <input class="form-control" id="imgSrc" type="text" value="img/picture-2.jpg">
            <span class="input-group-btn">
              <button class="btn btn-primary" id="setImgSrc" type="button">Set Image Src</button>
            </span>
          </div>
        </div>
      </div>
    </div>
    <form id="s-form" action="{{ URL::to('/admin/cropper-editor/crop') }}" method="post">
      <input type="hidden" id="src" name="src" value="{{ $src }}" />
      <input type="hidden" id="dest" name="dest" value="{{ $dest }}" />
      <input type="hidden" id="dest_width" name="dest_width" value="{{ $dest_width }}" />
      <input type="hidden" id="dest_height" name="dest_height" value="{{ $dest_height }}" />
      <input type="hidden" id="x" name="x" value="" />
      <input type="hidden" id="y" name="y" value="" />
      <input type="hidden" id="width" name="width" value="" />
      <input type="hidden" id="height" name="height" value="" />
      <button id="cropBtn" type="submit" class="btn btn-primary btn-lg btn-block" style="margin-top: 50px;clear: both;float: left;">Crop</button>
    </form>
    
  </div>

@stop
@section('footer-wrapper')
<!-- cropper -->
{{ HTML::script('js/plugins/cropper/cropper.min.js') }}
<script type="text/javascript">
$(function(){
$(function() {
      var $cropper = $(".cropper"),
          $dataX = $("#dataX"),
          $dataY = $("#dataY"),
          $dataH = $("#dataH"),
          $dataW = $("#dataW"),
          cropper;

      $cropper.cropper({
        //aspectRatio: 16 / 9,
        data: {
          x: 420,
          y: 50,
          width: 640,
          height: 360
        },
        preview: ".preview",

        // autoCrop: false,
        // dragCrop: false,
        // modal: false,
        // moveable: false,
        // resizeable: false,

        // maxWidth: 480,
        // maxHeight: 270,
        // minWidth: 160,
        // minHeight: 90,

        done: function(data) {
          $dataX.val(data.x);
          $dataY.val(data.y);
          $dataH.val(data.height);
          $dataW.val(data.width);
        }
      });

      cropper = $cropper.data("cropper");

      $cropper.on({
        "build.cropper": function(e) {
          console.log(e.type);
          // e.preventDefault();
        },
        "built.cropper": function(e) {
          console.log(e.type);
          // e.preventDefault();
        },
        "render.cropper": function(e) {
          console.log(e.type);
          // e.preventDefault();
        }
      });

      $("#enable").click(function() {
        $cropper.cropper("enable");
      });

      $("#disable").click(function() {
        $cropper.cropper("disable");
      });

      $("#reset").click(function() {
        $cropper.cropper("reset");
      });

      $("#reset-deep").click(function() {
        $cropper.cropper("reset", true);
      });

      $("#release").click(function() {
        $cropper.cropper("release");
      });

      $("#destroy").click(function() {
        $cropper.cropper("destroy");
      });

      $("#setData").click(function() {
        $cropper.cropper("setData", {
          x: $dataX.val(),
          y: $dataY.val(),
          width: $dataW.val(),
          height:$dataH.val()
        });
      });

      $("#setAspectRatio").click(function() {
        $cropper.cropper("setAspectRatio", $("#aspectRatio").val());
      });

      $("#setImgSrc").click(function() {
        $cropper.cropper("setImgSrc", $("#imgSrc").val());
      });

      $("#getImgInfo").click(function() {
        $("#showInfo").val(JSON.stringify($cropper.cropper("getImgInfo")));
      });

      $("#getData").click(function() {
        $("#showData").val(JSON.stringify($cropper.cropper("getData")));
      });

      $("#cropBtn").click(function() {
        var d = $cropper.cropper("getData");
        $('#x').val(d.x);
        $('#y').val(d.y);
        $('#width').val(d.width);
        $('#height').val(d.height);
      });
    });
});
</script>
@stop