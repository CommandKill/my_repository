<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
	<div class="col-xs-4" style="padding-bottom:13px;padding-left:15px;padding-right:19px;float:left;">
	        <div>
	            <span class="preview">
				</span>	
	          <span class="uploadbtn" style="width:111px">
	          	<div class="progress" style="width:111px;margin-left:15px">
	          		<div class="progress-bar progress-bar-success"></div>
	          	</div>
	          </span>
	        </div>
	</div>
{% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <div class="col-xs-4" style="padding-bottom:24px;padding-left:15px;padding-right:19px;float:left;" id="gal_id_{%=file.id%}" style="cursor: move">
        <div data-role="{%=file.id%}">
          <span class="preview">
		    {% if (file.thumbnailUrl) { %}
		        <img src="{%=file.thumbnailUrl%}" style="width:111px;height:73px;">
		    {% } %}
          </span>
          <span class="uploadbtn" style="width:110px">
          	<button class="btn btn-danger btn-remove" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}><i class="glyphicon glyphicon-remove"></i></button>
          </span>
        </div>
    </div>
{% } %}
</script>