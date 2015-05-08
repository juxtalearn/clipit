<?php

// Obetner la pregunta, su tipo y su array de respuestas 
$id = get_input('id_quest');
$quest = get_entity($id);
$respuestas = $quest->option_array;    
$quest_type = $quest->option_type;

// Obtener el ID del quiz asociado (si lo tiene)
$id_quiz = get_input('id_quiz');

//La pregunta NO se edita desde la vista de un quiz
if (!$id_quiz){ 
    $cancel_url = elgg_get_site_url()."questions/all";
    $limpiar_url = elgg_get_site_url()."questions/edit?id_quest={$id}";
    
//La pregunta SI se edita desde la vista de un quiz
} else { 
    $cancel_url = elgg_get_site_url()."quizzes/view?id_quiz={$id_quiz}";
    $limpiar_url = elgg_get_site_url()."questions/edit?id_quest={$id}&id_quiz={$id_quiz}";
}

?>
<div id="quest-tt" class="form-group">
    <label class="control-label">Tricky topic</label>
    <?php 
        $tt_array = ClipitTrickyTopic::get_all();
        foreach($tt_array as $tt){
            $tt_values[$tt->id] = $tt->name;
            //AQUI sacar los tags de un tt
        }
        echo elgg_view('input/pulldown', array(
                    'name' => 'topic',
                    'class' => 'form-control',
                    'options_values' => $tt_values,
                    'style' => 'padding-top: 5px; padding-bottom: 5px;'
                ));
    ?>
</div>

<div id="quest-tag" class="form-group">
    <label class="control-label">Etiqueta</label>
    <?php 
        $tag_array = ClipitTag::get_all();
        foreach($tag_array as $tag){
            $tag_values[$tag->id] = $tag->name;
        }
        echo elgg_view('input/pulldown', array(
			'name' => 'tags[]',
                        'class' => 'form-control',
			'options_values' => $tag_values,
                        'style' => 'padding-top: 5px; padding-bottom: 5px;'
                    ));
    ?>
</div>

<div id="quest-title" class="form-group">
    <label class="control-label">Título</label>
    <?php echo elgg_view('input/text', array(
                    'internalname' => 'title',
                    'class' => 'form-control',
                    'value' => $quest->name,
                ));
    ?>
</div>

<div id="quiz-description" class="form-group">
    <label class="control-label">Enunciado</label>
    <?php echo elgg_view('input/longtext', array(
                    'name' => 'enunciado',
                    'class' => 'form-control',
                    'value' => $quest->description,
                ));?>
</div>

<div id="quest-difficulty" class="form-group">
    <label class="control-label">Dificultad</label>
    <?php echo elgg_view('input/text',array(
                    'name' => 'dif',
                    'class' => 'form-control',
                    'value' => $quest->difficulty,
                )); 
    ?>
</div>

