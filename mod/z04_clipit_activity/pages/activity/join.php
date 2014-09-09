<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   9/09/14
 * Last update:     9/09/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
if($activity_status == 'active' || !$isCalled || $activity->group_mode != ClipitActivity::GROUP_MODE_STUDENT){
    return false;
}
$title = elgg_echo("activity:group:join");
elgg_push_breadcrumb($title);
$params = array(
    'content'   => elgg_view('activity/join', array('entity' => $activity)),
    'filter'    => '',
    'title'     => $title,
    'sub-title' => $activity->name,
    'title_style' => "background: #". $activity->color,
);