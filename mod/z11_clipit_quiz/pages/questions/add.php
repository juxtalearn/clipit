<?php
// asegurarse de que sólo los usuarios registrados pueden ver esta página
gatekeeper();

// establecer el título 
// para plugins distribuidos, asegúrese de usar elgg_echo () para la internacionalización
$title = "Crear una nueva pregunta";
elgg_push_breadcrumb($title);

// agregar el formulario en esta sección
$content = elgg_view_form('questions/save');

// diseño de la página
$body = elgg_view_layout('content', array(
    'filter' =>'',
    'content' => $content,
    'title' => $title,
));

// dibujar la página
echo elgg_view_page($title, $body);

?>