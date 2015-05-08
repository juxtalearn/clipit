<?php
// Asegurarse de que sólo los usuarios registrados pueden ver esta página
gatekeeper();

$id_quiz = get_input('id_quiz');
$quiz = array_pop(ClipitQuiz::get_by_id(array($id_quiz)));

/* 
 * Obtener el parametro 'option' pasado por la URL
 * Si option = list , se redirecciona al formulario de hacer el quiz en una sola página
 * Si option = paged, se redirecciona al formulario de hacer el quiz en varias páginas
 */
$option = get_input('option');

// Agregar el formulario correspondiente
if ($option == ClipitQuiz::VIEW_MODE_LIST){
    $content = elgg_view_form("results/list", array('entity' => $quiz, 'id_quiz' => $id_quiz));
} elseif ($option == ClipitQuiz::VIEW_MODE_PAGED){
    $content = elgg_view_form("results/paged", array('entity' => $quiz, 'id_quiz' => $id_quiz));
}

// Establecer el título de la página
$title = $quiz->name;
elgg_push_breadcrumb($title); //Migas de pan

// Diseño de la página
$body = elgg_view_layout('content', array(
    'filter' =>'',
    'content' => $content,
    'title' => $title,
));

// Dibujar la página
echo elgg_view_page($title, $body);

?>