<?php
// asegurarse de que sólo los usuarios registrados pueden ver esta página
gatekeeper();

//$quiz = get_entity(get_input('id_quiz'));
$id_quiz = get_input('id_quiz');
$quiz = ClipitQuiz::get_by_id(array($id_quiz));

$option = get_input('option');

// agregar el formulario correspondiente
if ($option == 'new'){
    $title = "Añadir una nueva pregunta";
    $content = elgg_view_form("questions/save", array('entity' => $quiz, 'id_quiz' => $id_quiz));
} else {
    $title = "Añadir preguntas existentes";
    $content = elgg_view_form("questions/list", array('entity' => $quiz, 'id_quiz' => $id_quiz));
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