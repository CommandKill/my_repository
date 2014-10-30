<!-- <section id="contact-agent"> -->
                <div class="col-md-3 col-sm-3 col-xs-3">
                    <a href="agent-detail.html">
                        @if($member->avatar)
                        <img width="100%" class="img-circle img-thumbnail" src="{{ $destination_url }}{{ $member->id }}/{{ $avatar_image_size }}_{{ $member->avatar }}" title="" alt="{{ $member->avatar }}"/>
                        @else
                        <img width="100%" src="{{ asset('img/agent-01.jpg') }}" title="placeholder" alt="placeholder"/>
                        @endif
                    </a>
                </div>
                <div class="col-md-9 col-sm-9 col-xs-9" style="margin-top:10px;">
                    <h5 class="no-margin pull-right" >{{ $member->first_name or ''}} {{ $member->last_name or '' }}</h5><br/>
                </div>
                <div class="col-md-12 col-sm-12">
                <dl style="margin-top:10px;margin-bottom:15px;">
                    <dt>Click to view</dt>
                    <dd><div id="number" style="color:#1CA5BE" data-last="{{$member->phone }}" data-first="{{Str::limit($member->phone,4,'xxxx')  }}">{{Str::limit($member->phone,4,'xxxx')  }}</div></dd>
                    <dt>Line ID</dt>
					<dd>n/a</dd>
					<dt>Views</dt>
					<dd>{{ $content->views or '0' }}</dd>
					<dt>Listing ID</dt>
					<dd>{{ $content->id }}</dd>
                    <!-- <dd><a href="mailto:{{ $member->email }}">{{ $member->email }}</a></dd> -->
                </dl>
                <!-- <hr> -->
                <!-- <a href="agent-detail.html" class="link-arrow">Full Profile</a> -->
				<div class="center-block">
					<button type="button" class="btn center-block" style="background-color:#1CA5BE;color:white;" id="form-contact-agent-submit" data-toggle="modal" data-target="#message_modal">Send a message</button>
				</div>
				<div class="center-block" style="margin-top:30px;align:center;text-align:center;">
					<a href="#fb"><img style="opacity:100%" src="{{ asset('newassets/Twitter@1x.png') }}"></a>
					<a href="#fb"><img src="{{ asset('newassets/Facebook@1x.png') }}"></a>
					<a href="#fb"><img src="{{ asset('newassets/Google +@1x.png') }}"></a>
					<a href="#fb"><img src="{{ asset('newassets/icon-mail@1x.png') }}"></a>
					<a href="#fb"><img src="{{ asset('newassets/icon-printer@1x.png') }}"></a>
				</div>

    		</div>
<!-- </section> -->
			
			<div class="modal fade" id="message_modal">
			  <div class="modal-dialog">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			        <h4 class="modal-title">ส่งข้อความถึง {{ $member->first_name or ''}} {{ $member->last_name or '' }} </h4>
			      </div>
				   <form role="form" id="form-contact-agent" method="post" class="clearfix">
			      <div class="modal-body">
	               
	                    <div class="form-group">
	                        <label for="form-contact-agent-message">Your Message<em>*</em></label>
	                        <textarea class="form-control" id="form-contact-agent-message" rows="2" name="form-contact-agent-message" required></textarea>
	                    </div><!-- /.form-group -->
	                    <div class="form-group">
	                        <label for="form-contact-agent-name">Your Telephone<em>*</em></label>
	                        <input type="text" class="form-control" id="form-contact-agent-name" name="form-contact-agent-name" required>
	                    </div><!-- /.form-group -->
	                    <div class="form-group">
	                        <label for="form-contact-agent-email">Your Email<em>*</em></label>
	                        <input type="email" class="form-control" id="form-contact-agent-email" name="form-contact-agent-email" required>
	                    </div><!-- /.form-group -->
	                    <div id="form-contact-agent-status"></div>
	
					
			      </div>
			      <div class="modal-footer">
			        <button type="submit" class="btn btn-primary" style="background-color:#1CA5BE;color:white;">ส่งข้อความ</button>
			      </div>
				  </form><!-- /#form-contact -->
			    </div><!-- /.modal-content -->
			  </div><!-- /.modal-dialog -->
			</div><!-- /.modal -->
			