<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   23/07/14
 * Last update:     23/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */

$user_id = elgg_get_logged_in_user_guid();
$limit = 3;

//DEBUG
$activities = ClipitUser::get_activities($user_id);
$groups = ClipitUser::get_groups($user_id);
$tasks = array();
foreach($activities as $activity_id){
    $tasks = array_merge($tasks, ClipitActivity::get_tasks($activity_id));
}
$object_array = array_merge($groups, $activities, $tasks);

$recommended_events = ClipitEvent::get_by_object($object_array, 0, $limit);

$recommended_events = ClipitEvent::get_recommended_events($user_id, 0, $limit);
?>
<div class="margin-bar"></div>
<ul class="events">
    <?php foreach ($recommended_events as $event_log):?>
        <?php echo view_recommended_event($event_log);?>
    <?php endforeach;?>
</ul>
<div style="position: relative; z-index: 100; margin-left: 35px;">
    <?php echo elgg_view('output/url', array(
        'href'  => 'ajax/view/navigation/pagination_timeline?view=full&type=user&offset='.$limit,
        'text'  => elgg_echo('view_more'),
        'class' => 'events-more-link'
    ));
    ?>
</div>