<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   2/07/14
 * Last update:     2/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$file = elgg_extract('file', $vars);
?>
<div class="multimedia-block">
    <div class="multimedia-preview">
        <?php echo elgg_view("multimedia/file/preview", array('file'  => $file));?>
    </div>
    <div class="multimedia-details">
        <div class="pull-right">
            <?php echo elgg_view('output/url', array(
                'href'  => "file/download/{$file->id}",
                'target' => '_blank',
                'class' => 'btn btn-icon btn-primary',
                'text'  => '<i class="fa fa-download"></i>',
            ));
            ?>
        </div>
        <small class="show"><strong><?php echo elgg_echo("file:" . $file->mime_short);?></strong></small>
        <small class="show"><?php echo formatFileSize($file->size);?></small>
    </div>
</div>
