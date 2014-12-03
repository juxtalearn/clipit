<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   02/12/2014
 * Last update:     02/12/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$entity_id = get_input('entity-id');
$tricky_topic_id = get_input('tricky_topic');

if($tricky_topic = array_pop(ClipitTrickyTopic::get_by_id(array($tricky_topic_id)))){
    if(!in_array($tricky_topic_id, ClipitTag::get_tricky_topics($entity_id))) {
        ClipitTrickyTopic::add_tags($tricky_topic_id, array($entity_id));
    }
}