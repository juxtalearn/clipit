<?php
$owner_id = elgg_get_logged_in_user_guid();

//Obtener el quiz y su ID
$id = elgg_extract('id', $vars);
$quiz= array_pop(ClipitQuiz::get_by_id(array($id)));

 //Obtener el array de preguntas del quiz
$questions = ClipitQuiz::get_quiz_questions($id);

//Establecer los enlaces para añadir preguntas nuevas o existentes
$add_quest_url = elgg_get_site_url()."questions/add2quiz?id_quiz={$id}&option=new";
$add_quest_from_list_url = elgg_get_site_url()."questions/add2quiz?id_quiz={$id}&option=list";

//Establecer enlaces para la previsualizacion del quiz segun su view_mode
if ($quiz->view_mode == ClipitQuiz::VIEW_MODE_LIST){
    $preview_url = elgg_get_site_url()."quizzes/preview?id_quiz={$id}&mode=list";
} elseif ($quiz->view_mode == ClipitQuiz::VIEW_MODE_PAGED){
    $preview_url = elgg_get_site_url()."quizzes/preview?id_quiz={$id}&mode=paged";
}

//Obtener el TrickyTopic asociado al quiz
$id_tt = $quiz->tricky_topic;
$tt = ClipitTrickyTopic::get_by_id(array($id_tt));
?>

<div id="quiz" class="row">
    <div class="info-block col-xs-12 col-md-8">
        <p id="quiz-description"><?php echo $quiz->description;?></p>      
        <p id="quiz-tt"><strong>Tricky Topic: </strong>
             <?php echo elgg_view('output/text', array('value' => $tt[$id_tt]->name));?>
        </p>
        <p id="quiz-access"><strong>Acceso: </strong>
             <?php 
             if ($quiz->public){
                 echo elgg_view('output/text', array('value' => "Publico"));
             } else {
                 echo elgg_view('output/text', array('value' => "Privado"));
             }
              ?>
        </p>
        <p id="quiz-view-mode"><strong>Visualización: </strong>
             <?php 
             if ( ($quiz->view_mode) == ClipitQuiz::VIEW_MODE_LIST ){
                 echo elgg_view('output/text', array('value' => "En una página"));
             } else {
                 echo elgg_view('output/text', array('value' => "En varias páginas"));
             }
              ?>
        </p>
        <?php 
        //Autor y tiempo
        $time_created = elgg_view("output/friendlytime", array('time' => $quiz->time_created));
        echo '<small class="show">Creado por ';
        echo '<span title="Profesor: '.$quiz->author_name.'" class="admin-owner" rel="nofollow"><i class="fa fa-fw fa-user"></i>'.$quiz->author_name.'</span>';
        echo ' '.$time_created.'</small>';
        ?>
    </div>

    <div id="buttons" class="col-xs-12 col-md-4" style="text-align: right;">
        <p><a href="<?php echo $add_quest_url; ?>" class='btn btn-primary btn-sm'>Añadir pregunta nueva</a></p>
        <p><a href="<?php echo $add_quest_from_list_url; ?>" class='btn btn-primary btn-sm'>Añadir pregunta existente</a></p>
        <p><a href="<?php echo $preview_url; ?>" class='btn btn-success btn-sm'>Previsualizar</a></p>

        <?php
        /*
         * Mostrar el botón para corregir el examen.
         * El examen sólo se puede corregir si tiene preguntas de desarrollo
         */
         if (quiz_has_develop_questions($id)){ 
            $correct_answer = elgg_get_site_url()."quizzes/students_list?id_quiz={$id}";
        ?>
            <p><a href="<?php echo $correct_answer; ?>" class='btn btn-info btn-sm'>Corregir</a></p>
        <?php } ?>
    </div>

</div>

<div id="quiz-questions" class="row" style="clear: left; margin-bottom: 15px;">
    <h3 class="page-header text-center">Preguntas del quiz</h3>
    <div id="questions-list" class="col-xs-12 col-md-12">
        
    <?php
    //Mostrar la lista de preguntas del quiz
    $num = 1;
    foreach($questions as $quest):
        $q = array_pop(ClipitQuizQuestion::get_by_id(array($quest)));
        $view_quest_url = elgg_get_site_url()."questions/view?id_quest={$q->id}";
        $edit_quest_url = elgg_get_site_url()."questions/edit?id_quest={$q->id}&id_quiz={$id}";
        $remove_quest_url = elgg_get_site_url()."action/questions/remove?id_quest={$q->id}&id_quiz={$id}";
        $time_created = elgg_view("output/friendlytime", array('time' => $q->time_created));
        
        //Titulo de la pregunta
        echo '<div id="question" class="row" style="margin-bottom: 10px;">';
        echo '<div id="quest-title" class="col-xs-6 col-md-6">';
        echo '<h4><a href="'.$view_quest_url.'" is_action="false">'.$num.') '.$q->name.'</a></h4>';
        echo '</div>';
        
        //Botones para editarla o eliminarla del quiz
        echo '<div id="options-buttons" class="col-xs-6 col-md-6" style="margin-top: 5px;">';
        if ($owner_id === $q->owner_id) {
            echo '<div id="edit-button" class="col-xs-2 col-md-2">';
            echo '<a type="button" class="btn btn-primary btn-xs" href="'.$edit_quest_url.'" is_action="false" title="Editar">
                        <i class="fa fa-fw fa-pencil fa-lg" aria-hidden="true"></i>
                    </a>';
            echo '</div>';
            echo '<div id="delete-button" class="col-xs-2 col-md-2">';
            echo elgg_view("output/url", 
                    array(
                        "type" => "button",
                        "href" => $remove_quest_url, 
                        "is_action" => true,
                        "class" => "btn btn-primary btn-xs",
                        "title" => "Eliminar",
                        "text" => '<i class="fa fa-fw fa-trash-o fa-lg" aria-hidden="true"></i>',
                        "onclick" => 'javascript:return confirmar("¿Está seguro de que desea eliminar esta pregunta del quiz?");',
                        ));
            echo '</div>';
        }
        //Muestro un mensaje si no ha sido coregida alguna respuesta de una pregunta de desarrollo
        if ($q->option_type == ClipitQuizQuestion::TYPE_STRING){    //Si es de desarrollo
            if (!have_been_checked($q->quiz_result_array)){        //Comprobar si todas las respuestas se han corregido
                echo '<div class="col-xs-8 col-md-8 alert alert-info text-center" style="padding-top: 1px; padding-bottom: 0px;">';
                echo '<span>Hay respuestas sin corregir</span>';
                echo '</div>';
            }
        }
        echo '</div>';  //Cerrar grupo de botones
        
        echo '<div id="quest-author" class="col-xs-12 col-md-12" style="margin-top: -10px;">';
        echo '<small class="show">Creado por ';
        echo '<span title="Profesor: '.$q->author_name.'" class="admin-owner" rel="nofollow"><i class="fa fa-fw fa-user"></i>'.$quiz->author_name.'</span>';
        echo ' '.$time_created.'</small></div>';
        echo '</div>'; //Cerrar #question
        $num ++;    //Incrementar contador preguntas
endforeach ?>
        
</div>  <!-- ./questions-list -->
</div>    <!-- ./quiz-questions -->
    
<script language="JavaScript">
    function confirmar (mensaje) {
        return confirm(mensaje);
    } 
</script>

