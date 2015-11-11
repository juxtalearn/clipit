<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   23/04/14
 * Last update:     23/04/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$href = elgg_extract('href', $vars);

$tabs = array(
    'videos' => array(
        'text' => elgg_view('output/filter_responsive', array('text' => elgg_echo('multimedia:videos'), 'icon' => 'fa-video-camera')),
        'href' => "{$href}?filter=videos",
        'priority' => 200,
    ),
    'files' => array(
        'text' => elgg_view('output/filter_responsive', array('text' => elgg_echo('multimedia:files'), 'icon' => 'fa-files-o')),
        'href' => "{$href}?filter=files",
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