<div id="quest-type" class="form-group">
    <?php
    switch ($quest_type) {
        case ClipitQuizQuestion::TYPE_STRING:
            echo '<label class="control-label">Tipo de respuesta: Long Question</label>';
            echo '<div class="qqt" id="'.ClipitQuizQuestion::TYPE_STRING.'">';
                echo '<label class="control-label">Respuesta</label>';
                echo elgg_view('input/longtext', array(
                            'name' => 'dr',
                            'class' => 'form-control',
                            'value' => $respuestas
                        ));
            echo '</div>';
            break;
            //******************************************************************
        case ClipitQuizQuestion::TYPE_NUMBER:
            echo '<label class="control-label">Tipo de respuesta: Numeric Question</label>';
            echo '<div class="qqt" id="'.ClipitQuizQuestion::TYPE_NUMBER.'">';
                echo '<label class="control-label">Respuesta</label>';
                echo elgg_view('input/text', array(
                            'name' => 'nr',
                            'class' => 'form-control',
                            'value' => $respuestas
                        ));
            echo '</div>';
            break;
            //******************************************************************
        case ClipitQuizQuestion::TYPE_TRUE_FALSE:
            echo '<label class="control-label">Tipo de respuesta: True or False Question</label>';
            echo '<div class="qqt" id="'.ClipitQuizQuestion::TYPE_TRUE_FALSE.'">';
                echo '<div class="radio" style="margin-left: 30px;">
                        <label>
                            <input type="radio" name="vof_ca" value="1"> Verdadera
                        </label>
                    </div>';
                echo '<div class="radio" style="margin-left: 30px;">
                        <label>
                            <input type="radio" name="vof_ca" value="2"> Falsa
                        </label>
                    </div>';
            echo '</div>';
            break;
            //******************************************************************
        case ClipitQuizQuestion::TYPE_SELECT_ONE:
            echo '<label class="control-label">Tipo de respuesta: One Choice Question</label>';
            echo '<div class="qqt" id="'.ClipitQuizQuestion::TYPE_SELECT_ONE.'">';
                echo '<div id="R1" class="form-group">
                        <label class="control-label">Respuesta 1</label>
                        <div class="col-md-9">
                            <input type="text" name="m1_resp1" class="form-control" value="'.$respuestas[0].'">
                        </div>
                        <div class="col-md-3">
                            <div class="radio">
                                <label><input type="radio" name="m1_ca" value="1"> Selecciona la correcta</label>
                            </div>
                        </div>
                    </div>';
                
                echo '<div id="R2" class="form-group">
                        <label class="control-label">Respuesta 2</label>
                        <div class="col-md-9">
                            <input type="text" name="m1_resp2" class="form-control" value="'.$respuestas[1].'">
                        </div>
                        <div class="col-md-3">
                            <div class="radio">
                                <label><input type="radio" name="m1_ca" value="2"> Selecciona la correcta</label>
                            </div>
                        </div>
                    </div>';
                
                echo '<div id="R3" class="form-group">
                        <label class="control-label">Respuesta 3</label>
                        <div class="col-md-9">
                            <input type="text" name="m1_resp3" class="form-control" value="'.$respuestas[2].'">
                        </div>
                        <div class="col-md-3">
                            <div class="radio">
                                <label><input type="radio" name="m1_ca" value="3"> Selecciona la correcta</label>
                            </div>
                        </div>
                    </div>';
                
                if ($respuestas[3]) {
                    echo '<div id="R4" class="form-group">
                        <label class="control-label">Respuesta 4</label>
                        <div class="col-md-9">
                            <input type="text" name="m1_resp4" class="form-control" value="'.$respuestas[3].'">
                        </div>
                        <div class="col-md-3">
                            <div class="radio">
                                <label><input type="radio" name="m1_ca" value="4"> Selecciona la correcta</label>
                            </div>
                        </div>
                    </div>';
                }
                
                if ($respuestas[4]) {
                    echo '<div id="R5" class="form-group">
                        <label class="control-label">Respuesta 5</label>
                        <div class="col-md-9">
                            <input type="text" name="m1_resp5" class="form-control" value="'.$respuestas[4].'">
                        </div>
                        <div class="col-md-3">
                            <div class="radio">
                                <label><input type="radio" name="m1_ca" value="5"> Selecciona la correcta</label>
                            </div>
                        </div>
                    </div>';
                }
            echo '</div>';
            break;
            //******************************************************************
        case ClipitQuizQuestion::TYPE_SELECT_MULTI:
            echo '<label class="control-label">Tipo de respuesta: Multiple Choice Question</label>';
            echo '<div class="qqt" id="'.ClipitQuizQuestion::TYPE_SELECT_MULTI.'">';
                echo '<div id="mR1" class="form-group">
                        <label class="control-label">Respuesta 1</label>
                        <div class="col-md-9">
                            <input type="text" name="m_resp1" class="form-control" value="'.$respuestas[0].'">
                        </div>
                        <div class="col-md-3">
                            <div class="checkbox">
                                <label><input type="checkbox" name="m_ca[]" value="1"> Selecciona la correcta</label>
                            </div>
                        </div>
                    </div>';
                
                echo '<div id="mR2" class="form-group">
                        <label class="control-label">Respuesta 2</label>
                        <div class="col-md-9">
                            <input type="text" name="m_resp2" class="form-control" value="'.$respuestas[1].'">
                        </div>
                        <div class="col-md-3">
                            <div class="checkbox">
                                <label><input type="checkbox" name="m_ca[]" value="2"> Selecciona la correcta</label>
                            </div>
                        </div>
                    </div>';
                
                echo '<div id="mR3" class="form-group">
                        <label class="control-label">Respuesta 3</label>
                        <div class="col-md-9">
                            <input type="text" name="m_resp3" class="form-control" value="'.$respuestas[2].'">
                        </div>
                        <div class="col-md-3">
                            <div class="checkbox">
                                <label><input type="checkbox" name="m_ca[]" value="3"> Selecciona la correcta</label>
                            </div>
                        </div>
                    </div>';
                
                if ($respuestas[3]) {
                    echo '<div id="mR4" class="form-group">
                            <label class="control-label">Respuesta 4</label>
                            <div class="col-md-9">
                                <input type="text" name="m_resp4" class="form-control" value="'.$respuestas[3].'">
                            </div>
                            <div class="col-md-3">
                                <div class="checkbox">
                                    <label><input type="checkbox" name="m_ca[]" value="4"> Selecciona la correcta</label>
                                </div>
                            </div>
                        </div>';
                }
                
                if ($respuestas[4]) {
                    echo '<div id="mR5" class="form-group">
                            <label class="control-label">Respuesta 5</label>
                            <div class="col-md-9">
                                <input type="text" name="m_resp5" class="form-control" value="'.$respuestas[4].'">
                            </div>
                            <div class="col-md-3">
                                <div class="checkbox">
                                    <label><input type="checkbox" name="m_ca[]" value="5"> Selecciona la correcta</label>
                                </div>
                            </div>
                        </div>';
                }
             echo '</div>';
             break;
            //******************************************************************
        default:
                echo elgg_view('input/pulldown', array(
			'name' => 'empty_ans',
                        'class' => 'form-control',
			'options_values' => array(
                                '' => "-- Elige el tipo de respuesta --",
                                ClipitQuizQuestion::TYPE_STRING => "Long question",
                                ClipitQuizQuestion::TYPE_NUMBER => "Numeric question",
                                ClipitQuizQuestion::TYPE_TRUE_FALSE => "True or false",
				ClipitQuizQuestion::TYPE_SELECT_ONE => "One choice",
                                ClipitQuizQuestion::TYPE_SELECT_MULTI => "Multiple choice",
                          ),	
                        'onchange' => 'javascript:on_change_type(this.value);',
                        'style' => 'padding-top: 5px; padding-bottom: 5px;'
			));
                break;
    }
