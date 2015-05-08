<?php
$quiz = get_entity(get_input('id_quiz'));

//Título de la página
$title = $quiz->name;
elgg_push_breadcrumb($title);

$params = array(
    'content'   => elgg_view_form("quizzes/edit"),
    'filter'    => '',
    'title'     => $title,
);
$body = elgg_view_layout('content', $params);
echo elgg_view_page($params['title'], $body);
?>
