<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   17/07/14
 * Last update:     17/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$href = elgg_extract('href', $vars);
$tabs = array(
    'setup' => array(
        'text' => elgg_view('output/filter_responsive', array('text' => elgg_echo('activity:admin:setup'), 'icon' => 'fa-cog')),
        'href' => "{$href}?filter=setup",
    ),
    'tasks' => array(
        'text' => elgg_view('output/filter_responsive', array('text' => elgg_echo('activity:admin:task_setup'), 'icon' => 'fa-tasks')),
        'href' => "{$href}?filter=tasks",
    ),
    'groups' => array(
        'text' => elgg_view('output/filter_responsive', array('text' => elgg_echo('activity:admin:groups'), 'icon' => 'fa-users')),
        'href' => "{$href}?filter=groups",
    ),
    'options' => array(
        'text' => elgg_view('output/filter_responsive', array('text' => elgg_echo('activity:admin:options'), 'icon' => 'fa-users')),
        'href' => "{$href}?filter=options",
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