<?php

//Obtengo los datos recogidos del formulario
$id_quiz = get_input('id_quiz');
$quest_list = get_input('check-quest');

//Obtengo el array de preguntas del Quiz
$quest_array = ClipitQuiz::get_quiz_questions($id_quiz);

if (!empty($quest_list)) {
    // *** AÑADIR QUESTIONS A UN QUIZ ***
    // hago un bucle para recorrer todos los elementos seleccionados
    foreach ($quest_list as $quest){
        // Creo un clon de la pregunta original seleccionada
        $new_question = ClipitQuizQuestion::create_clone($quest);
        // Guardo la nueva pregunta en el array de questions del quiz asociado
        array_push($quest_array, $new_question);
        ClipitQuiz::add_quiz_questions($id_quiz, $quest_array);
    }
    
    system_message("Preguntas añadidas correctamente");
}

// Redireccion a la vista del quiz
$view_quiz_url = elgg_get_site_url()."quizzes/view?id_quiz={$id_quiz}";
forward($view_quiz_url);