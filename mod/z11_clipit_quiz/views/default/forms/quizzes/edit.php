<?php
$id = get_input('id_quiz');
$quiz = get_entity($id);

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
<div>
	<label>
		<?php echo "Tricky topic"; ?>
	</label> <br>
	<?php echo
		elgg_view('input/pulldown', array(
			'name' => 'topic',
                        'options_values' => $tt_values,
			));
	?>
</div>

<div>
    
	<label>
		<?php echo "Titulo"; ?>
	</label> <br>
	<?php echo
		elgg_view('input/text', array(
			'internalname' => 'title',
			'value' => $quiz->name,
			));
	?>
</div>

<div>
	<label>
		<?php echo "Descripcion" ?>
	</label> <br>
	<?php echo
		elgg_view('input/longtext', array(
			'name' => 'description',
			'value' => $quiz->description,
			));
	?>
</div>

<div>
    <label>
        <?php echo "Tipo de vista del examen"; ?>
    </label><br>
    <?php echo
		elgg_view('input/pulldown', array(
			'name' => 'view_mode',
                        'options_values' => array(
                            'list' => "En una página",
                            'paged' => "En varias páginas",
                        )
			));
	?>    
</div>

<div>
	<label>
		<?php echo "Acceso"; ?>
	</label> <br>
	<?php echo
		elgg_view('input/pulldown', array(
			'name' => 'access',
                        'options_values' => array(
                            'private' => "Privado   ",
                            'public' => "Publico   ",
                        )
			));
	?>
</div>

<div>  
	<label>
		<?php echo "Autor/es"; ?>
	</label> <br>
	<?php echo
		elgg_view('input/text', array(
                            'name' => 'author',
                            'value' => $quiz->author_name,
                        ));
	?>
</div>

<div>
	<?php		
		echo elgg_view('input/submit', array(
			'value' => elgg_echo("save"),
		));
	?> 
        <?php		
		echo elgg_view('input/hidden', array(
			'name' => 'id_quiz',
			'value' => $id,
		));
	?> 
</div>