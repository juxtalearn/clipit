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

$performance_ratings = $entity->performance_rating_array;
foreach($performance_ratings as $performance_rating_id){
    $performance_rating = array_pop(ClipitPerformanceRating::get_by_id(array($performance_rating_id)));
    $performance_item = array_pop(ClipitPerformanceItem::get_by_id(array($performance_rating->performance_item)));
    $performance_view .= '
    <li class="list-item" style="margin: 10px 0;">
        <div class="rating readonly" data-score="'.$performance_rating->star_rating.'" style="color: #e7d333;float: right;font-size: 18px;margin: 0 10px;">
        '.star_rating_view($performance_rating->star_rating).'
        </div>
        <span class="blue" style="padding-top: 2px;">'.$performance_item->name.'</span>
    </li>';
}
$tag_ratings = $entity->tag_rating_array;
foreach($tag_ratings as $tag_rating_id){
    $tag_rating = array_pop(ClipitTagRating::get_by_id(array($tag_rating_id)));
    $tag = array_pop(ClipitTag::get_by_id(array($tag_rating->tag_id)));
    $is_used = "<i class='fa fa-times red'></i>";
    if($tag_rating->is_used){
        $is_used = "<i class='fa fa-check green'></i>";
    }
    $tags_view .= '
    <div style="margin-top: 5px;">
        <label class="text-truncate"><span class="blue">'.$is_used.'</span> '.$tag->name.'</label>
        <div>'.$tag_rating->description.'</div>
    </div>';
}
$overall_rating = elgg_echo("input:no");
if($entity->overall_rating){
    $overall_rating = elgg_echo("input:yes");
}
?>
<div class="row">
    <div class="col-md-8">
        <label for="tricky-understand">
            Does this video help you to understand Tricky Topic?
        </label>
        <p class="show blue"><strong><?php echo $overall_rating;?></strong></p>
        <?php echo $tags_view;?>
    </div>
    <div class="col-md-4">
        <div>
            <h4>
                <strong>Rating</strong>
            </h4>
            <ul><?php echo $performance_view;?> </ul>
        </div>
    </div>
</div>
