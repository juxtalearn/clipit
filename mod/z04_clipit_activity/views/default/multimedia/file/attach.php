<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   12/05/14
 * Last update:     12/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$entity = elgg_extract('entity', $vars);
$col_class = $vars['class'] ?  $vars['class'] : "col-md-9" ;
elgg_load_js("file:attach");
echo elgg_view("multimedia/file/templates/attach", array('entity' => $entity));
?>
<div class="upload-files <?php echo $col_class; ?>">
    <a style="position: relative;overflow: hidden;" href="javascript:;">
        <strong>
            <i class="fa fa-paperclip"></i> <?php echo elgg_echo('multimedia:attach_files');?>
            <input type="file" multiple name="files">
        </strong>
    </a>
    <div class="upload-files-list files" style="display:none;float: left; width: 100%;"></div>
</div>