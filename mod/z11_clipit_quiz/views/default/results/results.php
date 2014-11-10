<?php

$quiz = elgg_extract('entity', $vars);
$id_quiz = elgg_extract('id', $vars);
$user_id = elgg_get_logged_in_user_guid();
$quiz_questions = ClipitQuiz::get_quiz_questions($id_quiz); //Array de preguntas del quiz
$quiz_results = array_pop(ClipitQuizResult::get_by_owner(array($user_id)));//Array con todas las respuestas de un usuario

$result_questions = array(); //Array con los IDs de las respuestas del usuario a las preguntas de ese quiz
foreach($quiz_results as $quiz_result){
    $id_quest = $quiz_result->quiz_question;
    if (in_array($id_quest, $quiz_questions)){
       $result_questions[] = $quiz_result->id; 
    } 
}
?>

<div class="quiz">
    <div>
        <p><strong><?php echo $quiz->description; ?></strong></p>
    </div>
    <br> 
</div>

<?php

$num = 1; // Contador para numerar las preguntas

foreach ($result_questions as $id_resp):
    $result = array_pop(ClipitQuizResult::get_by_id(array($id_resp)));
    $question = array_pop(ClipitQuizQuestion::get_by_id(array($result->quiz_question)));
    $type = $question-> option_type; //Guardo el tipo de pregunta
    $oa = $question-> option_array; //Guardo el array de respuestas
?>

<div class="question" style="height: 120px;">

    <div class="content-block" style="position: relative;">
        <div style="position: absolute;">
            <h4>
                 <?php echo $num . ". " . $question->name;?>
            </h4>
            <p>
                <?php echo $question->description;?>
            </p> 
        </div>
    
    <div class="answers-block" style="position: absolute; top:30px;">
        
        <?php 
          switch ($type) {
              case ClipitQuizQuestion::TYPE_STRING:
                  //Comprobar si esta corregida o no, para mostrar bien,mal,pendiente
                  ?>
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
    
    <div class="result" style="position: absolute; top:50px; right: 0px; width: 100px;">
        <?php
            //Si ha respondido correctamente
            if ($result->correct){?>
                <img src="<?php echo elgg_get_site_url() . "mod/z11_clipit_quiz/graphics/correct.jpg";?>" title='BIEN'>
            <?php } else { ?>
                <img src="<?php echo elgg_get_site_url() . "mod/z11_clipit_quiz/graphics/incorrect.jpg";?>" title='MAL'>
            <?php }
        ?>
    </div>
            </div>
    <br>
</div>       

<?php 
    $num ++;
    endforeach;
?>