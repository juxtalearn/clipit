<?php
/**
 * Walled garden login
 */

$welcome = elgg_echo('welcome');
//$welcome .= ': <br/>' . $title;

$menu = elgg_view_menu('walled_garden', array(
	'sort_by' => 'priority',
	'class' => 'elgg-menu-general elgg-menu-hz',
));
$login_box = elgg_view('core/account/login_box', array('module' => 'walledgarden-login'));
$plugin = elgg_get_plugin_from_id('z03_clipit_site');
$vars = $plugin->getAllSettings();
$vars['img_path'] = $CONFIG->wwwroot."mod/z03_clipit_global/graphics/";
$vars['bg_img'] = $vars['img_path']."icons/".$vars['bg_img'];
$vars['logo_img'] = $vars['img_path']."icons/".$vars['logo_img'];
?>
<?php echo elgg_view('core/account/login_box', array('module' => 'walledgarden-login'));?>
<script>
    $(function(){
        // Auto focus, username input
        $('#modal-login').on('shown.bs.modal', function () {
            $('#inputUsername').focus();
        });
    });
</script>
<!-- Jumbotron -->
<div class="jumbotron" style="background-image: url(<?php echo $vars['bg_img'];?>)">
    <div class="text-center">
        <h1><?php echo elgg_echo('clipit:slogan');?></h1>
        <p>
            <a class="btn btn-primary btn-lg" href="<?php $CONFIG->wwwroot;?>register" role="button"><?php echo elgg_echo('user:register');?></a>
            <a class="btn btn-primary btn-lg" data-toggle="modal" data-target="#modal-login" role="button"><?php echo elgg_echo('user:login');?></a>
        </p>
        <div class="container">
            <!-- Clipit blocks -->
            <div class="row">
                <div class="col-sm-4 bg-red block text-center">
                    <div class="arrow">
                        <span class="red"></span>
                    </div>
                    <img src="<?php echo $vars['img_path'];?>crea.png">
                    <h2><?php echo elgg_echo('clipit:slogan:create');?></h2>
                </div>
                <div class="col-sm-4 bg-yellow block text-center">
                    <div class="arrow">
                        <span class="yellow"></span>
                    </div>
                    <img src="<?php echo $vars['img_path'];?>aprende.png">
                    <h2><?php echo elgg_echo('clipit:slogan:learn');?></h2>
                </div>
                <div class="col-sm-4 bg-blue block text-center">
                    <img src="<?php echo $vars['img_path'];?>comparte.png">
                    <h2><?php echo elgg_echo('clipit:slogan:share');?></h2>
                </div>
            </div>
            <!-- Clipit blocks end -->
        </div>
    </div>
</div><!-- Jumbotron end-->
<div class="container">
    <!-- Social -->
    <div class="row">
        <div class="col-sm-12 social-connect text-center">
            <h2><?php echo elgg_echo('follow_us');?></h2>
            <div class="social-icons">
                <?php if($vars['account_twitter']): ?>
                    <img src="<?php echo $vars['img_path'];?>social/twitter.png" />
                <? endif; ?>
                <?php if($vars['account_facebook']): ?>
                    <img src="<?php echo $vars['img_path'];?>social/facebook.png" />
                <? endif; ?>
                <?php if($vars['account_linkedin']): ?>
                    <img src="<?php echo $vars['img_path'];?>social/linkedin.png" />
                <? endif; ?>
                <?php if($vars['account_youtube']): ?>
                    <img src="<?php echo $vars['img_path'];?>social/youtube.png" />
                <? endif; ?>
                <?php if($vars['account_vimeo']): ?>
                    <img src="<?php echo $vars['img_path'];?>social/vimeo.png" />
                <? endif; ?>
            </div>
        </div>
    </div><!-- Social end-->
</div><!-- Container mid end-->
