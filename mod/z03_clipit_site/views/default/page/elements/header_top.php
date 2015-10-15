<?php
$site = elgg_get_site_entity();
?>
<nav class="navbar navbar-default navbar-static-top navbar-blue" role="navigation">
    <?php echo elgg_view('output/url', array(
        'href' => "/",
        'class' => 'navbar-brand visible-xs visible-sm col-xs-6',
        'title' => 'ClipIt'. elgg_echo("home"),
        'text'  =>
            elgg_view('output/img', array(
                'src' => "mod/z03_clipit_site/graphics/icons/clipit_logo_white.png",
                'style' => 'height: auto !important;'
            ))
    ));
    ?>
    <div class="container">
        <h2 class="white pull-left site-title hidden-xs hidden-sm" style="font-size: 13px;font-family: FuturaBoldRegular,Impact,'Impact Bold',Helvetica,Arial,sans,sans-serif;margin: 0;padding: 10px 0;letter-spacing: .5px;"><?php echo $site->name;?></h2>
        <?php
        if (elgg_is_logged_in()): ?>
        <div class="col-md-3 pull-right">
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
        <?php
        $installed_langs = array(
            'es' => 'Español',
            'en' => 'English',
            'de' => 'Deutsch',
            'pt' => 'Português',
            'sv' => 'Svenska'
        );
        ?>
        <div class="navbar-text navbar-right lang" style="text-transform: uppercase;">
            <div class="visible-xs visible-sm text-right">
                <div class="dropdown inline-block margin-right-10">
                    <button class="btn btn-xs btn-primary margin-right-5" style="text-transform:uppercase;box-shadow: none;background-color: #1ba1d3;" id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo get_current_language();?>
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu text-left" role="menu" aria-labelledby="dLabel" style="right: 0;left: auto;">
                        <?php foreach($installed_langs as $key => $language):
                            $active = false;
                            if(get_current_language() == $key){
                                $active = 'active';
                            }
                            echo '<li class="'.$active.'">';
                            echo elgg_view('output/url', array(
                                'href'  => "action/language/set?lang={$key}",
                                'is_action' => true,
                                'title' => $language,
                                'text'  => $language,
                            ));
                            echo '</li>';
//                            if(end($installed_langs) != $language){
//                                echo '<span class="divider">|</span>';
//                            }
                        endforeach;
                        ?>
                    </ul>
                </div>
                <?php if(elgg_is_logged_in()):?>
                    <i class="fa fa-search white"></i>
                    <?php echo elgg_view('output/url', array(
                        'href'  => 'action/logout',
                        'title' => elgg_echo('user:logout'),
                        'class' => 'fa fa-sign-out',
                        'text' => ''
                    ));
                    ?>
                <?php endif;?>
            </div>
            <div class="hidden-xs hidden-sm lang-horizontal">
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
                $active = false;
                if(get_current_language() == $key){
                    $active = 'active';
                }
                echo elgg_view('output/url', array(
                    'href'  => "action/language/set?lang={$key}",
                    'is_action' => true,
                    'title' => $language,
                    'text'  => $key,
                    'class' => $active,
                ));
                if(end($installed_langs) != $language){
                    echo '<span class="divider">|</span>';
                }
            endforeach;
            ?>
            </div>
        </div>
    </div>
</nav>
