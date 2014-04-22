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
 * @package         Clipit
 */
$activity = elgg_extract('entity', $vars);

$tabs = array(
    'files' => array(
        'text' => elgg_echo('sta:files').' (n)',
        'href' => "clipit_activity/{$activity->id}/materials?filter=files",
        'priority' => 200,
    ),
    'videos' => array(
        'text' => elgg_echo('sta:videos').' (n)',
        'href' => "clipit_activity/{$activity->id}/materials?filter=videos",
        'priority' => 300,
    ),
    'links' => array(
        'text' => elgg_echo('sta:links').' (n)',
        'href' => "clipit_activity/{$activity->id}/materials?filter=links",
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
