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
//set_config('language', 'es', 1);
//$CONFIG->language = 'en';
//echo elgg_echo('welcome', $args = array(), $language = "en");
//echo  get_current_language();
$plugin = elgg_get_plugin_from_id('clipit_theme');
$vars_plugin = $plugin->getAllSettings();
$vars_plugin['img_path'] = $CONFIG->wwwroot."mod/clipit_theme/graphics/";
$vars_plugin['bg_img'] = $vars_plugin['img_path']."icons/".$vars_plugin['bg_img'];
$vars_plugin['logo_img'] = $vars_plugin['img_path']."icons/".$vars_plugin['logo_img'];
$vars = array_merge($vars_plugin, $vars);

$footer = elgg_view('page/elements/footer', $vars);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<?php echo elgg_view('page/elements/head', $vars); ?>

</head>
<body>
<div class="elgg-page elgg-page-walledgarden">
    <!--<?php echo elgg_echo('welcome'); ?>-->
	<div class="elgg-page-messages">
		<?php echo elgg_view('page/elements/messages', array('object' => $vars['sysmessages'])); ?>
	</div>
    <div id="wrap">
		<?php
        echo elgg_view("header", $vars);
        echo $vars['body'];
        ?>
	</div>
</div>
<footer id="footer">
    <div class="container">
        <div class="row">
            <?php echo $footer; ?>
        </div>
        <div class="row sponsors">
            <div class="col-sm-3 pull-right">
                <img src="<?php echo $CONFIG->wwwroot; ?>mod/clipit_theme/graphics/sponsors.png">
            </div>
        </div>
    </div>
</footer>
</body>
</html>