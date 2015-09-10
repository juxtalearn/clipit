<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   4/06/14
 * Last update:     4/06/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$group = elgg_extract('entity', $vars);
$activity_id = ClipitGroup::get_activity($group->id);
$activity = array_pop(ClipitActivity::get_by_id(array($activity_id)));
?>
<div class="row">
    <div class="col-md-12">
        <div>
            <h3><?php echo elgg_echo("group:progress"); ?></h3>
            <?php
            echo elgg_view("page/components/progressbar", array(
                'value' => get_group_progress($group->id),
                'width' => '100%',
            ));
            ?>
        </div>
        <div class="row margin-top-10">
            <div class="col-md-6">
                <small class="show" style="margin: 5px 0"><?php echo elgg_echo('activity:pending_tasks');?></small>
                <?php echo elgg_view("page/components/pending_tasks", array('entity' => $activity)); ?>
            </div>
            <?php if($group->tag_array):?>
            <div class="tags-list col-md-6">
                <small><?php echo elgg_echo('tags');?></small>
                <?php echo elgg_view("tricky_topic/tags/view", array('tags' => $group->tag_array, 'limit' => 4, 'width' => '22%')); ?>
            </div>
            <?php endif;?>
        </div>
    </div>
</div>
<div class="row">
    <?php
    $users_id = ClipitGroup::get_users($group->id);
    ?>
    <div class="col-md-4">
        <?php echo elgg_view("page/components/title_block", array('title' => elgg_echo("group:members"))); ?>
        <ul class="scroll-list-400">
        <?php
        foreach($users_id as $user_id):
            $user = array_pop(ClipitUser::get_by_id(array($user_id)));
        ?>
            <li class="list-item">
                <?php echo elgg_view("page/elements/user_block", array("entity" => $user)); ?>
            </li>
        <?php endforeach; ?>
        </ul>
    </div>
    <div class="col-md-8">
        <?php echo elgg_view("page/components/title_block", array('title' => elgg_echo("group:timeline"))); ?>
        <ul class="events">
            <?php
                $limit = 5;
                $events_log = ClipitEvent::get_by_object(array($group->id), 0, $limit);
                foreach($events_log as $event_log):
            ?>
                <?php echo view_recommended_event($event_log, 'simple'); ?>
            <?php endforeach; ?>
        </ul>
        <div>
            <?php echo elgg_view('output/url', array(
                'href'  => 'ajax/view/navigation/pagination_timeline?view=simple&type=group&id='.$group->id.'&offset='.$limit,
                'text'  => 'More',
                'class' => 'events-more-link'
                ));
            ?>
        </div>
    </div>
</div>