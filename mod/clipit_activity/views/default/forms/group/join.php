<?php
/**
 * Created by JetBrains PhpStorm.
 * User: equipo
 * Date: 25/02/14
 * Time: 11:23
 * To change this template use File | Settings | File Templates.
 */
$group = elgg_extract('entity', $vars);


 echo elgg_view("input/hidden", array(
    'name' => 'group-id',
    'value' => $group->id,
));

echo elgg_view("input/button", array(
    'class' => 'join-group btn btn-sm btn-default btn-sp',
    'value' => elgg_echo("group:join"),
    'type'  => 'submit',
));

