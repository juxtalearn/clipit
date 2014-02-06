<p><?php echo elgg_echo('sqlspaces:description'); ?></p>

<form action="<?php echo $vars['url']; ?>action/sqlspaces/modify" method="post">
<p>
	<?php	echo elgg_echo('sqlspaces:formenabled');
			echo elgg_view('input/radio',array('internalname' => "showga", 'options' => array('yes' => 1,'no' => 0), 'value' => $vars['showga']));
	?>
</p>
<p>
<label>
	<?php 	echo elgg_echo('sqlspaces:modify'); ?>
	<?php	echo elgg_view('input/text',array(
				'internalname' => 'spacename',
				'value' => $vars['spacename']
			)); 
	?>
</label>
<label>
	<?php 	echo elgg_echo('sqlspaces:serverurl'); ?>
	<?php	echo elgg_view('input/text',array(
				'internalname' => 'sqlsurl',
				'value' => $vars['sqlsurl']
			)); 
	?>
</label>
<label>
	<?php 	echo elgg_echo('sqlspaces:serverport'); ?>
	<?php	echo elgg_view('input/text',array(
				'internalname' => 'sqlsport',
				'value' => $vars['sqlsport']
			)); 
	?>
</label>
<?php
	echo elgg_view('input/hidden',array('internalname' => '__elgg_token', 'value' => $vars['token']));
	echo elgg_view('input/hidden',array('internalname' => '__elgg_ts', 'value' => $vars['ts']));
?>
</p>
<p>
<input type="submit" value="<?php echo elgg_echo('sqlspaces:submit'); ?>" />
</p>

</form>

