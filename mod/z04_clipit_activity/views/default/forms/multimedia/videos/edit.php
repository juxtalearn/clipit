<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   14/05/14
 * Last update:     14/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$entity = elgg_extract('entity', $vars);
$object = ClipitSite::lookup($entity->id);
$activity = array_pop(ClipitActivity::get_by_id(array(ClipitVideo::get_activity($entity->id))));
$tt = array_pop(ClipitTrickyTopic::get_by_id(array($activity->tricky_topic)));

$tt_tags = $tt->tag_array;
$tags = $entity->tag_array;
$performance_items = $entity->performance_item_array;
foreach(ClipitLabel::get_by_id($entity->label_array) as $label){
    $labels_value[] = $label->name;
}

echo elgg_view("input/hidden", array(
    'name' => 'video-id',
    'value' => $entity->id,
));
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
//        Load tinyMCE in textarea
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
<div class="form-group">
    <label for="video-title"><?php echo elgg_echo("video:title");?></label>
    <?php echo elgg_view("input/text", array(
        'name' => 'video-title',
        'value' => $entity->name,
        'class' => 'form-control',
        'required' => true
    ));?>
</div>
<div class="form-group">
    <label for="video-description"><?php echo elgg_echo("video:description");?></label>
    <?php echo elgg_view("input/plaintext", array(
        'name'  => 'video-description',
        'value' => $entity->description,
        'id'    => 'edit-'.$entity->id,
        'class' => 'form-control mceEditor',
        'required' => true,
        'rows'  => 6,
    ));?>
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