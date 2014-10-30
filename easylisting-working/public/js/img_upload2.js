$(function(){
	// var i =0;
	//console.log('postID :: '+$('#hidden_post_id').val());
    $('#modal-post-form').on('shown.bs.modal', function (e) {	
		///admin/post/fileupload
		//'/admin/post/file-thumbnail'
		var urlThumbnail = '/post/file-thumbnail';
		// alert(urlThumbnail);
		var urlGallery = '/post/fileupload';
		var PostID = $('#hidden_post_id').val();
		
	    $('#post-form').fileupload({
	      url: urlGallery,
	      filesContainer: $('div.files'),
	      uploadTemplateId: "template-upload",
	      downloadTemplateId: "template-download",
	      previewMaxWidth: 110,
	      previewMaxHeight: 73,
  		  limitMultiFileUploads:12,
  		  dataType: 'json',
  		  autoUpload: true,
		  sequentialUploads:true,
  		  formData: {id: PostID}
	    });
		
		$("#post-form").bind('fileuploadcompleted', function (e, data) {
			console.log('completed');
			$("button.btn-remove").click(function(e){
				e.preventDefault();
				// console.log($(this).parentsUntil('.col-xs-4'));
				//
				$this = $(this);
			  $.get($this.data('url'),function(){
				  $this.parentsUntil('.col-xs-4').parent().remove();
			  });
				console.log('delete');
				return false;
			
			});
		});
		
		$("button.btn-remove").click(function(e){
			e.preventDefault();
			// console.log($(this).parentsUntil('.col-xs-4'));
			//
			$this = $(this);
		  $.get($this.data('url'),function(){
			  $this.parentsUntil('.col-xs-4').parent().remove();
		  });
			console.log('delete');
			return false;
			
		});
		
	    $( "#sortable" ).sortable({
	      placeholder: "col-xs-4 in",
	      stop: function( event, ui ) {
	          var data = $(this).sortable("serialize");
	          $.post( "/post/update-gallery-order",data).done(function( data ) {},"json");
	      }
	    });
		
		// $('#fileuploads').fileupload({
// 		  url: urlGallery,
// 		  limitMultiFileUploads:12,
// 		  dataType: 'json',
// 		  autoUpload: true,
// 		  formData: {id: PostID }
// 		}).prop('disabled', !$.support.fileInput)
// 		    .parent().addClass($.support.fileInput ? undefined : 'disabled');
	});

});
