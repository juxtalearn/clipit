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
    $va = $q-> validation_array; //Obtengo el array de validacion
    $quiz_result_array = ClipitQuizQuestion::get_quiz_results($id_quest); //Obtengo el array de respuestas a la pregunta
    
    switch ($type) {
        case ClipitQuizQuestion::TYPE_TRUE_FALSE:
            $resp_seleccionada = get_input("vof_{$id_quest}");
            correct_true_false($va, $resp_seleccionada, $correct);
            break;
        
        case ClipitQuizQuestion::TYPE_SELECT_ONE:
            $resp_seleccionada = get_input("m1_{$id_quest}");
            correct_select_one($va, $resp_seleccionada, $correct);
            break;
        
        case ClipitQuizQuestion::TYPE_SELECT_MULTI:
            $selects = (array) get_input("m_{$id_quest}");
            correct_select_multi($va, $selects, $correct);
            break;
    }
    
    //Crear objeto QuizQuestionResult y guardarlo en el quiz_result_array de cada pregunta(QuizQuestion)
    if ($type == ClipitQuizQuestion::TYPE_STRING){ //Si es de Desarrollo guardo la respuesta para que la corrija el profesor
        $id_result = ClipitQuizResult::create(array(
            'user' => $user,
            'description' => get_input("resp_{$id_quest}"),
            'quiz_question' => $id_quest,
        ));
    
    /* Si es cualquier otro tipo de pregunta, se ha corregido 'automáticamente' */
    } else {
        $id_result = ClipitQuizResult::create(array(
            'user' => $user,
            'correct' => $correct,
            'quiz_question' => $id_quest,
        ));
    }
    
    //Añado el resultado al atributo quiz_result_array de la pregunta asociada (QuizQuestion)
    array_push($quiz_result_array, $id_result);
    
} //Fin FOR

ClipitQuizQuestion::set_quiz_results($id_quest, $quiz_result_array);

$view_quiz_url = elgg_get_site_url()."results/index_quiz?id_quiz={$id_quiz}";
forward($view_quiz_url);