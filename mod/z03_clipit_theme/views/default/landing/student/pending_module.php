<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   28/05/14
 * Last update:     28/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$my_groups_ids = ClipitUser::get_groups(elgg_get_logged_in_user_guid());
foreach($my_groups_ids as $group_id){
    $activity_ids[] = ClipitGroup::get_activity($group_id);
}
$activities = ClipitActivity::get_by_id($activity_ids);
$content = elgg_view("page/components/pending_tasks_activities", array('entities' => $activities));

/*$all_link = elgg_view('output/url', array(
    'href' => "linkHref",
    'text' => elgg_echo('link:view:all'),
    'is_trusted' => true,
));*/

echo elgg_view('landing/module', array(
    'name'      => "pending",
    'title'     => elgg_echo('activity:pending_tasks'),
    'content'   => $content,
    'all_link'  => $all_link,
));