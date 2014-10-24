<?php
$quest = get_entity(get_input('id_quest')); //*****
$id_quest = get_input("id_quest");

$title = $quest->name;

$params = array(
    'content'   => elgg_view("questions/view", array('entity' => $quest, 'id' => id_quest)),
    'filter'    => '',
    'title'     => $title,
);
$body = elgg_view_layout('content', $params);
echo elgg_view_page($params['title'], $body);
?>
