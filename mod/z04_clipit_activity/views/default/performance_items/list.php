<?php
/**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   23/05/14
 * Last update:     23/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$entity = elgg_extract('entity', $vars);
$activity_id = elgg_get_page_owner_guid();
$activity_id = elgg_extract('activity_id', $vars);
?>

    <?php
    $i = 0;
        $user = array_pop(ClipitUser::get_by_id(array($entity->owner_id)));
        $group_id = ClipitGroup::get_from_user_activity($entity->owner_id, $activity_id);
        $group = array_pop(ClipitGroup::get_by_id(array($group_id)));
        $rubric_average = ClipitRubricRating::get_average_user_rating_for_target($entity->owner_id, $entity->target);
        ?>
        <div class="panel panel-default" style="border: 0;margin-top: 10px;box-shadow: none;overflow: initial;">
            <div class="panel-heading" style="  background-color: rgb(236, 247, 252);border: 0">
                <a href="#collapse_<?php echo $entity->id;?>" data-toggle="collapse" data-parent="#accordion" class="child-decoration-none">
                    <div class="image-block">
                        <?php echo elgg_view('output/img', array(
                            'src' => get_avatar($user, 'small'),
                            'class' => 'avatar-small'
                        ));?>
                    </div>
                    <div class="content-block">
                        <div class="pull-right text-right">
                            <strong style="font-size: 20px;line-height: 20px;" class="show">
                                <?php echo $rubric_average ? floor($rubric_average * 100)/10 : '-';?>
                            </strong>
                            <small><?php echo elgg_view('output/friendlytime', array('time' => $entity->time_created));?></small>
                        </div>
                        <span class="blue"><?php echo $user->name;?></span>
                        <?php if($group):?>
                        <div>
                            <span class="label label-primary " style="background: #32b4e5;color: #fff;vertical-align: middle;display: inline-block;">
                                <?php echo $group->name;?>
                            </span>
                        </div>
                        <?php endif;?>
                    </div>
                </a>
            </div>
            <div id="collapse_<?php echo $entity->id;?>" class="panel-collapse collapse" style="height: auto;">
                <div class="panel-body">
                    <?php echo elgg_view('performance_items/full',array('entity'  => $entity));?>
                </div>
            </div>
        </div>
    <?php
    ?>