?>
</div> <!-- ./#question-type -->

<script>
    function on_change_type(value){
        $(".qqt").hide();
        $("#"+ value).show();
    }
</script>

<?php
/* Considero que pueda editar una pregunta vacia (no habia selecionado un tipo) 
 * Por lo que muestro un formulario como el de crear una nueva                  */
if($quest_type == ""){   
?>

<div class="qqt form-group" id="<?php echo ClipitQuizQuestion::TYPE_STRING;?>" style="display:none;">
    <label class="control-label">Respuesta</label>
    <?php echo elgg_view('input/longtext',array('name' => 'd_resp', 'class' => 'form-control')); ?>
    <br>
</div>

<div class="qqt form-group" id="<?php echo ClipitQuizQuestion::TYPE_NUMBER;?>" style="display:none;">
    <label class="control-label">Respuesta</label>
    <?php echo elgg_view('input/text',array('name' => 'n_resp', 'class' => 'form-control')); ?>
    <br>
</div>

<div class="qqt form-group" id="<?php echo ClipitQuizQuestion::TYPE_TRUE_FALSE;?>" style="display:none;">
    <div class="radio" style="margin-left: 30px;">
        <label>
            <input type="radio"  name="vof_ca" value="1"> Verdadera
        </label>
    </div>
    <div class="radio" style="margin-left: 30px;">
        <label>
            <input type="radio"  name="vof_ca" value="2"> Falsa
        </label>
    </div>
</div>

<!-- Permitir añadir más respuestas en tipo Once choice y Multiple choice -->
    <script type="text/javascript">
        function mostrar(clicked_id, r){
            document.getElementById(clicked_id).style.display = 'none';
            document.getElementById(r).style.display = 'block';}
    </script>

<div class="qqt form-group" id="<?php echo ClipitQuizQuestion::TYPE_SELECT_ONE;?>" style="display:none;">
    
    <div id="R1" class="form-group">
        <label class="control-label">Respuesta 1</label>
        <div class="col-md-9">
            <input type="text" name="m1_resp1" class="form-control" placeholder="Respuesta 1">
        </div>
        <div class="col-md-3">
            <div class="radio">
                <label><input type="radio"  name="m1_ca" value="1"> Selecciona la correcta</label>
            </div>
        </div>
    </div>

    <div id="R2" class="form-group">
        <label class="control-label">Respuesta 2</label>
        <div class="col-md-9">
            <input type="text" name="m1_resp2" class="form-control" placeholder="Respuesta 2">
        </div>
        <div class="col-md-3">
            <div class="radio">
                <label><input type="radio"  name="m1_ca" value="2"> Selecciona la correcta</label>
            </div>
        </div>
    </div>
    
    <div id="R3" class="form-group">
        <label class="control-label">Respuesta 3</label>
        <div class="col-md-9">
            <input type="text" name="m1_resp3" class="form-control" placeholder="Respuesta 3">
        </div>
        <div class="col-md-3">
            <div class="radio">
                <label><input type="radio"  name="m1_ca" value="3"> Selecciona la correcta</label>
            </div>
        </div>
    </div>
    
    <!-- Permitir añadir hasta 5 posibles respuestas -->
    <div class="col-md-12" style="margin-top: 10px;">
        <input id='m1R4' type="button" class="btn" value="Añadir otra respuesta" onclick="mostrar(this.id, 'R4')">
    </div>
    
    <div id="R4" class="form-group" style="display:none;">
        <label class="control-label">Respuesta 4</label>
        <div class="col-md-9">
            <input type="text" name="m1_resp4" class="form-control" placeholder="Respuesta 4">
        </div>
        <div class="col-md-3">
            <div class="radio">
                <label><input type="radio" name="m1_ca" value="4"> Selecciona la correcta</label>
            </div>
        </div>
        <div class="col-md-12" style="margin-top: 10px;">
            <input id='masR5' type="button" class="btn" value="Añadir otra respuesta" onclick="mostrar(this.id, 'R5')">
        </div>
    </div>
    
     <div id="R5" class="form-group" style="display:none;">
        <label class="control-label">Respuesta 5</label>
        <div class="col-md-9">
            <input type="text" name="m1_resp5" class="form-control" placeholder="Respuesta 5">
        </div>
        <div class="col-md-3">
            <div class="radio">
                <label><input type="radio" name="m1_ca" value="5"> Selecciona la correcta</label>
            </div>
        </div>
    </div>
</div>

<div class="qqt form-group" id="<?php echo ClipitQuizQuestion::TYPE_SELECT_MULTI;?>" style="display:none;">
    
    <div id="mR1" class="form-group">
        <label class="control-label">Respuesta 1</label>
        <div class="col-md-9">
            <input type="text" name="m_resp1" class="form-control" placeholder="Respuesta 1">
        </div>
        <div class="col-md-3">
            <div class="checkbox">
                <label><input type="checkbox" name="m_ca[]" value="1"> Selecciona la correcta</label>
            </div>
        </div>
    </div>
    
    <div id="mR2" class="form-group">
        <label class="control-label">Respuesta 2</label>
        <div class="col-md-9">
            <input type="text" name="m_resp2" class="form-control" placeholder="Respuesta 2">
        </div>
        <div class="col-md-3">
            <div class="checkbox">
                <label><input type="checkbox" name="m_ca[]" value="2"> Selecciona la correcta</label>
            </div>
        </div>
    </div>
    
    <div id="mR3" class="form-group">
        <label class="control-label">Respuesta 3</label>
        <div class="col-md-9">
            <input type="text" name="m_resp3" class="form-control" placeholder="Respuesta 3">
        </div>
        <div class="col-md-3">
            <div class="checkbox">
                <label><input type="checkbox" name="m_ca[]" value="3"> Selecciona la correcta</label>
            </div>
        </div>
    </div>
    
    <!-- Permitir añadir hasta 5 posibles respuestas -->
    <div class="col-md-12" style="margin-top: 10px;">
        <input id='moR4' type="button" class="btn" value="Añadir otra respuesta" onclick="mostrar(this.id, 'mR4')">
    </div>
    
    <div id="mR4" class="form-group" style="display:none;">
        <label class="control-label">Respuesta 4</label>
        <div class="col-md-9">
            <input type="text" name="m_resp4" class="form-control" placeholder="Respuesta 4">
        </div>
        <div class="col-md-3">
            <div class="checkbox">
                <label><input type="checkbox" name="m_ca[]" value="4"> Selecciona la correcta</label>
            </div>
        </div>
        <div class="col-md-12" style="margin-top: 10px;">
            <input id='moR5' type="button" class="btn" value="Añadir otra respuesta" onclick="mostrar(this.id, 'mR5')">
        </div>
    </div>
    
    <div id="mR5" class="form-group" style="display:none;">
        <label class="control-label">Respuesta 5</label>
        <div class="col-md-9">
            <input type="text" name="m_resp5" class="form-control" placeholder="Respuesta 5">
        </div>
        <div class="col-md-3">
            <div class="checkbox">
                <label><input type="checkbox" name="m_ca[]" value="5"> Selecciona la correcta</label>
            </div>
        </div>
    </div>
</div>
    
<?php 
    } /* Cierre IF respuestas vacias */
