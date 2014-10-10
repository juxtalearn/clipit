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
<div class="frame-container" style="width: 100%;">
    <?php if(get_video_url_embed($video->url)):?>
        <?php echo elgg_view('output/iframe', array(
            'value'  => get_video_url_embed($video->url)));
        ?>
    <?php else:?>
        <video width="100%"  controls>
            <source src="<?php echo($video->url); ?>" type='video/webm; codecs="vp8, vorbis"' />
            Your browser does not support the video tag.
        </video>
    <?php endif;?>
</div>