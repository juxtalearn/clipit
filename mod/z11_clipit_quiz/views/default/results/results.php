<?php

$quiz = elgg_extract('entity', $vars);
$id_quiz = elgg_extract('id', $vars);
$user_id = elgg_get_logged_in_user_guid();
$quiz_questions = ClipitQuiz::get_quiz_questions($id_quiz); //Array de preguntas del quiz
$quiz_results = array_pop(ClipitQuizResult::get_by_owner(array($user_id)));//Array con todas las respuestas del usuario

$result_questions = array(); //Array con los IDs de las respuestas del usuario a las preguntas de ese quiz
foreach($quiz_results as $quiz_result){
    $id_quest = $quiz_result->quiz_question;
    if (in_array($id_quest, $quiz_questions)){
       $result_questions[] = $quiz_result->id; 
    } 
}
?>

<div id="quiz" class="row">
    <div class="info-block col-xs-12 col-md-12">
        <p id="quiz-description"><?php echo $quiz->description;?></p>      
    </div>
</div>

<div id="quiz-questions" class="row" style="clear: left; margin-bottom: 15px;">
    <div id="questions-list" class="col-xs-12 col-md-12">
    
    <?php
    /* Mostrar todas las preguntas del quiz */

    $num = 1; // Contador para numerar las preguntas
    foreach ($result_questions as $id_resp):
        $result = array_pop(ClipitQuizResult::get_by_id(array($id_resp)));  //Obtengo la respuesta
        $question = array_pop(ClipitQuizQuestion::get_by_id(array($result->quiz_question))); //Obtengo su correspondiente pregunta
        $type = $question-> option_type; //Guardo el tipo de pregunta
        $oa = $question-> option_array; //Guardo el array de respuestas
        
        echo '<div id="question" class="row" style="margin-bottom: 10px;">';
        //Titulo de la pregunta
        echo '<div id="quest-title" class="col-xs-12 col-md-12">';
        echo '<h4>'.$num.') '.$question->name.'</h4>';
        echo '</div>';
        //Descripcion de la pregunta
        echo '<div id="quest-description" class="col-xs-12 col-md-12">';
        echo '<p>'.$question->description.'</p>';
        echo '</div>';

        //Respuestas
        echo '<div id="answers-block" class="row">';
        echo '<div id="answer" class="col-xs-9 col-md-10">';
            switch ($type) {
                case ClipitQuizQuestion::TYPE_STRING:
                    echo '<div class="d" id="'.$i.'" style="margin-left: 30px;">';
                    echo elgg_view('input/longtext', array(
                              'class' => 'form-control text-justify',
                              'name' => "dr_{$id_quest}",
                              'value' => $result->answer,
                              'disabled' => '',
                          ));
                    //echo '<br><textarea class="elgg-input-longtext" style="height:inherit; width:500px;" disabled>'.$result->answer.'</textarea>';
                    echo '</div>';
                    break;
              //****************************************************************************
                case ClipitQuizQuestion::TYPE_NUMBER:
                    echo '<div class="n" id="'.$i.'" style="margin-left: 30px;">';
                    echo elgg_view('input/text', array(
                                'class' => 'form-control',
                                'name' => "nr_{$id_quest}",
                                'value' => $result->answer,
                          ));
                    //echo '<input type"text" class="elgg-input-text" style="height:inherit;" value="'.$result->answer.'" disabled>';
                    echo '</div>';
                    break;
              //****************************************************************************
                case ClipitQuizQuestion::TYPE_TRUE_FALSE:
                    echo '<div class="qqt" id="vof" style="margin-left: 30px;">';
                    if ($result->answer == 1) {
                        echo '<div class="radio"><label>';
                            echo '<input type="checkbox" name="vof_ca[]" value="1" checked disabled> Verdadero';
                        echo '</label></div>';
                        echo '<div class="radio"><label>';
                            echo '<input type="checkbox" name="vof_ca[]" value="2" disabled> Falso';
                        echo '</label></div>';
                    } else {
                        echo '<div class="radio"><label>';
                            echo '<input type="checkbox" name="vof_ca[]" value="1" disabled> Verdadero';
                        echo '</label></div>';
                        echo '<div class="radio"><label>';
                            echo '<input type="checkbox" name="vof_ca[]" value="2" checked disabled> Falso';
                        echo '</label></div>';
                    } 
                    echo '</div>';
                    break;
              //****************************************************************************
                case ClipitQuizQuestion::TYPE_SELECT_ONE:
                    echo '<div class="qqt" id="m1" style="margin-left: 30px;">';
                    for ($index = 1; $index <= count($oa); $index++) {
                        if (strlen($oa[$index-1])>0){ //Imprimir cada opcion de la pregunta
                            if ($index == ($result->answer)){
                                echo '<div class="radio"><label>';
                                echo '<input type="checkbox" name="m1_ca[]" value="'.$index.'" checked disabled>'.$oa[$index-1].' ';
                                echo '</label></div>';
                            } else {
                                echo '<div class="radio"><label>';
                                echo '<input type="checkbox" name="m1_ca[]" value="'.$index.'" disabled>'.$oa[$index-1].' ';
                                echo '</label></div>';
                            }
                        }
                    }
                    echo '</div>';
                    break;
            //****************************************************************************
            case ClipitQuizQuestion::TYPE_SELECT_MULTI:
                echo '<div class="qqt" id="m" style="margin-left: 30px;">';
                    for ($index = 1; $index <= count($oa); $index++) {
                        if (strlen($oa[$index-1])>0){ //Imprimir cada opcion de la pregunta
                            if(in_array((string)$index, $result->answer)){  //¿Ha sido seleccionada?
                                echo '<div class="checkbox"><label>';
                                echo '<input type="checkbox" name="m_ca[]" value="'.$index.'" checked disabled>'.$oa[$index-1].' ';
                                echo '</label></div>';
                            } else {
                                echo '<div class="checkbox"><label>';
                                echo '<input type="checkbox" name="m_ca[]" value="'.$index.'" disabled>'.$oa[$index-1].' ';
                                echo '</label></div>';
                            }
                        }
                    }
                echo '</div>';
                break;
              //**************************************************************************
            default:
                break;
        } //FIN DEL SWITCH
        echo '</div>';    //Cierre respuesta
        
        //Si ha respondido correctamente
        echo '<div id="answers-correct" class="col-xs-3 col-md-2 text-center">';
        if (($type == ClipitQuizQuestion::TYPE_STRING) && (strlen($result->description) == 0)){
            echo '<img src="'.elgg_get_site_url().'mod/z11_clipit_quiz/graphics/pendiente(6).png" title="PENDIENTE">';
        } elseif ($result->correct) {
            echo '<img src="'.elgg_get_site_url().'mod/z11_clipit_quiz/graphics/correct.jpg" title="BIEN">';
        } else {
            echo '<img src="'.elgg_get_site_url().'mod/z11_clipit_quiz/graphics/incorrect.jpg" title="MAL">';
        }
        echo '</div>';  //Cierre ICONO
        
        echo '</div>';  //Cierre answers-block
          
    echo '</div>';  //Cierre pregunta
    $num ++;
    endforeach;
?>