?>
    
<div class="col-md-12" style="margin-top: 15px;">
    <?php   echo '<div class="col-xs-4 col-md-2">';
            echo elgg_view('input/submit', array(
                    'value' => elgg_echo("save"),
                    "class" => "btn btn-primary",
            ));
            echo '</div>';
            
            echo '<div class="col-xs-4 col-md-2">';
            echo elgg_view("output/url", 
                array(
                    "href" => $cancel_url, 
                    "is_action" => false,
                    "class" => "btn btn-warning",
                    "text" => "Cancelar",
                    "onclick" => 'javascript:return confirmar("¿Está seguro que desea cancelar la pregunta?");',
                    ));
            echo '</div>';
            
            echo '<div class="col-xs-4 col-md-2">';
            echo elgg_view("output/url",array(
                        "href" => "javascript:;", 
                        "is_action" => false,
                        "class" => "btn btn-success",
                        "text" => "Borrar",
                        "onclick" => 'javascript:limpiar();',
                        ));
            echo '</div>';
            
            echo elgg_view('input/hidden', array(
			'name' => 'id_quest',
			'value' => $id,
		));
            echo elgg_view('input/hidden', array(
			'name' => 'ta',
                        'value' => $quest_type,
		));
    ?> 
</div>

<script language="JavaScript">
    function confirmar (mensaje) {
        return confirm(mensaje);
    }

    function limpiar(){
        $('form input[type="text"]').attr('value', '');
        $('form textarea').text("");
        return false;
    }
</script>
