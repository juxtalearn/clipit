<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   20/05/14
 * Last update:     20/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$comment_text = get_input("comment-text");
$entity_id = get_input("entity-id");
$file_ids = get_input('file-id');
$object = ClipitSite::lookup($entity_id);
$user_id = elgg_get_logged_in_user_guid();
$href = REFERER;
$entity_class = $object['subtype']; // debug test
$entity = array_pop($entity_class::get_by_id(array($entity_id)));

if(!$entity || trim($comment_text) == ""){
    register_error(elgg_echo("comment:cantcreate"));
} else{
    $new_comment_id = ClipitComment::create(array(
        'name' => '',
        'description'   => $comment_text,
        'destination'   => $entity->id
    ));
    if($file_ids){
        ClipitComment::add_files($new_comment_id, $file_ids);
    }
    system_message(elgg_echo('comment:created'));
    $offset = '';
    if($entity_class == 'ClipitComment'){
        $object = ClipitSite::lookup($entity->destination);
        $entity = array_pop($object['subtype']::get_by_id(array($entity->destination)));
    } else {
        $entities_count = array_pop(ClipitComment::count_by_destination(array($entity->id)));
        $offset = "?offset=" . clipit_get_offset_last($entities_count);
    }
    switch($entity::get_scope($entity->id)){
        case 'site':
            $page = 'explore/';
            break;
        case 'task':
            $page = 'clipit_activity/'.$entity::get_activity($entity->id).'/publications/';
            break;
    }
    $href = $page.'view/'.$entity->id.$offset.'#comment_'.$new_comment_id;
}

forward($href);
