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
$user = elgg_extract('entity', $vars);

echo elgg_view("input/hidden", array(
    'name' => 'user-id',
    'value' => $user->id,
));
echo elgg_view("input/plaintext", array(
    'name' => 'message-reply',
    'class' => 'form-control mceEditor',
    'rows'  => 5,
    'required' => true,
    'style' => "width: 100%;"
));
echo elgg_view('input/submit', array(
    'value' => elgg_echo('create'),
    'class' => "btn btn-primary pull-right",
    'style' => "margin-top: 20px;"
));
