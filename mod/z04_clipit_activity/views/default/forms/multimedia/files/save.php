<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   09/07/2015
 * Last update:     09/07/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$entity = elgg_extract('entity', $vars);
$scope_entity = elgg_extract('scope_entity', $vars);
$parent_id = elgg_extract('parent_id', $vars);
if($entity){
    $activity = array_pop(ClipitActivity::get_by_id(array(ClipitFile::get_activity($entity->id))));
    $tt = array_pop(ClipitTrickyTopic::get_by_id(array($activity->tricky_topic)));
    $tt_tags = $tt->tag_array;
    $group_tags = array();
    if(($group_id = ClipitFile::get_group($entity->id)) && !$vars['publish']) {
        $group_tags = ClipitGroup::get_tags($group_id);
        $tt_tags = array_diff($tt_tags, $group_tags);
    }

    $tags = $entity->tag_array;
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
?>
<script>
    // Load tinyMCE in textarea
    clipit.tinymce();
    $(".chosen-select").chosen({disable_search_threshold: 1});
    $('ul#labels').each(clipit.labelList);
</script>
<div>
    <?php echo elgg_view('multimedia/file/view_summary', array('file' => $entity));?>
</div>
<div class="form-group">
    <label for="file-name"><?php echo elgg_echo("name");?></label>
    <?php echo elgg_view("input/text", array(
        'name' => 'file-name',
        'value' => $entity->name,
        'class' => 'form-control',
        'required' => true
    ));?>
</div>
<div class="form-group">
    <label for="file-text"><?php echo elgg_echo("multimedia:file:description");?></label>
    <?php echo elgg_view("input/plaintext", array(
        'name'  => 'file-text',
        'value' => $entity->description,
        'id'    => 'edit-'.$entity->id,
        'class' => 'form-control mceEditor',
        'rows'  => 6,
    ));?>
</div>
<div class="row">
    <div class="col-md-12">
        <?php if(!empty($tt_tags)):?>
            <div class="form-group">
                <label><?php echo elgg_echo("tags");?></label>
                <?php if($group_tags):?>
                    <?php echo elgg_view("tricky_topic/tags/view", array('tags' => $group_tags, 'width' => '45%')); ?>
                    <?php foreach($group_tags as $group_tag):?>
                        <?php echo elgg_view("input/hidden", array(
                            'name' => 'tags[]',
                            'value' => $group_tag
                        ));
                        ?>
                    <?php endforeach;?>
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
</div>