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
$message = elgg_extract('entity', $vars);

echo elgg_view("input/hidden", array(
    'name' => 'message-id',
    'value' => $message->id,
));
echo elgg_view("input/plaintext", array(
    'name' => 'message-reply',
    'class' => 'form-control mceEditor',
    'id'    => 'mceEditor',
    'rows'  => 6,
    'style' => "width: 100%;"
));
echo elgg_view('input/submit', array(
    'value' => elgg_echo('create'),
    'class' => "btn btn-primary pull-right",
    'style' => "margin-top: 20px;"
));
?>
<div class="upload-files">
    <strong>
        <a style="position: relative;overflow: hidden">
            <i class="fa fa-paperclip"></i> Attach file
            <input id="uploadfiles" type="file" multiple name="files[]">
        </a>
    </strong>
    <div class="upload-files-list" style="float: left; width: 100%;"></div>
</div>
