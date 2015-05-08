<?php

//Link para cancelar la creacion del quiz
$cancel_url = elgg_get_site_url()."quizzes/all";

//Obtener todos los TT para mostrarlos en la lista desplegable
$tt_array = ClipitTrickyTopic::get_all();
    foreach($tt_array as $tt){
        $tt_values[$tt->id] = $tt->name;
    }
?>

<div id="quiz-tt" class="form-group">
    <label class="control-label">Tricky topic</label>
    <?php echo elgg_view('input/pulldown', array(
                    'name' => 'topic',
                    'class' => 'form-control',
                    'options_values' => $tt_values,
                    'style' => 'padding-top: 5px; padding-bottom: 5px;'
                ));?>
</div>

<div id="quiz-title" class="form-group">
    <label class="control-label">Título</label>
    <input name="title" type="text" class="form-control" placeholder="Título">
</div>

<div id="quiz-description" class="form-group">
    <label class="control-label">Descripción</label>
    <?php echo elgg_view('input/longtext', array(
                    'name' => 'description',
                    'class' => 'form-control',
                    'placeholder' => "Descripción del quiz",
                ));?>
</div>

<div id="quiz-view-mode" class="form-group">
    <label class="control-label">Tipo de vista del examen</label>
    <?php echo elgg_view('input/pulldown', array(
                    'name' => 'view_mode',
                    'class' => 'form-control',
                    'options_values' => array(
                        ClipitQuiz::VIEW_MODE_LIST => "En una página",
                        ClipitQuiz::VIEW_MODE_PAGED => "En varias páginas",
                    ),
                    'style' => 'padding-top: 5px; padding-bottom: 5px;'
                ));?>    
</div>

<div id="quiz-access" class="form-group">
    <label class="control-label">Acceso</label>
    <?php echo elgg_view('input/pulldown', array(
                    'name' => 'access',
                    'class' => 'form-control',
                    'options_values' => array(
                        'private' => "Privado",
                        'public' => "Publico",
                    ),
                    'style' => 'padding-top: 5px; padding-bottom: 5px;'
                ));
    ?>
</div>

<div id="quiz-access" class="form-group">
    <label class="control-label">Autor</label>
    <input name="author" type="text" class="form-control" placeholder="Autor">
</div>

<div class="form-group">
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
                    "onclick" => 'javascript:return confirmar("¿Está seguro que desea cancelar el quiz?");',
                    ));
            echo '</div>';
            echo '<div class="col-xs-4 col-md-2">';
            echo '<input type="reset" class="btn btn-success" title="Borrar" value="Borrar">';
            echo '</div>';
    ?> 
</div>

<script language="JavaScript">
    function confirmar (mensaje) {
        return confirm(mensaje);
    }
</script>