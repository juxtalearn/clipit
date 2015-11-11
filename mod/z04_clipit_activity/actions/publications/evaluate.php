<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   19/05/14
 * Last update:     19/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$entity_id = get_input("entity-id");
$rating_id = get_input("rating-id");
$overall = get_input("overall");
$tags = get_input("tag_rating");
$rubric_rating = get_input("rubric_rating");
$object = ClipitSite::lookup($entity_id);

if($object){
    $rating_data = array(
        'target'    => $entity_id,
        'overall'    => $overall, // Yes, No
    );
    if($rating_id) {
        $rating = array_pop(ClipitRating::get_by_id(array($rating_id)));
        $new_tag_rating_id = ClipitRating::set_properties($rating_id, $rating_data);
    } else {
        $new_tag_rating_id = ClipitRating::create($rating_data);
    }
    if(!$new_tag_rating_id){
        register_error(elgg_echo("publications:cantrating"));
    } else {
        foreach($tags as $tag_id => $tag_value){
            if($rating_id) {
                $tags_rating[] = ClipitTagRating::set_properties($tag_value['id'], array(
                    'is_used'   => $tag_value['is_used'],
                    'description'   => $tag_value['comment']
                ));
            } else {
                $tags_rating[] = ClipitTagRating::create(array(
                    'tag_id'    => $tag_id,
                    'is_used'   => $tag_value['is_used'],
                    'description'   => $tag_value['comment']
                ));
            }
        }
        foreach($rubric_rating as $rubric_id => $rating){
            if($rating['level']){
                $rubric_rating_data = array(
                    'rubric_item' => $rubric_id,
                    'level' => $rating['level'],
                );
                if($rating_id) {
                    $rubrics_ratings[] = ClipitRubricRating::set_properties($rating['id'], $rubric_rating_data);
                } else {
                    $rubrics_ratings[] = ClipitRubricRating::create($rubric_rating_data);
                }
            }
        }
        if($rubric_rating){
            ClipitRating::add_tag_ratings($new_tag_rating_id, $tags_rating);
            ClipitRating::add_rubric_ratings($new_tag_rating_id, $rubrics_ratings);
            $object['subtype']::update_average_ratings($entity_id);
            system_message(elgg_echo('publications:rated'));
        }
    }
}

forward(REFERER);