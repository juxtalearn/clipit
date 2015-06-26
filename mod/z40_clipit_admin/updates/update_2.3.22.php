<?php
/**
 * Created by PhpStorm.
 * User: Pablo Llinás
 * Date: 01/06/2015
 * Time: 17:22
 */


// Update of the read_array so that it's linked using relationships
$chat_array = ClipitChat::get_all(0, 0, "", true, true);
foreach($chat_array as $chat_id){
    $elgg_obj = new ElggObject((int)$chat_id);
    $read_array = (array)$elgg_obj->get("read_array");
    if(!empty($read_array)) {
        ClipitChat::set_read_array((int)$chat_id, $read_array);
        $elgg_obj->set("read_array", null);
    }
}
$comment_array = ClipitComment::get_all(0, 0, "", true, true);
foreach($comment_array as $comment_id){
    $elgg_obj = new ElggObject((int)$comment_id);
    $read_array = (array)$elgg_obj->get("read_array");
    if(!empty($read_array)) {
        ClipitComment::set_read_array((int)$comment_id, $read_array);
        $elgg_obj->set("read_array", null);
    }
}
$post_array = ClipitPost::get_all(0, 0, "", true, true);
foreach($post_array as $post_id){
    $elgg_obj = new ElggObject((int)$post_id);
    $read_array = (array)$elgg_obj->get("read_array");
    if(!empty($read_array)) {
        ClipitPost::set_read_array((int)$post_id, $read_array);
        $elgg_obj->set("read_array", null);
    }
}
$file_array = ClipitFile::get_all(0, 0, "", true, true);
foreach($file_array as $file_id){
    $elgg_obj = new ElggObject((int)$file_id);
    $read_array = (array)$elgg_obj->get("read_array");
    if(!empty($read_array)) {
        ClipitFile::set_read_array((int)$file_id, $read_array);
        $elgg_obj->set("read_array", null);
    }
}
$video_array = ClipitVideo::get_all(0, 0, "", true, true);
foreach($video_array as $video_id){
    $elgg_obj = new ElggObject((int)$video_id);
    $read_array = (array)$elgg_obj->get("read_array");
    if(!empty($read_array)) {
        ClipitVideo::set_read_array((int)$video_id, $read_array);
        $elgg_obj->set("read_array", null);
    }
}
$stbd_array = ClipitStoryboard::get_all(0, 0, "", true, true);
foreach($stbd_array as $stbd_id){
    $elgg_obj = new ElggObject((int)$stbd_id);
    $read_array = (array)$elgg_obj->get("read_array");
    if(!empty($read_array)) {
        ClipitStoryboard::set_read_array((int)$stbd_id, $read_array);
        $elgg_obj->set("read_array", null);
    }
}
