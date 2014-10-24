<?php

use ClipitTrickyTopic;

$quiz = elgg_extract('entity', $vars);
$id = elgg_extract('id', $vars);

$do_quiz_url = elgg_get_site_url()."results/do_quiz?id_quiz={$id}&option=list";
if ($quiz->view_mode == "paged"){
    $do_quiz_url = elgg_get_site_url()."results/do_quiz?id_quiz={$id}&option=paged";
}
//$all = ClipitQuizResult::get_all();
//var_dump($all);
$results_url = elgg_get_site_url()."results/results?id_quiz={$id}";

//Obtengo el nombre del TT a partir de su ID
$id_tt = $quiz->tricky_topic;
$tt = ClipitTrickyTopic::get_by_id(array($id_tt));
?>

<div class="quiz">
    
        <div class="content-block">

            <div class="body">
                <p><strong>Tricky topic: </strong>
                    <?php 
                        echo elgg_view('output/text', array('value' => $tt[$id_tt]->name));?>
                </p>
                <p><?php echo $quiz->description;?></p>
            </div>
            <br>        

            <small class="show">
                <i>Creado por <?php echo elgg_view('output/text', array('value' => $quiz->author_name)) . " "
                                 . elgg_view('output/friendlytime', array('time' => $quiz->time_created));?>
                </i>
            </small>
            <br><br>
            <p>
                <?php
            echo "<a href='$do_quiz_url' class='elgg-button'>
                Do quiz
            </a>";
                    ?>
            </p>

            <p>
                <?php
            echo "<a href='$results_url' class='elgg-button'>
                View results
            </a>";
                    ?>
            </p>
            
            <br>
        </div>
</div>