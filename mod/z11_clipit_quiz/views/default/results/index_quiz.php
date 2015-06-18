<?php
// Obtengo el quiz y su ID
$quiz = elgg_extract('entity', $vars);
$id = elgg_extract('id', $vars);
$user = elgg_get_logged_in_user_guid();

// Establezco la URL para realizar el quiz según su modo de visualización
$do_quiz_url = elgg_get_site_url()."results/do_quiz?id_quiz={$id}&option=list";
if ($quiz->view_mode == ClipitQuiz::VIEW_MODE_PAGED){
    $do_quiz_url = elgg_get_site_url()."results/do_quiz?id_quiz={$id}&option=paged";
}

// Link a los resultados del quiz
$results_url = elgg_get_site_url()."results/results?id_quiz={$id}";

//Obtengo el TrickyTopic del quiz
$id_tt = $quiz->tricky_topic;
$tt = ClipitTrickyTopic::get_by_id(array($id_tt));
?>

<div id="quiz" class="row">
    <div class="info-block col-xs-12 col-md-12">
        <p id="quiz-tt"><strong>Tricky Topic: </strong>
             <?php echo elgg_view('output/text', array('value' => $tt[$id_tt]->name));?>
        </p>
        <p id="quiz-description"><?php echo $quiz->description;?></p>
        <?php 
        //Autor y tiempo
        $time_created = elgg_view("output/friendlytime", array('time' => $quiz->time_created));
        echo '<small class="show">Creado por ';
        echo '<span title="Profesor: '.$quiz->author_name.'" class="admin-owner" rel="nofollow"><i class="fa fa-fw fa-user"></i>'.$quiz->author_name.'</span>';
        echo ' '.$time_created.'</small>';
        ?>
    </div>
    
    <div id="buttons" class="col-xs-12 col-md-12" style="margin-top: 30px;">
        <?php
            $intentos_realizados = ClipitQuiz::questions_answered_by_user($id, $user);
            //Si aun no ha realizado el examen, opcion de realizarlo
            if ($intentos_realizados < 1){
                echo'<p><a href="'.$do_quiz_url.'" class="btn btn-primary">Realizar quiz</a></p>';
            } else { //Si lo ha realizado, opcion de ver resultados
                echo '<p><a href="'.$results_url.'" class="btn btn-info">Ver resultados</a></p>';
            }
        ?>
    </div>
    
</div>