<?php

// Obtener la pregunta y todas sus propiedades
$id = get_input('id_quest');
$quest = array_pop(ClipitQuizQuestion::get_by_id(array($id)));
$owner_id = elgg_get_logged_in_user_guid();
$user = array_pop(ClipitUser::get_by_id(array($owner_id)));
$respuestas = $quest->option_array;
$correctas = $quest->validation_array;
$answers = ClipitQuizQuestion::get_quiz_results($id);

?>

<div class="question">
    
        <div class="content-block">
            <h4>Difficulty:
                 <?php 
                        echo elgg_view('output/text', array('value' => $quest->difficulty));?>
            </h4>
            <br>   
            
            <p><strong>Question type: </strong>
                 <?php echo elgg_view('output/text', array('value' => $quest->option_type)); ?>
            </p>
            
            <div>
                <?php echo elgg_view('output/text', array('value' => $quest->description));?>
            </div>
            <br>
            
            <div>
                <?php 
                // Mostrar las posibles respuestas a elegir
                if ($quest->option_type !== ClipitQuizQuestion::TYPE_STRING){
                    foreach ($respuestas as $r) {
                         echo elgg_view('output/text', array('value' => $r)) . "<br>";
                    };
                };  
                ?>
            </div>
            <br>
            
            <p>
                <?php 
                
                switch ($quest->option_type) {
                    case ClipitQuizQuestion::TYPE_SELECT_MULTI:
                        echo "Las soluciones correctas son: ";
                        $i = 0;
                        while ($i < count($respuestas)) {
                            if ($correctas[$i] == "true"){
                                echo  $respuestas[$i] . ", ";
                            }
                        $i ++;
                        }
                        break;

                    case ClipitQuizQuestion::TYPE_STRING:
                        echo "Una posible solución correcta es: " .  $respuestas[0] . ".";
                        break;
                    
                    case ClipitQuizQuestion::TYPE_TRUE_FALSE:
                        if ($respuestas == 1){
                        $sol = "Verdadera";
                        } else {
                            $sol = "Falsa";
                        }
                        echo "La respuesta correcta es: " .  $sol;
                        break;
                    
                    default:
                        echo "La solución correcta es: ";  
                        $i = 0;
                        while ($i < count($respuestas)) {
                            if ($correctas[$i] == "true"){
                                echo  $respuestas[$i] . ".";
                            }
                        $i ++;
                        }
                        break;
                }
                /*
                // Mostrar cual/cuales son las soluciones correctas
                if ($quest->option_type == ClipitQuizQuestion::TYPE_SELECT_MULTI){
                    echo "Las soluciones correctas son: ";
                    $i = 0;
                    while ($i < count($respuestas)) {
                        if ($correctas[$i] == "true"){
                            echo  $respuestas[$i] . ", ";
                        }
                    $i ++;
                    }
                    
                } elseif ($quest->option_type == ClipitQuizQuestion::TYPE_STRING) {
                    echo "Una posible solución correcta es: " .  $respuestas[0];
                } elseif ($quest->option_type == ClipitQuizQuestion::TYPE_TRUE_FALSE) {
                    if ($respuestas == 1){
                        $sol = "Verdadera";
                    } else {
                        $sol = "Falsa";
                    }
                    echo "La respuesta correcta es: " .  $sol;
                } else {
                    echo "La solución correcta es: ";  
                    $i = 0;
                    while ($i < count($respuestas)) {
                        if ($correctas[$i] == "true"){
                            echo  $respuestas[$i] . ".";
                        }
                    $i ++;
                    }
                }*/
                ?>
            </p>
            
            <small>
                <i>Creada por <?php echo elgg_view('output/text', array('value' => $user->name)) . " "
                                . elgg_view('output/friendlytime', array('time' => $quest->time_created));?></i>
            </small>
            <br><br>
        </div>
</div>

<div>
    <h2>Respuestas</h2>
</div>

<?php
if (sizeof($answers) > 0){

    if (($quest->option_type == ClipitQuizQuestion::TYPE_STRING)){
    $all_checked = have_been_checked($answers, $all_checked);
    if ( !$all_checked ){
        echo elgg_view('output/url', 
           array(
                "href" => elgg_get_site_url()."quizzes/students_list?id_quest={$quest->id}", 
                "is_action" => false,
                "text" => "Hay respuestas sin corregir",
               ));
    }
    }
}

foreach($answers as $ans):

    $a = array_pop(ClipitQuizResult::get_by_id(array($ans)));

    $view_quest_url = elgg_get_site_url()."questions/view?id_quest={$a->id}";
    $edit_quest_url = elgg_get_site_url()."questions/edit?id_quest={$a->id}";
    $remove_quest_url = elgg_get_site_url()."action/questions/remove?id_quest={$a->id}";
   
   ?>

<div class="answers">

        <div class="content-block">
            <p>
                <?php   echo "Identificador respuesta = " . $a->id;
                ?>
            </p>
            <h3>
                 <?php echo elgg_view('output/url', array(
                            "href" => $view_quest_url,
                            "is_action" => false,
                            "text" => $a->name,
                        ));
                ?>
            </h3>

            <small>
                <i>Creada <?php echo elgg_view('output/friendlytime', array('time' => $a->time_created));?></i>
            </small>
        </div>
    <div class="options">

        <a href="<?php echo $edit_quest_url ?>">
                <img src="<?php echo elgg_get_site_url() . "mod/z11_clipit_quiz/graphics/edit.png" ?>" title="Editar"></a>

        <a href="<?php echo $remove_quest_url ?>">
                <img src="<?php echo elgg_get_site_url() . "mod/z11_clipit_quiz/graphics/eliminar.png" ?>" title="Eliminar"></a>

        <br><br>
        
    </div>
</div>
        

<?php endforeach ?>