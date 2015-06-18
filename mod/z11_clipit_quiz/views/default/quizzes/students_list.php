<?php
$id_quiz = get_input('id_quiz');

//Obtengo un array con los IDs de los alumnos que han realizado las preguntas del quiz
$students_list = students_list($id_quiz);

foreach ($students_list as $id_student) :
    $student = array_pop(ClipitUser::get_by_id($students_list));
    $avatar_img = get_avatar($student, 'small');
    
    //Obtengo el array de respuestas de cada estudiante
    $student_results = array_pop((ClipitQuizResult::get_by_owner($students_list)));

    //Comprobar si tiene todas las respuestas corregidas
    $all_checked = true;
    if (count($student_results)>0){
        
        foreach ($student_results as $result) { //Compruebo respuesta a respuesta
            //Obtener la pregunta 
            $q = array_pop(ClipitQuizQuestion::get_by_id(array($result->quiz_question)));
            //Si es una respuesta a una pregunta de desarrollo Y tiene el campo description vacio, NO ha sido corregida
            if (($q->option_type == ClipitQuizQuestion::TYPE_STRING) && (strlen($result->description) == 0)) {   
                    $all_checked = false;}
        }
    }
    
echo '<div id="student" class="row">';

    echo '<div id="info">';
    echo '<div id="avatar" class="col-xs-3 col-md-1" style="margin-left: 15px;">';
        echo elgg_view('output/img', array(
            'src' => $avatar_img,
            'class' => 'image-block avatar-small'
        ));
    echo '</div>';
    echo '<div id="student-name" class="col-xs-5 col-md-5" style="top: -25px;">';
        echo '<h3>'.$student->name.'</h3>';
        echo '<p>'.$student->email.'</p>';
    echo '</div>';
    echo '<div id="info-checked" class="col-xs-4 col-md-5">';
        if ($all_checked){
            echo '<div class="alert alert-success " style="float: right; padding-bottom: 0px; padding-top: 0px;">Corregida</div>';
        } else {
            echo '<div class="alert alert-warning " style="float: right; padding-bottom: 0px; padding-top: 0px;">Pendiente</div>';
        }
    echo '</div>';

    echo '<div id="info-time" class="col-xs-6 col-md-6" style="top: -20px; margin-left: 15px;">';
    echo 'Ha respondido '. elgg_view('output/friendlytime', array('time' => $result->time_created)).'';
    echo '</div>';
    $correct_answer = elgg_get_site_url()."quizzes/correct_answers?id_quiz={$id_quiz}&u={$id_student}";
    if (!$all_checked){
        echo '<div id="check-button" class="col-xs-6 col-md-5" style="top: -40px;">';
        echo '<a href="'.$correct_answer.'" class="bnt btn-info btn-sm" style="float: right;">Corregir</a>';
        echo '</div>';
    } 
    echo '</div>'; //Cerrar info
    
echo '</div>'; //Cerrar student
endforeach; //Lista de estudiantes
?>