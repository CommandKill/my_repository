<div class='modal fade' id='modal-subscribe-form' tabindex='-1'>
    <div class="modal-dialog" style="width:500px;position:relative">
      <div class='modal-content'>
          <div class='modal-body' style="padding-bottom: 0;min-height:200px; overflow: auto;">
               <div class="col-xs-12 no-padding">
                <h1>Newsletter Subscription</h1>
                <form id="subscribe-newsletter-form" method="POST">
                    <div class="form-group">
                        <label for="email">Your email<em>*</em></label>
                        <input type="text" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" id="btn-subscription" class="btn btn-primary">Submit</button>
                    </div>
                </form>
                @include('site.desktop.homepage.subscribe-newsletter-thankyou')
              </div>
          </div>
      </div>
      <a aria-hidden='true' class='btn-close-modal' data-dismiss='modal' type='button'>×</a>
      
    </div>
</div> <!-- /.modal --> 
