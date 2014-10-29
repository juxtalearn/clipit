<?php

//Título de la página
$title = "Todas las preguntas";

/*
 * Obtener todas las preguntas existentes y mostrarlas
 */

$questions = ClipitQuizQuestion::get_all();
foreach($questions as $quest){
    
    //Usuario que ha creado la pregunta
    $user = array_pop(ClipitUser::get_by_id(array($quest->owner_id)));
    
    //Enlaces para vew, editar y eliminar una pregunta
    $view_quest_url = elgg_get_site_url()."questions/view?id_quest={$quest->id}";
    $edit_quest_url = elgg_get_site_url()."questions/edit?id_quest={$quest->id}";
    $remove_quest_url = elgg_get_site_url()."action/questions/remove?id_quest={$quest->id}";
    
    $content .= ("<b>" . elgg_view("output/url", 
                         array(
                        "href" => $view_quest_url, 
                        "is_action" => false,
                        "text" => $quest->name)) 
                . "</b><br>"
                . $quest->description . "<br>"
            
       . "<i>Creada por ". $user->name . " " . elgg_view("output/friendlytime", 
                   array('time' => $quest->time_created))
            
       . "</i><br>" 
       . elgg_view("output/url", 
                   array(
                        "href" => $edit_quest_url, 
                        "is_action" => false,
                        "class" => "elgg-button",
                        "text" => "<img src='". elgg_get_site_url() . "mod/z11_clipit_quiz/graphics/edit.png' title='Editar'>",
                       ))
      . elgg_view("output/url", 
                    array(
                        "href" => $remove_quest_url, 
                        "is_action" => true,
                        "class" => "elgg-button",
                        "text" => "<img src='". elgg_get_site_url() . "mod/z11_clipit_quiz/graphics/eliminar.png' title='Eliminar'></a>",
                        "onclick" => 'javascript:return confirmar("¿Está seguro que desea eliminar la pregunta?");',
                        ))
        . "<p></p>");
}

$params = array(
    'content'   => $content,
    'title'     => $title,
);

$body = elgg_view_layout('content', $params);
echo elgg_view_page($body['title'], $body);

?>

<script language="JavaScript">
function confirmar (mensaje) {
    return confirm(mensaje);
} 
</script>