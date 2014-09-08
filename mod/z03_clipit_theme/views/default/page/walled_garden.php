<?php
/**
 * Walled garden page shell
 *
 * Used for the walled garden index page
 */
//$vars['img_path'] = $CONFIG->wwwroot."mod/clipit_home/graphics/";
elgg_unregister_css("twitter-bootstrap"); // Quitamos el bootstrap por defecto y aplicamos el exclusivo del home
// Set the content type
header("Content-type: text/html; charset=UTF-8");
$plugin = elgg_get_plugin_from_id('z03_clipit_theme');
$vars_plugin = $plugin->getAllSettings();
$vars_plugin['img_path'] = $CONFIG->wwwroot."mod/z03_clipit_theme/graphics/";
$vars_plugin['bg_img'] = $vars_plugin['img_path']."icons/".$vars_plugin['bg_img'];
$vars_plugin['logo_img'] = $vars_plugin['img_path']."icons/".$vars_plugin['logo_img'];
$vars = array_merge($vars_plugin, $vars);

$footer = elgg_view('page/elements/footer', $vars);
$header_top = elgg_view('page/elements/header_top', array('walled_garden' => true));
$header_account = elgg_view('page/elements/header_account', $vars);
//echo elgg_view_page('Clipit', 'pepes' );
//die;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php echo elgg_view('page/elements/head', $vars); ?>
</head>
<body>
<div class="elgg-page elgg-page-walledgarden">
	<div class="elgg-page-messages">
		<?php echo elgg_view('page/elements/messages', array('object' => $vars['sysmessages'])); ?>
	</div>
    <header>
        <?php echo $header_top; ?>
        <?php echo $header_account; ?>
    </header>
    <div id="wrap">
		<?php
        echo $vars['body'];
        ?>
	</div>
</div>
<?php echo elgg_view('page/elements/footer'); ?>
</body>
</html>