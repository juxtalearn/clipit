<?php
/**
 * Created by JetBrains PhpStorm.
 * User: equipo
 * Date: 25/02/14
 * Time: 11:23
 * To change this template use File | Settings | File Templates.
 */
$group = elgg_extract('entity', $vars);
$activity = array_pop(ClipitActivity::get_by_id(array($group->activity)));

 echo elgg_view("input/hidden", array(
    'name' => 'group-id',
    'value' => $group->id,
));
$text = elgg_echo("group:join"). " ".count(ClipitGroup::get_users($group->id))."/".$activity->max_group_size;
if(count(ClipitGroup::get_users($group->id)) >= $activity->max_group_size){
    $text = elgg_echo('group:full');
}
echo elgg_view("input/button", array(
    'class' => 'join-group btn btn-sm btn-primary btn-sp',
    'value' => $text,
    'type'  => 'submit',
    'disabled' => (count(ClipitGroup::get_users($group->id)) >= $activity->max_group_size ) ? true : false,
));

