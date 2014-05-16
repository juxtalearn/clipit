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
//$new_video_id = ClipitVideo::create(array(
//    'name' => $video->name,
//    'description' => $video->description,
//    'url'  => $video->url,
//    'preview' => $video->preview,
//    'duration' => $video->duration,
//    'author_id' => 75
//));
//ClipitActivity::add_videos(74, array($new_video_id));
?>
<div class="frame-container">
    <?php echo elgg_view('output/iframe', array(
        'value'  => get_video_url_embed($video->url)));
    ?>
</div>