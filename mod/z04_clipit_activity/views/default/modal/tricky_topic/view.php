<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   2/06/14
 * Last update:     2/06/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$id = (int)get_input("id");
if($tricky_topic = array_pop(ClipitTrickyTopic::get_by_id(array($id)))){
    $body = elgg_view('tricky_topic/view', array('entity'  => $tricky_topic));
    echo elgg_view("page/components/modal",
        array(
            "dialog_class"     => "modal-lg",
            "remote"    => true,
            "target"    => "tricky-topic-{$tricky_topic->id}",
            "title"     => elgg_echo('tricky_topic'),
            "form"      => false,
            "body"      => $body,
            "footer"    => false
        ));
}