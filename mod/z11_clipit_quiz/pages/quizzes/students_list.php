<?php
$id_quiz = get_input("id_quiz");

$title = "Students's answers";
elgg_push_breadcrumb($title);

$params = array(
    'content'   => elgg_view("quizzes/students_list", array('id_quiz' => $id_quiz)),
    'filter'    => '',
    'title'     => $title,
);
$body = elgg_view_layout('content', $params);
echo elgg_view_page($params['title'], $body);
?>