<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   21/05/14
 * Last update:     21/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$entity = elgg_extract('entity', $vars);
$user = array_pop(ClipitUser::get_by_id(array($entity->owner_id)));

$tag_ratings = $entity->tag_rating_array;
$performance_ratings = $entity->performance_rating_array;
$overall_rating = elgg_echo("input:no");
if($entity->overall){
    $overall_rating = elgg_echo("input:yes");
}
?>
<div class="row">
    <div class="col-md-8">
        <label for="tricky-understand">
            <?php echo elgg_echo('publications:question:tricky_topic',array(''));?>
        </label>
        <p class="show blue">
            <strong><?php echo $overall_rating;?></strong>
        </p>
        <?php
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
                    <span class="blue">
                        <?php echo $is_used;?>
                    </span>
                    <?php echo $tag->name;?>
                </label>
                <div><?php echo $tag_rating->description;?></div>
            </div>
        <?php endforeach;?>
    </div>
    <div class="col-md-4">
        <div>
            <h4>
                <strong><?php echo elgg_echo('publications:rating');?></strong>
            </h4>
            <ul class="margin-top-10">
                <?php
                foreach($performance_ratings as $performance_rating_id):
                    $performance_rating = array_pop(ClipitPerformanceRating::get_by_id(array($performance_rating_id)));
                    $performance_item = array_pop(ClipitPerformanceItem::get_by_id(array($performance_rating->performance_item)));
                ?>
                    <li class="list-item-5">
                        <div class="rating readonly pull-right" data-score="<?php echo $performance_rating->star_rating;?>" style="margin: 0 10px;">
                        <?php echo star_rating_view($performance_rating->star_rating);?>
                        </div>
                        <span class="blue" style="padding-top: 2px;"><?php echo $performance_item->name;?></span>
                    </li>
                <?php endforeach;?>
            </ul>
        </div>
    </div>
</div>
