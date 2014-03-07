<nav class="navbar navbar-default navbar-static-top navbar-blue" role="navigation">
    <div class="container">
        <?php
        if (elgg_is_logged_in()) { ?>
        <div class="col-sm-3 col-md-3 pull-right">

                <?php echo elgg_view('search/search_box', array('class' => 'navbar-form navbar-right search-form')); ?>

        </div>
        <?php } else { ?>
        <p class="navbar-text navbar-left">
            <a href="<?php echo elgg_get_site_url(); ?>" class="active" style="text-transform: uppercase;font-size: 16px;"><span class="glyphicon-chevron-left glyphicon"></span> Back</a>
        </p>
        <?php } ?>
        <p class="navbar-text navbar-right lang">
            <a href="#" class="active">ESP</a>
            <span class="divider">|</span>
            <a href="#">ENG</a>
        </p>
    </div>
</nav>