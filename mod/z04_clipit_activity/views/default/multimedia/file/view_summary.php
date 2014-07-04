<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   2/07/14
 * Last update:     2/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$file = elgg_extract('file', $vars);
?>
<div class="multimedia-block">
    <div class="multimedia-preview">
        <?php echo elgg_view("multimedia/file/preview", array('file'  => $file));?>
    </div>
        <div class="multimedia-details">
        <?php if($vars['title'] !== false):?>
            <div><?php echo $file->name;?></div>
        <?php endif;?>
        <small class="show"><strong><?php echo elgg_echo("file:" . $file->mime_type['short']);?></strong></small>
        <small class="show"><?php echo formatFileSize($file->size);?></small>
    </div>
</div>
