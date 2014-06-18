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
?>
<div class="row">
    <div class="col-md-12">
        <h3><?php echo elgg_echo("group:progress"); ?></h3>
        <?php
        echo elgg_view("page/components/progressbar", array(
            'value' => get_group_progress($group->id),
            'width' => '100%',
        ));
        ?>
        <?php echo elgg_view("page/components/next_deadline", array('entity' => $group)); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <?php echo elgg_view("page/components/title_block", array('title' => elgg_echo("group:members"))); ?>
        <ul>
        <?php
        $users_id = ClipitGroup::get_users($group->id);
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