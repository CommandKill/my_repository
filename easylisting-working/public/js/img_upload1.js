$(function(){
	// var i =0;
	//console.log('postID :: '+$('#hidden_post_id').val());
	
	var PostID = 0;
    $('#modal-post-form').on('shown.bs.modal', function (e) {
		// alert('modals show');
		PostID = $('#hidden_post_id').val();
		$thumbnail = $('#hidden_thumbnail').val();
		if($thumbnail!='') {
			$("#file-preview-image99").attr('src', "/uploaded/post/"+PostID+"/160x100-"+$('#hidden_thumbnail').val());
			$("#uploadbtn99").empty();
		
	        $('<button/>').addClass('btn btn-danger btn-remove').append('<i class="glyphicon glyphicon-remove"></i>')
	            .appendTo("#uploadbtn99")
	            .click(function () {
					  $.get('/post/delete-thumbnail/'+PostID,function(){
		                  $("#uploadbtn99").empty();
		                  $("#file-preview-image99").attr('src', '/img/thumb.png');
					  });
	                return false;
	            });
		}else {
			$("#file-preview-image99").attr('src', '/img/thumb.png');
		}
		
		
		// try to bind data to thumbnail
	
	
	
		///admin/post/fileupload
		//'/admin/post/file-thumbnail'
		var urlThumbnail = '/post/file-thumbnail';
		// alert(urlThumbnail);
		var urlGallery = '/post/fileupload';
		
		$('#thumbnail99').fileupload({
		  url: urlThumbnail,
		  limitMultiFileUploads:1,
		  dataType: 'json',
		  autoUpload: true,
		  formData: {id: PostID },
		  add: function (e, data) {
		    if (data.files && data.files[0]) {
		      var reader = new FileReader();
		      reader.onload = function(e) {
		          $('#file-preview-image99').attr('src', e.target.result);
		      }
		      reader.readAsDataURL(data.files[0]);
		    }
		    $("#uploadbtn99").empty(); // clear data first
		    data.context = $('<div/>').addClass('progress').attr('id','progress99').append($('<div/>').addClass('progress-bar progress-bar-success')).appendTo("#uploadbtn99");
			data.submit();
			return false;
		        // data.context = $('<button/>').addClass('btn btn-primary start').append('<i class="glyphicon glyphicon-upload"></i>')
// 		            .appendTo("#uploadbtn99")
// 		            .click(function () {
// 		                data.submit();
// 		                return false;
// 		            });

		    },
		  done: function (e, data) {
		    $.each(data.result.files, function (index, file) {
		      $("#file-preview-image99").attr('src', file.thumbnailUrl);
		      $("#uploadbtn99").empty();
		        // $('<p/>').text(file.name).appendTo('#thumbnail-file');
		        $('<button/>').addClass('btn btn-danger btn-remove').append('<i class="glyphicon glyphicon-remove"></i>')
		            .appendTo("#uploadbtn99")
		            .click(function () {
		                // data.context = $('<p/>').text('Uploading...').replaceAll($(this));
		                // if(confirm('r u sure?')){
		                  // console.log('psot to delete image from sys');
						  $.get('/post/delete-thumbnail/'+PostID,function(){
			                  $("#uploadbtn99").empty();
			                  $("#file-preview-image99").attr('src', '/img/car-empty.jpg');
						  });
		                // }
		                return false;
		            });
		    });
		  },
		  progressall: function (e, data) {
		    var progress = parseInt(data.loaded / data.total * 100, 10);
		    $('#progress99 .progress-bar').css(
		        'width',
		        progress + '%'
		    );
		  }
		}).prop('disabled', !$.support.fileInput)
		    .parent().addClass($.support.fileInput ? undefined : 'disabled');
	

		$('.filegallery').each(function () {
			var $id = $(this).parent().children('img').data('post_id');
			console.log($id);
			$(this).fileupload({
			  url: urlGallery,
			  limitMultiFileUploads:1,
			  dataType: 'json',
			  autoUpload: true,
			  formData: {id: $('#hidden_post_id').val(),gal_id:$id },
			  add: function (e, data) {
				  // alert('add data');
				$this = $(this);
	 			$roleID = $this.parent().parent().data('role');
	 			$uploadBtn = $this.parent().parent().children('span')[1];
			    if (data.files && data.files[0]) {
			      var reader = new FileReader();
			      reader.onload = function(e) {
					  $this.parent().children('img').attr('src', e.target.result);

			      }
			      reader.readAsDataURL(data.files[0]);
			    }

				$($uploadBtn).empty();
			    data.context = $('<div/>').addClass('progress').attr('id','progress'+$roleID).append($('<div/>').addClass('progress-bar progress-bar-success')).appendTo($uploadBtn);
                data.submit();
                return false;
				    // data.context = $('<button/>').addClass('btn btn-primary start').append('<i class="glyphicon glyphicon-upload"></i>')
// 	 		            .appendTo($uploadBtn)
// 	 		            .click(function () {
// 	 		                // data.context = $('<p/>').text('Uploading...').replaceAll($(this));
// 	 		                data.submit();
// 	 		                return false;
// 	 		            });
			    },
			  done: function (e, data) {
	  			$this = $(this);
	   			$roleID = $this.parent().parent().data('role');
	   			$uploadBtn = $this.parent().parent().children('span')[1];
				
			    $.each(data.result.files, function (index, file) {
				  $this.parent().children('img').attr('src', file.thumbnailUrl);
			      $($uploadBtn).empty();
		        $('<button/>').addClass('btn btn-danger btn-remove').append('<i class="glyphicon glyphicon-remove"></i>')
		            .appendTo($uploadBtn)
		            .click(function () {
		                // if(confirm('r u sure?')){
		                //   console.log('psot to delete image from sys');
						  
						  $.get(file.deleteUrl,function(){
			                  $($uploadBtn).empty();
			                  $this.parent().children('img').attr('src', '/img/car-empty.jpg');
						  });
						  
		                  
		                // }
		                return false;
		            });
			    });
			  },
			  progressall: function (e, data) {
	    		$this = $(this);
	     		$roleID = $this.parent().parent().data('role');
	     		$uploadBtn = $this.parent().parent().children('span')[1];
					
			    var progress = parseInt(data.loaded / data.total * 100, 10);
			    $('#progress'+$roleID+' .progress-bar').css(
			        'width',
			        progress + '%'
			    );
			  }
			}).prop('disabled', !$.support.fileInput)
			    .parent().addClass($.support.fileInput ? undefined : 'disabled');
				
		});
	});

});
