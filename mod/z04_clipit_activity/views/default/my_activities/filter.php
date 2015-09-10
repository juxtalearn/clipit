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
        'text' => '<span>'.elgg_echo('all').'<span>',
        'href' => "activities",
        'priority' => 200,
    ),
    'public' => array(
        'text' => elgg_view('output/filter_responsive', array('text' => elgg_echo('activities:open'), 'icon' => 'fa-unlock-alt')),
        'href' => "activities?filter=public",
        'priority' => 300,
    ),
    'enroll' => array(
        'text' => elgg_view('output/filter_responsive', array('text' => elgg_echo('status:enroll'), 'icon' => 'fa-clock-o')),
        'href' => "activities?filter=enroll",
        'priority' => 300,
    ),
    'active' => array(
        'text' => elgg_view('output/filter_responsive', array('text' => elgg_echo('status:active'), 'icon' => 'fa-play')),
        'href' => "activities?filter=active",
        'priority' => 400,
    ),
    'past' => array(
        'text' => elgg_view('output/filter_responsive', array('text' => elgg_echo('status:closed'), 'icon' => 'fa-stop')),
        'href' => "activities?filter=closed",
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
