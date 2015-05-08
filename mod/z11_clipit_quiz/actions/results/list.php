<?php

$id_quiz = get_input('id_quiz');
$user = elgg_get_logged_in_user_guid();
$correct = false;
$questions = ClipitQuiz::get_quiz_questions($id_quiz); 

// Recorro todas las preguntas del quiz
foreach($questions as $quest){
    $q = array_pop(ClipitQuizQuestion::get_by_id(array($quest))); 
    $id_quest = $q->id;
    $type = $q-> option_type; //Obtengo el tipo de pregunta
    $oa = $q-> option_array;
    $va = $q-> validation_array; //Obtengo el array de validacion
    $quiz_result_array = ClipitQuizQuestion::get_quiz_results($id_quest); //Obtengo el array de respuestas a la pregunta
    
    switch ($type) {
        case ClipitQuizQuestion::TYPE_NUMBER:
            $answer = get_input("nr_{$id_quest}");
            $correct = ($answer == $oa[0]);
            break;
        
        case ClipitQuizQuestion::TYPE_TRUE_FALSE:
            $answer = get_input("vof_{$id_quest}");
            $correct = (((int)$answer) == $oa[0]);
            //$correct = correct_true_false($answer,$va);
            break;
        
        case ClipitQuizQuestion::TYPE_SELECT_ONE:
            $answer = get_input("m1_{$id_quest}");
            $correct = correct_select_one($answer, $va);
            break;
        
        case ClipitQuizQuestion::TYPE_SELECT_MULTI:
            $answer = (array) get_input("m_{$id_quest}");
            $correct = correct_select_multi($answer, $va);
            break;
    }
    
    //Crear objeto QuizQuestionResult y guardarlo en el quiz_result_array de cada pregunta(QuizQuestion)
    if ($type == ClipitQuizQuestion::TYPE_STRING){ //Si es de Desarrollo guardo la respuesta para que la corrija el profesor
        $id_result = ClipitQuizResult::create(array(
            'user' => $user,
            'answer' => get_input("dr_{$id_quest}"),
            'quiz_question' => $id_quest,
            'description' => '',
        ));
    
    /* Si es cualquier otro tipo de pregunta, se ha corregido 'automáticamente' */
    } else {
        $id_result = ClipitQuizResult::create(array(
            'user' => $user,
            'correct' => $correct,
            'quiz_question' => $id_quest,
            'answer' => $answer,
            'description' => '',
        ));
    }
    
    //Añado el resultado al atributo quiz_result_array de la pregunta asociada (QuizQuestion)
    array_push($quiz_result_array, $id_result);
    
} //Fin FOR

ClipitQuizQuestion::set_quiz_results($id_quest, $quiz_result_array);

$view_quiz_url = elgg_get_site_url()."results/index_quiz?id_quiz={$id_quiz}";
forward($view_quiz_url);