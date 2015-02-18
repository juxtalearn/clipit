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
$selected_sbs = elgg_extract('selected', $vars);
$entity_id = elgg_extract('entity_id', $vars);
$input_prefix = elgg_extract('input_prefix', $vars);
if($input_prefix) {
    $input_prefix = $input_prefix . "[attach_storyboards][]";
} else {
    $input_prefix = 'attach_storyboards[]';
}
$object = ClipitSite::lookup($entity_id);
$storyboards = $object['subtype']::get_storyboards($entity_id);
?>
<div data-list="storyboards">
<?php
foreach($storyboards as $sb_id):
    $storyboard = array_pop(ClipitStoryboard::get_by_id(array($sb_id)));
    $file = array_pop(ClipitFile::get_by_id(array($storyboard->file)));
    $selected = false;
    if(in_array($sb_id, $selected_sbs)){
        $selected = true;
    }
?>
    <div class="multimedia-block col-md-4" style="position:relative;border-radius: 4px;margin-bottom: 0;padding: 0;background: transparent;">
        <label class="select-item attach-item" title="<?php echo $storyboard->name;?>" for="item_<?php echo $sb_id;?>"></label>
        <input
            type="checkbox"
            <?php echo  $selected ? 'checked' : false;?>
            style="display: none"
            name="<?php echo $input_prefix;?>"
            value="<?php echo $sb_id;?>"
            id="item_<?php echo $sb_id;?>"
            >
        <div class="attach-block <?php echo  $selected ? 'selected' : false;?>">
            <div class="multimedia-preview" >
                <?php echo elgg_view("multimedia/file/preview", array('file'  => $file, 'size' => 'medium'));?>
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
    <?php if(!$storyboards):?>
        <?php echo elgg_view('output/empty', array('value' => elgg_echo('storyboards:none')));?>
    <?php endif;?>
</div>