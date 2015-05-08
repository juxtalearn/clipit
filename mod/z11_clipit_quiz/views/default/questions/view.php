<?php

// Obtener la pregunta y todas sus propiedades
$id = get_input('id_quest');
$quest = array_pop(ClipitQuizQuestion::get_by_id(array($id)));
$owner_id = elgg_get_logged_in_user_guid();
$user = array_pop(ClipitUser::get_by_id(array($owner_id)));
$respuestas = $quest->option_array;
$correctas = $quest->validation_array;

//Enlaces para vew, editar y eliminar una pregunta
    $edit_quest_url = elgg_get_site_url()."questions/edit?id_quest={$id}";
    $remove_quest_url = elgg_get_site_url()."action/questions/remove?id_quest={$id}";
?>
<div id="question" class="row">
    <div class="info-block col-xs-12 col-md-8">
        <p id="quest-difficulty"><strong>Dificultad: <?php echo $quest->difficulty;?></strong></p>      
        <p id="quest-tt"><strong>Tipo de pregunta: </strong>
             <?php echo elgg_view('output/text', array('value' => $quest->option_type)); ?>
        </p>
        <div id="quest-description" class="well text-justify"><p><?php echo $quest->description;?></p>
        
        <?php // Mostrar las opciones a elegir solo para select_one y select_multi como parte del enunciado
            if ( ($quest->option_type == ClipitQuizQuestion::TYPE_SELECT_ONE) || ($quest->option_type == ClipitQuizQuestion::TYPE_SELECT_MULTI)){
                echo '<div id="quest-options">';
                foreach ($respuestas as $r) {
                    echo '<p style="margin-left: 30px;">'.$r.'</p>';
                }
                echo '</div>';
            }
        echo '</div>';  //Cerrar #quest-description
        //
        //Mostrar las soluciones correctas aportadas por el profesor
        echo '<div id="quest-solution" class="text-justify">';
            switch ($quest->option_type) {
                
                case ClipitQuizQuestion::TYPE_STRING:
                    echo "<p><strong>Una posible solución correcta es: </strong>" .  $respuestas[0] . ".</p>";
                    break;

                case ClipitQuizQuestion::TYPE_TRUE_FALSE:
                    if ($respuestas == 1){
                        $sol = "Verdadero";
                    } else {
                        $sol = "Falso";
                    }
                    echo '<p><strong>La respuesta correcta es: </strong>'.$sol.'</p>';
                    break;
                
                case ClipitQuizQuestion::TYPE_SELECT_MULTI:
                    echo "<p><strong>Las soluciones correctas son:</strong></p>";
                    $i = 0;
                    while ($i < count($respuestas)) {
                        if ($correctas[$i] == "true"){
                            echo  '<p style="margin-left: 30px;">'.$respuestas[$i] . '</p>';
                        }
                        $i ++;
                    }
                    break;

                default:
                    echo "<p><strong>La solución correcta es: </strong>";  
                    $i = 0;
                    while ($i < count($respuestas)) {
                        if ($correctas[$i] == "true"){
                            echo  $respuestas[$i] . "</p>";
                        }
                        $i ++;
                    }
                    break;
            }
        echo '</div>';  //Cerrar #quest-solution
       
        //Autor y tiempo
        $time_created = elgg_view("output/friendlytime", array('time' => $quest->time_created));
        echo '<small class="show">Creada por ';
        echo '<span title="Profesor: '.$user->name.'" class="admin-owner" rel="nofollow"><i class="fa fa-fw fa-user"></i>'.$user->name.'</span>';
        echo ' '.$time_created.'</small>';
        ?>
    </div>  <!-- ./info-block -->
    
    <div id="buttons" class="col-xs-12 col-md-4" style="text-align: right;">
        <?php //Si el usuario tiene permisos para editar y eliminar la pregunta
            if ($owner_id === $quest->owner_id){
                echo '<div id="edit-button" style="margin-bottom: 5px;">';
                echo '<a href="'.$edit_quest_url.'" class="btn btn-primary btn-sm" title="Editar"><i class="fa fa-fw fa-pencil fa-lg" aria-hidden="true"></i> Editar</a>';
                echo '</div>';
                echo '<div id="delete-button">';
                echo elgg_view("output/url", array(
                         "type" => "button",
                         "href" => $remove_quest_url, 
                         "is_action" => true,
                         "class" => "btn btn-primary btn-sm",
                         "title" => "Eliminar",
                         "style" => "padding-left: 3px;",
                         "text" => '<i class="fa fa-fw fa-trash-o fa-lg" aria-hidden="true"></i> Eliminar',
                         "onclick" => 'javascript:return confirmar("¿Está seguro de que desea eliminar la pregunta?");',
                    ));
                echo '</div>';
            }
        ?>
    </div>  <!-- ./buttons -->
