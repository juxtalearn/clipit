<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   26/01/2015
 * Last update:     26/01/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$entity = elgg_extract('entity', $vars);
$scope_entity = elgg_extract('scope_entity', $vars);
$parent_id = elgg_extract('parent_id', $vars);

$labels_value = array();
if($scope_entity){
    $hasToken = get_config("google_refresh_token");
    $object = ClipitSite::lookup($scope_entity->id);
    switch($object['subtype']){
        case "ClipitGroup":
            $group_tags = ClipitGroup::get_tags($scope_entity->id);
            $activity = array_pop(ClipitActivity::get_by_id(array($scope_entity->activity)));
            $tt = array_pop(ClipitTrickyTopic::get_by_id(array($activity->tricky_topic)));
            $tt_tags = $tt->tag_array;
            $tt_tags = array_diff($tt_tags, $group_tags);
            break;
        case "ClipitActivity":
            $tt = array_pop(ClipitTrickyTopic::get_by_id(array($scope_entity->tricky_topic)));
            $tt_tags = $tt->tag_array;
            break;
    }
    $tags = array();
    echo elgg_view("input/hidden", array(
        'name' => 'scope-id',
        'value' => $scope_entity->id,
    ));
} elseif($entity){
    $activity = array_pop(ClipitActivity::get_by_id(array(ClipitVideo::get_activity($entity->id))));
    $tt = array_pop(ClipitTrickyTopic::get_by_id(array($activity->tricky_topic)));
    $tt_tags = $tt->tag_array;
    $group_tags = array();
    if($group_id = ClipitVideo::get_group($entity->id) && !$vars['publish']) {
        $group_tags = ClipitGroup::get_tags($group_id);
        $tt_tags = array_diff($tt_tags, $group_tags);
    }
    $tags = $entity->tag_array;
    $performance_items = $entity->performance_item_array;
    foreach(ClipitLabel::get_by_id($entity->label_array) as $label){
        $labels_value[] = $label->name;
    }
    echo elgg_view("input/hidden", array(
        'name' => 'entity-id',
        'value' => $entity->id,
    ));
    if($parent_id) {
        echo elgg_view("input/hidden", array(
            'name' => 'parent-id',
            'value' => $parent_id,
        ));
        echo elgg_view("input/hidden", array(
            'name' => 'task-id',
            'value' => $vars['task'],
        ));
    }
}

echo elgg_view("input/hidden", array(
    'name' => 'tags',
));
echo elgg_view("input/hidden", array(
    'name' => 'labels',
    'id' => 'input_labels',
    'value' => implode(",", $labels_value)
));
$user_language = get_current_language();
$language_index = ClipitPerformanceItem::get_language_index($user_language);
?>
    <script>
        $(function(){
            // Load tinyMCE in textarea
            clipit.tinymce();
            $(".chosen-select").chosen({disable_search_threshold: 1});
            $(".chosen-select-items").chosen();

            $('form').on('click', 'input[type=submit]', function(evt) {
                if($(this.form).find(":file").val() != '' && $(this.form).find(":file").length > 0) {
                    $("#uploading").prependTo($(this).closest(".modal-content")).show();
                    $("body").css({"cursor": "progress"});
                }
            });
            $('ul#labels').each(function(){
                that = $(this);
                $(this).tagit({
                    allowSpaces: true,
                    removeConfirmation: true,
                    onTagExists: function(event, ui){
                        $(ui.existingTag).fadeIn("slow", function() {
                            $(this).addClass("selected");
                        }).fadeOut("slow", function() {
                            $(this).removeClass("selected");
                        });
                    },
                    autocomplete: {
                        delay: 0,
                        source: elgg.config.wwwroot+"ajax/view/publications/labels/search"
                    },
                    placeholderText: "<?php echo elgg_echo("tags:commas:separated");?>",
                    singleField: true,
                    singleFieldNode: that.closest("form").find("input[name=labels]")
                });
            });
        });
    </script>
    <style>
        .chosen-container{
            width: 100% !important;
        }
    </style>
<?php if($scope_entity):?>
    <!-- Video add -->
    <div id="uploading" style="display: none;position: absolute;  left: 0;  top: 0;  right: 0;  bottom: 0;  z-index: 999;background: rgba(255,255,255,0.8);">
        <div style="height: 100%;" class="wrapper separator loading-block">
            <div>
                <i class="fa fa-spinner fa-spin blue"></i>
                <h3 class="blue"><?php echo elgg_echo('video:uploading:youtube');?>...</h3>
            </div>
        </div>
    </div>
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
                        <label for="url"><?php echo elgg_echo("video:url");?></label>
                        <div class="icon">
                            <?php echo elgg_view("input/text", array(
                                'name' => 'url',
                                'id' => 'url',
                                'class' => 'form-control blue',
                            ));
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Video add end -->
<?php endif;?>
    <div class="form-group">
        <label for="title"><?php echo elgg_echo("video:title");?></label>
        <?php echo elgg_view("input/text", array(
            'name' => 'title',
            'value' => $entity->name,
            'class' => 'form-control',
            'required' => true
        ));?>
    </div>
    <div class="form-group">
        <label for="description"><?php echo elgg_echo("video:description");?></label>
        <?php echo elgg_view("input/plaintext", array(
            'name'  => 'description',
            'value' => $entity->description,
            'id'    => 'edit-'.$entity->id,
            'class' => 'form-control mceEditor',
            'rows'  => 6,
        ));?>
    </div>

    <div class="row">
        <div class="col-md-<?php echo get_config('fixed_performance_rating')?'12':'7'?>">
            <?php if(!empty($tt_tags)):?>
                <div class="form-group">
                    <label><?php echo elgg_echo("tags");?></label>
                    <?php if($group_tags):?>
                        <?php echo elgg_view("tricky_topic/tags/view", array('tags' => $group_tags, 'width' => '45%')); ?>
                    <?php endif;?>
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
            <?php endif;?>
            <div class="form-group">
                <label for="labels"><?php echo elgg_echo("labels");?></label>
                <ul id="labels"></ul>
            </div>
        </div>
        <?php if(!get_config('fixed_performance_rating')):?>
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
        <?php endif;?>
    </div>
<?php if($vars['publish']):?>
    <div class="margin-bottom-10 margin-top-5">
        <label><?php echo elgg_echo('send:to_global');?></label>
        <label style="font-weight: normal;" class="inline-block margin-right-10">
            <input name="remote" value="1" type="radio" checked> <?php echo elgg_echo('option:yes');?>
        </label>
        <label style="font-weight: normal;" class="inline-block">
            <input name="remote" value="0" type="radio"> <?php echo elgg_echo('option:no');?>
        </label>
    </div>
<?php endif;?>