<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   9/09/14
 * Last update:     9/09/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$user_id = elgg_get_logged_in_user_guid();
$my_group = ClipitGroup::get_from_user_activity($user_id, $activity->id);
$isTeacher = ($access == 'ACCESS_TEACHER' ? true: false);

$group_id = get_input('group_id');
$group = array_pop(ClipitGroup::get_by_id(array($group_id)));
if($activity->status == 'enroll' && !$isTeacher ){
    return false;
}

$canCreate = false;
if(($my_group == $group_id && $activity->status == 'active') || $isTeacher){
    $canCreate = true;
}

if($group &&
    ((!$isTeacher && $my_group == $group_id) // I am group member
        ||
        ($isTeacher && $my_group != $group_id)) // I am a teacher from activity
){
    $access_group = true;
}

if(!$access_group){
    return false;
}

elgg_push_breadcrumb($group->name, "clipit_activity/{$activity->id}/group/{$group->id}");
// set group icon status from activity status
$activity_status = $activity->status;
$icon_status = "lock";
if($activity_status == 'enroll'){
    $icon_status = "unlock";
}
$filter = "";
$group_dir = elgg_get_plugins_path() . 'z04_clipit_activity/pages/group';
switch ($page[3]) {
    case '':
        include("{$group_dir}/dashboard.php");
        break;
    case 'repository':
        include("{$group_dir}/repository.php");
        break;
    case 'discussion':
        include("{$group_dir}/discussion.php");
        break;
    default:
        return false;
}

$params['sub-title'] = $group->name;
$params['title_style'] = "background: #". $activity->color;

if($activity_status == ClipitActivity::STATUS_ENROLL){
    $params['special_header_content'] = elgg_view_form("group/leave",
        array('class' => 'pull-right'),
        array('entity' => $group, 'text' => elgg_echo("group:leave:me")));
}

