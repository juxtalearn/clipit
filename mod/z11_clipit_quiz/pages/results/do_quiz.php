<?php
// asegurarse de que sólo los usuarios registrados pueden ver esta página
gatekeeper();

$id_quiz = get_input('id_quiz');
$quiz = array_pop(ClipitQuiz::get_by_id(array($id_quiz)));

$option = get_input('option');
$title = $quiz->name;
// agregar el formulario correspondiente
if ($option == "list"){
    $content = elgg_view_form("results/list", array('entity' => $quiz, 'id_quiz' => $id_quiz));
} else {
    $content = elgg_view_form("results/paged", array('entity' => $quiz, 'id_quiz' => $id_quiz));
}

elgg_push_breadcrumb($title); //Migas de pan

// diseño de la página
$body = elgg_view_layout('content', array(
    'filter' =>'',
    'content' => $content,
    'title' => $title,
));

// dibujar la página
echo elgg_view_page($title, $body);

?>