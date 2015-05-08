<?php

// Obtengo la pregunta
$quest = get_entity(get_input('id_quest'));

// El título de la página es el nombre de la pregunta
$title = $quest->name;
$breadcrumb = "Editar ".$title;
elgg_push_breadcrumb($breadcrumb);   //Inlcuir migas de pan

$params = array(
    'content'   => elgg_view_form("questions/edit"),
    'filter'    => '',
    'title'     => $title,
);

$body = elgg_view_layout('content', $params);
echo elgg_view_page($params['title'], $body);

?>
