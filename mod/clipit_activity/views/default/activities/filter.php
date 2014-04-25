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

$tabs = array(
    'all' => array(
        'text' => elgg_echo('all'),
        'href' => "my_activities",
        'priority' => 200,
    ),
    'active' => array(
        'text' => elgg_echo('active'),
        'href' => "my_activities?filter=active",
        'priority' => 300,
    ),
    'past' => array(
        'text' => elgg_echo('past'),
        'href' => "my_activities?filter=past",
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
