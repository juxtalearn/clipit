<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   12/05/14
 * Last update:     12/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$storyboard = elgg_extract("entity", $vars);
$file = elgg_extract("file", $vars);
$file_url = elgg_extract("href", $vars);
$owner = array_pop(ClipitUser::get_by_id(array($storyboard->owner_id)));

$sb_description = trim(elgg_strip_tags($storyboard->description));
// text truncate max length 165
if(mb_strlen($sb_description)>165){
    $sb_description = substr($sb_description, 0, 165)."...";
}
?>
<h4>
    <strong>
    <?php echo elgg_view('output/url', array(
        'href'  => $file_url,
        'title' => $storyboard->name,
        'text'  => $storyboard->name));
    ?>
    </strong>
</h4>
<small class="show smaller">
    <strong><?php echo elgg_echo("file:" . $file->mime_short);?></strong>
</small>
<?php echo elgg_view('tricky_topic/tags/view', array('tags' => $storyboard->tag_array)); ?>
<p>
    <?php echo $sb_description; ?>
</p>
<small class="show">
    <?php echo elgg_view("publications/owner_summary", array(
        'entity' => $storyboard,
        'entity_class' => 'ClipitStoryboard',
        'msg' => elgg_echo('multimedia:uploaded_by')
    ));
    ?>
    <i>
        <?php echo elgg_view('output/friendlytime', array('time' => $storyboard->time_created));?>
    </i>
</small>