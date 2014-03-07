<?php
/**
 * Created by PhpStorm.
 * User: equipo
 * Date: 6/03/14
 * Time: 12:04
 */
$message = elgg_extract('entity', $vars);
$reply_id = $message->id;
if($vars['second_reply']){
    $reply_id = $message->destination;
}
echo elgg_view("input/hidden", array(
    'name' => 'message-id',
    'value' => $reply_id,
));
echo elgg_view("input/plaintext", array(
    'name' => 'message-reply',
    'class' => 'form-control wysihtml5',
    'rows'  => 6,
    'style' => "width: 100%;"
));
echo elgg_view('input/submit', array(
    'value' => elgg_echo('create'),
    'class' => "btn btn-primary pull-right",
    'style' => "margin-top: 20px;"
));
