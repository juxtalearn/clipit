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
$selected_files = elgg_extract('selected', $vars);
$entity_id = elgg_extract('entity_id', $vars);
$input_prefix = elgg_extract('input_prefix', $vars);
if($input_prefix) {
    $input_prefix = $input_prefix . "[attach_files][]";
} else {
    $input_prefix = 'attach_files[]';
}
$object = ClipitSite::lookup($entity_id);
$files = $object['subtype']::get_files($entity_id);
$id = uniqid('attach_files_');

switch($object['subtype']){
    case 'ClipitActivity':
        $href_file = "clipit_activity/{$entity_id}/resources/view/";
        break;
    case 'ClipitGroup':
        $activity_id = ClipitGroup::get_activity($entity_id);
        $href_file = "clipit_activity/{$activity_id}/group/{$entity_id}/repository/view/";
        break;
}
?>
<script>
    var $container = $('#<?php echo $id;?>'),
        input_file = $container.find('input[type="file"]'),
        $items = $container.find('.items-list');
    input_file.fileupload({
        maxFileSize: 500000000, // 500 MB
        url: elgg.config.wwwroot + 'ajax/view/multimedia/file/attach_action?prefix=<?php echo json_encode($input_prefix);?>',
        autoUpload: true,
        previewMaxWidth: 60,
//        acceptFileTypes: /(^(?!video).*)/g,
        acceptFileTypes: /^(?!video\/)(\w+)/g,
        //acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        downloadTemplateId: 'template-modal-download',
        uploadTemplateId: 'template-modal-upload',
        filesContainer: $items,
        prependFiles: true,
        previewMaxHeight: 60,
        disableImageResize: /Android(?!.*Chrome)|Opera/
            .test(window.navigator.userAgent),
        previewCrop: true
    }).on('fileuploadfinished', function(){
        var empty_content = $container.find('.empty');
        if(empty_content.length > 0){
            empty_content.remove();
        }
    });
</script>
<div data-list="files" id="<?php echo $id;?>">
    <div class="upload-files margin-bottom-10">
        <a style="position: relative;overflow: hidden;" href="javascript:;">
            <strong>
                <i class="fa fa-paperclip"></i> <?php echo elgg_echo('multimedia:attach_files');?>
                <input type="file" multiple name="files">
            </strong>
        </a>
        <hr class="margin-bottom-10 margin-top-10">
    </div>
    <div class="items-list">
<?php
foreach($files as $file_id):
    $file = array_pop(ClipitFile::get_by_id(array($file_id)));
    $selected = false;
    if(in_array($file_id, $selected_files)){
        $selected = true;
    }
?>
    <div class="multimedia-block col-md-4" style="position:relative;border-radius: 4px;margin-bottom: 0;padding: 0;background: transparent;">
        <label class="select-item attach-item" title="<?php echo $file->name;?>" for="item_<?php echo $file_id;?>"></label>
        <input
            type="checkbox"
            <?php echo  $selected ? 'checked' : false;?>
            style="display: none"
            name="<?php echo $input_prefix;?>"
            value="<?php echo $file_id;?>"
            id="item_<?php echo $file_id;?>"
            >
        <div class="attach-options">
            <?php echo elgg_view('output/url', array(
                'href' => 'file/download/'.$file_id,
                'class' => 'fa fa-download btn-icon',
                'target' => '_blank',
                'text'  => ''
            ));
            ?>
            <?php echo elgg_view('output/url', array(
                'href' => $href_file.$file_id,
                'class' => 'fa fa-external-link btn-icon',
                'target' => '_blank',
                'text'  => ''
            ));
            ?>
        </div>
        <div class="attach-block <?php echo  $selected ? 'selected' : false;?>">
            <div class="multimedia-preview" >
                <?php echo elgg_view("multimedia/file/preview", array('file'  => $file, 'size' => 'medium'));?>
            </div>
            <div class="multimedia-details">
                <div class="blue text-truncate">
                    <a class="item-info"><?php echo $file->name;?></a>
                </div>
                <small class="show"><strong><?php echo elgg_echo("file:" . $file->mime_short);?></strong></small>
            </div>
        </div>
    </div>
<?php endforeach;?>
    </div>
<?php if(!$files):?>
    <?php echo elgg_view('output/empty', array('value' => elgg_echo('file:none')));?>
<?php endif;?>
</div>