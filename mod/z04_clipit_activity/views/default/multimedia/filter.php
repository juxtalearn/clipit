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
$entity = elgg_extract('entity', $vars);
$href = elgg_extract('href', $vars);
$files_count = count($entity->file_array) > 0 ? "(".count($entity->file_array).")" : "";
$videos_count = count($entity->video_array) > 0 ? "(".count($entity->video_array).")" : "";

$tabs = array(
    'files' => array(
        'text' => elgg_echo('multimedia:files').' '.$files_count,
        'href' => "{$href}?filter=files",
        'priority' => 200,
    ),
    'videos' => array(
        'text' => elgg_echo('multimedia:videos').' '.$videos_count,
        'href' => "{$href}?filter=videos",
        'priority' => 300,
    ),
    'storyboards' => array(
        'text' => elgg_echo('multimedia:storyboards').' '.$sb_count,
        'href' => "{$href}?filter=storyboards",
        'priority' => 400,
    ),
    'links' => array(
        'text' => elgg_echo('multimedia:links').' (n)',
        'href' => "{$href}?filter=links",
        'priority' => 500,
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
