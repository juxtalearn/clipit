<?php

use ClipitTrickyTopic;

//Obtener el quiz y su ID
$quiz = elgg_extract('entity', $vars);
$id = elgg_extract('id', $vars);
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

<div class="quiz">
    <div class="info-block" style="float: left; margin-left: 10px;">
        <p><?php echo $quiz->description;?></p><br>        

        <p><strong>Tricky topic: </strong>
             <?php echo elgg_view('output/text', array('value' => $tt[$id_tt]->name));?>
        </p>

        <p><strong>Type of access: </strong>
             <?php 
             if ($quiz->public){
                 echo elgg_view('output/text', array('value' => "Publico"));
             } else {
                 echo elgg_view('output/text', array('value' => "Privado"));
             }
              ?>
        </p>

        <p><strong>View mode: </strong>
             <?php 
             if ( ($quiz->view_mode) == ClipitQuiz::VIEW_MODE_LIST ){
                 echo elgg_view('output/text', array('value' => "En una página"));
             } else {
                 echo elgg_view('output/text', array('value' => "En varias páginas"));
             }
              ?>
        </p>

        <small>
            <i>Creado por <?php echo elgg_view('output/text', array('value' => $quiz->author_name)) . " "
                             . elgg_view('output/friendlytime', array('time' => $quiz->time_created));?>
            </i>
        </small>
        <br><br>
        
    </div>

    <div class="buttons" style="float: right; margin-top: 10px; margin-right: 20px;">
        <p><a href="<?php echo $add_quest_url; ?>" class='elgg-button'>Add new question</a></p>
        <p><a href="<?php echo $add_quest_from_list_url; ?>" class='elgg-button'>Add question from list</a></p>
        <p><a href="<?php echo $preview_url; ?>" class='elgg-button'>Preview</a></p>

        <?php
        
        /*
         * Mostrar el botón para corregir el examen.
         * El examen sólo se puede corregir si tiene preguntas de desarrollo
         */
        if (quiz_has_develop_questions($id)){ 
            $correct_answer = elgg_get_site_url()."quizzes/students_list?id_quiz={$id}";
        ?>
        
            <p><a href="<?php echo $correct_answer; ?>" class='elgg-button'>Corregir</a></p>
        <?php } ?>
    </div>

</div>

<div class="questions" style="clear: left;">
    
<?php

//Mostrar la lista de preguntas del quiz
foreach($questions as $quest):

    $q = array_pop(ClipitQuizQuestion::get_by_id(array($quest)));

    $view_quest_url = elgg_get_site_url()."questions/view?id_quest={$q->id}";
    $edit_quest_url = elgg_get_site_url()."questions/edit?id_quest={$q->id}&id_quiz={$id}";
    $remove_quest_url = elgg_get_site_url()."action/questions/remove?id_quest={$q->id}&id_quiz={$id}";

?>

    <div class="question">
        <h3><?php echo elgg_view('output/url', array(
                        "href" => $view_quest_url,
                        "is_action" => false,
                        "text" => $q->name,
                    ));
            ?>
        </h3>

        <small>
            <i>Creada <?php echo elgg_view('output/friendlytime', array('time' => $q->time_created));?></i>
        </small>

      <div class="options-buttons">
        <?php
            echo elgg_view('output/url', 
                   array(
                        "href" => $edit_quest_url, 
                        "is_action" => false,
                        "class" => "elgg-button",
                        "text" => "<img src='". elgg_get_site_url() . "mod/z11_clipit_quiz/graphics/edit.png' title='Editar'>",
                       ));
            echo elgg_view('output/url', 
                    array(
                        "href" => $remove_quest_url, 
                        "is_action" => true,
                        "class" => "elgg-button",
                        "text" => "<img src='". elgg_get_site_url() . "mod/z11_clipit_quiz/graphics/eliminar.png' title='Eliminar'></a>",
                        "onclick" => 'javascript:return confirmar("¿Está seguro que desea eliminar la pregunta");',
                        ));

            //Muestro un mensaje si no ha sido coregida alguna respuesta de una pregunta de desarrollo
            if ($q->option_type == "Desarrollo"){
                $all_checked = have_been_checked($q->quiz_result_array, $all_checked);
                if ( !$all_checked ){
                    echo elgg_view('output/url', 
                       array(
                            "href" => "#", 
                            "is_action" => false,
                            "text" => "Hay respuestas sin corregir",
                           ));
                }
            }
        ?>  
        <br><br>
      </div>
    </div>

<?php endforeach ?>

</div>    
    
<script language="JavaScript">
function confirmar (mensaje) {
    return confirm(mensaje);
} 
</script>

