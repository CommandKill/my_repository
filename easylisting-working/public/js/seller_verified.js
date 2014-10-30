$(function(){
	
	var PostID = 0;

	/*
	|-------------------------------------------
	|	Seller Verified
	|-------------------------------------------
	*/
	$('#modal-verify-form').on('hidden.bs.modal', function (e) {
		$("#uploadbtn-carOwner").empty();
		$('#verified-car-text').remove();
		$("#file-preview-image-carOwner").attr('src', '/img/thumb.png');
	});

	$('#modal-verify-form').on('shown.bs.modal', function (e) {

		PostID = $('#hidden_post_id').val();

		// --- Check if verified show Seller Name and input to inactive
		$.get('/verified/check-id', function(data, textStatus, xhr) {
			// console.log(data.verified);
			$.each(data.verified, function (index, status) {
				// console.log(status.status);
				if( status.status == 1 ){
					$('#thumbnail-id').remove();
					$('#verified-text').remove();
					$('#title-id-docs').parent().append('<p id="verified-text">Verified Name : <b>'+status.name+'</b></p>');
					$("#file-preview-image-id").attr('src', status.id_docs_path);
				}else if( status.status == 0 ){
					$('#thumbnail-id').remove();
					$('#verified-text').remove();
					$('#title-id-docs').parent().append('<p id="verified-text">Please wait for approve.</p>');
					$("#file-preview-image-id").attr('src', status.id_docs_path);
				}
			});
		});

		$.get('/verified/check-car?id='+PostID, function(data, textStatus, xhr) {
			// console.log(data.verified);
			$.each(data.verified, function (index, status) {
				// console.log(status.status);
				if( status.status == 1 ){
					$('#thumbnail-carOwner').remove();
					$('#verified-car-text').remove();
					$('#title-car-docs').parent().append('<p id="verified-car-text"><b>Car Verified</b></p>');
					$("#file-preview-image-carOwner").attr('src', status.docs_path);
				}else if( status.status == 0 ){
					// $('#thumbnail-carOwner').remove(); // Remove this on waiting time can change
					$('#verified-car-text').remove();
					$('#title-car-docs').parent().append('<p id="verified-car-text">Please wait for approve.</p>');
					$("#file-preview-image-carOwner").attr('src', status.docs_path);
				}
				else{
					// $('#file-preview-image-carOwner').parent().append('<input id="thumbnail-carOwner" class="filegallery" type="file" name="thumbnail-carOwner">');
					// $('#verified-car-text').remove();
					// $("#file-preview-image-carOwner").attr('src', '/img/thumb.png');
				}
			});
		});


		var _id = "{{ Session::get('member.id') }}";
		// var urlThumbnail = '/post/file-thumbnail';
		var urlThumbnail = '/verified/add-id';
		// var urlThumbnail = "{{ URL::to(App::getLocale().'/verified/add-id?id='.$member->id) }}";
		// var urlGallery = '/post/fileupload';
		
		// --- ID Docs
		$('#thumbnail-id').fileupload({
		  url: urlThumbnail,
		  limitMultiFileUploads:1,
		  dataType: 'json',
		  autoUpload: true,
		  formData: {id: PostID },
		  add: function (e, data) {
		    if (data.files && data.files[0]) {
		      var reader = new FileReader();
		      reader.onload = function(e) {
		          $('#file-preview-image-id').attr('src', e.target.result);
		      }
		      reader.readAsDataURL(data.files[0]);
		    }
		    $("#uploadbtn-id").empty(); // clear data first
		    data.context = $('<div/>').addClass('progress').attr('id','progress-id').append($('<div/>').addClass('progress-bar progress-bar-success')).appendTo("#uploadbtn-id");
			data.submit();
			return false;

		    },
		  done: function (e, data) {
		    $.each(data.result.files, function (index, file) {
		      $("#file-preview-image-id").attr('src', file.thumbnailUrl);
		      $("#uploadbtn-id").empty();
		        // $('<p/>').text(file.name).appendTo('#thumbnail-file');
		        $('<button/>').addClass('btn btn-danger btn-remove').append('<i class="glyphicon glyphicon-remove"></i>')
		            .appendTo("#uploadbtn-id")
		            .click(function () {
		                // data.context = $('<p/>').text('Uploading...').replaceAll($(this));
		                // if(confirm('r u sure?')){
		                  // console.log('psot to delete image from sys');
						  // $.get('/verified/delete-id/'+PostID,function(){
						  	$.get('/verified/delete-id', function(){
			                  $("#uploadbtn-id").empty();
			                  // $("#file-preview-image-id").attr('src', '/img/car-empty.jpg');
			                  $("#file-preview-image-id").attr('src', '/img/thumb.png');
						  });
		                // }
		                return false;
		            });
		    });
		  },
		  progressall: function (e, data) {
		    var progress = parseInt(data.loaded / data.total * 100, 10);
		    $('#progress-id .progress-bar').css(
		        'width',
		        progress + '%'
		    );
		  }
		}).prop('disabled', !$.support.fileInput)
		    .parent().addClass($.support.fileInput ? undefined : 'disabled');


		// --- Car Owner Docs
		var urlCarDocs = '/verified/add-car-docs';

		$('#thumbnail-carOwner').fileupload({
		  url: urlCarDocs,
		  limitMultiFileUploads:1,
		  dataType: 'json',
		  autoUpload: true,
		  formData: {id: PostID },
		  add: function (e, data) {
		    if (data.files && data.files[0]) {
		      var reader = new FileReader();
		      reader.onload = function(e) {
		          $('#file-preview-image-carOwner').attr('src', e.target.result);
		      }
		      reader.readAsDataURL(data.files[0]);
		    }
		    $("#uploadbtn-carOwner").empty(); // clear data first
		    data.context = $('<div/>').addClass('progress').attr('id','progress-carOwner').append($('<div/>').addClass('progress-bar progress-bar-success')).appendTo("#uploadbtn-carOwner");
			data.submit();
			return false;

		    },
		  done: function (e, data) {
		    $.each(data.result.files, function (index, file) {
		      $("#file-preview-image-carOwner").attr('src', file.thumbnailUrl);
		      $("#uploadbtn-carOwner").empty();
		        // $('<p/>').text(file.name).appendTo('#thumbnail-file');
		        $('<button/>').addClass('btn btn-danger btn-remove').append('<i class="glyphicon glyphicon-remove"></i>')
		            .appendTo("#uploadbtn-carOwner")
		            .click(function () {
		                // data.context = $('<p/>').text('Uploading...').replaceAll($(this));
		                // if(confirm('r u sure?')){
		                  // console.log('psot to delete image from sys');
						  // $.get('/verified/delete-car-docs'+PostID,function(){
						  $.get('/verified/delete-car-docs?id='+PostID, function(){
			                  $("#uploadbtn-carOwner").empty();
			                  $("#file-preview-image-carOwner").attr('src', '/img/thumb.png');
						  });
		                // }
		                return false;
		            });
		    });
		  },
		  progressall: function (e, data) {
		    var progress = parseInt(data.loaded / data.total * 100, 10);
		    $('#progress-carOwner .progress-bar').css(
		        'width',
		        progress + '%'
		    );
		  }
		}).prop('disabled', !$.support.fileInput)
		    .parent().addClass($.support.fileInput ? undefined : 'disabled');

	});



	// Seller Verified
    $('#btn-post-new').click(function(){
        $('#modal-seller-verification').modal('show');
        return false;
    });   

    $('.verify-no').click(function(){
        $('#modal-seller-verification').modal('hide');
        // post to add new 
        $.post( '/post/store', function( data ) {
          if (!data.error) {
            $('#hidden_post_id').val(data.post.id);
            $('#modal-post-form').modal('show');
          } else {
            alert('can not add new post!');
          }
        });

        return false;
    });

    $('.verify-yes').click(function(){
        $('#modal-seller-verification').modal('hide');
        // post to add new 
        $.post( '/post/store', function( data ) {
          if (!data.error) {
            $('#hidden_post_id').val(data.post.id);
            $('#modal-verify-form').modal('show');
          } else {
            alert('can not add new post!');
          }
        });

        return false;
    });

    $('#next_add_car').click(function(e) {
      $('#modal-verify-form').modal('hide');
      $('#modal-post-form').modal('show');
    });

    $('.verify-car').click(function(e) {
    	var car_id = $(this).data('car-id');
    	$('#hidden_post_id').val(car_id);
    	$('#modal-verify-form').modal('show');
    });

});
