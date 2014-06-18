<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   18/06/14
 * Last update:     18/06/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
?>
<ul id="menu_settings" class="dropdown-menu caret-menu" role="menu" aria-labelledby="settings">
    <li role="presentation">
        <?php echo elgg_view('output/url', array(
            'href'  => "settings/user",
            'title' => elgg_echo('profile:settings:edit_profile'),
            'text'  => '<i class="fa fa-cog"></i> '.elgg_echo('profile:settings:edit_profile'),
        ));
        ?>
    </li>
    <li role="presentation" class="divider"></li>
    <li role="presentation">
        <?php echo elgg_view('output/url', array(
            'href'  => "stats",
            'title' => elgg_echo('profile:stats'),
            'text'  => '<i class="fa fa-bar-chart-o"></i> '.elgg_echo('profile:stats'),
        ));
        ?>
    </li>
</ul>