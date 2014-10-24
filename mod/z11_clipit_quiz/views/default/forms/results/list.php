<?php
use ClipitTrickyTopic;

$id_quiz = get_input('id_quiz');
$quiz = array_pop(ClipitQuiz::get_by_id(array($id_quiz)));

//Obtengo el nombre del TT a partir de su ID
$id_tt = $quiz->tricky_topic;
$tt = ClipitTrickyTopic::get_by_id(array($id_tt));
?>

<div class="quiz">

    <div class="body">
        <p><strong>Tricky topic: </strong>
            <?php echo $tt[$id_tt]->name; ?>
        </p>
        <p><?php echo $quiz->description; ?></p>
    </div>
    <br>  

</div>

<?php
$questions = ClipitQuiz::get_quiz_questions($id_quiz);

$num = 1;
foreach($questions as $quest):
    $q = array_pop(ClipitQuizQuestion::get_by_id(array($quest))); 
    $id_quest = $q->id;
    $type = $q-> option_type; //Guardo el tipo de pregunta
    $oa = $q-> option_array; //Guardo el array de respuestas
    $va = $q-> validation_array;
?>

<div class="questions">

    <div class="info-block">
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
              case "Desarrollo":?>
                    <div class="qqt" id="d">
                        <br><?php echo elgg_view('input/longtext',array('name' => "resp_{$id_quest}")); ?>
                    </div>
                  <?php break;
              //*******************************************************************************************
              case "Verdadero o falso":?>              
                     <div class="qqt" id="vof" style="margin-left: 30px;">
                        <br><input type="radio" name="<?php echo "vof_{$id_quest}"?>" value="1">
                        <?php
                        echo elgg_view('output/text', array('value' => $oa[0]));
                        ?>
                        <br><input type="radio" name="<?php echo "vof_{$id_quest}"?>" value="2">
                        <?php
                        echo elgg_view('output/text', array('value' => $oa[1]));
                        ?>
                    </div>
                  <?php break;
              //*******************************************************************************************
              case "One choice":?>
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
                 </div>
                 <?php break;
            //****************************************************************************
            case "Multiple choice":?>
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
                 </div>
                 <?php break;
              //**************************************************************************
              default:?>
                  <?php break;
          } //FIN DEL SWITCH
          
        ?>
        <br>
    </div>
</div> 

<?php 
    $num ++;
    endforeach;
?>

<div><?php
    echo elgg_view('input/submit', array(
			'value' => "Terminar",
		));
    echo elgg_view('input/hidden', array(
			'name' => 'id_quiz',
			'value' => $id_quiz,
		));
    ?>
</div>