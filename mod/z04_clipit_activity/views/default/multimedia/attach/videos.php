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
$object = ClipitSite::lookup($entity_id);
$videos = $object['subtype']::get_videos($entity_id);
?>
<div data-list="videos">
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
            name="attach_videos[]"
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
<?php if(!$videos):?>
    <?php echo elgg_view('output/empty', array('value' => elgg_echo('videos:none')));?>
<?php endif;?>
</div>