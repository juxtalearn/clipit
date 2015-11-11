<?php
/**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   22/04/14
 * Last update:     22/04/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$message = elgg_extract('entity', $vars);
echo elgg_view("input/hidden", array(
    'name' => 'message-id',
    'value' => $message->id,
));
echo '<label for="message-reply"></label>';
echo elgg_view("input/plaintext", array(
    'name' => 'message-reply',
    'class' => 'form-control mceEditor',
    'id'    => 'mceEditor',
    'rows'  => 6,
    'required'  => true,
    'style' => "width: 100%;"
));
echo elgg_view('input/submit', array(
    'value' => elgg_echo('send'),
    'class' => "btn btn-primary pull-right",
    'style' => "margin-top: 20px;"
));

// Attach system
echo elgg_view("multimedia/file/attach", array('entity' => $message));
