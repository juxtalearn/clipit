<?php
/**
* Elgg VeePlay Plugin
* @package veeplay
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
* @author Roger Grice
* @copyright 2012 DesignedbyRoger 
* @link http://DesignedbyRoger.com
* @version 1.8.3.2
*/
// Processor for AUDIO media
// Load jwplayer javascript
elgg_load_js('veeplay');
// Set location variables
$swf_url = elgg_get_site_url() . 'mod/veeplay/player/player.swf';
$file_url = elgg_get_site_url() . 'file/download/'.$vars['file_guid'];
$skin_url = "";
if($plugin_skin_typea = elgg_get_plugin_setting("skin_typea", "veeplay")){
	if($plugin_skin_typea == 'glow') {
	$skin_url = elgg_get_site_url() . 'mod/veeplay/player/glow.zip';
	}
}
$visual_plugin = "";
if($plugin_audio_effect = elgg_get_plugin_setting("audio_effect", "veeplay")){
	if($plugin_audio_effect == 'on') {
	$visual_plugin = 'revolt-1';
	}
}
$widtha = '560';
if($plugin_audio_wd = elgg_get_plugin_setting("audio_wd", "veeplay")){
	$widtha = $plugin_audio_wd;
}
$heighta = '315';
if($plugin_audio_ht = elgg_get_plugin_setting("audio_ht", "veeplay")){
	$widtha = $plugin_audio_ht;
}
$autostarta = 'false';
if($plugin_audio_start = elgg_get_plugin_setting("audio_start", "veeplay")){
	$autostarta = $plugin_audio_start;
}
// Go to the DB and pull down the original media filename
$result = mysql_query("SELECT {$CONFIG->dbprefix}metastrings.string
FROM {$CONFIG->dbprefix}metastrings
LEFT JOIN {$CONFIG->dbprefix}metadata
ON {$CONFIG->dbprefix}metastrings.id = {$CONFIG->dbprefix}metadata.value_id
LEFT JOIN {$CONFIG->dbprefix}objects_entity
ON {$CONFIG->dbprefix}metadata.entity_guid = {$CONFIG->dbprefix}objects_entity.guid
WHERE ({$CONFIG->dbprefix}objects_entity.guid = '{$vars['file_guid']}') AND ({$CONFIG->dbprefix}metastrings.string LIKE 'file/%')");
// Check query ran and result is populated
if (!$result) {
// Query failed, return to page with error
	register_error(elgg_echo('veeplay:dbase:runerror'));
	forward(REFERER);
}
// Query worked but returned empty row, slightly unneccesary, but anyway...
if (mysql_num_rows($result) == 0) {
	register_error(elgg_echo('veeplay:dbase:notvalid'));
	forward(REFERER);
}
$row = mysql_fetch_array($result);
// Just grab the extension
$ext = pathinfo($row['string'], PATHINFO_EXTENSION);
// Set file type variables
switch ($ext):
    case mp4:
        $mode = "video/mp4";
	$type = "flash";
        break;
    case m4v:
        $mode = "video/mp4";
	$type = "flash";
        break;
    case m4a:
        $mode = "video/mp4";
	$type = "flash";
        break;
    case aac:
        $mode = "video/mp4";
	$type = "flash";
        break;
    case mp3:
        $mode = "sound";
	$type = "flash";
        break;
    case ogg:
        $mode = "sound";
	$type = "html";
        break;
    case oga:
        $mode = "sound";
	$type = "html";
        break;
    default:// catches empty or unknown extensions
        $mode = "sound";
	$type = "flash";
endswitch;
?>
<!-- Place holder for media player-->
<div class="skin">
     <div name="mediaspace" id="mediaspace">
      <div class="AudioPlayer">
       <div id="mediaplayer02">Loading the player ...</div>
</div>
<!-- for non-mp4 container -->
<?php if ($mode == "sound") { ?>
<script type="text/javascript">
	jwplayer("mediaplayer02").setup({
		skin: '<?php echo $skin_url; ?>',
		autoplay:'<?php echo $autostarta;?>',
		file: "<?php echo $file_url;?>",
		type: 'sound',
		modes: [
			{ type: 'flash', src: "<?php echo $swf_url; ?>"},
			{ type: 'html5'},
			{ type: 'download'}
		],
		height: '<?php echo $heighta; ?>',
		width: '<?php echo $widtha; ?>',
		plugins: {
 		      '<?php echo $visual_plugin;?>': {}
 		},
		controlbar: 'bottom'
	});
</script>
<?php } else {?>
<script type="text/javascript">
	jwplayer("mediaplayer02").setup({
		skin: '<?php echo $skin_url; ?>',
		autoplay:'<?php echo $autostarta;?>',
		file: "<?php echo $file_url;?>",
		type: 'video',
		modes: [
			{ type: 'flash', src: "<?php echo $swf_url; ?>"},
			{ type: 'html5'},
			{ type: 'download'}
		],
		height: '<?php echo $heighta; ?>',
		width: '<?php echo $widtha; ?>',
		plugins: {
 		      '<?php echo $visual_plugin;?>': {}
 		},
		controlbar: 'bottom'
	});
</script>
<?php }?>
</div>
</div>
