<?php

/*
* Funciones para crear las preguntas con sus respuestas correctas (Profesor)
*/

/** Funcion auxiliar para guardar las respuestas de Desarrollo **/
function save_long_quest(&$option_array, &$val_array){
    $option_array = array(
            "0" => get_input('resp'),
        );
    $val_array = array(
            "0" => "true",
        );
}

/** Funcion auxiliar para guardar una pregunta de Verdadero-Falso **/
function save_true_false(&$option_array, &$val_array){
    $option_array = array(
            "0" => get_input('vof_resp1'),
            "1" => get_input('vof_resp2'),
        );
    $id_resp = get_input('vof_ca');
    if ($id_resp == 1) {
            $val_array = array(
                  "0" => "true",
                  "1" => "false");
    } else {
            $val_array = array(
                  "0" => "false",
                  "1" => "true");
    }
}


/*
 * Funcion auxiliar para guardar las respuestas de One Choice.
 * Guarda todas las respuestas aunque sean campos vacíos
 */
function save_select_one(&$option_array, &$val_array){
    //Bucle para guardar las respuestas
    $i = 1;
    $index = 0;
    while ($i <= 5) {
        $option_array["$index"] =get_input("m1_resp{$i}");
        $i ++;
        $index ++;   
    }
    //Bucle para guardar cuales son correctas/incorrectas
    $id_resp = get_input('m1_ca');
    for ($index = 1; $index <= count($option_array); $index++) {
        //Si ha sido seleccionada marco true
        $i = $index - 1;
        if ($id_resp == ($index)) {
            $val_array["$i"] = "true";
        } else {
            $val_array["$i"] = "false";
        }
    }
}

/*
 * Funcion auxiliar para guardar las respuestas de Multi-choice.
 * Guarda todas las respuestas aunque sean campos vacíos
 */
function save_select_multi (&$option_array, &$val_array){
    $i = 1;
    $index = 0;
    //Bucle para guardar las respuestas
    while ($i <= 5) {
        $option_array["$index"] = get_input("m_resp{$i}");
        $i ++;
        $index ++;   
    }
    //Guardar si las respuestas son true o false. Compruebo respuesta a respuesta
    $checkbox = (array) get_input('m_ca');
    $j = 0;
    $z = 1;
    while ($j < count($option_array)) {
        if (in_array(($z), $checkbox)) { //La respuesta 1,2,3.. ha sido seleccionada
            $val_array["$j"] = "true";
        } else { //No ha sido seleccionada
            $val_array["$j"] = "false";
        }
        $j ++;
        $z ++;
    }
}


/*
 * Funciones para corregir las respuestas dadas por el estudiante
 */
function test_vof(&$va, &$select_answer, &$correct){
    if (($select_answer == 1) && ($va[0] === "true")) {
                $correct = true;
            } elseif (($select_answer == 2) && ($va[1] === "true")) {
                $correct = true;
            } else {
                $correct = false;
    }
}

function test_one_choice(&$va, &$select_answer, &$correct){
    //Busca un valor determinado y devuelve la clave correspondiente en caso de éxito
    $correct_answer = array_search("true", $va);
    $correct_answer = $correct_answer + 1; //El indice de va[] es 0 para la resp 1, 1 para la resp 2, etc
    if ($select_answer == $correct_answer) {
        $correct = true;
    } else {
        $correct = false;
    }
}

function test_multi_choice(&$va, &$selects, &$all_correct){
    $corrects = 0; //Contador de respuestas correctas
    $j = 1; //Indice para el array de respuestas seleccionadas
    for ($i=0; $i < count($va); $i++) {
        if (in_array($j, $selects) && ($va[$i]=='true')){ //SI ha seleccionado la 1,2,3...
            $corrects ++;}
        $j ++;
    }
    $aux = (array) array_count_values($va);
        if ($aux["true"] == $corrects){
            $all_correct = true;}
}

/* Funcion para comprobar si una pregunta de desarrollo ha sido corregida
 * No ha sido corregida si tiene 'correct'=false y 'description'=texto
 * SI ha sido corregida si tiene 'correct'=true/false y 'description'=" " */
function have_been_checked ($quest_results, $all_cheked){ //me pasan el array de resultados de una pregunta
    $all_checked = true; //inicialmente todas están corregidas
    foreach ($quest_results as $id_result) { //Compruebo respuesta a respuesta
        $result = array_pop(ClipitQuizResult::get_by_id(array($id_result)));
        if (strlen($result->description) > 0){ //Si tiene el campo description con texto, NO ha sido corregida
            $all_checked = false;
        }
    }
}

//Funcion que devuelve TRUE si un quiz tiene preguntas de desarrollo
function quiz_has_develop_questions($id_quiz){
    $has_develop_questions = false;
    $quiz_questions = ClipitQuiz::get_quiz_questions($id_quiz);
    foreach ($quiz_questions as $id_question) {
        $question = array_pop(ClipitQuizQuestion::get_by_id($quiz_questions));
        if ($question->option_type == "Desarrollo"){
            $has_develop_questions = true;
        }
    }
    return $has_develop_questions;
}

//Funcion que me devuelve un array con los IDs de los estudiantes que han realizado un quiz
function students_list ($id_quiz){
    $students_array = array();
    $quiz_questions = ClipitQuiz::get_quiz_questions($id_quiz); //Obtengo todas las preguntas del quiz
    foreach ($quiz_questions as $id_question) {
        $questions_results = ClipitQuizQuestion::get_quiz_results($id_question); //Obtengo todos sus resultados
        foreach ($questions_results as $id_result) {
            $result = array_pop(ClipitQuizResult::get_by_id($questions_results));
            $students_array[] = $result->user;
        }
    }
    $students_array = array_unique($students_array); //Elimina los valores duplicados del array
    return $students_array;
}

?>