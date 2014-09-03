<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   2/09/14
 * Last update:     2/09/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$max_users = (int)get_input('max-users');
$group_mode = get_input('group-mode');
$activity_id = get_input('entity-id');

ClipitActivity::set_properties($activity_id, array('group_mode' => $group_mode, 'max_group_size' => $max_users));

forward(REFERRER);