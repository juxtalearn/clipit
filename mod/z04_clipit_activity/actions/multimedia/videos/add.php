<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   22/04/14
 * Last update:     22/04/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$title = get_input("video-title");
$description = get_input("video-description");
$url = get_input("video-url");
$file = $_FILES["video-upload"];
$entity_id = get_input("entity-id");

$object = ClipitSite::lookup($entity_id);
$user_id = elgg_get_logged_in_user_guid();
$video_data = video_url_parser($url);
$entity_class = $object['subtype'];

$entity = array_pop($entity_class::get_by_id(array($entity_id)));
if(count($entity)==0 || trim($title) == "" || trim($description) == ""){
    register_error(elgg_echo("video:cantadd"));
} else{
    // Video url (youtube|vimeo)
    if(trim($url) != "" && $video_data = video_url_parser($url)){
        $video_url = $video_data['url'];
    // Video upload to youtube
    } elseif(!empty($file['tmp_name'])){
        $video_url = ClipitVideo::upload_to_youtube($file['tmp_name'], $title);
        $video_data = video_url_parser($video_url);
    }
    if(!$video_data){
        register_error(elgg_echo("video:cantadd"));
    } else {
        $new_video_id = ClipitVideo::create(array(
            'name' => $title,
            'description' => $description,
            'url'  => $video_url,
            'preview' => $video_data['preview'],
            'duration' => $video_data['duration']
        ));
    }
    if($new_video_id){
        $entity_class::add_videos($entity_id, array($new_video_id));
    } else {
        register_error(elgg_echo("video:cantadd"));
    }

    system_message(elgg_echo('video:added'));
}
forward(REFERER);
