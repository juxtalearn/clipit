<nav class="navbar navbar-default navbar-static-top navbar-blue" role="navigation">
    <div class="container">
        <?php
        if (elgg_is_logged_in()): ?>
        <div class="col-sm-3 col-md-3 pull-right">
            <?php echo elgg_view('search/search_box', array('class' => 'navbar-form navbar-right search-form')); ?>
        </div>
        <?php elseif(!$vars['walled_garden']): ?>
        <p class="navbar-text navbar-left">
            <?php echo elgg_view('output/url', array(
                'href'  => "/",
                'title' => elgg_echo('back'),
                'text'  => '<i class="fa fa-chevron-left"></i> '. elgg_echo('back'),
                'class' => 'active back-top',
            ));
            ?>
        </p>
        <?php endif; ?>
        <p class="navbar-text navbar-right lang" style="text-transform: uppercase;">
            <?php
//            $installed_langs = get_installed_translations();
            $installed_langs = array(
                'es' => 'Español',
                'en' => 'English',
                'de' => 'Deutsch',
                'pt' => 'Português',
                'sv' => 'Svenska'
            );
            foreach($installed_langs as $key => $language):
                echo elgg_view('output/url', array(
                    'href'  => "action/language/set?lang={$key}",
                    'is_action' => true,
                    'title' => $language,
                    'text'  => $key,
                    'class' => get_current_language() == $key ? 'active' : '',
                ));
                if(end($installed_langs) != $language){
                    echo '<span class="divider">|</span>';
                }
            endforeach;
            ?>
        </p>
    </div>
</nav>