<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}

  <li class="list-group-item template-upload fade col-xs-4">
    <span class="preview">
    </span>
    <span class="name">
      {%=file.name%}
        <strong class="error text-danger"></strong>
    </span>
    <span>
      <p class="size">Processing...</p>
      <div class="progress progress-striped active " role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
      <div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
    </span>
    <span>
    {% if (!i && !o.options.autoUpload) { %}
        <button class="btn btn-primary btn-xs start" disabled>
            <i class="glyphicon glyphicon-upload"></i>
            <span>Start</span>
        </button>
    {% } %}
    {% if (!i) { %}
        <button class="btn btn-warning btn-xs cancel">
            <i class="glyphicon glyphicon-ban-circle"></i>
            <span>Cancel</span>
        </button>
    {% } %}
    </span>
  </li>
{% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
  <li class="template-download fade row col-xs-4" id="gal_id_{%=file.id%}">
    <span class="preview col-md-12">
    {% if (file.thumbnailUrl) { %}
        <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}" width="100%"></a>
    {% } %}
    </span>
    <span class="name col-md-12" style="overflow: hidden">
    {% if (file.url) { %}
        <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
    {% } else { %}
        <span>{%=file.name%}</span>
    {% } %}

    {% if (file.error) { %}
        <div><span class="label label-danger">Error</span> {%=file.error%}</div>
    {% } %}
    </span>
    <span class="size col-md-12">{%=o.formatFileSize(file.size)%}</span>
    <span class="col-md-12">
    {% if (file.deleteUrl) { %}
        <button class="btn btn-danger btn-xs delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
            <i class="glyphicon glyphicon-trash"></i>

        </button>
        <input type="checkbox" name="delete" value="1" class="toggle">
    {% } else { %}
        <button class="btn btn-warning btn-xs cancel">
            <i class="glyphicon glyphicon-ban-circle"></i>
            <span>Cancel</span>
        </button>
    {% } %}
    </span>
  </li>
{% } %}
</script>