<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   18/06/14
 * Last update:     18/06/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$user = elgg_extract('entity', $vars);
echo elgg_view('input/hidden', array(
    'name' => 'user_id',
    'value' => $user->id,
));

echo elgg_view('input/submit', array(
    'value' => elgg_echo('save'),
    'class' => "btn btn-primary pull-right",
    'style' => "margin-top: 20px;"
));