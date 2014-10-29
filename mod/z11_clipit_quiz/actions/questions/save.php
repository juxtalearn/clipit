<?php

/*
 * Obtengo los datos recogidos del formulario
 */

$id_quiz = get_input('id_quiz');
$owner_id = elgg_get_logged_in_user_guid();
//$tags = get_input('tags');
$title = get_input('title');
$enunciado = get_input('enunciado');
$difficulty = (int) get_input('dif');
$question_type = get_input('type_answer');


switch ($question_type) {
    case ClipitQuizQuestion::TYPE_STRING:
        $option_array = array(
            0 => get_input('d_resp'));
        $val_array = array(
            0 => "true");
        break;
    
    case ClipitQuizQuestion::TYPE_TRUE_FALSE:
        save_true_false($option_array, $val_array);
        break;
        
    case ClipitQuizQuestion::TYPE_SELECT_ONE:
        save_select_one($option_array, $val_array);
        break;
        
    case ClipitQuizQuestion::TYPE_SELECT_MULTI:
        save_select_multi($option_array, $val_array);
        break;
}

// Crear question
$question = ClipitQuizQuestion::create(array(
            'owner_id' => $owner_id,
            'name' => $title,
            'description' => $enunciado,
            'difficulty' => $difficulty,
            //'tag_array' => "",
            'option_type' => $question_type,
            'option_array' => $option_array,
            'validation_array' => $val_array,
        ));

// Link para volver a la vista de todas las preguntas
$view_url = elgg_get_site_url()."questions/all";

//Si es una pregunta asociada a un quiz
if (!empty($id_quiz)){
    
    //Obtengo su array de questions
    $quest_array = ClipitQuiz::get_quiz_questions($id_quiz); 
    
    //Guardo la question creada en el array de questions del quiz asociado
    array_push($quest_array, $question);
    ClipitQuiz::add_quiz_questions($id_quiz, $quest_array);
    
    // Link para volver a la vista del quiz
    $view_url = elgg_get_site_url()."quizzes/view?id_quiz={$id_quiz}";
}

system_message("Pregunta creada correctamente");
forward($view_url);
