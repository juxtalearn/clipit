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

<div class="quiz">
    <div class="info">
        <p><strong>Tricky topic: </strong>
            <?php echo $tt[$id_tt]->name; ?>
        </p>
        <p><?php echo $quiz->description; ?></p>
    </div>
    <br>  
</div>

<script>
    $(function(){
       $("a.step").click(function(){
          var step = $(this).data("step"); 
          $(".questions").hide();
          $(".questions#"+step).show();
          console.log(step);
       }); 
    });
</script>

<?php
/*
 * Mostrar pregunta a pregunta todas las questions del quiz
 */

$questions_ids = ClipitQuiz::get_quiz_questions($id_quiz); 
$questions = ClipitQuizQuestion::get_by_id($questions_ids, true);
$i = 1;

foreach ($questions as $question) :
    $id_quest = $question->id;
    $type = $question->option_type;
    $oa = $question->option_array;

?>

<div class="questions" id="<?php echo $i;?>" style="<?php echo $i>1 ? "display:none": ""; ?>">

    <div class="info-block">
            <h4>
                 <?php echo $question->name;?>
            </h4>
            <p>
                <?php echo $question->description;?>
            </p> 
    </div>
    
    <div class="answers-block">
        
        <?php 
          switch ($type) {
              case ClipitQuizQuestion::TYPE_STRING:?>
                    <div class="qqt" id="d">
                        <br><?php echo elgg_view('input/longtext',array('name' => 'd_resp')); ?>
                    </div><br><br>
                  <?php break;
              //*******************************************************************************************
              case ClipitQuizQuestion::TYPE_TRUE_FALSE:?>              
                     <div class="qqt" id="vof" style="margin-left: 30px;">
                        <br><input type="radio" name="<?php echo "vof_{$id_quest}"?>" value="1">
                        <?php
                        echo elgg_view('output/text', array('value' => $oa[0]));
                        ?>
                        <br><input type="radio" name="<?php echo "vof_{$id_quest}"?>" value="2">
                        <?php
                        echo elgg_view('output/text', array('value' => $oa[1]));
                        ?>
                    </div><br><br>
                  <?php break;
              //*******************************************************************************************
              case ClipitQuizQuestion::TYPE_SELECT_ONE:?>
                 <div class="qqt" id="m1" style="margin-left: 30px;">
                        <br><input type="radio" name="<?php echo "m1_{$id_quest}"?>" value="1">
                        <?php
                        echo elgg_view('output/text', array('value' => $oa[0]));
                        ?>
                        <br><input type="radio" name="<?php echo "m1_{$id_quest}"?>" value="2">
                        <?php
                        echo elgg_view('output/text', array('value' => $oa[1]));
                        ?> 
                        <br><input type="radio" name="<?php echo "m1_{$id_quest}"?>" value="3">
                        <?php
                        echo elgg_view('output/text', array('value' => $oa[2]));
                        //Si tiene mas de 3 respuestas:
                        if ($oa[3]) { ?>
                            <br><input type="radio" name="<?php echo "m1_{$id_quest}"?>" value="4">
                            <?php
                            echo elgg_view('output/text', array('value' => $oa[3]));
                            ?>         
                        <?php }

                        if ($oa[4]) { ?>
                            <br><input type="radio" name="<?php echo "m1_{$id_quest}"?>" value="5"> 
                            <?php
                                echo elgg_view('output/text', array('value' => $oa[4]));              
                        } ?>
                 </div><br><br>
                 <?php break;
            //****************************************************************************
            case ClipitQuizQuestion::TYPE_SELECT_MULTI:?>
                 <div class="qqt" id="m" style="margin-left: 30px;">
                        <br><input type="checkbox" name="<?php echo "m_{$id_quest}[]"?>" value="1">
                        <?php
                        echo elgg_view('output/text', array('value' => $oa[0]));
                        ?>
                        <br><input type="checkbox" name="<?php echo "m_{$id_quest}[]"?>" value="2">
                        <?php
                        echo elgg_view('output/text', array('value' => $oa[1]));
                        ?> 
                        <br><input type="checkbox" name="<?php echo "m_{$id_quest}[]"?>" value="3">
                        <?php
                        echo elgg_view('output/text', array('value' => $oa[2]));

                        if ($oa[3]) { ?>
                            <br><input type="checkbox" name="<?php echo "m_{$id_quest}[]"?>" value="4">
                            <?php
                            echo elgg_view('output/text', array('value' => $oa[3]));
                        }

                        if ($oa[4]) { ?>
                            <br><input type="checkbox" name="<?php echo "m_{$id_quest}[]"?>" value="5"> 
                            <?php
                            echo elgg_view('output/text', array('value' => $oa[4]));
                        } ?>
                 </div><br><br>
                 <?php break;
              //**************************************************************************
              default:?>
      
                  <?php break;
          } //FIN DEL SWITCH
          
     ?>
       </div>
    <div class="buttons">
     <?php     
     
          $x = $i;
          
          //Si NO es ni la primera ni la última pregunta
          if($i < count($questions) && $i > 1){ 
              //Muestro los botones anterior y siguiente 
              echo elgg_view('output/url', array(
                        "href" => "javascript:;", 
                        "class" => "elgg-button step",
                        "text" => "Anterior",
                        "data-step" => $x-1,
                ));
              
              echo elgg_view('output/url', array(
                        "href" => "javascript:;", 
                        "class" => "elgg-button step",
                        "text" => "Siguiente -->",
                        "data-step" => $x+1,
                )) . "<br>";
              
           //Si es la primera pregunta    
          } elseif ($i == 1) {
              //Muestro el botón siguiente
              echo elgg_view('output/url', array(
                        "href" => "javascript:;", 
                        "class" => "elgg-button step",
                        "text" => "Siguiente -->",
                        "data-step" => $x+1,
                )) . "<br>";
              
           //Si es la última pregunta   
          } else { 
              //Muestro los botones anterior y terminar
              echo elgg_view('output/url', array(
                            "href" => "javascript:;", 
                            "class" => "elgg-button step",
                            "text" => "Anterior",
                            "data-step" => $x-1,
                    ));
              echo " ";
              echo elgg_view('output/url', array(
                            "href" => $view_quiz_url, 
                            "class" => "elgg-button-action step",
                            "text" => "Terminar",
                    )) . "<br>";
          }
      ?></div>
</div>
    <?php
          
    $i ++;
    endforeach; 
?>