<div class='modal fade' id='modal-report-form' tabindex='-1'>
    <div class="modal-dialog" style="width:600px">
      <div class='modal-content'>
          <div class='modal-body' style="padding: 0 0 20px 0;min-height:500px; overflow: auto;">
               <div class="col-xs-12 no-padding">

                <h2 class="car-report-title">{{-- $data['text_page']['title'] --}}</h2>

                <div class="col-xs-12 car-report-item-info">
                  <div class="car-report-item-info-left">
                    <img id="file-report-preview-image" class="file-report-preview-image" src="" />
                  </div>
                  <div class="car-report-item-info-right">
                    <small id="report-id">ID </small>
                    <header id="report-title">XXX</header>
                  </div>
                </div>

                <form id="report-form" class="" method="POST">

                    <input type="hidden" id="post-id" name="post-id" value="" />

                    @foreach ($questionaire->question as $key => $value) 
                    <div class="car-report-item-questionaire">
                        <p class="question">{{ $value->lang[0]->title }}</p>
                        @foreach ($value->answer as $key_answer => $value_answer)
                        <div class="report-answer">
                            @if ($value_answer->illustration)
                            <img src="{{$thumbnail_path}}/thumb_{{$value_answer->illustration}}" title="" />
                            @endif
                            <input type="radio" required id="answer-{{$key}}}-{{$key_answer}}" name="report-reason" value="{{$value_answer->id}}" /> 
                            <label for="answer-{{$key}}}-{{$key_answer}}">{{ $value_answer->lang[0]->title }}</label><br/>
                        </div>
                        @endforeach                        
                    </div>
                    @endforeach

                    <div class="car-report-item-questionaire">
                        <label for="report-email">{{-- $data['text_page']['email_or_phone'] --}}</label>
                        <input type="email" required name="report-email" id="report-email" class="form-control" /> 
                        <br>
                        <button id="btn-report-submit" class="btn submit-btn next pull-right" >Submit</button>
                    </div>

                </form>

                <div class="thankyou-page">
                  <strong>{{-- $data['text_page']['thankyou'] --}}</strong>
                  <p>{{-- $data['text_page']['thankyou_desc'] --}}</p>
                </div>

                
              </div>
          </div>
      </div>
      <a aria-hidden='true' class='btn-close-modal' data-dismiss='modal' type='button'>×</a>
      
    </div>
</div> <!-- /.modal --> 
