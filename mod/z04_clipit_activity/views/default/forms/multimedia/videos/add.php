<?php
/**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   22/04/14
 * Last update:     22/04/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$entity = elgg_extract('entity', $vars);
$hasToken = get_config("google_refresh_token");
$object = ClipitSite::lookup($entity->id);
switch($object['subtype']){
    case "ClipitGroup":
        $group_tags = ClipitGroup::get_tags($entity->id);
        $activity = array_pop(ClipitActivity::get_by_id(array($entity->activity)));
        $tt = array_pop(ClipitTrickyTopic::get_by_id(array($activity->tricky_topic)));
        $tt_tags = $tt->tag_array;
        $tt_tags = array_diff($tt_tags, $group_tags);
        break;
    case "ClipitActivity":
        $tt = array_pop(ClipitTrickyTopic::get_by_id(array($entity->tricky_topic)));
        $tt_tags = $tt->tag_array;
        break;
}
$performance_items = array();
$performance_items = $activity->performance_item_array;
$tags = array();
$labels_value = array();
echo elgg_view("input/hidden", array(
    'name' => 'entity-id',
    'value' => $entity->id,
));
echo elgg_view("input/hidden", array(
    'name' => 'tags',
));
?>
<script>
    $(function(){
        $(".chosen-select").chosen({disable_search_threshold: 1});
        $(".chosen-select-items").chosen();

        $('form').on('click', 'input[type=submit]', function(evt) {
            if($(this.form).find(":file").val() != '' && $(this.form).find(":file").length > 0) {
                $("#uploading").prependTo($(this).closest(".modal-content")).show();
                $("body").css({"cursor": "progress"});
            }
        });
    });
</script>
<style>
    .chosen-container{
        width: 100% !important;
    }
</style>
<div id="uploading" style="display: none;position: absolute;  left: 0;  top: 0;  right: 0;  bottom: 0;  z-index: 999;background: rgba(255,255,255,0.8);">
    <div style="height: 100%;" class="wrapper separator loading-block">
        <div>
            <i class="fa fa-spinner fa-spin blue"></i>
            <h3 class="blue"><?php echo elgg_echo('video:uploading:youtube');?>...</h3>
        </div>
    </div>
</div>
<div class="row" style="position: relative;">
    <div class="col-md-12 add-video">
        <div class="video-info">
            <div class="panel-group" id="accordion_add" style="margin-bottom: 10px;">
                <?php if($hasToken):?>
                    <!-- Video upload -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <a data-toggle="collapse" data-parent="#accordion_add" href="#collapse_add1">
                                <h4 class="panel-title">
                                    <strong>
                                        <i class="fa fa-angle-down pull-right"></i>
                                        <?php echo elgg_echo('video:add:to_youtube');?>
                                    </strong>
                                </h4>
                            </a>
                        </div>
                        <div id="collapse_add1" class="panel-collapse collapse">
                            <div class="panel-body">
                                <div class="form-group">
                                    <label for="video-upload"><?php echo elgg_echo("video:upload");?></label>
                                    <?php echo elgg_view("input/file", array(
                                        'name' => 'video-upload',
                                        'id' => 'video-upload',
                                        'style' => "width: 100%;"
                                    ));
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Video url -->
                <?php endif;?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a data-toggle="collapse" data-parent="#accordion_add" href="#collapse_add2">
                            <h4 class="panel-title">
                                <strong>
                                    <i class="fa fa-angle-down pull-right"></i>
                                    <?php echo elgg_echo('video:add:paste_url');?>
                                </strong>
                            </h4>
                        </a>
                    </div>
                    <div id="collapse_add2" class="panel-collapse collapse">
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="video-url"><?php echo elgg_echo("video:url");?></label>
                                <div class="icon">
                                    <?php echo elgg_view("input/text", array(
                                        'name' => 'video-url',
                                        'id' => 'video-url',
                                        'class' => 'form-control blue',
                                    ));
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="video-title"><?php echo elgg_echo("video:title");?></label>
                <?php echo elgg_view("input/text", array(
                    'name' => 'video-title',
                    'id' => 'video-title',
                    'class' => 'form-control',
                    'required' => true
                ));
                ?>
            </div>
            <?php echo elgg_view("input/hidden", array(
                'name' => 'labels',
                'id' => 'input_labels',
                'value' => $labels_value
            ));?>
            <div class="form-group">
                <label for="video-description"><?php echo elgg_echo("video:description");?></label>
                <?php echo elgg_view("input/plaintext", array(
                    'name' => 'video-description',
                    'class' => 'form-control mceEditor',
                    'id' => 'video-description',
                    'rows'  => 3,
                    'style' => "width: 100%;"
                ));
                ?>
            </div>
            <div class="row">
            <div class="col-md-7">
                <div class="form-group">
                    <label><?php echo elgg_echo("tags");?></label>
                    <?php echo elgg_view("tricky_topic/tags/view", array('tags' => $group_tags, 'width' => '45%')); ?>
                    <div>
                        <select name="tags[]" data-placeholder="<?php echo elgg_echo('click_add');?>" style="width:100%;" multiple class="chosen-select" tabindex="8">
                            <option value=""></option>
                            <?php
                            foreach($tt_tags as $tag_id):
                                $tag = array_pop(ClipitTag::get_by_id(array($tag_id)));
                                ?>
                                <option <?php echo in_array($tag_id, $tags) ? "selected" : "";?> value="<?php echo $tag->id;?>"><?php echo $tag->name;?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="title"><?php echo elgg_echo("labels");?></label>
                    <ul id="labels"></ul>
                </div>
            </div>
            <div class="col-md-5">
                <label><?php echo elgg_echo("performance_items");?></label>
                <div>
                    <select name="performance_items[]" data-placeholder="<?php echo elgg_echo('click_add');?>" style="width:100%;" multiple class="chosen-select-items" tabindex="8">
                        <option value=""></option>
                        <?php foreach(ClipitPerformanceItem::get_from_category(null, $user_language) as $category => $items):?>
                            <optgroup label="<?php echo $category; ?>">
                                <?php foreach($items as $item): ?>
                                    <option <?php echo in_array($item->id, $performance_items) ? "selected" : "";?> value="<?php echo $item->id; ?>">
                                        <?php echo $item->item_name[$language_index]; ?>
                                    </option>
                                <?php endforeach; ?>
                            </optgroup>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>