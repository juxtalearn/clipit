<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   28/05/14
 * Last update:     28/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$entity = elgg_extract('entity', $vars);
$parent_id = elgg_extract('parent_id', $vars);
$tt_tags = elgg_extract('tags', $vars);

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
<script src="http://harvesthq.github.io/chosen/chosen.jquery.js"></script>
<script>
$(function(){
    $(".chosen-select").chosen({disable_search_threshold: 1});
    $(".chosen-select-items").chosen({max_selected_options: 5}).on("chosen:maxselected", function () {
        alert("max");
    });
});
</script>
<!--<div class="bg-warning">-->
<!--    Select task:-->
<!--    <input type="radio" > Upload video-->
<!--</div>-->
<div class="row">
    <div class="col-md-8">
        <div class="form-group">
            <label for="title"><?php echo elgg_echo("url");?></label>
            <a href="<?php echo $entity->url;?>" target="_blank"><?php echo $entity->url;?></a>
            <hr style="margin: 10px 0;">
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
            <div>
                <select name="tags[]" data-placeholder="Select tags" style="width:100%;" multiple class="chosen-select" tabindex="8">
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
<style>

</style>
    <div class="col-md-4">
        <img src="<?php echo $entity->preview;?>" class="img-responsive"><br>
        <label><?php echo elgg_echo("performance_items");?></label>
        <div>
            <select name="performance_items[]" data-placeholder="<?php echo elgg_echo('performance_item:select'); ?>" style="width:100%;" multiple class="chosen-select-items" tabindex="8">
                <option value=""></option>
                <?php foreach(ClipitPerformanceItem::get_by_category() as $category => $items): ?>
                <optgroup label="<?php echo $category; ?>">
                    <?php foreach($items as $item): ?>
                        <option <?php echo in_array($item->id, $performance_items) ? "selected" : "";?> value="<?php echo $item->id; ?>"><?php echo $item->name; ?></option>
                    <?php endforeach; ?>
                </optgroup>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
</div>
<p class="text-center">
    <?php echo elgg_view('input/submit', array('value' => elgg_echo('publish'), 'class' => 'elgg-button btn btn-primary'));?>
</p>