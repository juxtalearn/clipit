<?php
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
	<?php echo elgg_view('input/pulldown', array(
			'name' => 'topic',
                        'options_values' => $tt_values
		));
	?>
</div>

<div>  
	<label>
		<?php echo "Titulo"; ?>
	</label> <br>
	<?php echo
		elgg_view('input/text', array('name' => 'title',));
	?>
</div>

<div>
	<label>
		<?php echo "Descripcion" ?>
	</label> <br>
	<?php echo
		elgg_view('input/longtext', array('name' => 'description'));
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
                            ClipitQuiz::VIEW_MODE_LIST => "En una página",
                            ClipitQuiz::VIEW_MODE_PAGED => "En varias páginas",
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
		elgg_view('input/text', array('name' => 'author',));
	?>
</div>

<div>
	<?php		
		echo elgg_view('input/submit', array(
			'value' => elgg_echo("save"),
		));
        ?> 
</div>
