<?php
/**
 * Created by PhpStorm.
 * User: pebs74
 * Date: 20/01/2015
 * Time: 16:55
 */
datalist_set('simplecache_enabled', 0);
datalist_set('system_cache_enabled', 0);

// Move activity teacher resources to corresponding TT, and make clones to add to activity
$activity_array = ClipitActivity::get_all();
foreach($activity_array as $activity){
    $tt_id = $activity->tricky_topic;
    if(empty($tt_id)){
        continue;
    }
    // FILES
    $file_clones = array();
    foreach($activity->file_array as $file_id){
        $file_clone = ClipitFile::create_clone($file_id, false, true);
        // reverse link to make the clone be the parent
        ClipitFile::link_parent_clone($file_clone, $file_id);
        $file_clones[] = $file_clone;
    }
    ClipitTrickyTopic::add_files($tt_id, $file_clones);
    // STORYBOARDS
    $storyboard_clones = array();
    foreach($activity->storyboard_array as $storyboard_id){
        $storyboard_clone = ClipitStoryboard::create_clone($storyboard_id, false, true);
        // reverse link to make the clone be the parent
        ClipitStoryboard::link_parent_clone($storyboard_clone, $storyboard_id);
        $storyboard_clones[] = $storyboard_clone;
    }
    ClipitTrickyTopic::add_storyboards($tt_id, $storyboard_clones);
    // VIDEOS
    $video_clones = array();
    foreach($activity->video_array as $video_id){
        $video_clone = ClipitVideo::create_clone($video_id, false, true);
        // reverse link to make the clone be the parent
        ClipitVideo::link_parent_clone($video_clone, $video_id);
        $video_clones[] = $video_clone;
    }
    ClipitTrickyTopic::add_videos($tt_id, $video_clones);
}