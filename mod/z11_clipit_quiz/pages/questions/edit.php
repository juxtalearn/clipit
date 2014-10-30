<?php

$quest = get_entity(get_input('id_quest'));

// Título de la página
$title = $quest->name;

$params = array(
    'content'   => elgg_view_form("questions/edit"),
    'filter'    => '',
    'title'     => $title,
);

$body = elgg_view_layout('content', $params);
echo elgg_view_page($params['title'], $body);

?>
