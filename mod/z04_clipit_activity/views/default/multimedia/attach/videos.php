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
$entity_id = elgg_extract('entity_id', $vars);
$videos = ClipitGroup::get_videos($entity_id);
?>
<div data-list="videos">
<?php
foreach($videos as $video_id):
    $video = array_pop(ClipitVideo::get_by_id(array($video_id)));
    ?>
    <div class="multimedia-block col-md-4" style="position:relative;border-radius: 4px;margin-bottom: 0;padding: 0;background: transparent;">
        <label class="select-item attach-item" title="<?php echo $video->name;?>" for="item_<?php echo $video_id;?>"></label>
        <input type="checkbox" style="display: none" name="attach_videos[]" value="<?php echo $video_id;?>" id="item_<?php echo $video_id;?>">
        <div class="attach-block">
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
<?php if(!$videos):?>
    <?php echo elgg_view('output/empty', array('value' => elgg_echo('videos:none')));?>
<?php endif;?>
</div>