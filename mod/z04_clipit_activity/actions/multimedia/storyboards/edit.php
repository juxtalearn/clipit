<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   7/05/14
 * Last update:     7/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$user_id = elgg_get_logged_in_user_guid();
$id = get_input('entity-id');
$storyboard = array_pop(ClipitStoryboard::get_by_id(array($id)));

$sb_description = get_input('sb-description');

if(!isset($storyboard) || trim($sb_description) == ""){
    register_error(elgg_echo("storyboard:cantedit"));
} else{
    ClipitStoryboard::set_properties($storyboard->id, array(
        'description' => $sb_description
    ));
    system_message(elgg_echo('storyboard:edited'));
}


forward(REFERER);