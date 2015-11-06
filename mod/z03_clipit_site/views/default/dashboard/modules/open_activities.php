<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   20/07/2015
 * Last update:     20/07/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$activities = elgg_extract('entities', $vars);
$my_activities = ClipitUser::get_activities(elgg_get_logged_in_user_guid());
?>
<div class="wrapper separator">
    <ul style="margin-bottom: 0;">
    <?php foreach($activities as $activity):
        $to_join = false;
    ?>
        <li class="list-item-5">
            <div class="image-block">
                <?php echo elgg_view('output/url', array(
                    'class' => 'activity-point',
                    'style' => 'background: #'.$activity->color,
                    'href'  => "clipit_activity/{$activity->id}",
                    'title' => $activity->name,
                    'text'  => elgg_echo('activity:number'),
                    'name'  => elgg_echo('activity:number'),
                ));
                ?>
            </div>
            <div class="content-block">
                <div class="text-truncate">
                    <div class="pull-right">
                    <?php if(in_array($activity->id, $my_activities)):?>
                        <strong class="blue-lighter"><?php echo elgg_echo('activity:joined');?></strong>
                        <?php elseif($activity->status != ClipitActivity::STATUS_ENROLL): ?>
                            <small class="activity-status status-<?php echo $activity->status;?>">
                                <strong><?php echo elgg_echo("status:".$activity->status);?></strong>
                            </small>
                        <?php elseif(count($activity->student_array) >= $activity->max_students && $activity->max_students > 0):?>
                        <strong class="blue-lighter"><?php echo elgg_echo('group:full');?></strong>
                        <?php
                        else:
                            $to_join = true;
                        ?>
                        <?php echo elgg_view('output/url', array(
                            'href'  => "clipit_activity/{$activity->id}",
                            'class'  => 'btn btn-xs btn-border-blue btn-primary',
                            'title' => $activity->name,
                            'text'  => elgg_echo('activity:join'),
                        ));
                        ?>
                    <?php endif;?>
                    </div>
                    <?php echo elgg_view('output/url', array(
                        'href'  => "clipit_activity/{$activity->id}",
                        'title' => $activity->name,
                        'text'  => $activity->name,
                    ));
                    ?>
                </div>
                <small>
                    <?php if($to_join):?>
                    <div class="pull-right margin-top-5">
                        <?php echo elgg_view('output/friendlytime', array('time' => $activity->start));?>
                    </div>
                    <?php endif;?>

                    <?php echo count($activity->student_array);?><?php echo $activity->max_students ? '/'.$activity->max_students:'';?>
                    <?php echo elgg_echo('students');?>
                </small>
            </div>
        </li>
    <?php endforeach;?>
    </ul>
</div>