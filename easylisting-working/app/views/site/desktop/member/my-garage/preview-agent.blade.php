<!-- <section id="contact-agent"> -->
<div class="col-xs-5">
    <a href="#">
        <img width="100%" id="preview-thumbnail" class="img-circle img-thumbnail" src="{{ asset('img/agent-01.jpg') }}" title="placeholder" alt="placeholder"/>
    </a>
</div>
<div class="col-xs-7" style="margin-top:10px;">
    <h5 class="no-margin pull-right" ><span class="preview-post_by"></span></h5>
</div>
<div class="col-xs-12">
  <dl style="margin-top:10px;margin-bottom:15px;">
      <dt>Phone</dt>
      <dd><div id="number" style="color:#1CA5BE" data-last="444444444" data-first="{{Str::limit(444444444,4,'xxxx')  }}">
        {{Str::limit('444444444',4,'xxxx')  }}
      </div>
    </dd>
    <dt id="preview-line_id0">Line ID</dt>
  	<dd id="preview-line_id">n/a</dd>
  	<dt>Listing ID</dt>
  	<dd id="preview-post_id">xxx</dd>
  </dl>
</div>