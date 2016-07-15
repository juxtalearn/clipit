<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   24/07/14
 * Last update:     24/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$rating = elgg_extract('rating', $vars);
$entity = elgg_extract('entity', $vars);
$href = elgg_extract('href', $vars);

// Get invidual ratings
$rubric_ratings = ClipitRubricRating::get_by_id($rating->rubric_rating_array);
$average_rating = 0;
$rubric_items = [];
foreach($rubric_ratings as $rubric_rating) {
    $rubric_item = array_pop(ClipitRubricItem::get_by_id(array($rubric_rating->rubric_item)));
    $rubric_items[$rubric_rating->rubric_item] = array(
      'name' => $rubric_item->name,
      'score' => round($rubric_rating->score*10, 1)
    );
    $average_rating += $rubric_rating->score;
}
if ($average_rating > 0) {
    $average_rating /= count($rubric_ratings);
}
?>
<style>
.user-rating-view .image-background{
    width: 100%;
    height: 70px;
    max-height: 100px;
    background-size: cover;
    background-position: 50% 30%;
}
</style>
<li class="row list-item user-rating-view">
    <div class="col-md-8">
        <small class="pull-right">
            <?php echo elgg_view('output/friendlytime', array('time' => $rating->time_created));?>
        </small>
        <label for="tricky-understand">
            <?php echo elgg_echo('publications:question:tricky_topic',array(''));?>
        </label>
        <p class="show blue">
            <strong>
                <?php
                if($rating->overall){
                    echo elgg_echo("input:yes");
                } else {
                    echo elgg_echo("input:no");
                }
                ?>
            </strong>
        </p>
        <?php
        $tag_ratings = $rating->tag_rating_array;
        foreach($tag_ratings as $tag_rating_id):
            $tag_rating = array_pop(ClipitTagRating::get_by_id(array($tag_rating_id)));
            $tag = array_pop(ClipitTag::get_by_id(array($tag_rating->tag_id)));
            $is_used = "<i class='fa fa-times red'></i>";
            if($tag_rating->is_used){
                $is_used = "<i class='fa fa-check green'></i>";
            }
            ?>
            <div style="margin-top: 5px;">
                <label class="text-truncate">
                    <span class="blue"><?php echo $is_used;?></span> <?php echo $tag->name;?>
                </label>
                <div><?php echo $tag_rating->description;?></div>
            </div>
        <?php endforeach;?>
    </div>
    <div class="col-md-4">
        <strong class="show margin-bottom-10">
            <?php echo elgg_view('output/url', array(
                'href'  => "{$href}/view/".$entity->id,
                'title' => $entity->name,
                'class' => 'text-truncate',
                'text'  => $entity->name));
            ?>
        </strong>
        <?php echo elgg_view('publications/admin/item_preview', array('entity' => $entity, 'href' => $href));?>
        <?php if($rating->rubric_rating_array):?>
        <div class="margin-top-10">
            <strong class="pull-right blue" style="font-size: 18px;line-height: 20px;"><?php echo round($average_rating*10,1);?></strong>
            <small><?php echo elgg_echo('publications:rating');?></small>
        </div>
        <div class="clearfix"></div>
        <div>
            <hr class="margin-bottom-5 margin-top-5">
            <div>
                <ul class="margin-top-10">
                    <?php foreach($rubric_items as $rubric_item): ?>
                        <li class="list-item-5 text-muted">
                            <strong class="pull-right"><?php echo $rubric_item['score'];?></strong>
                            <?php echo $rubric_item['name'];?>
                        </li>
                    <?php endforeach;?>
                </ul>
            </div>
        </div>
        <?php endif;?>
    </div>
</li>