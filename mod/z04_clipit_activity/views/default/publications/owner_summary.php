<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   19/05/14
 * Last update:     19/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$entity = elgg_extract("entity", $vars);
$msg = elgg_extract("msg", $vars);
$entity_class = elgg_extract("entity_class", $vars);
$publish_level = $entity_class::get_publish_level($entity->id);

switch($publish_level){
    case "group":
        $output = $msg." ";
        $user = array_pop(ClipitUser::get_by_id(array($entity->owner_id)));
        $output .= elgg_view('output/url', array(
            'href'  => "profile/".$user->login,
            'title' => $user->name,
            'text'  => $user->name));
        break;
    case "site":
        $activity_id = $entity_class::get_activity($entity->id);
        $activity = array_pop(ClipitActivity::get_by_id(array($activity_id)));
        $output = '<a class="btn btn-primary btn-xs '.$vars['class'].'">'.$activity->name.'</a>';
        break;
    case "task":
    case "activity":
        $group_id = $entity_class::get_group($entity->id);
        $group = array_pop(ClipitGroup::get_by_id(array($group_id)));
        $output = '<span class="label label-blue '.$vars['class'].'"><i class="fa fa-users"></i> '.$group->name.'</span>';
        break;
}

echo $output;