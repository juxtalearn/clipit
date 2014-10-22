<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   22/04/14
 * Last update:     22/04/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$entity = elgg_extract('entity', $vars);
$hasToken = get_config("google_refresh_token");
$group_id = $entity->id;
$activity = array_pop(ClipitActivity::get_by_id(array($entity->activity)));
$group_tags = ClipitGroup::get_tags($group_id);
$tt = array_pop(ClipitTrickyTopic::get_by_id(array($activity->tricky_topic)));
$tt_tags = $tt->tag_array;
$tt_tags = array_diff($tt_tags, $group_tags);
//load jQuery Chosen
elgg_load_js("jquery:chosen");
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
//    $(".chosen-select-items").chosen({max_selected_options: 5}).on("chosen:maxselected", function () {
//        alert("max");
//    });
        $(".chosen-select-items").chosen();
    });
</script>
<style>
    .chosen-container{
        width: 100% !important;
    }
</style>
<div class="row">
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
    </div>
</div>