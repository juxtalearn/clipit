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
?>
<div data-list="storyboards">
<?php
foreach(ClipitGroup::get_storyboards($entity_id) as $sb_id):
    $storyboard = array_pop(ClipitStoryboard::get_by_id(array($sb_id)));
    $file = array_pop(ClipitFile::get_by_id(array($storyboard->file)));
?>
    <div class="multimedia-block col-md-4" style="position:relative;border-radius: 4px;margin-bottom: 0;padding: 0;background: transparent;">
        <label class="select-item attach-item" title="<?php echo $storyboard->name;?>" for="item_<?php echo $sb_id;?>"></label>
        <input type="checkbox" style="display: none" name="attach_storyboards[]" value="<?php echo $sb_id;?>" id="item_<?php echo $sb_id;?>">
        <div class="attach-block">
            <div class="multimedia-preview" >
                <?php echo elgg_view("multimedia/file/preview", array('file'  => $file, 'size' => 'normal'));?>
            </div>
            <div class="multimedia-details">
                <div class="blue text-truncate">
                    <a class="item-info"><?php echo $storyboard->name;?></a>
                </div>
                <small class="show"><strong><?php echo elgg_echo("file:" . $file->mime_type['short']);?></strong></small>
            </div>
        </div>
    </div>
<?php endforeach;?>
</div>