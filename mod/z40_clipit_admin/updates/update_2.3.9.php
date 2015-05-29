<?php
/**
 * Created by PhpStorm.
 * User: pebs74
 * Date: 20/01/2015
 * Time: 16:55
 */
// forced refresh of average ratings
$video_array = ClipitVideo::get_all();
foreach($video_array as $video){
    ClipitVideo::update_average_ratings($video->id);
}
$storyboard_array = ClipitStoryboard::get_all();
foreach($storyboard_array as $storyboard){
    ClipitStoryboard::update_average_ratings($storyboard->id);
}
