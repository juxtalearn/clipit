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
$category = elgg_extract('category', $vars);

echo elgg_view("input/hidden", array(
    'name' => 'message-id',
    'value' => $entity->id,
));
echo elgg_view("input/hidden", array(
    'name' => 'message-category',
    'value' => $category,
));
echo elgg_view("input/plaintext", array(
    'name' => 'message-reply',
    'class' => 'form-control wysihtml5',
    'rows'  => 6,
    'style' => "width: 100%;"
));
echo elgg_view('input/submit', array(
    'value' => elgg_echo('submit'),
    'class' => "btn btn-primary pull-right",
    'style' => "margin-top: 20px;"
));