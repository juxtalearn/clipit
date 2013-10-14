<h2 class="elgg-heading-main">Generate a new key</h2>
<hr />
<br />
<?php
	$ref_label = elgg_echo('apiadmin:yourref');
	$ref_control = elgg_view('input/text', array('name' => 'ref'));
	$gen_control = elgg_view('input/submit', array('value' => elgg_echo('apiadmin:generate')));
	
	$form_body = <<< END
	<div class="contentWrapper">
		<p>$ref_label: $ref_control <br>  <br>$gen_control</p>
	</div>
END;


	echo elgg_view('input/form', array('action' => "{$vars['url']}apiadmin/generate", "body" => $form_body));
?>
<br />
<h2 class="elgg-heading-main">
List of existing Keys </h2>
<hr />
<table border="1" cellpadding="5" cellspacing="5" width="600">
<tr>
	<td width="30%">No</td>
	<td width="60%">API Key</td>
</tr>
<?php $apiKeys = apiadmin_list_key();
for($i=0,$j=1; $i<count($apiKeys); $i++,$j++){

?>
<tr>
	<td><?php echo $j;?></td>
	<td><?php echo $apiKeys[$i]->api_key;?></td>
</tr>
<?php 
}
?>
</table>