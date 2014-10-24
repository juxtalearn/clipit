<?php
//Página para la composición de los blogs

// asegurarse de que sólo los usuarios registrados pueden ver esta página
gatekeeper();

// establecer el título 
// para plugins distribuidos, asegúrese de usar elgg_echo () para la internacionalización
$title = "Crear un nuevo examen";
elgg_push_breadcrumb($title);

/** TENGO QUE CONTEMPLAR LA OPCION DE QUE CREEN EL QUIZ DENTRO DE UNA ACTIVIDAD
 ** POR TANTO, DEBEN PASARME ALGUN PARAMETRO POR LA URL. SUPONGO QUE ME PASAN
 ** EL ID DE LA ACTIVIDAD  **/

$id_act = get_input('id_act');
if (!$id_act){
    $content = elgg_view_form('quizzes/save');
} else {
    $content = elgg_view_form("quizzes/save", array('id_act' => $id_act));
}

// diseño de la página
$body = elgg_view_layout('content', array(
    'filter' =>'',
    'content' => $content,
    'title' => $title,
));

// dibujar la página
echo elgg_view_page($title, $body);

?>