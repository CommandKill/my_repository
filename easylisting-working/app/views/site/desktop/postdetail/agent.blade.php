<!-- <section id="contact-agent"> -->
<div class="col-xs-5">
    <a href="#">
        @if(isset($post_by['avatar']) && $post_by['avatar'])
        <img width="100%" class="img-circle img-thumbnail" src="{{ $destination_url }}/{{ $post_by['member_id'] }}/150x150-{{ $post_by['avatar'] }}" title="" alt="{{ $post_by['avatar'] }}"/>
        @else
        <img width="100%" src="{{ asset('img/agent-01.jpg') }}" title="placeholder" alt="placeholder"/>
        @endif
    </a>
</div>
<div class="col-xs-7" style="margin-top:10px;">
    <h5 class="no-margin pull-right" >{{ $post_by['first_name'] or ''}} {{ $post_by['last_name'] or '' }}</h5><br/>
</div>
<div class="col-xs-12">
<dl style="margin-top:10px;margin-bottom:15px;">
  @if(isset($post_by['phone']) && $post_by['phone'])
    <dt>Click to view</dt>
    <dd><div id="number" style="color:#1CA5BE;cursor:pointer;" data-last="{{$post_by['phone'] }}" data-first="{{Str::limit($post_by['phone'],3,'xxxxxxx')  }}">
      {{Str::limit($post_by['phone'],3,'xxxxxxx')  }}
    </div>
  </dd>
  @endif
  @if(isset($post_by['line_id']))
    <dt>Line ID</dt>
	<dd>{{ $post_by['line_id']  }}</dd>
  @endif
	<dt>Views</dt>
	<dd>{{ $views or '0' }}</dd>
	<dt>Listing ID</dt>
	<dd>{{ $post_id }}</dd>

</dl>
<!-- <hr> -->
<!-- <a href="agent-detail.html" class="link-arrow">Full Profile</a> -->
<div class="center-block">
	<button type="button" class="btn center-block" style="background-color:#1CA5BE;color:white;" id="form-contact-agent-submit" data-toggle="modal" data-target="#message_modal">Send a message</button>
</div>
<div class="center-block" style="margin-top:30px;align:center;text-align:center;">
	<a href="#fb" style="margin-bottom:15px"><!-- <img src="{{ asset('img/icons/Facebook@1x.png') }}"> -->
		{{ Shareable::facebook($options = array('url'=>Request::url(),'type'=>'button')) }}
	</a>
	<a href="#twitter">
		<!-- <img style="opacity:100%" src="{{ asset('img/icons/Twitter@1x.png') }}"> -->
		{{ Shareable::twitter($options = array('url'=>Request::url(),'count'=>false)) }}
	</a>
	<a href="#googleplus" style="margin-top:5px;">
		{{ Shareable::googlePlus($options = array('url'=>Request::url(),'size'=>'medium','annotation'=>'none')) }}
		<!-- <img src="{{ asset('img/icons/Google +@1x.png') }}"> -->
	</a>
	<a href="#fb" data-toggle="modal" data-target="#share_email"><img src="{{ asset('img/icons/icon-mail@1x.png') }}"></a>
	<a href="#print" id="print_page"><img src="{{ asset('img/icons/icon-printer@1x.png') }}"></a>
	<!-- {{ Shareable::all() }} -->
</div>
@if($post_id==Session::get('member.id'))
<div class="center-block" style="margin-top:30px;align:center;text-align:center;">
    <a href="#delete" data-id="{{ $post_id }}" data-href="{{ URL::to(App::getLocale().'/my-garage/destroy/'.$post_id) }}" 
          data-toggle="modal" data-target="#modal-confirm-confirm-to-delete" 
          class='btn btn-default btn-delete btn-delete-post'><i style="padding-right:10px" class="delete fa fa-trash-o"></i>ลบ/ยกเลิกประกาศ</a>
</div>
@endif
</div>
<!-- </section> -->
			
<div class="modal fade" id="message_modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">ส่งข้อความถึง {{ $post_by['first_name'] or ''}} {{ $post_by['last_name'] or '' }} </h4>
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

@include('site.desktop.postdetail.share_email')
