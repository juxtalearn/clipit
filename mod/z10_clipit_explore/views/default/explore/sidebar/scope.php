<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   01/09/2015
 * Last update:     01/09/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$href = elgg_extract('href', $vars);
$icon = '
    <div class="image-block">
        <i class="fa fa-globe"></i>
    </div>';
elgg_register_menu_item('explore:scope', array(
    'name' => 'explore_site',
    'text' => $icon.elgg_echo('explore:public'),
    'href' => "explore{$href}site=true",
    'selected' => $vars['site']
));

echo elgg_view_menu('explore:scope', array(
    'sort_by' => 'register',
));