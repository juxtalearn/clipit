<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   26/01/2015
 * Last update:     26/01/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$url = get_input("url");
$title = get_input("title");
$description = get_input("description");
$performance_items = get_input("performance_items");
$file = $_FILES["video-upload"];
$entity_id = get_input("scope-id"); // {Activity, Group} id
$video_id = get_input("entity-id");
$labels = get_input("labels");
$labels = array_filter(explode(",", $labels));
$tags = array_filter(get_input("tags", array()));
if(!$tags){
    $tags = array();
}

$data = array(
    'name' => $title,
    'description' => $description,
);
$href = REFERER;
if(trim($title) == ""){
    register_error(elgg_echo("video:cantadd"));
} else {
    // New video
    if($entity_id){
        $object = ClipitSite::lookup($entity_id);
        $video_url = is_video_provider($url);
        $entity_class = $object['subtype'];
        $entity = array_pop($entity_class::get_by_id(array($entity_id)));
        // Video url (youtube|vimeo)
        if(!empty($file['tmp_name'])){
            $video_url = ClipitVideo::upload_to_youtube($file['tmp_name'], $title);
        }
        if(!$video_url){
            register_error(elgg_echo("video:cantadd"));
        } else {
            $video_id = ClipitVideo::create(array(
                'url'  => $video_url,
            ));
            $entity_class::add_videos($entity_id, array($video_id));
        }
        $successful_message = elgg_echo('video:added');
    }

    if($video_id){
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
            if($group_id = ClipitVideo::get_group($video_id)){
                /* Get tags from group */
                $group_tags = array();
                $group_tags = ClipitGroup::get_tags($group_id);
                $tags = array_merge($tags, $group_tags);
            }

            ClipitVideo::set_labels($video_id, $total_labels);
            ClipitVideo::set_tags($video_id, $tags);
        }
        // Performance items
        ClipitVideo::set_performance_items($video_id, $performance_items);
        // Set properties
        ClipitVideo::set_properties($video_id, $data);
        $successful_message = elgg_echo('video:edited');
    } else {
        register_error(elgg_echo("video:cantadd"));
    }
    system_message($successful_message);
}
// forward to task directly
if(get_input('select-task')){
    $href = 'clipit_activity/'.ClipitVideo::get_activity($video_id).'/group/'.$entity_id.'/repository/publish/'.$video_id.'?task_id='.get_input('select-task');
}

forward($href);