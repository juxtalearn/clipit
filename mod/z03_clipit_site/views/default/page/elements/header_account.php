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
            <?php if (elgg_is_logged_in()): ?>
                <?php echo elgg_view_menu('top_account', array('sort_by' => 'priority', 'class' => 'nav navbar-nav navbar-right top-account')); ?>
            <?php else: ?>
                <?php echo elgg_view_menu('top_walled_garden', array('sort_by' => 'priority', 'class' => 'nav navbar-nav navbar-right top-account')); ?>
            <?php endif;?>
            <?php echo elgg_view_menu('top_menu', array('sort_by' => 'priority', 'class' => 'top-menu')); ?>
        </div><!-- /.navbar-collapse -->
    </div>
</nav>