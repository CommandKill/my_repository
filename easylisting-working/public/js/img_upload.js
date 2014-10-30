$('#thumbnail0').fileupload({
  url: '/admin/post/file-thumbnail',
  limitMultiFileUploads:1,
  dataType: 'json',
  autoUpload: true,
  formData: {id: 1 },
  add: function (e, data) {
    if (data.files && data.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
          $('#file-preview-image0').attr('src', e.target.result);
      }
      reader.readAsDataURL(data.files[0]);
    }
    $("#uploadbtn0").empty(); // clear data first
    data.context = $('<div/>').addClass('progress').attr('id','progress0').append($('<div/>').addClass('progress-bar progress-bar-success')).appendTo("#uploadbtn0");
        data.context = $('<button/>').addClass('btn btn-primary start').append('<i class="glyphicon glyphicon-upload"></i> Upload')
            .appendTo("#uploadbtn0")
            .click(function () {
                // data.context = $('<p/>').text('Uploading...').replaceAll($(this));
                data.submit();
                return false;
            });
    },
  done: function (e, data) {
    $.each(data.result.files, function (index, file) {
      $("#file-preview-image0").attr('src', file.thumbnailUrl);
      $("#uploadbtn0").empty();
        // $('<p/>').text(file.name).appendTo('#thumbnail-file');
        $('<button/>').addClass('btn btn-danger btn-remove').append('<i class="glyphicon glyphicon-remove"></i>')
            .appendTo("#uploadbtn0")
            .click(function () {
                // data.context = $('<p/>').text('Uploading...').replaceAll($(this));
                if(confirm('r u sure?')){
                  console.log('psot to delete image from sys');
                  $("#uploadbtn0").empty();
                  $("#file-preview-image0").attr('src', '/img/car-empty.jpg');
                }
                return false;
            });
    });
  },
  progressall: function (e, data) {
    var progress = parseInt(data.loaded / data.total * 100, 10);
    $('#progress0 .progress-bar').css(
        'width',
        progress + '%'
    );
  }
}).prop('disabled', !$.support.fileInput)
    .parent().addClass($.support.fileInput ? undefined : 'disabled');


$('#thumbnail1').fileupload({
  url: '',
  limitMultiFileUploads:1,
  dataType: 'json',
  autoUpload: true,
  formData: {id: 1 },
  add: function (e, data) {
    if (data.files && data.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
          $('#file-preview-image1').attr('src', e.target.result);
      }
      reader.readAsDataURL(data.files[0]);
    }
    $("#uploadbtn1").empty(); // clear data first
    data.context = $('<div/>').addClass('progress').attr('id','progress1').append($('<div/>').addClass('progress-bar progress-bar-success')).appendTo("#uploadbtn1");
    data.context = $('<button/>').addClass('btn btn-primary start').append('<i class="glyphicon glyphicon-upload"></i> Upload').appendTo("#uploadbtn1")
      .click(function () {
          // data.context = $('<p/>').text('Uploading...').replaceAll($(this));
          data.submit();
          return false;
      });
    },
  done: function (e, data) {
    $.each(data.result.files, function (index, file) {
    $("#file-preview-image1").attr('src', file.thumbnailUrl);
    $("#uploadbtn1").empty();
        // $('<p/>').text(file.name).appendTo('#thumbnail-file');
    });
  },
  progressall: function (e, data) {
    var progress = parseInt(data.loaded / data.total * 100, 10);
    $('#progress1 .progress-bar').css(
        'width',
        progress + '%'
    );
  }
}).prop('disabled', !$.support.fileInput)
    .parent().addClass($.support.fileInput ? undefined : 'disabled');


