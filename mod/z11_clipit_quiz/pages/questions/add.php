<?php

// Asegurarse de que sólo los usuarios registrados pueden ver la página
gatekeeper();

// Establecer el título 
$title = "Crear una nueva pregunta";
elgg_push_breadcrumb($title);   //Inlcuir migas de pan

// Agregar el formulario en esta sección
$content = elgg_view_form('questions/save');

// Diseño de la página
$body = elgg_view_layout('content', array(
    'filter' =>'',
    'content' => $content,
    'title' => $title,
));

// Dibujar la página
echo elgg_view_page($title, $body);

?>