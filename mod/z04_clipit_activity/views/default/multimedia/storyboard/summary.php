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
    <?php echo elgg_view('output/url', array(
        'href'  => $file_url,
        'title' => $file->name,
        'text'  => $file->name)); ?>
</h4>
<small class="show">
    <strong><?php echo elgg_echo("file:" . $file->mime_type['short']);?></strong>
</small>
<div>
    <?php echo $sb_description; ?>
</div>
<small class="show file-user-info">
    <i>Uploaded by
        <?php echo elgg_view('output/url', array(
            'href'  => "profile/".$owner->login,
            'title' => $owner->name,
            'text'  => $owner->name));
        ?>
        <?php echo elgg_view('output/friendlytime', array('time' => $storyboard->time_created));?>
    </i>
</small>