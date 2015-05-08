<?php
// Obtengo el quiz y su ID
$quiz = get_entity(get_input('id_quiz'));
$id_quiz = get_input('id_quiz');

// EL titulo de la página es el título del quiz
$title = $quiz->name;
elgg_push_breadcrumb($title);

$params = array(
    'content'   => elgg_view("results/index_quiz", array('entity' => $quiz, 'id' => $id_quiz)),
    'filter'    => '',
    'title'     => $title,
);

$body = elgg_view_layout('content', $params);
echo elgg_view_page($params['title'], $body);

?>
