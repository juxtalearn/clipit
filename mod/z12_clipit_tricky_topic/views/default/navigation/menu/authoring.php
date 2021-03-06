<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   7/07/14
 * Last update:     7/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
?>
<li <?php echo elgg_in_context('authoring') ? 'class="active"': '';?>>
    <?php echo elgg_view('output/url', array(
        'href'  => "#",
        'data-toggle' => 'dropdown',
        'id' => 'authoring',
        'title' => elgg_echo('teacher:authoring_tools'),
        'text'  => '<i class="fa fa-caret-down pull-right hidden-xs hidden-sm" style="float: right !important;"></i>'.elgg_echo('teacher:authoring_tools'),
        'text' => '<i class="fa fa-cogs visible-xs visible-sm"></i>
                    <i class="fa fa-caret-down pull-right hidden-xs hidden-sm" style="float: right !important;"></i>
                    <span class="hidden-xs hidden-sm">'.elgg_echo('teacher:authoring_tools'). '</span>',
        'aria-hidden' => 'true',
        'aria-label' => elgg_echo('teacher:authoring_tools'),
    ));
    ?>
    <!-- Auhtoring menu -->
    <ul id="menu_authoring" class="dropdown-menu caret-menu" role="menu" aria-labelledby="settings">
        <li role="presentation">
            <?php echo elgg_view('output/url', array(
                'href'  => "tricky_topics",
                'title' => elgg_echo('tricky_topics'),
                'text'  => '<i class="fa fa-list-alt"></i> '.elgg_echo('tricky_topics'),
            ));
            ?>
        </li>
        <li role="presentation" class="divider"></li>
        <li role="presentation">
            <?php echo elgg_view('output/url', array(
                'href'  => "tricky_topics/examples",
                'title' => elgg_echo('examples'),
                'text'  => '<i class="fa fa-list"></i> '.elgg_echo('examples'),
            ));
            ?>
        </li>
        <li role="presentation" class="divider"></li>
        <li role="presentation">
            <?php echo elgg_view('output/url', array(
                'href'  => "quizzes",
                'title' => elgg_echo('quizzes'),
                'text'  => '<i class="fa fa-pencil-square-o"></i> '.elgg_echo('quizzes'),
            ));
            ?>
        </li>
        <li role="presentation" class="divider"></li>
        <li role="presentation">
            <?php echo elgg_view('output/url', array(
                'href'  => "rubrics",
                'title' => elgg_echo('rubrics'),
                'text'  => '<i class="fa fa-star"></i> '.elgg_echo('rubrics'),
            ));
            ?>
        </li>
    </ul>
</li>
<li class="separator">|</li>