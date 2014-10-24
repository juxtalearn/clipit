<?php

$title = "Todos los Quizzes";
$quizzes = ClipitQuiz::get_all();
foreach($quizzes as $quiz){
    
    $user = array_pop(ClipitUser::get_by_id(array($quiz->owner_id)));

    $view_quiz_url = elgg_get_site_url()."results/index_quiz?id_quiz={$quiz->id}";
    //$edit_quiz_url = elgg_get_site_url()."quizzes/edit?id_quiz={$quiz->id}";
    //$remove_quiz_url = elgg_get_site_url()."action/quizzes/remove?id_quiz={$quiz->id}";
    
    $content .= ("<b>" . elgg_view("output/url", 
                         array(
                        "href" => $view_quiz_url, 
                        "is_action" => false,
                        "text" => $quiz->name)) 
                . "</b><br>"
                . $quiz->description . "<br>"
            
       . "<i>Creado por " . $quiz->author_name . " " . elgg_view("output/friendlytime", 
                   array('time' => $quiz->time_created))
            
       . "</i><br>" 

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