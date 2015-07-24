<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   12/05/14
 * Last update:     12/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$user_id = elgg_get_logged_in_user_guid();
$file_name = get_input('file-name');
$files = $_FILES['files'];
$count = 0;
$output = array('files' => array('error' => elgg_echo("file:cantupload")));

if(get_input('type') == 'video'){
    $url = get_input('video_url');
    $video_url = is_video_provider($url);
    if($video_url) {
        $new_video_id = ClipitVideo::create(array(
            'name' => get_input('video_title'),
            'url' => $video_url
        ));
        if($entity_id = get_input('entity-id')){
            $object = ClipitSite::lookup($entity_id);
        }
        if($entity_id){
            switch($object['subtype']){
                case "ClipitActivity":
                    ClipitActivity::add_videos($entity_id, array($new_video_id));
                    break;
            }
        }
        $video = array_pop(ClipitVideo::get_by_id(array($new_video_id)));
        $output = array(
            'files' => array(
                array(
                    "video" => true,
                    "id" =>  $video->id,
                    "name" =>  $video->name,
                    "preview" => $video->preview,
                    "preview_ready" => true,
                    "input_prefix" => json_decode(get_input('prefix'))
                )
            )
        );
    }
}
if($video_file = $_FILES['video_file']){
    $output =  json_encode(array('files' => array('error' => elgg_echo("video:cantupload"))));
    $title = get_input('video_title');
    if(!$title){
        $title = $video_file['name'];
    }
    // Upload to Youtube
    $video_url = ClipitVideo::upload_to_youtube($video_file['tmp_name'], $title);
    if($video_url) {
        $new_video_id = ClipitVideo::create(array(
            'name' => $title,
            'url' => $video_url
        ));
    }
    if($new_video_id) {
        if ($entity_id = get_input('entity-id')) {
            $object = ClipitSite::lookup($entity_id);
        }
        if ($entity_id) {
            switch ($object['subtype']) {
                case "ClipitActivity":
                    ClipitActivity::add_videos($entity_id, array($new_video_id));
                    break;
            }
        }
        $video = array_pop(ClipitVideo::get_by_id(array($new_video_id)));
        $output = array(
            'files' => array(
                array(
                    "video" => true,
                    "id" => $video->id,
                    "name" => $video->name,
                    "preview" => $video->preview,
                    "input_prefix" => json_decode(get_input('prefix'))
                )
            )
        );
    }
} elseif($files = $_FILES['files']){
    $new_file_id = ClipitFile::create(array(
        'name' => $files['name'],
        'description' => $file_text,
        'temp_path'  => $files['tmp_name']
    ));
    if($new_file_id){
        // Upload to GDrive
        ClipitFile::upload_to_gdrive($new_file_id);
        if($entity_id = get_input('entity-id')){
            $object = ClipitSite::lookup($entity_id);
        }
        if($entity_id){
            switch($object['subtype']){
                case "ClipitActivity":
                    ClipitActivity::add_files($entity_id, array($new_file_id));
                    break;
            }
        }
        $file = array_pop(ClipitFile::get_by_id(array($new_file_id)));
        $output = array(
            'files' => array(
                array(
                    "id" =>  $file->id,
                    "name" =>  $file->name,
                    "size"  => $file->size,
                    "download_url" => elgg_normalize_url(elgg_format_url("file/download/{$file->id}")),
                    "preview" => elgg_view("multimedia/file/preview", array('file'  => $file, 'size' => 'medium')),
                    "type" => elgg_echo("file:" . $file->mime_short),
                    "input_prefix" => json_decode(get_input('prefix'))
                )
            )
        );
    }
}
if(get_input('type') == 'file' && isset($files)){

}
echo json_encode($output);