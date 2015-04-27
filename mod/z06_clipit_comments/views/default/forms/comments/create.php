<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   22/04/14
 * Last update:     22/04/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$entity = elgg_extract('entity', $vars);
$wysiwyg = "";
if($vars['wysiwyg'] !== false){
    $wysiwyg = "mceEditor";
}
echo elgg_view("input/hidden", array(
    'name' => 'entity-id',
    'value' => $entity->id,
));
echo '<label for="comment-text"></label>';
echo elgg_view("input/plaintext", array(
    'name' => 'comment-text',
    'class' => 'form-control '.$wysiwyg,
    'id'    => uniqid(),
    'rows'  => 6,
    'required' => true,
    'style' => "width: 100%;"
));
echo elgg_view('input/submit', array(
    'value' => elgg_echo('send'),
    'class' => "btn btn-primary pull-right",
    'style' => "margin-top: 20px;"
));

// Attach files
echo elgg_view("multimedia/file/attach", array('entity' => $entity));