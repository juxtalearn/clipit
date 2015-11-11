<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   04/09/2015
 * Last update:     04/09/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$activity = elgg_extract('entity', $vars);
$tabs = array(
    'all' => array(
        'text' => '<span>'.elgg_echo('all').'<span>',
        'href' => "public_activities",
        'priority' => 200,
    ),
    'enroll' => array(
        'text' => elgg_view('output/filter_responsive', array('text' => elgg_echo('status:enroll'), 'icon' => 'fa-clock-o')),
        'href' => "public_activities?filter=enroll",
        'priority' => 300,
    ),
    'active' => array(
        'text' => elgg_view('output/filter_responsive', array('text' => elgg_echo('status:active'), 'icon' => 'fa-play')),
        'href' => "public_activities?filter=active",
        'priority' => 400,
    ),
    'past' => array(
        'text' => elgg_view('output/filter_responsive', array('text' => elgg_echo('status:closed'), 'icon' => 'fa-stop')),
        'href' => "public_activities?filter=closed",
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

echo elgg_view_menu('filter', array('sort_by' => 'priority', 'class' => 'nav nav-tabs'));
