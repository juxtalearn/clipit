<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   24/06/14
 * Last update:     24/06/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$storyboards = elgg_extract('storyboards', $vars);
?>
<table style="display: none" class="table table-advance table-hover files-table row">
    <?php
    foreach($storyboards as $storyboard):
        $file = array_pop(ClipitFile::get_by_id(array($storyboard->file)));
    ?>
    <tr class="col-md-6">
        <td class="text-center">
            <div class="multimedia-preview">
                <?php echo elgg_view('output/url', array(
                    'href'  => $sb_url,
                    'title' => $storyboard->name,
                    'text'  => elgg_view("multimedia/file/preview", array('file'  => $file))
                )); ?>
            </div>
        </td>
        <td class="col-md-9 file-info">
            <h4>
                <?php echo elgg_view('output/url', array(
                    'href'  => $file_url,
                    'title' => $file->name,
                    'text'  => $file->name));
                ?>
            </h4>
            <small class="show">
                <strong><?php echo elgg_echo("file:" . $file->mime_type['short']);?></strong>
            </small>
            <?php echo elgg_view('tricky_topic/tags/view', array('tags' => $storyboard->tag_array, 'width' => 100, 'limit' => 2)); ?>
        </td>
        <td class="col-md-3" style="vertical-align: middle;">
            <div style="width: 35px;display: inline-block;float: right;text-align: center;margin-left:10px;">
                <?php echo elgg_view('output/url', array(
                    'href'  => "file/download/".$file->id,
                    'title' => $file->name,
                    'class' => 'btn btn-default btn-icon',
                    'text'  => '<i class="fa fa-download"></i>'));
                ?>
                <small class="show text-truncate" title="'.formatFileSize($file->size).'" style="margin-top: 3px;">
                    <?php echo formatFileSize($file->size); ?>
                </small>
            </div>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<div class="row">
    <?php
    foreach($storyboards as $storyboard):
        $file = array_pop(ClipitFile::get_by_id(array($storyboard->file)));
    ?>
    <div class="col-md-6">
        <div style="border-bottom: 1px solid #bae6f6;margin-bottom: 10px;padding-bottom: 5px;height: 65px;">
            <div class="image-block">
                <div class="multimedia-preview">
                    <?php echo elgg_view('output/url', array(
                        'href'  => $sb_url,
                        'title' => $storyboard->name,
                        'text'  => elgg_view("multimedia/file/preview", array('file'  => $file))
                    )); ?>
                </div>
            </div>
            <div class="content-block" style="height: 70px;">
                <div style="width: 35px;display: inline-block;float: right;text-align: center;margin-left:10px;">
                    <?php echo elgg_view('output/url', array(
                        'href'  => "file/download/".$file->id,
                        'title' => $file->name,
                        'class' => 'btn btn-default btn-icon',
                        'text'  => '<i class="fa fa-download"></i>'));
                    ?>
                    <small class="show text-truncate" title="<?php echo formatFileSize($file->size);?>" style="margin-top: 3px;font-size: 75%">
                        <?php echo formatFileSize($file->size); ?>
                    </small>
                </div>
                <div>
                    <strong>
                        <?php echo elgg_view('output/url', array(
                            'href'  => $sb_url,
                            'title' => $storyboard->name,
                            'text'  => $storyboard->name
                        )); ?>
                    </strong>
                    <small class="show">
                        <strong><?php echo elgg_echo("file:" . $file->mime_type['short']);?></strong>
                    </small>
                    <?php echo elgg_view('tricky_topic/tags/view', array('tags' => $storyboard->tag_array, 'width' => 100, 'limit' => 2)); ?>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>