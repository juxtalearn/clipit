<?php

// Obetner la pregunta, su tipo y su array de respuestas 
$id = get_input('id_quest');
$quest = get_entity($id);
$respuestas = $quest->option_array;    
$quest_type = $quest->option_type;

// Obtener el ID del quiz
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

<div>
	<label>
		<?php echo "Tricky topic"; ?>
	</label> <br>
	
        <?php 
        $tt_array = ClipitTrickyTopic::get_all();
        foreach($tt_array as $tt){
            $tt_values[$tt->id] = $tt->name;
            //AQUI sacar los tags de un tt
        }
        
        echo
		elgg_view('input/pulldown', array(
			'name' => 'topic',
                        'options_values' => $tt_values
			));
	?>
</div>

<div>
	<label>
		<?php echo "Etiquetas" ?>

        <?php
        $tag_array = ClipitTag::get_all();
        foreach($tag_array as $tag){
            $tag_values[$tag->id] = $tag->name;
        }
        
        echo
		elgg_view('input/pulldown', array(
			'name' => 'tags[]',
			'options_values' => $tag_values
			));
	?>
        </label> <br>
</div>

<div>
    
	<label>
		<?php echo "Titulo"; ?>
	</label> <br>
	<?php echo
		elgg_view('input/text', array(
			'internalname' => 'title',
			'value' => $quest->name,
			));
	?>
</div>

<div>
	<label>
		<?php echo "Enunciado" ?>
	</label> <br>
	<?php echo
		elgg_view('input/longtext', array(
			'name' => 'enunciado',
			'value' => $quest->description,
			));
	?>
        
</div>

<div>
	<label>
		<?php echo "Dificultad" ?>
	</label> <br>
	<?php echo elgg_view('input/text',array(
                        'name' => 'dif',
                        'value' => $quest->difficulty,
                    )); ?>
</div> 

