<?php
// Obtengo el quiz y su ID
$id_quiz = get_input('id_quiz');
$quiz = array_pop(ClipitQuiz::get_by_id(array($id_quiz)));

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
    </div>
</div>

<div id="quiz-questions" class="row" style="clear: left; margin-bottom: 15px;">
    <div id="questions-list" class="col-xs-12 col-md-12">
    
    <?php
    /* Mostrar todas las preguntas del quiz */

    $questions = ClipitQuiz::get_quiz_questions($id_quiz);
    $num = 1; // Contador para numerar las preguntas

    foreach($questions as $quest):
        $q = array_pop(ClipitQuizQuestion::get_by_id(array($quest))); 
        $id_quest = $q->id;
        $type = $q-> option_type; //Guardo el tipo de pregunta
        $oa = $q-> option_array; //Guardo el array de respuestas
        $va = $q-> validation_array;

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
                    echo '<div class="d" id="'.$i.'">';
                    echo elgg_view('input/longtext', array(
                              'class' => 'form-control',
                              'name' => "dr_{$id_quest}",
                          ));
                    echo '</div>';
                    break;
              //****************************************************************************
                case ClipitQuizQuestion::TYPE_NUMBER:
                    echo '<div class="n" id="'.$i.'">';
                    echo elgg_view('input/text', array(
                              'class' => 'form-control',
                              'name' => "nr_{$id_quest}",
                          ));
                    echo '</div>';
                    break;
              //****************************************************************************
                case ClipitQuizQuestion::TYPE_TRUE_FALSE:
                    echo '<div class="qqt" id="vof" style="margin-left: 30px;">';
                    echo '<div class="radio"><label>';
                        echo '<input type="radio" class="vof" name="vof_'.$id_quest.'" value="1"> Verdadero';
                        //echo elgg_view('output/text', array('value' => $oa[0]));
                    echo '</label></div>';
                    echo '<div class="radio"><label>';
                        echo '<input type="radio" class="vof" name="vof_'.$id_quest.'" value="2"> Falso';
                        //echo elgg_view('output/text', array('value' => $oa[1]));
                    echo '</label></div>';
                    break;
              //****************************************************************************
              case ClipitQuizQuestion::TYPE_SELECT_ONE:
                    echo '<div class="qqt" id="m1" style="margin-left: 30px;">';
                    echo '<div class="radio"><label>';
                        echo '<input type="radio" class="oc" name="m1_'.$id_quest.'" value="1">';
                        echo elgg_view('output/text', array('value' => $oa[0]));
                    echo '</label></div>';
                    echo '<div class="radio"><label>';
                        echo '<input type="radio" class="oc" name="m1_'.$id_quest.'" value="2">';
                        echo elgg_view('output/text', array('value' => $oa[1]));
                    echo '</label></div>';
                    echo '<div class="radio"><label>';
                        echo '<input type="radio" class="oc" name="m1_'.$id_quest.'" value="3">';
                        echo elgg_view('output/text', array('value' => $oa[2]));
                    echo '</label></div>';
                        //Si tiene mas de 3 respuestas:
                            if ($oa[3]) { 
                                echo '<div class="radio"><label>';
                                echo '<input type="radio" class="oc" name="m1_'.$id_quest.'" value="4">';
                                echo elgg_view('output/text', array('value' => $oa[3]));
                                echo '</label></div>';
                           }
                            if ($oa[4]) { 
                                echo '<div class="radio"><label>';
                                echo '<input type="radio" class="oc" name="m1_'.$id_quest.'" value="5">';
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
          
    echo '</div>';  //Cierre pregunta
    $num ++;
    endforeach;
    
    //Botones
    echo '<div id="buttons">';  
        echo '<div class="col-xs-6 col-md-3" style="margin-top: 15px;">'; 
            echo '<a type="button" class="btn btn-success" onclick="comprobar_respuestas()">Terminar</a>';
        echo '</div>';
        echo elgg_view('input/hidden', array(
                    'name' => 'id_quiz',
                    'value' => $id_quiz,
            ));
    echo '</div>';  //Cerrar botones
?>
    </div>  <!-- ./questions-list -->
</div>    <!-- ./quiz-questions -->

<script type="text/javascript">
    function comprobar_respuestas(){
        //Comprobar todos los campos
        numQuestions = 0;       //Numero de preguntas
        numChecked = 0;         //Numero de respuestas dadas
        
        //Comprobar desarrollo
        numQuestions = $('div.d').size();     //Numero de preguntas de desarrollo
        for (i=1; i <= numQuestions; i++) {
            answer = $(".d#"+i+" textarea").val();
            if ( answer === "") {
                alert("Hay preguntas de desarrollo sin responder.");
                return false;
            }
        }
        //Comprobar numericas
        numQuestions = $('div.n').size();     //Numero de preguntas de numericas
        for (i=1; i <= numQuestions; i++) {
            answer = $(".n#"+i+" input:text").val();
            if ( answer === "") {
                alert("Hay preguntas de numéricas sin responder.");
                return false;
            }
        }
        //Comprobar T/F
        numQuestions = $('div#vof').size();     //Numero de preguntas T/F
        numChecked = $('input:radio[class=vof]:checked').size(); //Numero de respuestas seleccionadas
        if (numChecked < numQuestions) {
            alert("Hay preguntas one choice sin responder.");
            return false;
        }
        //Comprobar once choice
        numQuestions = $('div#m1').size();     //Numero de preguntas one choice
        numChecked = $('input:radio[class=oc]:checked').size();   //Numero de respuestas seleccionadas
        if (numChecked < numQuestions) {
            alert("Hay preguntas multiple choice sin responder.");
            return false;
        }
        //Comprobar multiples
        numQuestions = $('div#m').size();     //Numero de preguntas multiples
        numChecked = $('input:checkbox:checked').size();   //Numero de respuestas checkeadas
        if (numChecked < numQuestions) {
            alert("Hay preguntas sin responder.5");
            return false;
        }
        //enviar formulario
        $("form").submit();
    }
</script>