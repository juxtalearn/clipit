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
$group = elgg_extract('entity', $vars);


echo elgg_view("input/hidden", array(
    'name' => 'group-id',
    'value' => $group->id,
));
echo elgg_view("input/file", array(
    'name' => 'file',
));
echo '<div class="form-group">
    <label for="discussion-title">'.elgg_echo("files:title").'</label>
    '.elgg_view("input/text", array(
        'name' => 'file-title',
        'class' => 'form-control',
        'required' => true
    )).'
</div>';

echo '<div class="form-group">
    <label for="discussion-text">'.elgg_echo("files:description").'</label>
    '.elgg_view("input/plaintext", array(
        'name' => 'file-text',
        'class' => 'form-control wysihtml5',
        'required' => true,
        'rows'  => 6,
    )).'
</div>';


echo elgg_view('input/submit', array('value' => elgg_echo('send')));