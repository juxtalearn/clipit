<?php
//Obtener el quiz, su ID y su array de preguntas
$quiz = elgg_extract('entity', $vars);
$id = elgg_extract('id', $vars);
$questions = ClipitQuiz::get_quiz_questions($id);

//Obtener el TT asociado al quiz
$id_tt = $quiz->tricky_topic;
$tt = ClipitTrickyTopic::get_by_id(array($id_tt));

//Link a la vista del quiz
$view_quiz_url = elgg_get_site_url()."quizzes/view?id_quiz={$id}";

?>
<div id="quiz" class="row">
    <div class="info-block col-xs-12 col-md-8">
        <p id="quiz-tt"><strong>Tricky Topic: </strong>
             <?php echo elgg_view('output/text', array('value' => $tt[$id_tt]->name));?>
        </p>  
        <p id="quiz-description"><?php echo $quiz->description;?></p>      
    </div>
</div>

<div id="quiz-questions" class="row" style="clear: left; margin-bottom: 15px;">
    <div id="questions-list" class="col-xs-12 col-md-12">
    
    <?php
    /* Mostrar todas las preguntas del quiz */
    
    $num = 1; //Contador para numerar las preguntas
    foreach($questions as $quest):
        $q = array_pop(ClipitQuizQuestion::get_by_id(array($quest))); 
        $type = $q-> option_type; //Guardo el tipo de pregunta
        $oa = $q-> option_array; //Guardo el array de respuestas
        
        echo '<div id="question" class="row" style="margin-bottom: 10px;">';
        //Titulo de la pregunta
        echo '<div id="quest-title" class="col-xs-12 col-md-12">';
        echo '<h4>'.$num.') '.$q->name.'</h4>';
        echo '</div>';
        //Descripcion de la pregunta
        echo '<div id="quest-description" class="col-xs-12 col-md-12">';
        echo '<p>'.$q->description.'</p>';
        echo '</div>'; 

        //Respuestas
        echo '<div id="answers-block" class="col-xs-12 col-md-12">';
          switch ($type) {
              case ClipitQuizQuestion::TYPE_STRING:
                    echo elgg_view('input/longtext', array(
                              'class' => 'form-control',
                          ));
                    break;
              //****************************************************************************
                case ClipitQuizQuestion::TYPE_NUMBER:
                    echo elgg_view('input/text', array(
                              'class' => 'form-control',
                          ));
                    break;
              //****************************************************************************
              case ClipitQuizQuestion::TYPE_TRUE_FALSE:
                    echo '<div class="qqt" id="vof" style="margin-left: 30px;">';
                    echo '<div class="radio"><label>';
                        echo '<input type="radio" name="vof_ca" value="1">';
                        echo elgg_view('output/text', array('value' => $oa[0]));
                    echo '</label></div>';
                    echo '<div class="radio"><label>';
                        echo '<input type="radio" name="vof_ca" value="2">';
                        echo elgg_view('output/text', array('value' => $oa[1]));
                    echo '</label></div>';
                    break;
              //****************************************************************************
              case ClipitQuizQuestion::TYPE_SELECT_ONE:
                    echo '<div class="qqt" id="m1" style="margin-left: 30px;">';
                    echo '<div class="radio"><label>';
                        echo '<input type="radio" name="m1_ca" value="1">';
                        echo elgg_view('output/text', array('value' => $oa[0]));
                    echo '</label></div>';
                    echo '<div class="radio"><label>';
                        echo '<input type="radio" name="m1_ca" value="2">';
                        echo elgg_view('output/text', array('value' => $oa[1]));
                    echo '</label></div>';
                    echo '<div class="radio"><label>';
                        echo '<input type="radio" name="m1_ca" value="3">';
                        echo elgg_view('output/text', array('value' => $oa[2]));
                    echo '</label></div>';
                        //Si tiene mas de 3 respuestas:
                            if ($oa[3]) { 
                                echo '<div class="radio"><label>';
                                echo '<input type="radio" name="m1_ca" value="4">';
                                echo elgg_view('output/text', array('value' => $oa[3]));
                                echo '</label></div>';
                           }
                            if ($oa[4]) { 
                                echo '<div class="radio"><label>';
                                echo '<input type="radio" name="m1_ca" value="5">';
                                echo elgg_view('output/text', array('value' => $oa[4]));  
                                echo '</label></div>';
                            }
                    echo '</div>';
                    break;
            //****************************************************************************
            case ClipitQuizQuestion::TYPE_SELECT_MULTI:
                    echo '<div class="qqt" id="m" style="margin-left: 30px;">';
                    echo '<div class="checkbox"><label>';
                        echo '<input type="checkbox" name="m_ca[]" value="1">';
                        echo elgg_view('output/text', array('value' => $oa[0]));
                    echo '</label></div>';
                    echo '<div class="checkbox"><label>';
                        echo '<input type="checkbox" name="m_ca[]" value="2">';
                        echo elgg_view('output/text', array('value' => $oa[1]));
                    echo '</label></div>';
                    echo '<div class="checkbox"><label>';
                        echo '<input type="checkbox" name="m_ca[]" value="3">';
                        echo elgg_view('output/text', array('value' => $oa[2]));
                    echo '</label></div>';
                        //Si tiene mas de 3 respuestas:
                            if ($oa[3]) { 
                                echo '<div class="checkbox"><label>';
                                echo '<input type="checkbox" name="m_ca[]" value="4">';
                                echo elgg_view('output/text', array('value' => $oa[3]));
                                echo '</label></div>';
                            }
                            if ($oa[4]) { 
                                echo '<div class="checkbox"><label>';
                                echo '<input type="checkbox" name="m_ca[]" value="5"> ';
                                echo elgg_view('output/text', array('value' => $oa[4]));
                                echo '</label></div>';
                            }
                    echo '</div>';
                    break;
              //**************************************************************************
              default:  break;
          } //FIN DEL SWITCH
          echo '</div>';    //Cierre respuesta
    echo '</div>';    //Cierre pregunta
    $num ++;
    endforeach;
?>

    </div>  <!-- ./questions-list -->
</div>    <!-- ./quiz-questions -->
    
<?php
    echo elgg_view('output/url', array(
        "href" => $view_quiz_url,
        "class" => "btn btn-primary",
        "text" => "Terminar",
    ));
?>