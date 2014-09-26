<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   23/04/14
 * Last update:     23/04/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$href = elgg_extract('href', $vars);

$tabs = array(
//    'videos' => array(
//        'text' => elgg_echo('multimedia:videos'),
//        'href' => "{$href}?filter=videos",
//        'priority' => 200,
//    ),
    'videos' => array(
        'text' => elgg_echo('resources'),
        'href' => "{$href}?filter=resources",
        'priority' => 200,
    ),
    'storyboards' => array(
        'text' => elgg_echo('multimedia:storyboards'),
        'href' => "{$href}?filter=storyboards",
        'priority' => 300,
    ),
);

foreach ($tabs as $name => $tab) {
    $tab['name'] = $name;

    if ($vars['selected'] == $name) {
        $tab['selected'] = true;
    }

    elgg_register_menu_item('filter', $tab);
}

echo elgg_view_menu('filter', array('sort_by' => 'priority', 'class' => 'menu-activity-section nav nav-tabs'));