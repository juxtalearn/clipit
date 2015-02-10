<?php
/**
 * Button area for showing the add widgets panel
 */
?>
<div class="elgg-widget-add-control">
<?php
	echo elgg_view('output/url', array(
		'href' => '#widgets-add-panel',
		'text' => elgg_echo('widgets:add'),
		'class' => 'btn btn-primary margin-bottom-10 ',
		'rel' => 'toggle',
		'is_trusted' => true,
	));
?>
</div>
