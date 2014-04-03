<?php
/**
 * Created by JetBrains PhpStorm.
 * User: equipo
 * Date: 25/02/14
 * Time: 13:20
 * To change this template use File | Settings | File Templates.
 */
$group = elgg_extract('entity', $vars);
$text = elgg_echo("group:leave");
if($vars['text']){
    $text = $vars['text'];
}
echo elgg_view("input/hidden", array(
    'name' => 'group-id',
    'value' => $group->id,
));

// Leave button
echo elgg_view("input/button", array(
    'class' => 'leave-group btn btn-sm btn-danger btn-sp',
    'value' => $text,
    'type'  => 'submit',
));