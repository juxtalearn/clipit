<?php
//PARTE COMUN, Obtengo los datos recogidos del formulario
$id_quiz = get_input('id_quiz');
$owner_id = elgg_get_logged_in_user_guid();
$tags = string_to_tag_array(get_input('tags')); //$tags = get_input('tags');
$title = get_input('title');
$enunciado = get_input('enunciado');
$difficulty = (int) get_input('dif');
$type_answer = get_input('type_answer');


switch ($type_answer) {
    case 'd':
        $option_type = "Desarrollo";
        $option_array = array(
            0 => get_input('d_resp'));
        $val_array = array(
            0 => "true");
        break;
    
    case 'vof':
        $option_type = "Verdadero o falso";
        respuestas_verdadero_falso($option_array, $val_array);
        break;
        
    case 'm1':
        $option_type = "One choice";
        //respuestas_once_choice($option_array, $val_array);
        r_o_c($option_array, $val_array);
        break;
        
    case 'm':
        $option_type = "Multiple choice";
        //respuestas_multi_choice($option_array, $val_array);
        r_m_c($option_array, $val_array);
        break;
}

// Crear question
$question = ClipitQuizQuestion::create(array(
            'owner_id' => $owner_id,
            'name' => $title,
            'description' => $enunciado,
            'difficulty' => $difficulty,
            'tag_array' => $tags,
            'option_type' => $option_type,
            'option_array' => $option_array,
            'validation_array' => $val_array,
        ));

$view_url = elgg_get_site_url()."questions/all";

//Si es una pregunta asociada a un quiz
if (!empty($id_quiz)){
    $quest_array = ClipitQuiz::get_quiz_questions($id_quiz); //Obtengo su array de questions
    //Guardo la question creada en el array de questions del quiz asociado
    array_push($quest_array, $question);
    ClipitQuiz::add_quiz_questions($id_quiz, $quest_array);
    $view_url = elgg_get_site_url()."quizzes/view?id_quiz={$id_quiz}";
}

system_message("Pregunta creada correctamente");
forward($view_url);
