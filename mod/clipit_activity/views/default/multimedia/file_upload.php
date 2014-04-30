<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   29/04/14
 * Last update:     29/04/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$body .='
<script>$(function(){tinymce_setup();});</script>
<div class="row">
<div class="col-md-3">
    <div class="file-info">
        <div class="no-file" style="display:none;background: #f1f2f7;display:table;width:100%;height: 150px;">
            <div style="display:table-cell;vertical-align:middle;text-align:center;">
               <h2 style="text-transform: uppercase;color: #999;">'.elgg_echo("file:nofile").'</h2>
            </div>
        </div>
    </div>
</div>
<div class="col-md-8">
    <div class="form-group">
        <label for="file-name">'.elgg_echo("multimedia:links:add").'</label>
    '.elgg_view("input/text", array(
        'name' => 'file-name[]',
        'id' => 'file-name',
        'style' => 'padding-left: 25px;',
        'class' => 'form-control blue',
        'required' => true
    )).'
    </div>
    <div class="form-group">
        '.elgg_view("input/plaintext", array(
        'name' => 'file-text[]',
        'class' => 'form-control mceEditor',
        'required' => true,
        'rows'  => 3,
    )).'
    </div>
</div>
</div>';
echo json_encode($body);
?>