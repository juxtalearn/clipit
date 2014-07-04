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
$object = ClipitSite::lookup($entity->id);
$entity_class = $object['subtype'];
$publish_level = $entity_class::get_resource_scope($entity->id);

switch($publish_level){
    case "group":
    case "activity":
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
        $group_id = $entity_class::get_group($entity->id);
        $group = array_pop(ClipitGroup::get_by_id(array($group_id)));
        $output = elgg_view("page/components/modal_remote", array('id'=> "group-{$group->id}" ));
        $output .= elgg_view('output/url', array(
            'href'  => "ajax/view/modal/group/view?id={$group->id}",
            'text'  => '<i class="fa fa-users"></i> '.$group->name,
            'title' => $group->name,
            'class' => 'label label-blue '.$vars['class'],
            'data-toggle'   => 'modal',
            'data-target'   => '#group-'.$group->id
        ));
        break;
}

echo $output;