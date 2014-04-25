<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   25/04/14
 * Last update:     25/04/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$messages = elgg_extract('entity', $vars);
$items = array();
foreach($messages as $message){
    $message->description = trim(elgg_strip_tags($message->description));
    // Message text truncate max length 50
    if(mb_strlen($message->description) > 50){
        $message->description = substr($message->description, 0, 50)."...";
    }
    // Options
    $move_msg_url = "action/messages/list?set-option=to_inbox&check-msg[]={$message->id}";
    $message->option = array(
        'buttons' => elgg_view('output/url', array(
            'href'  => elgg_add_action_tokens_to_url($move_msg_url, true),
            'title' => elgg_echo("message:movetoinbox"),
            'style' => 'padding: 3px 9px;',
            'text'  => '<i class="fa fa-check"></i> '.elgg_echo("message:movetoinbox"),
            'class' => 'btn btn-success-o btn-xs',
        ))
    );
    $item = array(
        $message->description,
        $message->option
    );
    $items = array_merge($items, $item);
}

echo elgg_view("messages/list/section", array('items' => $items));
?>
