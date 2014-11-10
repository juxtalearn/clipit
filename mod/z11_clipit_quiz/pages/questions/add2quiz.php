<?php

// Asegurarse de que sólo los usuarios registrados pueden ver esta página
gatekeeper();

$id_quiz = get_input('id_quiz');
$quiz = ClipitQuiz::get_by_id(array($id_quiz));

/* 
 * Obtener el parametro 'option' pasado por la URL
 * Si option = new , se redirecciona al formulario de crear una nueva pregunta
 * Si option = list, se redirecciona al formulario con el listado de preguntas existentes
 */
$option = get_input('option');

// Agregar el formulario correspondiente
if ($option == 'new'){
    $title = "Añadir una nueva pregunta";
    $content = elgg_view_form("questions/save", array('entity' => $quiz, 'id_quiz' => $id_quiz));
} else {
    $title = "Añadir preguntas existentes";
    $content = elgg_view_form("questions/list", array('entity' => $quiz, 'id_quiz' => $id_quiz));
}

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