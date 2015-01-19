<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   01/12/2014
 * Last update:     01/12/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$href = elgg_extract('href', $vars);
$tabs = array(
    'all' => array(
        'text' => elgg_echo('all'),
        'href' => "quizzes/{$href}",
        'priority' => 100,
    ),
    'mine' => array(
        'text' => elgg_echo('mine'),
        'href' => "quizzes/{$href}?filter=mine",
        'priority' => 200,
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