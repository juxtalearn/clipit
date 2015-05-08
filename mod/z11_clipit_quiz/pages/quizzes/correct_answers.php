<?php
// asegurarse de que sólo los usuarios registrados pueden ver esta página
gatekeeper();

$id_quiz = get_input('id_quiz');
$id_user = get_input('u');

$title = "Corregir respuesta";
elgg_push_breadcrumb($title); //Migas de pan

$content = elgg_view_form("quizzes/correct_answers", array('id_quiz' => $id_quiz, 'u' => $id_user));

$body = elgg_view_layout('content', array(
    'filter' =>'',
    'content' => $content,
    'title' => $title,
));

echo elgg_view_page($title, $body);
?>