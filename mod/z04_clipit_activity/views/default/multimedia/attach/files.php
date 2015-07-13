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
?>
<div data-list="files">
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
<?php if(!$files):?>
    <?php echo elgg_view('output/empty', array('value' => elgg_echo('file:none')));?>
<?php endif;?>
</div>