<nav class="navbar navbar-default navbar-static-top navbar-blue" role="navigation">
    <div class="container">
        <?php
        if (elgg_is_logged_in()): ?>
        <div class="col-sm-3 col-md-3 pull-right">
            <?php echo elgg_view('search/search_box', array('class' => 'navbar-form navbar-right search-form')); ?>
        </div>
        <?php else: ?>
        <p class="navbar-text navbar-left">
            <a href="<?php echo elgg_get_site_url(); ?>" class="active" style="text-transform: uppercase;font-size: 16px;"><span class="glyphicon-chevron-left glyphicon"></span> Back</a>
        </p>
        <?php endif; ?>
        <p class="navbar-text navbar-right lang" style="text-transform: uppercase">
            <?php
            $installed_langs = get_installed_translations();
            foreach($installed_langs as $key => $language):
                $active = false;
                if(get_current_language() == $key){
                    $active = 'active';
                }
                echo elgg_view('output/url', array(
                    'href'  => elgg_add_action_tokens_to_url("action/language/set?lang={$key}", true),
                    'title' => $language,
                    'text'  => $key,
                    'class' => $active,
                ));
                if(end($installed_langs) != $language){
                    echo '<span class="divider">|</span>';
                }
            endforeach;
            ?>
        </p>
    </div>
</nav>