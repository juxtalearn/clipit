<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   8/07/14
 * Last update:     8/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */

$tabs = array(
    'step_info' => array(
        'text' => '<i class="fa fa-info-circle"></i> '.elgg_echo('activity:admin:info'),
        'href' => "javascript:;",
        'id' => 'nav-step-0',
        'data-step' => 0,
        'priority' => 50,
    ),
    'step_1' => array(
        'text' => elgg_echo('activity:admin:setup'),
        'href' => "javascript:;",
        'id' => 'nav-step-1',
        'data-step' => 1,
        'priority' => 100,
    ),
    'step_2' => array(
        'text' => elgg_echo('activity:admin:task_setup'),
        'href' => "javascript:;",
        'id' => 'nav-step-2',
        'data-step' => 2,
        'priority' => 200,
    ),
    'step_3' => array(
        'text' => elgg_echo('activity:admin:groups'),
        'href' => "javascript:;",
        'id' => 'nav-step-3',
        'data-step' => 3,
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
echo elgg_view_menu('filter', array('sort_by' => 'priority', 'class' => 'nav nav-tabs nav-steps hidden-xs'));
