<?php

// Obtengo el quiz y su ID
$id_quiz = get_input('id_quiz');
$quiz = array_pop(ClipitQuiz::get_by_id(array($id_quiz)));

//Obtengo el TrickyTopic del quiz
$id_tt = $quiz->tricky_topic;
$tt = ClipitTrickyTopic::get_by_id(array($id_tt));
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

$questions_ids = ClipitQuiz::get_quiz_questions($id_quiz);
$questions = ClipitQuizQuestion::get_by_id($questions_ids, true);
$i = 1;

foreach ($questions as $question) :
    $type = $question->option_type;
    $oa = $question->option_array;
    $id_quest = $question->id;

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
                        <br><?php echo elgg_view('input/longtext',array('name' => "dr_{$id_quest}")); ?>
                    </div><br><br>
                  <?php break;
              //*******************************************************************************************
              case ClipitQuizQuestion::TYPE_NUMBER:?>
                    <div class="qqt" id="n">
                        <br><?php echo elgg_view('input/text',array('name' => "nr_{$id_quest}")); ?>
                    </div><br><br>
                  <?php break;
              //*******************************************************************************************
              case ClipitQuizQuestion::TYPE_TRUE_FALSE:?>              
                     <div class="qqt" id="vof" style="margin-left: 30px;">
                        <br><input type="radio" name="<?php echo "vof_{$id_quest}"?>" value="1">
                        <input type="radio" name="<?php echo "vof_{$id_quest}"?>" value="2"><br>
                    </div>
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
          
          $x = $i;
          if($i < count($questions) && $i > 1){        //Si No es ni la primera ni la última pregunta
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
                ));
          } elseif ($i == 1) {                         //Si es la primera pregunta
              echo elgg_view('output/url', array(
                        "href" => "javascript:;", 
                        "class" => "elgg-button step",
                        "text" => "Siguiente -->",
                        "data-step" => $x+1,
                ));
          } else {                                     //Si es la última pregunta
              echo elgg_view('output/url', array(
                            "href" => "javascript:;", 
                            "class" => "elgg-button step",
                            "text" => "Anterior",
                            "data-step" => $x-1,
                    ));
              echo elgg_view('input/submit', array(
                        'value' => "Terminar",
                    ));
          }
      ?></div></div>
    <?php
          
    $i ++;
    endforeach; 
?>

<div><?php
    echo elgg_view('input/hidden', array(
            'name' => 'id_quiz',
            'value' => $id_quiz,
            ));
    ?>
</div>