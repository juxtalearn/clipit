<?php
/**
 * Created by JetBrains PhpStorm.
 * User: equipo
 * Date: 24/02/14
 * Time: 16:06
 * To change this template use File | Settings | File Templates.
 */
$related_video_ids = array_slice(ClipitSite::get_videos(), 0, 3);
$related_videos = ClipitVideo::get_by_id($related_video_ids);
$href = "explore";
?>
<?php if(count($related_videos)):?>
    <h3 class="activity-module-title"><?php echo elgg_echo('videos:related');?></h3>
    <?php echo elgg_view("explore/video/list", array('videos' => $related_videos, 'href' => $href));?>
<?php endif;?>
