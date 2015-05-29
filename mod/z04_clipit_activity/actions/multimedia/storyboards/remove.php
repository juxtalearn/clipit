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
$id = get_input('id');
$user_id = elgg_get_logged_in_user_guid();
$ids = is_array($id) ? $id : array($id);
$unlink = get_input('unlink');

if(!$unlink){
    foreach($ids as $sb_id){
        $storyboard = array_pop(ClipitStoryboard::get_by_id(array((int)$sb_id)));
        if($storyboard &&  $storyboard->owner_id == $user_id){
            ClipitStoryboard::delete_by_id(array($storyboard->id));
            system_message(elgg_echo("storyboard:removed", array($storyboard->name)));
        } else{
            register_error(elgg_echo("storyboard:cantremove"));
        }
    }
    forward(custom_forward_referer("/view/", "?filter=storyboards"));
} else {
    ClipitStoryboard::unlink_from_parent($id);
    ClipitTask::remove_storyboards(ClipitStoryboard::get_task($id), array($id));
    system_message(elgg_echo('storyboard:removed', array($storyboard->name)));
}


