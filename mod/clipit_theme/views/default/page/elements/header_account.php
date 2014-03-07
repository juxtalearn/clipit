<?php
$context = elgg_get_context();
$url = $CONFIG->url;
?>
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
            <a class="navbar-brand" href="<?php echo $CONFIG->wwwroot; ?>">
                <img src="<?php echo $vars['logo_img'];?>" alt="ClipIt logo">
            </a>
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
                <li><a href="<?php echo $url; ?>explore"><?=elgg_echo("explore");?></a></li>
                <?php if (elgg_is_admin_logged_in()) { ?>
                    <li><a href="<?php echo $CONFIG->url; ?>admin"><?=elgg_echo("admin");?></a></li>
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