<div>
	<label>
		<?php echo "Tipo de respuesta: " . $quest_type ?>
	</label> 
    
	<?php 
        
        switch ($quest_type) {
            //******************************************************************
            case ClipitQuizQuestion::TYPE_STRING:
                ?>
            <div class="qqt" id="<?php echo ClipitQuizQuestion::TYPE_STRING;?>">
                <br>
                <label>
                    <?php echo "Respuesta" ?>
                </label> <br>
                <?php
                echo elgg_view('input/longtext', array(
                    'name' => 'resp',
                    'value' => $respuestas));
                ?>
            </div>
            <?php break;
            //******************************************************************
            case ClipitQuizQuestion::TYPE_TRUE_FALSE:?>
            <div class="qqt" id="<?php echo ClipitQuizQuestion::TYPE_TRUE_FALSE;?>">
                <br>
                <label>
                    <?php echo "Respuesta 1" ?>
                </label> <br>
                <?php
                echo elgg_view('input/text', array(
                    'name' => 'vof_resp1',
                    'value' => $respuestas[0]));
                ?>
                <input type="radio" name="vof_ca" value="1"> Selecciona la correcta<br>
                <br>
                <label>
                    <?php echo "Respuesta 2" ?>
                </label> <br>
                <?php
                echo elgg_view('input/text', array(
                    'name' => 'vof_resp2',
                    'value' => $respuestas[1]));
                ?>
                <input type="radio" name="vof_ca" value="2">Selecciona la correcta<br>
            </div>
                
            <?php  break;
            //******************************************************************
            case ClipitQuizQuestion::TYPE_SELECT_ONE:?>
            <div class="qqt" id="<?php echo ClipitQuizQuestion::TYPE_SELECT_ONE;?>">
                <br>
                <label>
                    <?php echo "Respuesta 1" ?>
                </label> <br>
                <?php
                echo elgg_view('input/text', array(
                    'name' => 'm1_resp1',
                    'value' => $respuestas[0]));
                ?>
                <input type="radio" name="m1_ca" value="1"> Selecciona la correcta<br>
                <br>
                <label>
                    <?php echo "Respuesta 2" ?>
                </label> <br>
                <?php
                echo elgg_view('input/text', array(
                    'name' => 'm1_resp2',
                    'value' => $respuestas[1]));
                ?>
                <input type="radio" name="m1_ca" value="2">Selecciona la correcta<br>
                <br>
                <label>
                <?php echo "Respuesta 3" ?>
                </label> <br>
                <?php
                echo elgg_view('input/text', array(
                    'name' => 'm1_resp3',
                    'value' => $respuestas[2]));
                ?>
                <input type="radio" name="m1_ca" value="3">Selecciona la correcta<br>
                
                <?php 
                    if ($respuestas[3]){ ?>
                <br>
                <label>
                <?php echo "Respuesta 4" ?>
                </label> <br>
                <?php
                echo elgg_view('input/text', array(
                    'name' => 'm1_resp4',
                    'value' => $respuestas[3]));
                ?>
                <input type="radio" name="m1_ca" value="4">Selecciona la correcta<br>        
                <?php    }  ?>
                
                <?php 
                    if ($respuestas[4]){ ?>
                <br>
                <label>
                <?php echo "Respuesta 5" ?>
                </label> <br>
                <?php
                echo elgg_view('input/text', array(
                    'name' => 'm1_resp5',
                    'value' => $respuestas[4]));
                ?>
                <input type="radio" name="m1_ca" value="5">Selecciona la correcta<br>        
                <?php    }  ?>
                
            </div>
            <?php   break;
            //******************************************************************
            case ClipitQuizQuestion::TYPE_SELECT_MULTI:?>
            <div class="qqt" id="<?php echo ClipitQuizQuestion::TYPE_SELECT_MULTI;?>">
                <br>
                <label>
                    <?php echo "Respuesta 1" ?>
                </label> <br>
                <?php
                echo elgg_view('input/text', array(
                    'name' => 'm_resp1',
                    'value' => $respuestas[0]));
                ?>
                <input type="checkbox" name="m_ca[]" value="1"> Selecciona la correcta<br>
                <br>
                <label>
                    <?php echo "Respuesta 2" ?>
                </label> <br>
                <?php
                echo elgg_view('input/text', array(
                    'name' => 'm_resp2',
                    'value' => $respuestas[1]));
                ?>
                <input type="checkbox" name="m_ca[]" value="2">Selecciona la correcta<br>
                <br>
                <label>
                <?php echo "Respuesta 3" ?>
                </label> <br>
                <?php
                echo elgg_view('input/text', array(
                    'name' => 'm_resp3',
                    'value' => $respuestas[2]));
                ?>
                <input type="checkbox" name="m_ca[]" value="3">Selecciona la correcta<br>
                
                <?php 
                    if ($respuestas[3]){ ?>
                <br>
                <label>
                <?php echo "Respuesta 4" ?>
                </label> <br>
                <?php
                echo elgg_view('input/text', array(
                    'name' => 'm_resp4',
                    'value' => $respuestas[3]));
                ?>
                <input type="checkbox" name="m_ca[]" value="4">Selecciona la correcta<br>        
                <?php    }  ?>
                
                <?php 
                    if ($respuestas[4]){ ?>
                <br>
                <label>
                <?php echo "Respuesta 5" ?>
                </label> <br>
                <?php
                echo elgg_view('input/text', array(
                    'name' => 'm_resp5',
                    'value' => $respuestas[4]));
                ?>
                <input type="checkbox" name="m_ca[]" value="5">Selecciona la correcta<br>        
                <?php    }  ?>
                
            </div>
            <?php break;
            //******************************************************************
            default:
                echo
		elgg_view('input/pulldown', array(
			'name' => 'empty_ans',
			'options_values' => array(
                                'initial' => "Elige el tipo de respuesta",
                                ClipitQuizQuestion::TYPE_STRING => "Long question",
                                ClipitQuizQuestion::TYPE_NUMBER => "Numeric question",
                                ClipitQuizQuestion::TYPE_TRUE_FALSE => "True or false",
				ClipitQuizQuestion::TYPE_SELECT_ONE => "One choice",
                                ClipitQuizQuestion::TYPE_SELECT_MULTI => "Multiple choice",
                          ),	
                        'onchange' => 'javascript:on_change_type(this.value);'
			));
                break;
        }
        
	?>
</div> <br>

<script>
    function on_change_type(value){
        $(".qqt").hide();
        $("#"+ value).show();
    }
</script>

