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
$entity_id = get_input("entity-id");
$tags = get_input("tags");
$tags = explode(",", $tags);

$object = ClipitSite::lookup($entity_id);
$user_id = elgg_get_logged_in_user_guid();
$video_data = video_url_parser($url);
$entity_class = $object['subtype'];

$entity = array_pop($entity_class::get_by_id(array($entity_id)));
if(count($entity)==0 || trim($title) == "" || trim($description) == "" || trim($url) == "" || !$video_data['id']){
    register_error(elgg_echo("video:cantadd"));
} else{
    $new_video_id = ClipitVideo::create(array(
        'name' => $title,
        'description' => $description,
        'url'  => $video_data['url'],
        'preview' => $video_data['preview'],
        'duration' => $video_data['duration']
    ));
    if($new_video_id){
        $entity_class::add_videos($entity_id, array($new_video_id));
        if(count($tags) > 0){
            foreach(ClipitTag::get_all() as $tag_exist){
                if(($key = array_search($tag_exist->name, $tags)) !== false) {
                    $tags_id[$tag_exist->name] = $tag_exist->id;
                    unset($tags[$key]);
                }
            }
            $new_tag_ids = array();
            foreach($tags as $tag_value){
                $new_tag_ids[] = ClipitTag::create(array(
                    'name'    => $tag_value,
                ));
            }
            ClipitVideo::add_tags($new_video_id, array_merge($tags_id, $new_tag_ids));
        }
    } else {
        register_error(elgg_echo("video:cantadd"));
    }

    system_message(elgg_echo('video:added'));
}
forward(REFERER);
