<?php
$context = elgg_get_context();
$url = $CONFIG->url;
$images_dir = elgg_extract('images_dir', $vars);
?>
<?php if (elgg_is_logged_in()) : ?>
<!-- Messages modal -->
<?php echo elgg_view_form('messages/compose', array('data-validate'=> "true" )); ?>
<!-- Messages modal end -->
<?php endif; ?>
<nav class="navbar navbar-default" id="navbar-sticky" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <?php echo elgg_view('output/url', array(
                'href' => "/",
                'class' => 'navbar-brand',
                'title' => 'ClipIt'. elgg_echo("home"),
                'text'  =>
                    elgg_view('output/img', array(
                        'src' => $images_dir . "icons/clipit_logo.png",
                        'class' => 'hidden-xs'
                    )).
                    elgg_view('output/img', array(
                        'src' => $images_dir . "icons/clipit_logo_white.png",
                        'class' => 'visible-xs'
                    ))
            ));
            ?>
        </div>
        <?php if (elgg_is_logged_in()) { ?>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-navbar-collapse">
            <?php
            echo elgg_view_menu('top_account', array('sort_by' => 'priority', 'class' => 'nav navbar-nav navbar-right top-account'));
            echo elgg_view_menu('top_menu', array('sort_by' => 'priority', 'class' => 'top-menu'));
            ?>
            <!--
            <ul class="nav navbar-nav navbar-right" style="margin-right: 0px;">
                <li><a href="<?php echo $url; ?>explore"><?php echo elgg_echo("explore");?></a></li>
                <?php if (elgg_is_admin_logged_in()) { ?>
                    <li><a href="<?php echo $CONFIG->url; ?>admin"><?php echo elgg_echo("admin");?></a></li>
                <?php } ?>
            </ul>
             -->
        </div><!-- /.navbar-collapse -->
        <?php } else { ?>
            <!--
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#">Menu</a></li>
                <li class="active"><a href="#">Menu</a></li>
                <li><a href="#">Menu</a></li>
                <li><a href="#">Menu</a></li>
            </ul>-->
        <?php } ?>
    </div>
</nav>