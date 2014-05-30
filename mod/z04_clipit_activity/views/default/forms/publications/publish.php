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
<div class="bg-warning">Cuidadin.... bla bla bla</div>

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
<link rel="stylesheet" href="http://harvesthq.github.io/chosen/chosen.css">
<script src="http://harvesthq.github.io/chosen/chosen.jquery.js"></script>
<script>
$(function(){
    $(".chosen-select").chosen({disable_search_threshold: 10});
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
            <label for="title"><?php echo elgg_echo("tags");?></label>
            <div>
                <select data-placeholder="Your Favorite Types of Bear" style="width:350px;" multiple class="chosen-select" tabindex="8">
                    <option value=""></option>
                    <?php
                    foreach($tt_tags as $tag_id):
                        $tag = array_pop(ClipitTag::get_by_id(array($tag_id)));
                    ?>
                        <option><?php echo $tag->name;?></option>
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

    <div class="col-md-4">
        <img src="<?php echo $entity->preview;?>" class="img-responsive"><br>
        <h5 class="blue"><strong><?php echo elgg_echo('performance_item:select'); ?></strong></h5>
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