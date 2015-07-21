<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   20/07/2015
 * Last update:     20/07/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$activity = get_input('activity');
$data = array(
    'is_open' => $activity['is_open'],
);
if($activity['is_open']){
    $data = array_merge($data, array(
        'group_mode' => ClipitActivity::GROUP_MODE_STUDENT,
        'max_group_size' => $activity['max_group_size'],
        'max_students' => $activity['max_students'],
    ));
}
ClipitActivity::set_properties($activity['id'], $data);