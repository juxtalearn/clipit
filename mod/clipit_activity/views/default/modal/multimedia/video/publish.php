<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   16/05/14
 * Last update:     16/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$id = (int)get_input("id");
$parent_id = (int)get_input("parent_id");
$user_id = elgg_get_logged_in_user_guid();
$video = array_pop(ClipitVideo::get_by_id(array($id)));

if($video && $parent_id){
    echo elgg_view_form('multimedia/videos/publish', array('data-validate'=> "true" ), array('entity'  => $video, 'parent_id' => $parent_id));
}