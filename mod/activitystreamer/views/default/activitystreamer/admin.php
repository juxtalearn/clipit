<p><?php echo elgg_echo('activitystreamer:description'); ?></p>

<form action="<?php echo $vars['url']; ?>action/activitystreamer/modify" method="post">
<p>
	<?php	echo elgg_echo('activitystreamer:formenabled');
			echo elgg_view('input/radio',array('internalname' => "showga", 'options' => array('yes' => 1,'no' => 0), 'value' => $vars['showga']));
	?>
</p>
<p>
<?php
	echo elgg_view('input/hidden',array('internalname' => '__elgg_token', 'value' => $vars['token']));
	echo elgg_view('input/hidden',array('internalname' => '__elgg_ts', 'value' => $vars['ts']));
?>
</p>
<p>
<input type="submit" value="<?php echo elgg_echo('activitystreamer:submit'); ?>" />
</p>

</form>

