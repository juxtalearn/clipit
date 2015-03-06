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
if($vars['user_rating']){
    $rating_average = ClipitPerformanceRating::get_average_user_rating_for_target($entity->owner_id, $entity->target);
} else {
    //$rating_average = ClipitPerformanceRating::get_average_target_rating($entity->id);
    $rating_average = $entity->performance_rating_average;
}

$class = 'rating';
if($vars['class']){
    $class = $class . " " .$vars['class'];
}
if($vars['show_check'] ) {
    //$me_rating = ClipitRating::get_from_user_for_target(elgg_get_logged_in_user_guid(), $entity->id);
    echo elgg_view("page/components/modal_remote", array('id'=> "rating-average-{$me_rating->id}" ));
}

?>
<div class="<?php echo $class;?> readonly" data-score="<?php echo $rating_average;?>">
    <?php echo star_rating_view($rating_average);?>
    <?php if($me_rating):?>
        <div class="text-right">
            <?php echo elgg_view('output/url', array(
                    'href'  => "ajax/view/modal/publications/rating?id={$me_rating->id}",
                    'text'  => '<i class="fa fa-check btn btn-xs btn-primary"></i>',
                    'title' => elgg_echo('publications:rating:my_evaluation'),
                    'data-toggle'   => 'modal',
                    'data-target'   => '#rating-average-'.$me_rating->id
                ));
            ?>
        </div>
    <?php endif;?>
</div>