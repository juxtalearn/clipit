<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   26/01/2015
 * Last update:     26/01/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$url = get_input("url");
$title = get_input("title");
$description = get_input("description");
$entity_id = get_input("scope-id"); // {Activity, Group} id
$text_id = get_input("entity-id");
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
    register_error(elgg_echo("text:cantadd"));
} else {
    // New text
    if($entity_id){
        $object = ClipitSite::lookup($entity_id);
        $text_url = ($url);
        $entity_class = $object['subtype'];
        $entity = array_pop($entity_class::get_by_id(array($entity_id)));

        $text_id = ClipitText::create( array_merge($data, array('url'  => $text_url)) );
        $entity_class::add_texts($entity_id, array($text_id));

        $successful_message = elgg_echo('text:added');
    }

    if($text_id){
        if((isset($labels) || isset($tags))) {
            // Labels
            $total_labels = array();
            foreach ($labels as $label) {
                $total_labels[] = ClipitLabel::create(array(
                    'name' => $label,
                ));
            }
            if($group_id = ClipitText::get_group($text_id)){
                /* Get tags from group */
                $group_tags = array();
                $group_tags = ClipitGroup::get_tags($group_id);
                $tags = array_merge($tags, $group_tags);
            }

            ClipitText::set_labels($text_id, $total_labels);
            ClipitText::set_tags($text_id, $tags);
        }
        // Set properties
        ClipitText::set_properties($text_id, $data);
        $successful_message = elgg_echo('text:edited');
    } else {
    register_error(elgg_echo("text:cantadd"));
}
    system_message($successful_message);
}
// forward to task directly
if(get_input('select-task')){
    $href = 'clipit_activity/'.ClipitText::get_activity($text_id).'/group/'.$entity_id.'/repository/publish/'.$text_id.'?task_id='.get_input('select-task');
}

forward($href);