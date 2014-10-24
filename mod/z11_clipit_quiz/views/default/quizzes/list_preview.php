<?php

use ClipitTrickyTopic;

$quiz = elgg_extract('entity', $vars);
$id = elgg_extract('id', $vars);
$view_quiz_url = elgg_get_site_url()."quizzes/view?id_quiz={$id}";

$questions = ClipitQuiz::get_quiz_questions($id);

//Obtengo el nombre del TT a partir de su ID
$id_tt = $quiz->tricky_topic;
$tt = ClipitTrickyTopic::get_by_id(array($id_tt));
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
$num = 1;
foreach($questions as $quest):
    $q = array_pop(ClipitQuizQuestion::get_by_id(array($quest))); 
    $type = $q-> option_type; //Guardo el tipo de pregunta
    $oa = $q-> option_array; //Guardo el array de respuestas
    $va = $q-> validation_array; //Guardo el array de validacion de respuestas
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
              case "Desarrollo":
                  //No mostrar nada ?>
                  <?php break;
              //*******************************************************************************************
              case "Verdadero o falso":?>              
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
              case "One choice":?>
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
            case "Multiple choice":?>
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