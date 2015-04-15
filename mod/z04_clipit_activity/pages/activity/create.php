<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   7/07/14
 * Last update:     7/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$step = get_input('step');
$selected_tab = 'step_info';

$filter = elgg_view('activity/create/filter', array('selected' => $selected_tab, 'step' => $step));

$params = array(
    'content' => elgg_view_form('activity/create', array('id' => 'activity-create', 'data-validate' => 'true')),
    'title' => elgg_echo("activity:create"),
    'filter' => $filter,
);
$body = elgg_view_layout('one_column', $params);

echo elgg_view_page($title, $body);
