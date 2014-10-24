<?php
$id = get_input('id_quest');
$id_quiz = get_input('id_quiz');
$quest = get_entity($id);
$respuestas = $quest->option_array;    
$id_type = $quest->option_type;

$borrar_url = elgg_get_site_url()."action/questions/limpiar?id_quest={$id}";

if (!$id_quiz){ //La pregunta NO se edita desde un quiz
    $cancel_url = elgg_get_site_url()."questions/all";
    $limpiar_url = elgg_get_site_url()."questions/edit?id_quest={$id}";
} else { //La pregunta SI se edita desde un quiz
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
            //sacar los tags de un tt
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
        <!-- <textarea rows="10" cols="50" class="elgg-input-longtext"><?php// echo $quest->description ?></textarea> -->
</textarea>
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
		<?php echo "Tipo de respuesta: " . $id_type ?>
	</label> 
    
	<?php 
        
        switch ($id_type) {
            //******************************************************************
            case "Desarrollo":
                ?>
            <div class="qqt" id="d">
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
            case "Verdadero o falso":?>
            <div class="qqt" id="vof">
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
            case "One choice":?>
            <div class="qqt" id="m1">
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
            case "Multiple choice":?>
            <div class="qqt" id="m">
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
                                'initial' => "Elige el tipo de pregunta",
				'd' => "Desarrollo",
                                'vof' => "Verdadero o falso",
				'm1' => "One choice",
                                'm' => "Multiple choice",
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

<?php if( ($id_type == "") || ($id_type == NULL) ){   
    /* Considero las preguntas vacias */
    ?>

<div class="qqt" id="d" style="display:none;">
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

<div class="qqt" id="vof" style="display:none;">
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

<div class="qqt" id="m1" style="display:none;">
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

<div class="qqt" id="m" style="display:none;">
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
                        'value' => $id_type,
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
