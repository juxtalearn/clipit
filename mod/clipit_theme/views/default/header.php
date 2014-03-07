<header>
    <nav class="navbar navbar-default navbar-static-top navbar-blue" role="navigation">
        <div class="container">
            <?php
            if (elgg_is_logged_in()) { ?>
                <div class="col-sm-3 col-md-3 pull-right">

                    <?php echo elgg_view('search/search_box', array('class' => 'navbar-form navbar-right search-form')); ?>

                </div>
            <?php }  ?>
            <p class="navbar-text navbar-right lang">
                <a href="#" class="active">ESP</a>
                <span class="divider">|</span>
                <a href="#">ENG</a>
            </p>
        </div>
    </nav>
    <nav class="navbar navbar-default" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo elgg_get_site_url(); ?>"><img src="<?php echo $vars['logo_img'];?>" alt="ClipIt logo"></a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <!--
            <div class="collapse navbar-collapse" id="bs-navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#">Menu</a></li>
                    <li class="active"><a href="#">Menu</a></li>
                    <li><a href="#">Menu</a></li>
                    <li><a href="#">Menu</a></li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div>
    </nav>
</header>