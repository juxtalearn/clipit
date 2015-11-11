<?php
/**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   22/04/14
 * Last update:     22/04/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$title = get_input("video-title");
$description = get_input("video-description");
$url = get_input("video-url");
$file = $_FILES["video-upload"];
$entity_id = get_input("entity-id");
$performance_items = get_input("performance_items");
$labels = get_input("labels");
$labels = array_filter(explode(",", $labels));
$tags = array_filter(get_input("tags", array()));
if(!$tags){
    $tags = array();
}

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
        if((isset($labels) || isset($tags))) {
            // Labels
            $total_labels = array();
            foreach ($labels as $label) {
                if ($label_exist = array_pop(ClipitLabel::get_from_search($label, true, true))) {
                    $total_labels[] = $label_exist->id;
                } else {
                    $total_labels[] = ClipitLabel::create(array(
                        'name' => $label,
                    ));
                }
            }
            ClipitVideo::set_labels($new_video_id, $total_labels);
            // Tags
            /* get tags from group */
            $group_tags = ClipitGroup::get_tags($entity_id);
            if ($group_tags) {
                $tags = array_merge($tags, $group_tags);
            }
            ClipitVideo::set_tags($new_video_id, $tags);
        }
        // Performance items
        ClipitVideo::add_performance_items($new_video_id, $performance_items);
    } else {
        register_error(elgg_echo("video:cantadd"));
    }

    system_message(elgg_echo('video:added'));
}
forward(REFERER);
