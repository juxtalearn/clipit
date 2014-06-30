<?php
/**
 * Created by JetBrains PhpStorm.
 * User: equipo
 * Date: 24/02/14
 * Time: 16:06
 * To change this template use File | Settings | File Templates.
 */
$related_videos = ClipitVideo::get_all(3);
$href = "explore/video";
?>
<h3 class="activity-module-title">Related videos</h3>
<?php echo elgg_view("explore/video/list", array('videos' => $related_videos, 'href' => $href));?>
