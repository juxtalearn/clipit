<?php
$id_quiz = get_input('id_quiz');

/*** Si la pregunta NO esta asociada a un quiz ***/
if (!$id_quiz){
    $cancel_url = elgg_get_site_url()."questions/all";
    $limpiar_url = elgg_get_site_url()."questions/add";
    //Obtengo todos los TT del sistema
    $tt_array = ClipitTrickyTopic::get_all();
    foreach ($tt_array as $tt) {
        $tt_values[$tt->id] = $tt->name;
    }
    //Obtengo todos los Tags del sistema
    $tag_array = ClipitTag::get_all();
    foreach ($tag_array as $tag) {
        $tag_values[$tag->id] = $tag->name;
    }
} else { //Si la pregunta esta asociada a un quiz
    $cancel_url = elgg_get_site_url()."quizzes/view?id_quiz={$id_quiz}";
    $limpiar_url = elgg_get_site_url()."questions/add2quiz?id_quiz={$id_quiz}&option=new";
    //Obtengo el TT asociado al quiz
    $quiz = array_pop(ClipitQuiz::get_by_id(array($id_quiz)));
    $tt_id = $quiz->tricky_topic;
    $tt = array_pop(ClipitTrickyTopic::get_by_id(array($tt_id)));
    
    //Obtengo los Tags asociados al TT del quiz
    $tag_array = ClipitTrickyTopic::get_tags($tt_id);
    foreach ($tag_array as $id_tag) {
        $tag = array_pop(ClipitTag::get_by_id(array($id_tag)));
        $tag_values[$id_tag] = $tag->name;
    }
}   
var_dump($tag_values);
?>
<script language="javascript" src="js/jquery-1.2.6.min.js"></script>
<script language="javascript" type="text/javascript">
$(document).ready(function(){
   $("#topics").change(function () {
           $("#topics option:selected").each(function () {
            elegido = $(this).val();
            $.post("etiquetas.php", { elegido: elegido }, function(data){ //falla en el data que no debe llegar bien
            $("#etiquetas").html(data);
            });            
        });
   })
});
</script>
 <!--                
<select name="topics" id="topics">
    <option>- - Seleccionar - -</option>
    <?php/*
        foreach ($tt_values as $id => $name){
            echo '<option value="'.$id.'">'.$name.'</option>';
        }*/
    ?>
</select>
<a id="prueba"></a>
<select name="etiquetas" id="etiquetas">
    <option>- - - - - - -</option>
</select>

<select name="select3">
    <option>- - - - - - -</option>
</select>
-->

<div id="etiquetado" style="display: flex;">
<div id="topics">
	<label>
		<?php echo "Tricky topic"; ?>
	</label> <br>
	
        <?php 
        if(!$id_quiz){ //Si no esta asociada a un quiz muestro Topics del sistema
             echo
		elgg_view('input/pulldown', array(
			'name' => 'topic',
                        'options_values' => $tt_values,
                        //'onchange' => 'javascript:slctryole(this, this.form.select2);',
			));
        } else {
            echo
                elgg_view('input/pulldown', array(
                        'name' => 'topic',
                        'options_values' => array(
                            "$tt_id" => $tt->name,
                        )
                ));
        }
	?>
</div>

<div id="etiquetas" style="margin-left: 50px;">
	<label>
		<?php echo "Etiquetas" ?>
        </label> <br>
        <?php
        
        echo
		elgg_view('input/pulldown', array(
			'name' => 'tags[]',
			'options_values' => $tag_values,
			));
	?>
</div>
</div>
<div>
	<label>
		<?php echo "Titulo" ?>
	</label> <br>
	<?php echo
		elgg_view('input/text', array('name' => 'title'));
	?>
</div>

<div>
	<label>
		<?php echo "Enunciado" ?>
	</label> <br>
	<?php echo elgg_view('input/plaintext',array('name' => 'enunciado')); ?>
</div> 

<div>
	<label>
		<?php echo "Dificultad" ?>
	</label> <br>
	<?php echo elgg_view('input/text',array('name' => 'dif')); ?>
</div> 

<div>
	<label>
		<?php echo "Tipo de respuesta" ?>
	</label> 
	<?php echo
		elgg_view('input/pulldown', array(
			'name' => 'type_answer',
			'options_values' => array(
                                'initial' => "Elige el tipo de respuesta",
				'd' => "Desarrollo",
                                'vof' => "Verdadero o falso",
				'm1' => "One choice",
                                'm' => "Multiple choice",
                                ),	
                        'onchange' => 'javascript:on_change_type(this.value);'
			));
        
	?>
</div> <br>

<script>
    function on_change_type(value){
        $(".qqt").hide();
        $("#"+value).show();
    }
</script>

<div class="qqt" id="d" style="display:none;">
    <label>
	<?php echo "Respuesta" ?>
    </label> <br>
    <?php echo elgg_view('input/longtext',array('name' => 'd_resp')); ?>
</div>

<div class="qqt" id="vof" style="display:none;">
    <label>
	<?php echo "Respuesta 1" ?>
    </label> <br>
    <?php echo elgg_view('input/text',array('name' => 'vof_resp1')); ?>
    <input type="radio" name="vof_ca" value="1"> Selecciona la correcta<br>
    <br>
    <label>
	<?php echo "Respuesta 2" ?>
    </label> <br>
    <?php echo elgg_view('input/text',array('name' => 'vof_resp2')); ?>
    <input type="radio" name="vof_ca" value="2">Selecciona la correcta<br>
</div>

<!-- Permitir añadir mas respuestas en tipo Once choice y Multiple choice -->
    <script type="text/javascript">
        function mostrar(clicked_id, r){
            document.getElementById(clicked_id).style.display = 'none';
            document.getElementById(r).style.display = 'block';}
    </script>

<div class="qqt" id="m1" style="display:none;">
    <label>
	<?php echo "Respuesta 1" ?>
    </label> <br>
    <?php echo elgg_view('input/text',array('name' => 'm1_resp1')); ?>
    <input type="radio" name="m1_ca" value="1"> Selecciona la correcta<br>
    <br>
    <label>
	<?php echo "Respuesta 2" ?>
    </label> <br>
    <?php echo elgg_view('input/text',array('name' => 'm1_resp2')); ?>
    <input type="radio" name="m1_ca" value="2">Selecciona la correcta<br>
    <br>
    <label>
	<?php echo "Respuesta 3" ?>
    </label> <br>
    <?php echo elgg_view('input/text',array('name' => 'm1_resp3')); ?>
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
    <label>
	<?php echo "Respuesta 1" ?>
    </label> <br>
    <?php echo elgg_view('input/text',array('name' => 'm_resp1')); ?>
    <input type="checkbox" name="m_ca[]" value="1"> Selecciona la correcta<br>
    <br>
    <label>
	<?php echo "Respuesta 2" ?>
    </label> <br>
    <?php echo elgg_view('input/text',array('name' => 'm_resp2')); ?>
    <input type="checkbox" name="m_ca[]" value="2">Selecciona la correcta<br>
    <br>
    <label>
	<?php echo "Respuesta 3" ?>
    </label> <br>
    <?php echo elgg_view('input/text',array('name' => 'm_resp3')); ?>
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

<div> <?php 
        echo elgg_view('input/hidden', array(
			'name' => 'id_quiz',
			'value' => $id_quiz,
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
 
        ?>
    <button type="reset" value="Reset">Borrar Datos</button>
</div><br>

<script language="JavaScript">
function confirmar (mensaje) {
    return confirm(mensaje);
} 
</script>