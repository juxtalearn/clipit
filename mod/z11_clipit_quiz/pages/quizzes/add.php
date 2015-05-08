<?php
//Asegurarse de que sólo los usuarios registrados pueden ver esta página
gatekeeper();

// Establecer el título 
// para plugins distribuidos, asegúrese de usar elgg_echo () para la internacionalización
$title = "Crear un nuevo examen";
elgg_push_breadcrumb($title);   //Inlcuir migas de pan

$id_act = get_input('id_act');
if (!$id_act){
    $content = elgg_view_form('quizzes/save');
} else {
    $content = elgg_view_form("quizzes/save", array('id_act' => $id_act));
}

//Diseño de la página
$body = elgg_view_layout('content', array(
    'filter' =>'',
    'content' => $content,
    'title' => $title,
));

echo elgg_view_page($title, $body);
?>