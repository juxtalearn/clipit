<?php

use ClipitTrickyTopic;

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

<div class="quiz">
        <div class="content-block">
                <p id="topic"><strong>Tricky topic: </strong>
                 <?php
                        echo elgg_view('output/text', array('value' => $tt[$id_tt]->name));?>
                </p>
                <p><?php echo $quiz->description; ?></p>
            <br>  
        </div>
</div>

<?php

/*
 * Mostrar todas las preguntas del quiz
 */

$num = 1; //Contador para numerar las preguntas
foreach($questions as $quest):
    $q = array_pop(ClipitQuizQuestion::get_by_id(array($quest))); 
    $type = $q-> option_type; //Guardo el tipo de pregunta
    $oa = $q-> option_array; //Guardo el array de respuestas

?>

<div class="questions">

    <div class="content-block">
            <h4>
                 <?php echo $num . ". " . $q->name;?>
            </h4>
            <p>
                <?php echo $q->description;?>
            </p> 
    </div>
    
    <div class="answers-block">
        
        <?php 
          switch ($type) {
              case ClipitQuizQuestion::TYPE_STRING:
                  echo elgg_view('input/longtext'); ?>
                  <?php break;
              //*******************************************************************************************
              case ClipitQuizQuestion::TYPE_TRUE_FALSE:?>              
                     <div class="qqt" id="vof" style="margin-left: 30px;">
                        <br><input type="radio" name="vof_ca" value="1">
                        <?php
                        echo elgg_view('output/text', array('value' => $oa[0]));
                        ?>
                        <br><input type="radio" name="vof_ca" value="2">
                        <?php
                        echo elgg_view('output/text', array('value' => $oa[1]));
                        ?>
                    </div>
                  <?php break;
              //*******************************************************************************************
              case ClipitQuizQuestion::TYPE_SELECT_ONE:?>
                 <div class="qqt" id="m1" style="margin-left: 30px;">
                        <br><input type="radio" name="m1_ca" value="1">
                        <?php
                        echo elgg_view('output/text', array('value' => $oa[0]));
                        ?>
                        <br><input type="radio" name="m1_ca" value="2">
                        <?php
                        echo elgg_view('output/text', array('value' => $oa[1]));
                        ?> 
                        <br><input type="radio" name="m1_ca" value="3">
                        <?php
                        echo elgg_view('output/text', array('value' => $oa[2]));
                        //Si tiene mas de 3 respuestas:
                        if ($oa[3]) { ?>
                            <br><input type="radio" name="m1_ca" value="4">
                            <?php
                            echo elgg_view('output/text', array('value' => $oa[3]));
                            ?>         
                        <?php }

                        if ($oa[4]) { ?>
                            <br><input type="radio" name="m1_ca" value="5"> 
                            <?php
                                echo elgg_view('output/text', array('value' => $oa[4]));              
                        } ?>
                 </div>
                 <?php break;
            //****************************************************************************
            case ClipitQuizQuestion::TYPE_SELECT_MULTI:?>
                 <div class="qqt" id="m" style="margin-left: 30px;">
                        <br><input type="checkbox" name="m_ca[]" value="1">
                        <?php
                        echo elgg_view('output/text', array('value' => $oa[0]));
                        ?>
                        <br><input type="checkbox" name="m_ca[]" value="2">
                        <?php
                        echo elgg_view('output/text', array('value' => $oa[1]));
                        ?> 
                        <br><input type="checkbox" name="m_ca[]" value="3">
                        <?php
                        echo elgg_view('output/text', array('value' => $oa[2]));

                        if ($oa[3]) { ?>
                            <br><input type="checkbox" name="m_ca[]" value="4">
                            <?php
                            echo elgg_view('output/text', array('value' => $oa[3]));
                        }

                        if ($oa[4]) { ?>
                            <br><input type="checkbox" name="m_ca[]" value="5"> 
                            <?php
                            echo elgg_view('output/text', array('value' => $oa[4]));
                        } ?>
                 </div>
                 <?php break;
              //**************************************************************************
              default:?>
                  <?php break;
          } //FIN DEL SWITCH
          
        ?>
        <br><br>
    </div>
</div>       

<?php 
    $num ++;
    endforeach;


    echo elgg_view('output/url', array(
        "href" => $view_quiz_url,
        "class" => "elgg-button-action",
        "text" => "Terminar",
    )) . "<br>";

?>