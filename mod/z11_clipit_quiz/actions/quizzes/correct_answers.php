<?php

$id_quiz = get_input('id_quiz');

//Array con los IDs de las respuestas del usuario a todas las preguntas de desarrollo del quiz
$array = get_input("array");
$tmp = stripslashes($array); 
$tmp = urldecode($tmp); 
$user_develop_results = unserialize($tmp);

//hago un bucle para recorrer respuesta a respuesta
foreach ($user_develop_results as $result) {
    var_dump($result);
    
    //Obtengo 0 o -1 si el profesor la ha marcado como correcta o incorrecta respectivamente
    $value_marked = get_input("correct_{$result->id}");
    
    if ($value_marked == 0){            //La ha marcado como CORRECTA
        $prop_value_array['correct'] = true;
    } elseif ($value_marked == -1) {    //La ha marcado como INCORRECTA
        $prop_value_array['correct'] = false;
    }
    
    //Modifico el objeto resultado eliminando el campo descripcion porque ya esta corregida
    $prop_value_array['description'] = "";
    ClipitQuizResult::set_properties($result->id, $prop_value_array);
    system_message("Respuesta corregida");
}

//Redireccion al listado de alumnos
$students_list_url = elgg_get_site_url()."quizzes/students_list?id_quiz={$id_quiz}";
forward($students_list_url);