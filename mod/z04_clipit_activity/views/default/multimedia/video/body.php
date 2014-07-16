<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   13/05/14
 * Last update:     13/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$video = elgg_extract("entity", $vars);
?>
<?php echo elgg_view("publications/view_scope", array('entity' => $video));?>
<div class="frame-container" style="width: 100%;">
    <?php echo elgg_view('output/iframe', array(
        'value'  => get_video_url_embed($video->url)));
    ?>
</div>