<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   22/04/14
 * Last update:     22/04/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$activity = elgg_extract('entity', $vars);
$href = elgg_extract('href', $vars);

$tabs = array(
    'files' => array(
        'text' => elgg_echo('sta:files').' (n)',
        'href' => "{$href}?filter=files",
        'priority' => 200,
    ),
    'videos' => array(
        'text' => elgg_echo('sta:videos').' (n)',
        'href' => "{$href}?filter=videos",
        'priority' => 300,
    ),
    'links' => array(
        'text' => elgg_echo('sta:links').' (n)',
        'href' => "{$href}?filter=links",
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

echo elgg_view_menu('filter', array('sort_by' => 'priority', 'class' => 'menu-activity-section nav nav-tabs'));
