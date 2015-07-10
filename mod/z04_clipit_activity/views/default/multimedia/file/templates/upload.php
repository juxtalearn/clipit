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
$object = ClipitSite::lookup($entity->id);
switch($object['subtype']){
    case 'ClipitActivity':
        $tags = ClipitTrickyTopic::get_tags($entity->tricky_topic);
        break;
    case 'ClipitGroup':
        $activity = array_pop(ClipitActivity::get_by_id(array($entity->activity)));
        $tags = ClipitTrickyTopic::get_tags($activity->tricky_topic);
        break;
}

?>
<script>
$(function(){
    $(document).on("click", ".add-tag", function(){
        var content = $(this).parent("div").find("div");
        content.toggle();
        content.find('.tag-select').chosen();
    });
});
</script>
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
<div class="row template-upload fade">
    <?php echo elgg_view("input/hidden", array(
        'name' => 'scope-id',
        'value' => $entity->id,
    ));
    ?>
    <?php echo elgg_view("input/hidden", array(
        'name' => 'type',
        'value' => $type,
    ));
    ?>
    <div class="col-md-2">
        <div class="file-info">
            <div class="img-prev"><div class="preview"></div></div>
            <div class="text-truncate text-center">
                <small class="size"><?php echo elgg_echo('multimedia:processing');?>...</small>
            </div>
            <strong class="error text-danger"></strong>
            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
            <a class="cancel btn btn-border-red btn-xs margin-top-10 show" style="text-transform: uppercase;">
                    <i class="fa fa-trash-o"></i>
                    <span><?php echo elgg_echo('multimedia:delete');?></span>
                </a>
        </div>
    </div>
    <button class="btn btn-primary start" style="display:none;" disabled>
        <span>Start</span>
    </button>
    <div class="col-md-10">
        <div class="form-group">
            <label for="file-name"><?php echo elgg_echo("name");?></label>
            <input type="text" name="file-name" class="form-control" placeholder="{%=file.name%}" required="true" value="{%=file.name%}" onfocus="if(this.value == '{%=file.name%}') { this.value = ''; }">
        </div>
        <div class="form-group">
            <label for="file-text"><?php echo elgg_echo("multimedia:file:description");?></label>
            <?php echo elgg_view("input/plaintext", array(
                    'name' => 'file-text',
                    'class' => 'form-control mceEditor',
                    'rows'  => 3
                ));
            ?>
        </div>
        <div style="margin-top: -10px;">
        <a href="javascript:;" class="add-tag"><strong>+ <?php echo elgg_echo('tags:assign');?></strong></a>
            <div style="display:none;" class="margin-top-10">
            <select name="tags[]" data-placeholder="<?php echo elgg_echo('click_add');?>" style="width:100%;" class="tag-select" multiple tabindex="8">
                <option value=""></option>
                <?php
                foreach($tags as $tag_id):
                    $tag = array_pop(ClipitTag::get_by_id(array($tag_id)));
                ?>
                    <option value="<?php echo $tag->id;?>"><?php echo $tag->name;?></option>
                <?php endforeach;?>
            </select>
            </div>
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