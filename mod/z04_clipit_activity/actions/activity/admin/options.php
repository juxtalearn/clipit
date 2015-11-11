<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   20/07/2015
 * Last update:     20/07/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$activity = get_input('activity');
$data = array(
    'public' => $activity['public'],
);
if($activity['public']){
    $data = array_merge($data, array(
        'group_mode' => ClipitActivity::GROUP_MODE_STUDENT,
        'max_group_size' => $activity['max_group_size'],
        'max_students' => $activity['max_students'],
    ));
}
ClipitActivity::set_properties($activity['id'], $data);