<?php
/**
 * Footer clipit navigation menu
 *
 */

$items = elgg_extract('menu', $vars);
$class = elgg_extract('class', $vars, false);
?>
<ul class="<?php echo $class; ?>">
    <li <?php echo elgg_in_context('explore') ? 'class="active"': '';?>>
        <?php echo elgg_view('output/url', array(
            'href'  => "login",
            'title' => elgg_echo('login'),
            'text'  => '<i class="fa fa-globe visible-xs visible-sm"></i>
                    <span class="hidden-xs hidden-sm">'.elgg_echo('login'). '</span>'
        ));
        ?>
    </li>
    <li class="separator">|</li>
    <li <?php echo elgg_in_context('explore') ? 'class="active"': '';?>>
        <?php echo elgg_view('output/url', array(
            'href'  => "register",
            'title' => elgg_echo('user:register'),
            'text'  => '<i class="fa fa-globe visible-xs visible-sm"></i>
                    <span class="hidden-xs hidden-sm">'.elgg_echo('user:register'). '</span>'
        ));
        ?>
    </li>
    <li class="separator">|</li>
    <li <?php echo elgg_in_context('explore') ? 'class="active"': '';?>>
        <?php echo elgg_view('output/url', array(
            'href'  => "videos",
            'title' => elgg_echo('videos'),
            'text'  => '<i class="fa fa-globe visible-xs visible-sm"></i>
                    <span class="hidden-xs hidden-sm">'.elgg_echo('videos'). '</span>'
        ));
        ?>
    </li>
    <li class="separator">|</li>
    <li <?php echo elgg_in_context('explore') ? 'class="active"': '';?>>
        <?php echo elgg_view('output/url', array(
            'href'  => "public_activities",
            'title' => elgg_echo('activities'),
            'text'  => '<i class="fa fa-globe visible-xs visible-sm"></i>
                    <span class="hidden-xs hidden-sm">'.elgg_echo('activities'). '</span>'
        ));
        ?>
    </li>
</ul>