<?php
/**
 * Created by JetBrains PhpStorm.
 * User: equipo
 * Date: 17/02/14
 * Time: 12:43
 * To change this template use File | Settings | File Templates.
 */
$activity = elgg_extract('entity', $vars);

elgg_register_menu_item('group:tools', array(
    'name' => 'group_discussion',
    'text' => elgg_echo('group:discussion'),
    'href' => "clipit_activity/".$activity->id."/group/discussion",
    'badge' => 10
));
elgg_register_menu_item('group:tools', array(
    'name' => 'group_files',
    'text' => elgg_echo('group:files'),
    'href' => "clipit_activity/".$activity->id."/group/multimedia",
));
elgg_register_menu_item('group:tools', array(
    'name' => 'group_activity_log',
    'text' => elgg_echo('group:activity_log'),
    'href' => "clipit_activity/".$activity->id."/group/activity_log",
));
elgg_register_menu_item('group:tools', array(
    'name' => 'group_progress',
    'text' => elgg_echo('group:progress'),
    'href' => "clipit_activity/".$activity->id."/group/progress",
));

$body = elgg_view_menu('group:tools', array(
    'sort-by' => 'register',
));
echo elgg_view_module('aside', elgg_echo('group:tools'), $body );