<?php
$user_logged = elgg_get_logged_in_user_guid();
//$title = "Todos los examenes";
$title = "HOLA";
$quizzes = ClipitQuiz::get_all();
foreach($quizzes as $quiz){
    
    $user = array_pop(ClipitUser::get_by_id(array($quiz->owner_id)));
    $view_quiz_url = elgg_get_site_url()."quizzes/view?id_quiz={$quiz->id}";
    $edit_quiz_url = elgg_get_site_url()."quizzes/edit?id_quiz={$quiz->id}";
    $remove_quiz_url = elgg_get_site_url()."action/quizzes/remove?id_quiz={$quiz->id}";
    
    $content .= ("<b>" . elgg_view("output/url", 
                         array(
                        "href" => $view_quiz_url, 
                        "is_action" => false,
                        "text" => $quiz->name)) 
                . "</b><br>"
                . $quiz->description . "<br>"
            
       . "<i>Creado por " . $quiz->author_name . " " . elgg_view("output/friendlytime", 
                   array('time' => $quiz->time_created))
            
       . "</i><br>");
    
   if ($user_logged == $user->id) {
       $content .= (
            elgg_view("output/url", 
                   array(
                        "href" => $edit_quiz_url, 
                        "is_action" => false,
                        "class" => "elgg-button",
                        "text" => "<img src='". elgg_get_site_url() . "mod/z11_clipit_quiz/graphics/edit.png' title='Editar'>",
                       ))
            . elgg_view("output/url", 
                    array(
                        "href" => $remove_quiz_url, 
                        "is_action" => true,
                        "class" => "elgg-button",
                        "text" => "<img src='". elgg_get_site_url() . "mod/z11_clipit_quiz/graphics/eliminar.png' title='Eliminar'></a>",
                        "onclick" => 'javascript:return confirmar("¿Está seguro que desea eliminar el quiz?");',
                        ))
           . "<p></p>");
   } else {
            $content .= "<br>";
   }//fin IF
  
}

$params = array(
    'content'   => $content,
    //'filter'    => "", //quito el filtro
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