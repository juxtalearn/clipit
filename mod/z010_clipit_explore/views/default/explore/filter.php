<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   24/06/14
 * Last update:     24/06/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$href = elgg_extract('href', $vars);

$tabs = array(
    'videos' => array(
        'text' => elgg_echo('videos'),
        'href' => "{$href}?filter=videos",
        'priority' => 100,
    ),
    'storyboards' => array(
        'text' => elgg_echo('storyboards'),
        'href' => "{$href}?filter=storyboards",
        'priority' => 200,
    ),
    'files' => array(
        'text' => elgg_echo('files'),
        'href' => "{$href}?filter=files",
        'priority' => 300,
    ),
    'activities' => array(
        'text' => elgg_echo('activities'),
        'href' => "{$href}?filter=activities",
        'priority' => 400,
    ),
);

foreach ($tabs as $name => $tab) {
    $tab['name'] = $name;

    if ($vars['selected'] == $name) {
        $tab['selected'] = true;
    }

    elgg_register_menu_item('filter', $tab);
}

echo elgg_view_menu('filter', array('sort_by' => 'priority', 'class' => 'nav nav-tabs'));