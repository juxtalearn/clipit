<?php
/**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   22/04/14
 * Last update:     22/04/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$href = elgg_extract('href', $vars);
$files_count = elgg_extract('files_count', $vars);
$videos_count = elgg_extract('videos_count', $vars);
$texts_count = elgg_extract('texts_count', $vars);

$tabs = array(
    'files' => array(
        'text' => elgg_view('output/filter_responsive', array('text' => elgg_echo('multimedia:files'), 'badge' => $files_count, 'icon' => 'fa-files-o')),
        'href' => "{$href}?filter=files",
        'priority' => 200,
    ),
    'videos' => array(
        'text' => elgg_view('output/filter_responsive', array('text' => elgg_echo('multimedia:videos'), 'badge' => $videos_count, 'icon' => 'fa-video-camera')),
        'href' => "{$href}?filter=videos",
        'priority' => 300,
    ),
    /*'texts' => array(
        'text' => elgg_view('output/filter_responsive', array('text' => elgg_echo('multimedia:texts'), 'badge' => $texts_count, 'icon' => 'fa-file-text-o')),
        'href' => "{$href}?filter=texts",
        'priority' => 400,
    ),*/
);
foreach ($tabs as $name => $tab) {
    $tab['name'] = $name;

    if ($vars['selected'] == $name) {
        $tab['selected'] = true;
    }

    elgg_register_menu_item('filter', $tab);
}

echo elgg_view_menu('filter', array('sort_by' => 'priority', 'class' => 'menu-activity-section nav nav-tabs'));
