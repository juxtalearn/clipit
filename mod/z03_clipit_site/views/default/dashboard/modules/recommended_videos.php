<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   24/07/14
 * Last update:     24/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$related_video_ids = array_slice(ClipitSite::get_videos(), 0, 3);
$related_videos = ClipitVideo::get_by_id($related_video_ids);
echo elgg_view("multimedia/video/recommended/view", array('entities' => $related_videos));