<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   19/03/14
 * Last update:     19/03/14
 *
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, JuxtaLearn Project
 * @version         $Version$
 * @link            http://juxtalearn.org
 * @license         GNU Affero General Public License v3
 *                  (http://www.gnu.org/licenses/agpl-3.0.txt)
 *                  This program is free software: you can redistribute it and/or modify
 *                  it under the terms of the GNU Affero General Public License as
 *                  published by the Free Software Foundation, version 3.
 *                  This program is distributed in the hope that it will be useful,
 *                  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *                  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 *                  GNU Affero General Public License for more details.
 *                  You should have received a copy of the GNU Affero General Public License
 *                  along with this program. If not, see
 *                  http://www.gnu.org/licenses/agpl-3.0.txt.
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