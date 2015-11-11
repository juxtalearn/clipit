<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   02/12/2014
 * Last update:     02/12/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$entity_id = get_input('entity-id');
$tricky_topic_id = get_input('tricky_topic');

if($tricky_topic = array_pop(ClipitTrickyTopic::get_by_id(array($tricky_topic_id)))){
    if(!in_array($tricky_topic_id, ClipitTag::get_tricky_topics($entity_id))) {
        ClipitTrickyTopic::add_tags($tricky_topic_id, array($entity_id));
    }
}