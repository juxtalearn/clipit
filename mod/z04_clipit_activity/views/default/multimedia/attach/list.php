<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   24/06/14
 * Last update:     24/06/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$entity_id = elgg_extract('entity_id', $vars);
$list = elgg_extract('list', $vars);
$class = elgg_extract('class', $vars);
$id = elgg_extract('id', $vars);
if(!$id){
    $id = uniqid();
}
?>
<style>
.select-item{
    position: absolute;
    width: 100%;
    height: 100%;
    border-radius: 4px;
    z-index: 10;
    display: none;
    cursor: pointer;
}
.attach-block{
    margin: 2px !important;
    border: 2px solid transparent;
}
.multimedia-block:hover .attach-block{
    border: 2px solid #32b4e5 !important;
}
.multimedia-block:hover .attach-block.selected {
    border: 2px solid rgba(153, 203, 0, 0.5) !important;
}
.multimedia-block .selected{
    border: 2px solid #99cb00;
    display: block;
}
.multimedia-block:hover .select-item{
    display: block;
}
</style>
<style>
    #attach_list ul.menu-list>li {
        padding: 5px;
    }
</style>
<script>
$(function(){
    $.blueimp.fileupload.prototype._renderPreviews = function (data) {
        data.context.find('.preview').each(function (index, elm) {
            var preview = data.files[index].preview;
            if (preview) {
                $(elm).append(preview);
            } else {
                var $icon = $('<i class="icon fa" style="font-size: 50px;"/>');
                $icon = clipit.file.getIcon(data.files[index].type, $icon);
                $(elm).append($icon);
            }
        });
    };
});
</script>
<div data-attach="<?php echo $id;?>" id="attach_list" class="row attach_list <?php echo $class;?>" style="padding: 10px 0;display: none">
    <ul class="col-md-2 margin-top-10 menu-list">
        <li class="selected" data-menu="files">
            <strong><span class="blue-lighter pull-right" id="files_count"></span></strong>
            <?php echo elgg_view('output/url', array(
                'href'  => "javascript:;",
                'title' => elgg_echo('files'),
                'class' => 'element_attach_menu show child-decoration-none',
                'data-menu' => 'files',
                'text'  => '<i class="fa fa-files-o"></i> '.elgg_echo('files')
            ));
            ?>
        </li>
        <li data-menu="videos">
            <strong><span class="blue-lighter pull-right" id="videos_count"></span></strong>
            <?php echo elgg_view('output/url', array(
                'href'  => "javascript:;",
                'title' => elgg_echo('videos'),
                'class' => 'element_attach_menu show child-decoration-none',
                'data-menu' => 'videos',
                'text'  => '<i class="fa fa-video-camera"></i> '.elgg_echo('videos')
            ));
            ?>
        </li>
    </ul>
    <div class="col-md-10" style="border-left: 1px solid #bae6f6;padding: 0px 10px;">
        <div class="multimedia-list">
            <p id="attach-loading"><span><i class="fa fa-spinner fa-spin fa-3x blue-lighter"></i></span></p>
        </div>
    </div>
</div>