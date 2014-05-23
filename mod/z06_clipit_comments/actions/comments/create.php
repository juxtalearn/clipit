<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   20/05/14
 * Last update:     20/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$comment_text = get_input("comment-text");
$entity_id = get_input("entity-id");
$file_ids = get_input('file-id');
$object = ClipitSite::lookup($entity_id);
$user_id = elgg_get_logged_in_user_guid();

$entity_class = $object['subtype']; // debug test
$entity = array_pop($entity_class::get_by_id(array($entity_id)));
if(!$entity || trim($comment_text) == ""){
    register_error(elgg_echo("comment:cantcreate"));
} else{
    $new_comment_id = ClipitComment::create(array(
        'name' => '',
        'description'   => $comment_text,
        'destination'   =>$entity->id
    ));
    if($file_ids){
        ClipitComment::add_files($new_comment_id, $file_ids);
    }
    system_message(elgg_echo('comment:created'));
}
forward(REFERER);