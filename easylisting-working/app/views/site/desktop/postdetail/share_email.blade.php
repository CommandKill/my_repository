<div class="modal fade" id="share_email">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title"> Share to your friend </h4>
      </div>
	   <form role="form" id="share_email_form" method="post" class="clearfix">
		<input type="hidden" name="id" value="{{ $post_id }}">   
      <div class="modal-body">
	        <div class="form-group">
	            <label for="form-contact-agent-message">Your friend's name<em>*</em></label>
	            <input type="text" class="form-control" id="share_friend_name" name="share_friend_name" required>
	        </div><!-- /.form-group -->
	        <div class="form-group">
	            <label for="form-contact-agent-message">Your friend's email<em>*</em></label>
	            <input type="email" class="form-control" id="share_friend_email" name="share_friend_email" required>
	        </div><!-- /.form-group -->
            <div class="form-group">
                <label for="form-contact-agent-email">Your name<em>*</em></label>
                <input type="text" class="form-control" id="share_name" name="share_name" required>
            </div><!-- /.form-group -->
	        <div class="form-group">
	            <label for="form-contact-agent-message">Your email<em>*</em></label>
	            <input type="email" class="form-control" id="share_email" name="share_email" required>
	        </div><!-- /.form-group -->
            <div class="form-group">
                <label for="form-contact-agent-message">Your Message</label>
                <textarea class="form-control" id="share_message" rows="2" name="share_message"></textarea>
            </div><!-- /.form-group -->
            <div id="form-contact-agent-status"></div>

		
      </div>
      <div class="modal-footer">
		 <div class="pull-left" id="waiting"></div> 
        <button type="submit" class="btn btn-primary" style="background-color:#1CA5BE;color:white;">Submit</button>
      </div>
	  </form><!-- /#form-contact -->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->