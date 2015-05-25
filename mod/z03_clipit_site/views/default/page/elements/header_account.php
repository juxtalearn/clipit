<?php
$context = elgg_get_context();
?>
<nav class="navbar navbar-default" id="navbar-sticky" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <?php echo elgg_view('output/url', array(
                'href' => "/",
                'class' => 'navbar-brand hidden-xs hidden-sm',
                'title' => 'ClipIt'. elgg_echo("home"),
                'text'  =>
                    elgg_view('output/img', array(
                        'src' => "mod/z03_clipit_site/graphics/icons/clipit_logo.png",
                    ))
            ));
            ?>
        </div>
        <?php if (elgg_is_logged_in()) { ?>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="navbar-collapse">
            <div class="pull-right">
                <button type="button" class="navbar-toggle margin-0 margin-top-5 margin-bottom-5">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <?php echo elgg_view_menu('top_account', array('sort_by' => 'priority', 'class' => 'nav navbar-nav navbar-right top-account')); ?>
            <?php echo elgg_view_menu('top_menu', array('sort_by' => 'priority', 'class' => 'top-menu')); ?>
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