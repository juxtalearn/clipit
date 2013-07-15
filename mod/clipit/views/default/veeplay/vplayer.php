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
// Processor for VIDEO media
// Load jwplayer javascript
elgg_load_js('veeplay');
// Set location variables
$swf_url = elgg_get_site_url() . 'mod/veeplay/player/player.swf';
$file_url = elgg_get_site_url() . 'file/download/'.$vars['file_guid'];
$skin_url = "";
if($plugin_skin_typev = elgg_get_plugin_setting("skin_typev", "veeplay")){
	if($plugin_skin_typev == 'glow') {
	$skin_url = elgg_get_site_url() . 'mod/veeplay/player/glow.zip';
	}
}
$widthv = '100%';
if($plugin_video_wd = elgg_get_plugin_setting("video_wd", "veeplay")){
	$widthv = $plugin_video_wd;
}
$heightv = '500';
if($plugin_video_ht = elgg_get_plugin_setting("video_ht", "veeplay")){
	$widthv = $plugin_video_ht;
}
$autostartv = 'false';
if($plugin_video_start = elgg_get_plugin_setting("video_start", "veeplay")){
	$autostartv = $plugin_video_start;
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
        $mode = "video";
	$type = "flash";
        break;
    case m4v:
        $mode = "video";
	$type = "flash";
        break;
    case flv:
        $mode = "video";
	$type = "flash";
        break;
    case mov:
        $mode = "video";
	$type = "flash";
        break;
    case webm:
        $mode = "video/webm";
	$type = "html";
        break;
    case ogg:
        $mode = "video";
	$type = "html";
        break;
    default:// catches empty or unknown extensions
        $mode = "video";
	$type = "flash";
endswitch;
?>
<!-- Place holder for media player-->
<div class="skin">
     <div name="mediaspace" id="mediaspace">
      <div class="VideoPlayer">
        <video
          id="mediaplayer01"
          height="<?php echo $heightv; ?>"
	width="<?php echo $widthv; ?>">
       <source src="<?php echo $file_url;?>" type="<?php echo $mode; ?>" />
       </video>
  </div>
<!-- Setup jwplayer javascript and switch between HTML5 or flash dominant -->
<?php if ($type == "html") { ?>
<script type="text/javascript">
	jwplayer("mediaplayer01").setup({
		skin: '<?php echo $skin_url; ?>',
		provider: 'video',
		modes: [
			{ type: 'html5'},
			{ type: 'flash', src: "<?php echo $swf_url; ?>"},
			{ type: 'download'}
		],
		autoplay:'<?php echo $autostartv;?>',
		controlbar: 'bottom'
	});
</script>
<?php } else {?>
<script type="text/javascript">
	jwplayer("mediaplayer01").setup({
		skin: '<?php echo $skin_url; ?>',
		provider: 'video',
		modes: [
			{ type: 'flash', src: "<?php echo $swf_url; ?>"},
			{ type: 'html5'},
			{ type: 'download'}
		],
		autoplay:'<?php echo $autostartv;?>',
		controlbar: 'bottom'
	});
</script>
<?php }?>
</div>
</div>
