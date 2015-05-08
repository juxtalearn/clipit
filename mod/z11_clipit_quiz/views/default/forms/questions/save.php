<?php

// Obetner el ID de la pregunta
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
    
/*** Si la pregunta esta asociada a un quiz ***/
} else { 
    
    $cancel_url = elgg_get_site_url()."quizzes/view?id_quiz={$id_quiz}";
    $limpiar_url = elgg_get_site_url()."questions/add2quiz?id_quiz={$id_quiz}&option=new";
    
    //Obtengo el quiz
    $quiz = array_pop(ClipitQuiz::get_by_id(array($id_quiz)));
    
    //Obtengo el TT asociado al quiz
    $tt_id = $quiz->tricky_topic;
    $tt = array_pop(ClipitTrickyTopic::get_by_id(array($tt_id)));
    
    //Obtengo los Tags asociados al TT
    $tag_array = ClipitTrickyTopic::get_tags($tt_id);
    foreach ($tag_array as $id_tag) {
        $tag = array_pop(ClipitTag::get_by_id(array($id_tag)));
        $tag_values[$id_tag] = $tag->name;
    }
}   

?>
<div id="quest-tt" class="form-group">
    <label class="control-label">Tricky topic</label>
    <?php 
        /** Si la pregunta no esta asociada a un quiz, muestro TT del sistema **/
        if(!$id_quiz){ 
            echo elgg_view('input/pulldown', array(
                    'name' => 'topic',
                    'class' => 'form-control',
                    'options_values' => $tt_values,
                    'style' => 'padding-top: 5px; padding-bottom: 5px;'
                ));
        /** Si la pregunta está asociada a un quiz, muestro el TT del quiz **/
        } else {
            echo elgg_view('input/pulldown', array(
                    'name' => 'topic',
                    'class' => 'form-control',
                    'options_values' => array("$tt_id" => $tt->name),
                    'style' => 'padding-top: 5px; padding-bottom: 5px;'
                ));
        }
    ?>
</div>

<div id="quest-tag" class="form-group">
    <label class="control-label">Etiqueta</label>
    <?php echo elgg_view('input/pulldown', array(
			'name' => 'tags[]',
                        'class' => 'form-control',
			'options_values' => $tag_values,
                        'style' => 'padding-top: 5px; padding-bottom: 5px;'
                    ));
    ?>
</div>

<div id="quest-title" class="form-group">
    <label class="control-label">Título</label>
    <input name="title" type="text" class="form-control" placeholder="Título">
</div>

<div id="quiz-description" class="form-group">
    <label class="control-label">Enunciado</label>
    <?php echo elgg_view('input/longtext', array(
                    'name' => 'enunciado',
                    'class' => 'form-control',
                    'placeholder' => "Enunciado de la pregunta",
                ));?>
</div>

<div id="quest-difficulty" class="form-group">
    <label class="control-label">Dificultad</label>
    <input name="dif" type="text" class="form-control" placeholder="Dificultad">
</div>

<div id="quest-type" class="form-group">
    <label class="control-label">Tipo de respuesta</label>
    <?php echo elgg_view('input/pulldown', array(
                    'name' => 'type_answer',
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
    ?>
</div>

<script>
    //Función para mostrar el formulario de respuestas según el tipo de pregunta elegida
    function on_change_type(value){
        $(".qqt").hide();
        $("#"+value).show();
    }
</script>

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
            echo '<button type="reset" class="btn btn-success" value="Reset">Borrar</button>';
            echo '</div>';
            
            echo elgg_view('input/hidden', array(
			'name' => 'id_quiz',
			'value' => $id_quiz,
		));
    ?> 
</div>

<script language="JavaScript">
    function confirmar (mensaje) {
        return confirm(mensaje);
    } 
</script>