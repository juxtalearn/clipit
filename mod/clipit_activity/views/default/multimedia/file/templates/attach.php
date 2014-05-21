<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   12/05/14
 * Last update:     12/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
?>
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
<div class="template-upload fade file">
    <div class="preview"></div>
    <div class="details">
        <div class="pull-right">
            <small class="size">Processing...</small>
            <a class="cancel" style="color: #ff1a1a;display: inline-block;" href="javascript:;">
                <i class="fa fa-times"></i>
            </a>
        </div>
        <div class="name">{%=file.name%}</div>
        <strong class="error text-danger"></strong>
        <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" style=" height: 15px; border-radius: 0; margin-top: 5px; ">
            <div class="progress-bar progress-bar-success" style="width:0%;"></div>
        </div>
    </div>
    <button class="btn btn-primary start" style="display:none;" disabled>
        <span>Start</span>
    </button>
</div>
{% } %}
</script>
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
<div class="template-download fade file">
    <input type="hidden" name="file-id[]" value="{%=file.id%}" />
    <div class="details">
        <span class="size pull-right">{%=o.formatFileSize(file.size)%}</span>
        <div>
            {% if (!file.error) { %}
            <a target="_blank" href="{%=file.download_url%}" >{%=file.name%}</a>
            {% } else { %}
            <span>{%=file.name%}</span>
            {% } %}
        </div>
        {% if (file.error) { %}
        <strong class="error text-danger">{%=file.error%}</strong>
        {% } %}
    </div>
</div>
{% } %}
</script>