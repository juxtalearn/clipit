<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   25/06/14
 * Last update:     25/06/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$selected_videos = elgg_extract('selected', $vars);
$entity_id = elgg_extract('entity_id', $vars);
$input_prefix = elgg_extract('input_prefix', $vars);
if($input_prefix) {
    $input_prefix = $input_prefix . "[attach_videos][]";
} else {
    $input_prefix = 'attach_videos[]';
}
$object = ClipitSite::lookup($entity_id);
$videos = $object['subtype']::get_videos($entity_id);
$id = uniqid('add_video_');
?>
<script>
$(function() {
    var $container = $('#<?php echo $id;?>'),
        input_file = $container.find('input[type="file"]'),
        $items = $container.find('.items-list');
    $container.find('.add-video-btn').click(function(){
        var form = $(this).closest('[data-list="videos"]'),
            $items = $('#<?php echo $id;?> .items-list'),
            add_video_options = $(this).closest('.add-video');
        // Collapse add-video container
        add_video_options.find('.in').collapse('hide');

        elgg.get('ajax/view/multimedia/file/attach_action?type=video&prefix=<?php echo json_encode($input_prefix);?>',{
            dataType: "json",
            data: $(this).closest('form').serialize(),
            success: function(json){
                $container.find('.empty').remove();
                $items.prepend(tmpl("template-modal-download", json));
                // Set empty values
                $container.find('.add-video :input').val('');
            }
        });
    });

    input_file.fileupload({
        maxFileSize: 500000000, // 500 MB
        url: elgg.config.wwwroot + 'ajax/view/multimedia/file/attach_action?prefix=<?php echo json_encode($input_prefix);?>',
        autoUpload: true,
        acceptFileTypes: /^video\/(\w+)/g,
        previewMaxWidth: 60,
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
});
</script>
<div data-list="videos" id="<?php echo $id;?>">
    <div class="margin-bottom-10 add-video">
        <strong>
            <?php echo elgg_view('output/url', array(
                'href'  => '#'.$id.'_options',
                'title' => elgg_echo('video:add'),
                'class' => 'pres',
                'text'  => '<i class="fa fa-plus"></i> '. elgg_echo('video:add'),
                'data-toggle' => 'collapse',
            ));
            ?>
        </strong>
        <div class="collapse add-video-options" id="<?php echo $id;?>_options" style="padding: 10px;">
            <?php echo elgg_view("input/text", array(
                'name' => 'video_title',
                'style' => 'width: 70%;',
                'class' => 'form-control',
                'placeholder' => elgg_echo('video:title'),
                'required' => true
            ));
            ?>
            <div id="<?php echo $id;?>_collapse" class="panel-group">
                <div class="margin-top-15 panel" style="  box-shadow: none;">
                    <div style="margin-left: 1px;" class="upload-files inline-block">
                        <a class="btn btn-xs btn-border-blue margin-right-10" style="position: relative;overflow: hidden;" href="javascript:;">
                            <strong>
                                <i class="fa fa-upload"></i> <?php echo elgg_echo('video:add:to_youtube');?>
                                <?php echo elgg_view("input/file", array(
                                    'name' => 'video_file',
                                ));
                                ?>
                            </strong>
                        </a>
                    </div>
                    <?php echo elgg_view('output/url', array(
                        'href'  => '#'.$id.'_paste',
                        'class' => 'btn btn-xs btn-border-blue margin-right-10',
                        'style' => 'font-weight:bold;',
                        'title' => elgg_echo('video:add:paste_url'),
                        'text'  => '<i class="fa fa-link"></i> '. elgg_echo('video:add:paste_url'),
                        'data-parent' => '#'.$id.'_collapse',
                        'data-toggle' => 'collapse',
                    ));
                    ?>

                    <!-- Video paste url -->
                    <div class="collapse margin-top-15" id="<?php echo $id;?>_paste" style="background-color: #f4f4f4;padding: 10px;">
                        <?php echo elgg_view("input/text", array(
                            'name' => 'video_url',
                            'style' => 'width: 70%;',
                            'class' => 'form-control margin-bottom-10',
                            'placeholder' => elgg_echo('video:link:youtube_vimeo'),
                        ));
                        ?>
                        <?php echo elgg_view('output/url', array(
                            'class' => 'btn btn-xs btn-primary add-video-btn',
                            'title' => elgg_echo('add'),
                            'text'  => elgg_echo('add'),
                        ));
                        ?>
                    </div>
                </div> <!-- collapse panel -->
            </div> <!-- collapse parent -->
        </div>
        <hr class="margin-bottom-10 margin-top-10">
    </div>
    <div class="items-list">
        <?php
        foreach($videos as $video_id):
            $video = array_pop(ClipitVideo::get_by_id(array($video_id)));
            $selected = false;
            if(in_array($video_id, $selected_videos)){
                $selected = true;
            }
            ?>
            <div class="multimedia-block col-md-4" style="position:relative;border-radius: 4px;margin-bottom: 0;padding: 0;background: transparent;">
                <label class="select-item attach-item" title="<?php echo $video->name;?>" for="item_<?php echo $video_id;?>"></label>
                <input
                    type="checkbox"
                    <?php echo  $selected ? 'checked' : false;?>
                    style="display: none"
                    name="<?php echo $input_prefix;?>"
                    value="<?php echo $video_id;?>"
                    id="item_<?php echo $video_id;?>"
                    >
                <div class="attach-block <?php echo  $selected ? 'selected' : false;?>">
                    <div class="multimedia-preview" style="margin-right: 0;float: none;display: block;height: 100%;">
                        <img src="<?php echo $video->preview;?>" style="width: 100%;">
                    </div>
                    <div class="multimedia-details" style="overflow: initial;margin-top: 10px;">
                        <div class="blue text-truncate">
                            <a class="item-info">
                                <strong><?php echo $video->name;?></strong>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach;?>
    </div>
    <?php if(!$videos):?>
        <?php echo elgg_view('output/empty', array('value' => elgg_echo('videos:none')));?>
    <?php endif;?>
</div>