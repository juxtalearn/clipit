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
$activity = elgg_extract('activity', $vars);
$tt_tags = elgg_extract('tags', $vars);

$tags = $entity->tag_array;
$tag_value = array();
foreach($tags as $tag_id){
    $tag = array_pop(ClipitTag::get_by_id(array($tag_id)));
    $tag_value[] = $tag->name;
}
$tags_value = implode(", ", $tag_value);
?>

<?php echo elgg_view("input/hidden", array(
    'name' => 'entity-id',
    'value' => $entity->id,
)); ?>
<?php echo elgg_view("input/hidden", array(
    'name' => 'parent-id',
    'value' => $parent->id,
)); ?>

<?php echo elgg_view("input/hidden", array(
    'name' => 'tags',
    'id' => 'input_tags',
    'value' => $tags_value
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
                <select data-placeholder="Select tags" style="width:100%;" multiple class="chosen-select" tabindex="8">
                    <option value=""></option>
                    <?php
                    foreach($tt_tags as $tag_id):
                        $tag = array_pop(ClipitTag::get_by_id(array($tag_id)));
                    ?>
                        <option value="<?php echo $tag->id;?>"><?php echo $tag->name;?></option>
                    <?php endforeach;?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="title"><?php echo elgg_echo("labels");?></label>
            <ul id="tags"></ul>
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
.chosen-select-items + .chosen-container .chosen-choices li{
    float: none;
    font-weight: normal;
    border: 0;
    border-bottom: 1px solid #bae6f6;
    border-radius: 0;
}
.chosen-select-items + .chosen-container .chosen-choices li input{
    cursor: default;
}
.chosen-select-items + .chosen-container .chosen-choices li:last-child{
    border: 0;
}
.chosen-select-items + .chosen-container .chosen-results li.group-option{
    font-weight: normal;
}
</style>
    <div class="col-md-4">
        <img src="<?php echo $entity->preview;?>" class="img-responsive"><br>
        <label><?php echo elgg_echo("performance_items");?></label>
        <div>
            <select data-placeholder="<?php echo elgg_echo('performance_item:select'); ?>" style="width:100%;" multiple class="chosen-select-items" tabindex="8">
                <option value=""></option>
                <optgroup label="Format">
                    <option value="20">Stop motion</option>
                    <option>Tutorial</option>
                    <option>Video diary</option>
                </optgroup>
                <optgroup label="Genre">
                    <option>Stop motion <i class="fa fa-question"></i></option>
                    <option>Tutorial</option>
                    <option>Video diary</option>
                </optgroup>
                <optgroup label="Story">
                    <option>Stop motion</option>
                    <option>Tutorial</option>
                    <option>Video diary</option>
                </optgroup>
            </select>
            <ul>
                <li class="list-item">item</li>
                <li class="list-item">item</li>
                <li class="list-item">item</li>
            </ul>
        </div>
        <div class="multiple-check form-control">
            <a href="javascript:;"><h4>- Learning</h4></a>
            <div class="check-group">
            <?php foreach(ClipitPerformanceItem::get_all() as $performance_item): ?>
                <label for="pi_<?php echo $performance_item->id;?>">
                    <input type="checkbox" name="performance_items[]" value="<?php echo $performance_item->id;?>" id="pi_<?php echo $performance_item->id;?>">
                    <span><?php echo $performance_item->name;?></span>
                </label>
            <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<p class="text-center">
    <?php echo elgg_view('input/submit', array('value' => elgg_echo('publish'), 'class' => 'elgg-button btn btn-primary'));?>
</p>