<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   19/05/14
 * Last update:     19/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$entity = elgg_extract("entity", $vars);
$msg = elgg_extract("msg", $vars);
$object = ClipitSite::lookup($entity->id);
$entity_class = $object['subtype'];
$publish_level = $entity_class::get_scope($entity->id);

$user = array_pop(ClipitUser::get_by_id(array($entity->owner_id)));
switch($publish_level){
    case "group":
    case "activity":
        $output = $msg." ";
        $output .= elgg_view('page/elements/user_summary', array('user' => $user));
        break;
    case "site":
        $activity_id = $entity_class::get_activity($entity->id);
        $activity = array_pop(ClipitActivity::get_by_id(array($activity_id)));
        $output = '<a class="btn btn-primary btn-xs '.$vars['class'].'">'.$activity->name.'</a>';
        break;
    case "task":
        $output = $msg ." ". elgg_view('page/elements/user_summary', array('user' => $user));
        if($user->role == ClipitUser::ROLE_STUDENT) {
            $group_id = $entity_class::get_group($entity->id);
            $group = array_pop(ClipitGroup::get_by_id(array($group_id)));
            $output = elgg_view("group/preview", array('entity' => $group, 'class' => $vars['class']));
        }
        break;
    default:
        $output = $msg." ";
        $output .= elgg_view('page/elements/user_summary', array('user' => $user));
        break;
}


echo $output;