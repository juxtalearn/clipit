<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   27/06/14
 * Last update:     27/06/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$activity = elgg_extract('entity', $vars);
$user_id = elgg_get_logged_in_user_guid();

$params = array(
    'name' => 'activity_aprofile',
    'text' => elgg_echo('activity:profile'),
    'href' => "clipit_activity/".$activity->id,
    'aria-describedby' => "activityMenu",
    'aria-label' => elgg_echo('activity:menu:start'),
);
elgg_register_menu_item('activity:menu', $params);
$params = array(
    'name' => 'activity_sta',
    'text' => elgg_echo('activity:stas'),
    'href' => "clipit_activity/".$activity->id."/resources",
    'aria-describedby' => "activityMenu",
);
elgg_register_menu_item('activity:menu', $params);
$params = array(
    'name' => 'activity_groups',
    'text' => elgg_echo('activity:groups'),
    'href' => "clipit_activity/".$activity->id."/groups",
    'aria-describedby' => "activityMenu",
);
elgg_register_menu_item('activity:menu', $params);
$params = array(
    'name' => 'activity_tasks',
    'text' => elgg_echo('activity:tasks'),
    'href' => "clipit_activity/".$activity->id."/tasks",
    'aria-describedby' => "activityMenu",
);
elgg_register_menu_item('activity:menu', $params);

$total_unread_posts = array_pop(ClipitPost::unread_by_destination(array($activity->id), $user_id, true));
$params = array(
    'name' => 'activity_discussion',
    'text' => elgg_echo('activity:discussion'),
    'href' => "clipit_activity/".$activity->id."/discussion",
    'badge' => $total_unread_posts > 0 ? $total_unread_posts : "",
    'aria-describedby' => "activityMenu",
    'aria-label' => elgg_echo('activity:menu:discussions'),
);
elgg_register_menu_item('activity:menu', $params);
$params = array(
    'name' => 'activity_publications',
    'text' => elgg_echo('activity:publications'),
    'href' => "clipit_activity/".$activity->id."/publications",
    'aria-describedby' => "activityMenu",
);
elgg_register_menu_item('activity:menu', $params);
?>
<small class="show margin-bottom-5">
    <span class="pull-right"><strong><?php echo elgg_echo('end');?>:</strong> <?php echo date("d/m/Y", $activity->end);?></span>
    <span><strong><?php echo elgg_echo('start');?>:</strong> <?php echo date("d/m/Y", $activity->start);?></span>
</small>
<?php
echo elgg_view_menu('activity:menu', array(
    'sort_by' => 'register',
));