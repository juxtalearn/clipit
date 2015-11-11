<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   25/06/14
 * Last update:     25/06/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$entity = elgg_extract("entity", $vars);
$href = elgg_extract("href", $vars);
$file = elgg_extract('file', $vars);
?>
<style>
.message-owner .multimedia-preview .file-icon{
    font-size: 70px;
}
.message-owner .multimedia-preview .img-preview{
    height: 70px;
    width: 70px;
}
.message-owner .multimedia-preview img{
    height: 70px;
    width: auto;
}
</style>
<div class="file col-md-4" style="height: 100px;">
    <strong>
        <?php echo elgg_view('output/url', array(
            'class' => 'text-truncate',
            'href'  => "{$href}/".$entity->id,
            'title' => $entity->name,
            'text'  => $entity->name,
            'target' => 'blank_'
        ));
        ?>
    </strong>
    <div style="overflow: hidden;margin-top: 5px;">
        <div class="preview" style="width: auto;padding: 0;">
            <div class="multimedia-preview">
                <?php if($file):?>
                    <?php $preview =  elgg_view("multimedia/file/preview", array('file'  => $file, 'size' => 'medium'));?>
                <?php else: ?>
                    <?php $preview = '<img src="'.$entity->preview.'"/>'; ?>
                <?php endif; ?>
                <?php echo elgg_view('output/url', array(
                    'class' => 'text-truncate',
                    'href'  => "{$href}/".$entity->id,
                    'title' => $entity->name,
                    'text'  => $preview,
                    'target' => 'blank_'
                ));
                ?>
            </div>
        </div>
        <div class="details">
            <small class="show">
                <?php echo elgg_view('output/friendlytime', array('time' => $entity->time_created));?>
            </small>
            <small class="show" style="margin: 5px 0;">
                <strong>
                <?php if($file):?>
                    <?php echo elgg_echo("file:" . $file->mime_short);?>
                <?php else: ?>
                    <?php echo elgg_echo('video');?>
                <?php endif; ?>
                </strong>
            </small>
            <?php if($file):?>
                <?php echo elgg_view('output/url', array(
                    'class' => 'btn btn-default btn-xs',
                    'style' => 'margin-right: 5px;font-family: inherit;',
                    'href'  => "file/download/".$file->id,
                    'title' => $file->name,
                    'text'  => '<i class="fa fa-download"></i>',
                    'target' => 'blank_'
                ));
                ?>
                <small><?php echo formatFileSize($file->size); ?></small>
            <?php endif; ?>
        </div>
    </div>
</div>