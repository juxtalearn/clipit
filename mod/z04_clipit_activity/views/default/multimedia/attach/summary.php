<?php
/**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   12/05/14
 * Last update:     12/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$files_id = elgg_extract("files", $vars);
?>
<div class="attachment-files" style="overflow: hidden;">
    <span class="total-files"><i class="fa fa-paperclip"></i> <?php echo count($files_id);?> <?php echo elgg_echo('attachments');?></span>
    <?php
    foreach($files_id as $file_id):
        $file = array_pop(ClipitFile::get_by_id(array($file_id)));

        $isViewer = elgg_view("multimedia/file/view", array(
            'file'  => $file,
            'size'  => 'original' ));
        $href_viewer = false;
        if($isViewer){
            echo elgg_view("page/components/modal_remote", array('id'=> "viewer-id-{$file->id}" ));
            $href_viewer = "ajax/view/multimedia/file/viewer?id=".$file->id;
        }
        ?>
        <div class="file col-md-3">
            <div class="preview">
                <div class="multimedia-preview">
                    <?php echo elgg_view('output/url', array(
                        'href'  => $href_viewer,
                        'title' => $file->name,
                        'data-target' => '#viewer-id-'.$file->id,
                        'data-toggle' => 'modal',
                        'text'  => elgg_view("multimedia/file/preview", array('file'  => $file))));
                    ?>
                </div>
            </div>
            <div class="details">
                <strong>
                    <?php if ($isViewer): ?>
                        <?php echo elgg_view('output/url', array(
                            'href'  => $href_viewer,
                            'title' => $file->name,
                            'class' => 'text-truncate',
                            'data-target' => '#viewer-id-'.$file->id,
                            'data-toggle' => 'modal',
                            'text'  => $file->name));
                        ?>
                    <?php else: ?>
                        <div class="name text-truncate" title="<?php echo $file->name; ?>">
                            <?php echo $file->name; ?>
                        </div>
                    <?php endif; ?>
                </strong>
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
            </div>
        </div>
    <?php endforeach; ?>
</div>