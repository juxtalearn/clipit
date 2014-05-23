<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   19/05/14
 * Last update:     19/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$entity_id = get_input("entity-id");
$overall = get_input("overall");
$tags = get_input("tag_rating");
$performance_rating = get_input("performance_rating");
$object = ClipitSite::lookup($entity_id);

if($object){
    $new_tag_rating_id = ClipitRating::create(array(
        'target'    => $entity_id,
        'overall'    => $overall, // Yes
    ));
    if(!$new_tag_rating_id){
        register_error(elgg_echo("publications:cantrating"));
    } else {
        foreach($tags as $tag_id => $tag_value){
            $tags_rating[] = ClipitTagRating::create(array(
                'tag_id'    => $tag_id,
                'is_used'   => $tag_value['is_used'],
                'description'   => $tag_value['comment']
            ));
        }
        foreach($performance_rating as $performance_id => $star_value){
            if($star_value){
                $performance_ratings[] = ClipitPerformanceRating::create(array(
                    'performance_item' => $performance_id,
                    'star_rating'   => $star_value
                ));
            }
        }
        if(count($performance_ratings) != count($performance_rating)){
            ClipitRating::delete_by_id(array($new_tag_rating_id));
            register_error(elgg_echo("publications:starsrequired"));
        } else {
            ClipitRating::add_tag_ratings($new_tag_rating_id, $tags_rating);
            ClipitRating::add_performance_ratings($new_tag_rating_id, $performance_ratings);
            system_message(elgg_echo('publications:rated'));
        }
    }
}

forward(REFERER);