<?php if( ($quest_type == "") || ($quest_type == NULL) ){   
    /* Considero las preguntas vacias */
    ?>

<div class="qqt" id="<?php echo ClipitQuizQuestion::TYPE_STRING;?>" style="display:none;">
    <br>
    <label>
	<?php echo "Respuesta" ?>
    </label> <br>
    <?php 
         echo elgg_view('input/longtext',array(
                    'name' => 'd_resp',
                 ));
    ?>
</div>

<div class="qqt" id="<?php echo ClipitQuizQuestion::TYPE_TRUE_FALSE;?>" style="display:none;">
    <br>
    <label>
	<?php echo "Respuesta 1" ?>
    </label> <br>
    <?php
        echo elgg_view('input/text',array(
                    'name' => 'vof_resp1',
                    ));
    ?>
    <input type="radio" name="vof_ca" value="1"> Selecciona la correcta<br>
    <br>
    
    <label>
	<?php echo "Respuesta 2" ?>
    </label> <br>
    <?php echo elgg_view('input/text',array(
                    'name' => 'vof_resp2',
            ));
     ?>
    <input type="radio" name="vof_ca" value="2">Selecciona la correcta<br>
</div>

<!-- Permitir añadir mas respuestas en tipo Once choice y Multiple choice -->
    <script type="text/javascript">
        function mostrar(clicked_id, r){
            document.getElementById(clicked_id).style.display = 'none';
            document.getElementById(r).style.display = 'block';}
    </script>

<div class="qqt" id="<?php echo ClipitQuizQuestion::TYPE_SELECT_ONE;?>" style="display:none;">
    <br>
    <label>
	<?php echo "Respuesta 1" ?>
    </label> <br>
    <?php
        echo elgg_view('input/text',array(
                    'name' => 'm1_resp1',
                ));?>
    <input type="radio" name="m1_ca" value="1"> Selecciona la correcta<br>
    <br>
    
    <label>
	<?php echo "Respuesta 2" ?>
    </label> <br>
    <?php echo elgg_view('input/text',array(
                    'name' => 'm1_resp2',
                    )); ?>
    <input type="radio" name="m1_ca" value="2">Selecciona la correcta<br>
    <br>
    
    <label>
	<?php echo "Respuesta 3" ?>
    </label> <br>
    <?php echo elgg_view('input/text',array(
                    'name' => 'm1_resp3',
                ));
     ?>
    <input type="radio" name="m1_ca" value="3">Selecciona la correcta<br><br>
    
    <!-- Permitir añadir hasta 5 posibles respuestas -->
    <input id='m1R4' type="button" value="Añadir otra respuesta" onclick="mostrar(this.id, 'R4')">
    
    <div id='R4' style='display:none;'>
            <label>
                <?php echo "Respuesta 4" ?>
            </label> <br>
            <?php echo elgg_view('input/text', array('name' => 'm1_resp4')); ?>
            <input type="radio" name="m1_ca" value="4">Selecciona la correcta<br><br>
            <input id='masR5' type="button" value="Añadir otra respuesta" onclick="mostrar(this.id, 'R5')">
    </div>
    
     <div id='R5' style='display:none;'>
            <label>
                <?php echo "Respuesta 5" ?>
            </label> <br>
            <?php echo elgg_view('input/text', array('name' => 'm1_resp5')); ?>
            <input type="radio" name="m1_ca" value="5">Selecciona la correcta<br>
    </div>
    
</div>

<div class="qqt" id="<?php echo ClipitQuizQuestion::TYPE_SELECT_MULTI;?>" style="display:none;">
    <br>
    <label>
	<?php echo "Respuesta 1" ?>
    </label> <br>
    <?php
        echo elgg_view('input/text',array(
                    'name' => 'm_resp1',
                )); ?>
    <input type="checkbox" name="m_ca[]" value="1"> Selecciona la correcta<br>
    <br>
    
    <label>
	<?php echo "Respuesta 2" ?>
    </label> <br>
    <?php echo elgg_view('input/text',array(
                    'name' => 'm_resp2',
            )); ?>
    <input type="checkbox" name="m_ca[]" value="2">Selecciona la correcta<br>
    <br>
    
    <label>
	<?php echo "Respuesta 3" ?>
    </label> <br>
    <?php echo elgg_view('input/text',array(
                    'name' => 'm_resp3',
            ));
     ?>
    <input type="checkbox" name="m_ca[]" value="3">Selecciona la correcta<br><br>
    
    <!-- Permitir añadir hasta 5 posibles respuestas -->
    <input id='moR4' type="button" value="Añadir otra respuesta" onclick="mostrar(this.id, 'mR4')">
    
    <div id='mR4' style='display:none;'>
            <label>
                <?php echo "Respuesta 4" ?>
            </label> <br>
            <?php echo elgg_view('input/text',array('name' => 'm_resp4')); ?>
            <input type="checkbox" name="m_ca[]" value="4">Selecciona la correcta<br><br>
            <input id='moR5' type="button" value="Añadir otra respuesta" onclick="mostrar(this.id, 'mR5')">
    </div>
    
     <div id='mR5' style='display:none;'>
            <label>
                <?php echo "Respuesta 5" ?>
            </label> <br>
            <?php echo elgg_view('input/text',array('name' => 'm_resp5')); ?>
            <input type="checkbox" name="m_ca[]" value="5">Selecciona la correcta<br><br>
    </div>
    
</div>
    
<?php } 
    /* Cierre IF respuestas vacias */
?>
    
<div> <?php 
        echo elgg_view('input/hidden', array(
			'name' => 'id_quest',
			'value' => $id,
		));
        echo elgg_view('input/hidden', array(
			'name' => 'ta',
                        'value' => $quest_type,
		));
        echo elgg_view('input/submit', array(
			'value' => "Guardar",
		)); 
        
        echo elgg_view("output/url", 
                    array(
                        "href" => $cancel_url, 
                        "is_action" => false,
                        "class" => "elgg-button-action",
                        "text" => "Cancelar",
                        "onclick" => 'javascript:return confirmar("¿Está seguro que desea cancelar la pregunta?");',
                        ));
        echo elgg_view("output/url", 
                    array(
                        "href" => "javascript:;", 
                        "is_action" => false,
                        "class" => "elgg-button-action",
                        "text" => "Borrar",
                        "onclick" => 'javascript:limpiar();',
                        ));
        ?>
</div><br>

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
