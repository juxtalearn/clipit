<?php

// Obtengo la pregunta
$quest = get_entity(get_input('id_quest'));

// El título de la página es el nombre de la pregunta
$title = $quest->name;

$params = array(
    'content'   => elgg_view_form("questions/edit"),
    'filter'    => '',
    'title'     => $title,
);

$body = elgg_view_layout('content', $params);
echo elgg_view_page($params['title'], $body);

?>
