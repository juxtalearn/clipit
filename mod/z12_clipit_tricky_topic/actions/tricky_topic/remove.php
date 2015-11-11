<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   18/12/2014
 * Last update:     18/12/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$id = get_input('id');

if(ClipitTrickyTopic::delete_by_id(array($id))){
    system_message(elgg_echo('tricky_topic:removed'));
} else {
    register_error(elgg_echo("tricky_topic:cantremove"));
}
forward("tricky_topics");