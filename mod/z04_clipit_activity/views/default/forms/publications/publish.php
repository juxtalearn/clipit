<?php
/**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   28/05/14
 * Last update:     28/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$entity = elgg_extract('entity', $vars);
$parent_id = elgg_extract('parent_id', $vars);
$tt_tags = elgg_extract('tags', $vars);
$group_id = $entity::get_group($entity->id);
$group_tags = ClipitGroup::get_tags($group_id);
$tt_tags = array_diff($tt_tags, $group_tags);

$performance_items = $entity->performance_item_array;
$tags = $entity->tag_array;
$labels = $entity->label_array;
$label_value = array();
foreach($labels as $label_id){
    $label = array_pop(ClipitLabel::get_by_id(array($label_id)));
    $label_value[] = $label->name;
}
$labels_value = implode(", ", $label_value);
?>
<?php echo elgg_view("input/hidden", array(
    'name' => 'task-id',
    'value' => get_input('task_id'),
)); ?>
<?php echo elgg_view("input/hidden", array(
    'name' => 'entity-id',
    'value' => $entity->id,
)); ?>
<?php echo elgg_view("input/hidden", array(
    'name' => 'parent-id',
    'value' => $parent_id,
)); ?>

<?php echo elgg_view("input/hidden", array(
    'name' => 'labels',
    'id' => 'input_labels',
    'value' => $labels_value
));?>
<script>
    $(function(){
        $(".chosen-select").chosen({disable_search_threshold: 1});
        $(".chosen-select-items").chosen();
    });
</script>
<?php
if($task_id = get_input('task_id')):
    $task = array_pop(ClipitTask::get_by_id(array($task_id)));
    ?>
    <div class="bg-warning">
        <small><?php echo elgg_echo('activity:task');?>:</small>
        <h4 style="margin: 0">
            <?php echo elgg_view('output/url', array(
                'href'  => "clipit_activity/{$task->activity}/tasks/view/{$task->id}",
                'title' => $task->name,
                'text'  => $task->name,
            ));
            ?>
        </h4>
        <div><?php echo $task->description;?></div>
    </div>
    <?php echo elgg_view('input/submit', array('value' => elgg_echo('select'), 'class' => 'pull-right elgg-button btn btn-primary'));?>
    <label><?php echo elgg_echo('publications:review:info');?></label>
    <hr>
<?php endif; ?>

<div class="row">
    <div class="col-md-<?php echo ($vars['entity_preview'] ? 8 : 12);?>">
        <?php if($entity->url):?>
            <div class="form-group">
                <label for="title"><?php echo elgg_echo("url");?></label>
                <a href="<?php echo $entity->url;?>" target="_blank"><?php echo $entity->url;?></a>
                <hr style="margin: 10px 0;">
            </div>
        <?php endif;?>
        <div class="form-group">
            <label for="title"><?php echo elgg_echo("title");?></label>
            <?php echo elgg_view("input/text", array(
                'name' => 'title',
                'value' => $entity->name,
                'class' => 'form-control',
                'required' => true
            ));?>
        </div>
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
        <div class="form-group">
            <label for="title"><?php echo elgg_echo("labels");?></label>
            <ul id="labels"></ul>
        </div>
        <div class="form-group">
            <label for="description"><?php echo elgg_echo("description");?></label>
            <?php echo elgg_view("input/plaintext", array(
                'name'  => 'description',
                'value' => $entity->description,
                'id'    => 'publish-'.$entity->id,
                'class' => 'form-control mceEditor',
                'required' => true,
                'rows'  => 6,
            ));?>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Entity preview -->
        <?php echo $vars['entity_preview'];?>
        <!-- Entity preview end -->
        <br>
    </div>
</div>
<p class="text-right">
    <?php echo elgg_view('input/submit', array('value' => elgg_echo('select'), 'class' => 'elgg-button btn btn-primary'));?>
</p>