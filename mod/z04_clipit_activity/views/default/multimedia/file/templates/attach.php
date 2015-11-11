<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   12/05/14
 * Last update:     12/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
?>
<script id="template-modal-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
<div class="multimedia-block template-upload fade file col-md-4" style="position:relative;border-radius: 4px;margin-bottom: 0;padding: 0;background: transparent;">
    <div class="attach-block">
        {% if (/^video\/(\w+)/g.test(file.type)) { %}
            <div style="width: 100%;height: 75px;text-align: center;background-color: #bae6f6;border-radius: 4px;">
                <i class="fa fa-spinner fa-spin fa-3x blue" style="line-height: 75px;"></i>
            </div>
        {% } else { %}
            <div class="multimedia-preview image-block">
                <div class="preview"></div>
            </div>
        {% } %}
        <div class="details content-block">
            <div class="pull-right">
                <a class="cancel" style="color: #ff1a1a;display: inline-block;" href="javascript:;">
                    <i class="fa fa-times"></i>
                </a>
            </div>
            <div class="name text-truncate">{%=file.name%}</div>
            <small class="size">Processing...</small>
            <strong class="error text-danger show"></strong>
            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" style=" height: 15px; border-radius: 0; margin-top: 5px; ">
                <div class="progress-bar progress-bar-success" style="width:0%;"></div>
            </div>
        </div>
        <button class="btn btn-primary start" style="display:none;" disabled>
            <span>Start</span>
        </button>
    </div>
</div>
{% } %}
</script>
<script id="template-modal-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
<div class="multimedia-block col-md-4" style="position:relative;border-radius: 4px;margin-bottom: 0;padding: 0;background: transparent;">
    <label class="select-item attach-item" title="{%=file.name%}" for="item_{%=file.id%}"></label>
    <input
        type="checkbox"
        checked
        style="display: none"
        name="{%#file.input_prefix%}"
        value="{%=file.id%}"
        id="item_{%=file.id%}"
        >
    <div class="attach-block selected">
{% if (file.video) { %}
    <div class="multimedia-preview" style="margin-right: 0;float: none;display: block;height: 100%;">
        {% if (!file.preview_ready) { %}
        <div style="width: 100%;height: 108px;text-align: center;background-color: #bae6f6;border-radius: 4px;">
            <i class="fa fa-youtube-square fa-5x blue" style="line-height: 105px;"></i>
        </div>
        {% } else { %}
            <img src="{%=file.preview%}" style="width: 100%;">
        {% } %}
    </div>
    <div class="multimedia-details margin-top-10">
        <div class="blue text-truncate">
            <a class="item-info"><strong>{%=file.name%}</strong></a>
        </div>
    </div>
{% } else { %}
    <div class="multimedia-preview" >
        {%#file.preview%}
    </div>
    <div class="multimedia-details">
        <div class="blue text-truncate">
            <a class="item-info">{%=file.name%}</a>
        </div>
        <small class="show"><strong>{%=file.type%}</small>
    </div>
{% } %}
    </div>
</div>
{% } %}
</script>
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
        <strong class="error text-danger show">{%=file.error%}</strong>
        {% } %}
    </div>
</div>
{% } %}
</script>
