<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   23/05/14
 * Last update:     23/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$entities = elgg_extract('entity', $vars);
?>
<div class="panel-group" id="accordion">
    <?php
    foreach($entities as $entity):
        $user = array_pop(ClipitUser::get_by_id(array($entity->owner_id)));
        $user_elgg = new ElggUser($user->id);
        $performance_average = ClipitPerformanceRating::get_average_user_rating_for_target($entity->owner_id, $entity->target);
    ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <a href="#collapse_<?php echo $entity->id;?>" data-toggle="collapse" data-parent="#accordion" class="child-decoration-none">
                    <div class="image-block">
                        <img src="<?php echo $user_elgg->getIconURL("small");?>">
                    </div>
                    <div class="content-block">
                        <small class="pull-right"><?php echo elgg_view('output/friendlytime', array('time' => $entity->time_created));?></small>
                        <span class="blue"><?php echo $user->name;?></span>
                        <div class="rating readonly"><?php echo star_rating_view($performance_average);?></div>
                    </div>
                </a>
            </div>
            <div id="collapse_<?php echo $entity->id;?>" class="panel-collapse collapse" style="height: auto;">
              <div class="panel-body">
                <?php echo elgg_view('publications/rating_full',array('entity'  => $entity));?>
              </div>
            </div>
        </div>
    <?php endforeach;?>
</div>