<?php
// Asegurarse de que sólo los usuarios registrados pueden ver esta página
gatekeeper();

// Obtengo el quiz y su ID
$id_quiz = get_input('id_quiz');
$quiz = array_pop(ClipitQuiz::get_by_id(array($id_quiz)));

// Establezco el título de la página
$title = "Resultados de " . $quiz->name;
elgg_push_breadcrumb($title);

$params = array(
    'content'   => elgg_view("results/results", array('entity' => $quiz, 'id' => $id_quiz)),
    'filter'    => '',
    'title'     => $title,
);

$body = elgg_view_layout('content', $params);
echo elgg_view_page($params['title'], $body);

?>