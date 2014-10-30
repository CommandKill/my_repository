<!-- <div class='modal fade' id='modal-confirm-confirm-to-delete' tabindex='-1'>
      <div class='modal-dialog'style="width:200px">
        <div class='modal-content'>
            <div class='modal-header'>
             <button aria-hidden='true' class='close' data-dismiss='modal' type='button'>×</button>
             <h4 class='modal-title' id='myModalLabel'>Delete listing</h4>
            </div>
            <div class='modal-body' style="padding-bottom: 0;">
                 <div class='form-group'>
                    <label class='control-label'>Are you sure you want to delete your listing?</label>
                    <a href="" id="link-delete-post" class='btn btn-primary btn-sm btn-block search-btn'>Yes</a>
                 </div> 
            </div>
        </div>
      </div>
    </div>
 -->

<div class='modal fade' id='modal-confirm-confirm-to-delete' tabindex='-1'>
    <div class="modal-dialog" style="width:600px">
      <div class='modal-content'>
          <div class='modal-body' style="padding: 0 0 20px 0;min-height:300px; overflow: auto;">
               <div class="col-xs-12 no-padding">

                <h2 class="car-report-title" style="margin-bottom:10px;">ลบประกาศ <span id="report-title">XXX</span> </h2>
                <h3 class="car-report-title">หมายเลขประกาศ <small id="report-id">ID </small></h3>
                <form id="delete-form" class="" method="POST">

                    <input type="hidden" id="delete-listing-id" name="delete-listing-id" value="" />

                    @foreach ($questionaire->question as $key => $value) 
                    <div class="car-report-item-questionaire">
                        <p class="question">{{ $value->lang[0]->title }}</p>
                        @foreach ($value->answer as $key_answer => $value_answer)
                        <div class="report-answer">
                            @if ($value_answer->illustration)
                            <img src="{{$thumbnail_path}}/thumb_{{$value_answer->illustration}}" title="" />
                            @endif
                            <input type="radio" required id="answer-{{$key}}}-{{$key_answer}}" name="delete-reason" value="{{$value_answer->id}}" /> 
                            <label for="answer-{{$key}}}-{{$key_answer}}">{{ $value_answer->lang[0]->title }}</label><br/>
                        </div>
                        @endforeach                        
                    </div>
                    @endforeach

                    <div class="car-report-item-questionaire">
                        <button id="btn-confirm-delete-listing" class="btn submit-btn pull-right" >Submit</button>
                    </div>

                </form>

                <div class="thankyou-page">
                  <strong>ขอบคุณค่ะ</strong>
                </div>

                
              </div>
          </div>
      </div>
      <a aria-hidden='true' class='btn-close-modal' data-dismiss='modal' type='button'>×</a>
      
    </div>
</div> <!-- /.modal --> 
