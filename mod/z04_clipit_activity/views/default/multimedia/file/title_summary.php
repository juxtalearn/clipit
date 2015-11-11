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
$file = elgg_extract("entity", $vars);
$file_url = elgg_extract("href", $vars);
$owner = array_pop(ClipitUser::get_by_id(array($file->owner_id)));

$file_description = trim(elgg_strip_tags($file->description));
// text truncate max length 165
if(mb_strlen($file_description)>165){
    $file_description = substr($file_description, 0, 165)."...";
}
?>
<h4>
    <strong>
    <?php echo elgg_view('output/url', array(
    'href'  => $file_url,
    'title' => $file->name,
    'text'  => $file->name));
    ?>
    </strong>
</h4>
<small class="show hidden-xs">
    <strong><?php echo elgg_echo("file:" . $file->mime_short);?></strong>
</small>
<?php echo elgg_view('tricky_topic/tags/view', array('tags' => ClipitFile::get_tags($file->id))); ?>
<div class="hidden-xs">
    <p>
        <?php echo $file_description; ?>
    </p>
    <small class="show hidden-xs">
        <?php echo elgg_view("publications/owner_summary", array(
            'entity' => $file,
            'msg' => elgg_echo('multimedia:uploaded_by')
        ));
        ?>
        <i>
            <?php echo elgg_view('output/friendlytime', array('time' => $file->time_created));?>
        </i>
    </small>
</div>