</div>  <!-- ./question -->

<div id="statictics" class="row">
    <h3 class="page-header text-center">Estadísticas <i class="fa fa-bar-chart-o" title="Estadísticas"></i></h3>
    <?php 
        $answers = ClipitQuizQuestion::get_quiz_results($id); //Array de respuestas a una pregunta
        $num_answers = count($answers);
        $num_correct = 0;
        $num_incorrect = 0;
        $num_p = 0;
        foreach ($answers as $id_answer) {
            $result = array_pop(ClipitQuizResult::get_by_id(array($id_answer)));
            if ($result->correct){
                $num_correct ++;
            } else {
                //Si es de desarrollo y esta pendiente de corregir, mostrar como pendiente
                if ( ($quest->option_type == ClipitQuizQuestion::TYPE_STRING) && ($result->description == NULL)){
                    $num_p ++;
                } else {
                    $num_incorrect ++;
                }
            }
        }
        
        $porcentaje_correct = ($num_correct*100)/$num_answers;
        $porcentaje_incorrect = ($num_incorrect*100)/$num_answers;
        $porcentaje_p = ($num_p*100)/$num_answers;
        
        echo '<p class="text-center"><strong>Hay un total de '.$num_answers.' respuestas</strong></p>';
        
        echo '<div class="col-xs-6 col-md-8">';
        echo '<div class="progress progress-striped active" style="margin-bottom: 10px;">
                <div class="progress-bar progress-bar-success" role="progressbar"
                     aria-valuenow="'.$porcentaje_correct.'" aria-valuemin="0" aria-valuemax="100"
                     style="width: '.$porcentaje_correct.'%; background-color: #5cb85c;">
                  <span>'.$porcentaje_correct.'% correctas</span>
                </div>
              </div>';
        if ($num_p > 0){
            echo '<div class="progress progress-striped active" style="margin-bottom: 10px;">
                <div class="progress-bar progress-bar-info" role="progressbar"
                     aria-valuenow="'.$porcentaje_p.'" aria-valuemin="0" aria-valuemax="100"
                     style="width: '.$porcentaje_p.'%; background-color: #f0ad4e;">
                  <span>'.$porcentaje_p.'% pendientes</span>
                </div>
              </div>';
        }
        echo '<div class="progress progress-striped active">
                <div class="progress-bar progress-bar-danger" role="progressbar"
                     aria-valuenow="'.$porcentaje_incorrect.'" aria-valuemin="0" aria-valuemax="100"
                     style="width: '.$porcentaje_incorrect.'%; background-color: #d9534f;">
                  <span>'.$porcentaje_incorrect.'% incorrectas</span>
                </div>
              </div>';
        echo '</div>';
        echo '<div class="col-xs-6 col-md-4">';
            echo '<p>'.$num_correct.' respuestas correctas</p>';
            if ($num_p > 0){
                echo '<p>'.$num_p.' respuestas pendientes de corregir</p>';
            }
            echo '<p>'.$num_incorrect.' respuestas incorrectas</p>';
        echo '</div>';
    ?>
</div>

<script language="JavaScript">
    function confirmar (mensaje) {
        return confirm(mensaje);
    } 
</script>