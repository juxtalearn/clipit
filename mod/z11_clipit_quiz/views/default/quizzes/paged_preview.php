<?php
//Obtener el quiz y su ID
$id_quiz = get_input('id_quiz');
$quiz = array_pop(ClipitQuiz::get_by_id(array($id_quiz)));

//Obtener el TT asociado al quiz
$id_tt = $quiz->tricky_topic;
$tt = ClipitTrickyTopic::get_by_id(array($id_tt));

//Link a la vista del quiz
$view_quiz_url = elgg_get_site_url()."quizzes/view?id_quiz={$id_quiz}";

?>
<div id="quiz" class="row">
    <div class="quiz-info col-xs-12 col-md-12">
        <p id="quiz-tt"><strong>Tricky Topic: </strong>
             <?php echo elgg_view('output/text', array('value' => $tt[$id_tt]->name));?>
        </p>  
        <p id="quiz-description"><?php echo $quiz->description;?></p>      
    </div>
</div>

<script>
    $(function(){
       $("a.step").click(function(){
          var step = $(this).data("step"); 
          $(".question").hide();
          $(".question#"+step).show();
          console.log(step);
       }); 
    });
</script>

<div id="quiz-questions" class="row" style="clear: left; margin-bottom: 15px;">
    <div id="questions-list" class="col-xs-12 col-md-12">
        
    <?php
    /* Mostrar pregunta a pregunta todas las questions del quiz */

    $questions_ids = ClipitQuiz::get_quiz_questions($id_quiz); 
    $questions = ClipitQuizQuestion::get_by_id($questions_ids, true);
    $i = 1;
    
    foreach ($questions as $question) :
        $id_quest = $question->id;
        $type = $question->option_type;
        $oa = $question->option_array;
        $display = null;
        if ($i>1){
            $display = "display:none;";
        }else{
            $display = "";}

        echo '<div id="'.$i.'" class="question" style="'.$display.'">';
        //Titulo de la pregunta
        echo '<div id="quest-title" class="col-xs-12 col-md-12">';
        echo '<h4>'.$i.') '.$question->name.'</h4>';
        echo '</div>';
        //Descripcion de la pregunta
        echo '<div id="quest-description" class="col-xs-12 col-md-12">';
        echo '<p>'.$question->description.'</p>';
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
                        echo '<input type="radio" name="vof_'.$id_quest.'" value="1">';
                        echo elgg_view('output/text', array('value' => $oa[0]));
                    echo '</label></div>';
                    echo '<div class="radio"><label>';
                        echo '<input type="radio" name="vof_'.$id_quest.'" value="2">';
                        echo elgg_view('output/text', array('value' => $oa[1]));
                    echo '</label></div>';
                    break;
              //****************************************************************************
              case ClipitQuizQuestion::TYPE_SELECT_ONE:
                    echo '<div class="qqt" id="m1" style="margin-left: 30px;">';
                    echo '<div class="radio"><label>';
                        echo '<input type="radio" name="m1_'.$id_quest.'" value="1">';
                        echo elgg_view('output/text', array('value' => $oa[0]));
                    echo '</label></div>';
                    echo '<div class="radio"><label>';
                        echo '<input type="radio" name="m1_'.$id_quest.'" value="2">';
                        echo elgg_view('output/text', array('value' => $oa[1]));
                    echo '</label></div>';
                    echo '<div class="radio"><label>';
                        echo '<input type="radio" name="m1_'.$id_quest.'" value="3">';
                        echo elgg_view('output/text', array('value' => $oa[2]));
                    echo '</label></div>';
                        //Si tiene mas de 3 respuestas:
                            if ($oa[3]) { 
                                echo '<div class="radio"><label>';
                                echo '<input type="radio" name="m1_'.$id_quest.'" value="4">';
                                echo elgg_view('output/text', array('value' => $oa[3]));
                                echo '</label></div>';
                           }
                            if ($oa[4]) { 
                                echo '<div class="radio"><label>';
                                echo '<input type="radio" name="m1_'.$id_quest.'" value="5">';
                                echo elgg_view('output/text', array('value' => $oa[4]));  
                                echo '</label></div>';
                            }
                    echo '</div>';
                    break;
            //****************************************************************************
            case ClipitQuizQuestion::TYPE_SELECT_MULTI:
                    echo '<div class="qqt" id="m" style="margin-left: 30px;">';
                    echo '<div class="checkbox"><label>';
                        echo '<input type="checkbox" name="m_'.$id_quest.'[]" value="1">';
                        echo elgg_view('output/text', array('value' => $oa[0]));
                    echo '</label></div>';
                    echo '<div class="checkbox"><label>';
                        echo '<input type="checkbox" name="m_'.$id_quest.'[]" value="2">';
                        echo elgg_view('output/text', array('value' => $oa[1]));
                    echo '</label></div>';
                    echo '<div class="checkbox"><label>';
                        echo '<input type="checkbox" name="m_'.$id_quest.'[]" value="3">';
                        echo elgg_view('output/text', array('value' => $oa[2]));
                    echo '</label></div>';
                        //Si tiene mas de 3 respuestas:
                            if ($oa[3]) { 
                                echo '<div class="checkbox"><label>';
                                echo '<input type="checkbox" name="m_'.$id_quest.'[]" value="4">';
                                echo elgg_view('output/text', array('value' => $oa[3]));
                                echo '</label></div>';
                            }
                            if ($oa[4]) { 
                                echo '<div class="checkbox"><label>';
                                echo '<input type="checkbox" name="m_'.$id_quest.'[]" value="5"> ';
                                echo elgg_view('output/text', array('value' => $oa[4]));
                                echo '</label></div>';
                            }
                    echo '</div>';
                    break;
              //**************************************************************************
              default:  break;
          } //FIN DEL SWITCH
            echo '</div>';    //Cierre respuesta
        
    //Botones de navegación entre preguntas
    echo '<div id="buttons">';  
        $x = $i;
        //Si NO es ni la primera ni la última pregunta
        if($i < count($questions) && $i > 1){ 
            //Muestro los botones anterior y siguiente 
            echo '<div class="col-xs-6 col-md-3" style="margin-top: 15px;">'; 
            echo elgg_view('output/url', array(
                      "href" => "javascript:;", 
                      "class" => "step btn btn-primary",
                      "text" => '<i class="fa fa-fw fa-chevron-left fa-lg" aria-hidden="true"></i> Anterior',
                      "data-step" => $x-1,
              ));
            echo '</div>';
            echo '<div class="col-xs-6 col-md-3" style="margin-top: 15px;">'; 
            echo elgg_view('output/url', array(
                      "href" => "javascript:;", 
                      "class" => "step btn btn-primary",
                      "text" => 'Siguiente <i class="fa fa-fw fa-chevron-right fa-lg" aria-hidden="true"></i>',
                      "data-step" => $x+1,
              ));
            echo '</div>';
         //Si es la primera pregunta    
        } elseif ($i == 1) {
            //Muestro el botón siguiente
            echo '<div class="col-xs-6 col-md-3" style="margin-top: 15px;">'; 
            echo elgg_view('output/url', array(
                      "href" => "javascript:;", 
                      "class" => "step btn btn-primary",
                      "text" => 'Siguiente <i class="fa fa-fw fa-chevron-right fa-lg" aria-hidden="true"></i>',
                      "data-step" => $x+1,
              ));
            echo '</div>';
         //Si es la última pregunta   
        } else { 
            //Muestro los botones anterior y terminar
            echo '<div class="col-xs-6 col-md-3" style="margin-top: 15px;">'; 
            echo elgg_view('output/url', array(
                          "href" => "javascript:;", 
                          "class" => "step btn btn-primary",
                          "text" => '<i class="fa fa-fw fa-chevron-left fa-lg" aria-hidden="true"></i> Anterior',
                          "data-step" => $x-1,
                  ));
            echo '</div>';
            echo '<div class="col-xs-6 col-md-3" style="margin-top: 15px;">'; 
            echo elgg_view('output/url', array(
                          "href" => $view_quiz_url, 
                          "class" => "step btn btn-success",
                          "text" => "Terminar",
                  ));
            echo '</div>';
        }
    echo '</div>';  //Cerrar botones
    echo '</div>';  //Cierre pregunta
    $i ++;
    endforeach; 
?>
    </div>  <!-- ./questions-list -->
</div>    <!-- ./quiz-questions -->