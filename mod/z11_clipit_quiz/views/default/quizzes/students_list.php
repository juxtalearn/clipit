<?php

$id_quiz = get_input('id_quiz');
//Obtengo un array con los IDs de los alumnos que han realizado las preguntas del quiz
$students_list = students_list($id_quiz);

foreach ($students_list as $id_student) :
    $student = array_pop(ClipitUser::get_by_id($students_list));
    $avatar_img = get_avatar($student, 'small');
    
    //Obtengo el array de respuestas de cada estudiante
    $student_results = array_pop((ClipitQuizResult::get_by_owner($students_list)));
    $all_checked = true; //inicialmente todas están corregidas
    foreach ($student_results as $result) { //Compruebo respuesta a respuesta si tiene todas corregidas
        if (strlen($result->description) > 0){ //Si tiene el campo description con texto, NO ha sido corregida
            $all_checked = false;
        }
    }
?>

<div id='student'>
    <?php
        echo elgg_view('output/img', array(
            'src' => $avatar_img,
            'class' => 'image-block avatar-small',
            'style' => 'float: left; margin-right: 10px;',
        ));
    ?>
    
    <h3><?php echo $student->name ?></h3>

    <?php
        if (!$all_checked){?>
            <p style='float: right; margin-right:6px;'>Pendiente</p>
        <?php
        } else { ?>
            <p style='float: right;'>Corregida</p>
        <?php
        }
    ?>
            
    <p><?php echo $student->email ?></p>
    
    <?php
        $correct_answer = elgg_get_site_url()."quizzes/correct_answers?id_quiz={$id_quiz}&u={$id_student}";
        if (!$all_checked){?>
            <a href="<?php echo $correct_answer; ?>" class='elgg-button' style="float: right; margin-top:-10px;">Corregir</a>
    <?php
        } 
    ?>    
            
    <i>Ha respondido <?php echo elgg_view('output/friendlytime', array('time' => $result->time_created));?></i>
    <br><br>
</div>

<?php 
endforeach; //Lista de estudiantes
?>