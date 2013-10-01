<p><?php echo elgg_echo('piwik:description'); ?></p>

<form action="<?php echo $vars['url']; ?>action/piwik/modify" method="post">
<p>
	<?php	echo elgg_echo('piwik:formenabled');
			echo elgg_view('input/radio',array('internalname' => "showga", 'options' => array('yes' => 1,'no' => 0), 'value' => $vars['showga']));
	?>
</p>
<p>
<label>
	<?php 	echo elgg_echo('piwik:modify'); ?>
	<?php	echo elgg_view('input/text',array(
				'internalname' => 'trackid',
				'value' => $vars['trackid']
			)); 
	?>
</label>
<label>
	<?php 	echo elgg_echo('piwik:trackurl'); ?>
	<?php	echo elgg_view('input/text',array(
				'internalname' => 'trackurl',
				'value' => $vars['trackurl']
			)); 
	?>
</label>
<?php
	echo elgg_view('input/hidden',array('internalname' => '__elgg_token', 'value' => $vars['token']));
	echo elgg_view('input/hidden',array('internalname' => '__elgg_ts', 'value' => $vars['ts']));
?>
</p>
<p>
<input type="submit" value="<?php echo elgg_echo('piwik:submit'); ?>" />
</p>

</form>


	<?php
	$idSite = $vars['trackid'];
	$start = date( "Y-m-d", time() - ( 31 * 24 * 60 * 60 ) );
	$end = date( "Y-m-d" );
	?>
	<div id="content_area_user_title">
		<h2><?php echo elgg_echo('piwik:statistics_heading' ); ?></h2>
	</div>
	<?php echo elgg_echo('piwik:statistics' ); ?>
	<div id="widgetIframe">
		<iframe width="100%" height="350" src="http://<?php echo $vars['trackurl']; ?>/index.php?module=Widgetize&action=iframe&columns[]=nb_visits&moduleToWidgetize=VisitsSummary&actionToWidgetize=getEvolutionGraph&idSite=<?php echo $idSite; ?>&period=range&date=<?php echo $start; ?>%2C<?php echo $end; ?>&disableLink=1&widget=1" scrolling="no" frameborder="0" marginheight="0" marginwidth="0">
		</iframe>
	</div>
