<?php
$id = get_input('id_quiz');
$quiz = get_entity($id);

$cancel_url = elgg_get_site_url()."quizzes/all";
$limpiar_url = elgg_get_site_url()."questions/edit?id_quest={$id}";

//Obtengo el nombre del TT a partir de su ID
$id_tt = $quiz->tricky_topic;
$tt = ClipitTrickyTopic::get_by_id(array($id_tt));
$tt_values[$id_tt] = $tt[$id_tt]->name;

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
    <?php echo elgg_view('input/text', array(
                    'internalname' => 'title',
                    'class' => 'form-control',
                    'value' => $quiz->name,
                )); ?>
</div>

<div id="quiz-description" class="form-group">
    <label class="control-label">Descripción</label>
    <?php echo elgg_view('input/longtext', array(
                    'name' => 'description',
                    'class' => 'form-control',
                    'value' => $quiz->description,
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
    <?php echo elgg_view('input/text', array(
                    'name' => 'author',
                    'class' => 'form-control',
                    'value' => $quiz->author_name,
                )); ?>
</div>

<div class="form-group row">
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
            echo elgg_view("output/url", 
                array(
                    "href" => "javascript:;", 
                    "is_action" => false,
                    "class" => "btn btn-success",
                    "text" => "Borrar",
                    "onclick" => 'javascript:limpiar();',
                    ));	
            echo '</div>';
            echo elgg_view('input/hidden', array(
                    'name' => 'id_quiz',
                    'value' => $id,
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