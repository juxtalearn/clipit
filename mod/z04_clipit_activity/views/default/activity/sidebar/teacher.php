<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   9/05/14
 * Last update:     9/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$user_id = elgg_get_logged_in_user_guid();
$teachers = elgg_extract("teachers", $vars);
$access = elgg_extract("access", $vars);
$activity_id = elgg_extract("activity_id", $vars);

$body = '
    <ul style="background: #fff; padding: 10px;">';
        foreach($teachers as $teacher_id){
            $teacher = array_pop(ClipitUser::get_by_id(array($teacher_id)));
            $body .='<li class="list-item">
                '.elgg_view("page/elements/user_block", array("entity" => $teacher)).'
            </li>';
        }
if($access == 'ACCESS_TEACHER'){
    $body .= '<li>';
    $body .= elgg_view('output/url', array(
        'title' => elgg_echo('teachers:add'),
        'text' => '<i class="fa fa-plus"></i> '.elgg_echo('teachers:add'),
        'href' => "clipit_activity/{$activity_id}/admin?filter=setup#add_teachers",
    ));
    $body .= '</li>';
}
$body .= '</ul>';
echo elgg_view_module('aside', elgg_echo('activity:teachers'), $body );
?>
