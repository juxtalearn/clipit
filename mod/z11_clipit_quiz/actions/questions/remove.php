<?php

session_start();

$id_quest = get_input('id_quest');
$id_quiz = get_input('id_quiz');

/** Eliminar una pregunta que esta asociada a un quiz **/
if ($id_quiz > 0){
    //Obtengo el array de questions del quiz
    $quest_array = ClipitQuiz::get_quiz_questions($id_quiz);
    //Obtengo el indice donde está guardado el id de la pregunta
    $clave = array_search('$id_quest', $quest_array);
    //Elimino el elemento que está en ese índice
    unset($quest_array[$clave]);
    //Modifico el array de preguntas del quiz
    $prop_value_array['quiz_question_array'] = $quest_array;
    ClipitQuiz::set_properties($id_quiz, $prop_value_array);
    forward(REFERER);
    
/** Eliminar una pregunta que NO esta asociada a un quiz **/    
} else {
    //Tengo que eliminar la question del sistema
    ClipitQuizQuestion::delete_by_id(array($id_quest));
    $view_url = elgg_get_site_url()."questions/all";
    forward($view_url);
}

system_message("Pregunta eliminada correctamente");
?>
