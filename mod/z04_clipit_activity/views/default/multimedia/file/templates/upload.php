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
$entity = elgg_extract("entity", $vars);
$type = elgg_extract("type", $vars);
?>
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
<div class="row template-upload fade">
    <?php echo elgg_view("input/hidden", array(
        'name' => 'entity-id',
        'value' => $entity->id,
    ));
    ?>
    <?php echo elgg_view("input/hidden", array(
        'name' => 'type',
        'value' => $type,
    ));
    ?>
    <div class="col-md-3">
        <div class="file-info">
            <div class="img-prev"><div class="preview"></div></div>
            <div class="text-truncate">
                <small class="size pull-right">Processing...</small>
                <div class="text-truncate"><a title="{%=file.name%}">{%=file.name%}</a></div>
            </div>
            <strong class="error text-danger"></strong>
            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
            <a class="cancel btn" style="
    color: #ff1a1a;
    margin-top: 5px;
    display: block;
    text-transform: uppercase;
    border: 1px solid #ff1a1a;
">
                    <i class="fa fa-ban"></i>
                    <span>Delete</span>
                </a>
        </div>
    </div>
    <button class="btn btn-primary start" style="display:none;" disabled>
        <span>Start</span>
    </button>
    <div class="col-md-8">
        <div class="form-group">
            <label for="file-name"><?php echo elgg_echo("multimedia:file:description");?></label>
            <?php echo elgg_view("input/plaintext", array(
                    'name' => 'file-text',
                    'class' => 'form-control mceEditor',
                    'rows'  => 3,
                ));
            ?>
        </div>
    </div>
</div>
{% } %}

</script>
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <div class="template-download fade" style="display:none;">
    </div>
{% } %}
</script>