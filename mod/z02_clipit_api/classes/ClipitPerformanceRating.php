<?php

/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   2013-10-10
 * Last update:     $Date$
 * @author          Pablo Llinás Arnaiz <pebs74@gmail.com>, URJC JuxtaLearn Team
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 * @subpackage      clipit_api
 */
class ClipitPerformanceRating extends UBItem {
    /**
     * @const string Elgg entity SUBTYPE for this class
     */
    const SUBTYPE = "ClipitPerformanceRating";
    public $performance_item = 0;
    public $star_rating = null;

    /**
     * Loads object parameters stored in Elgg
     *
     * @param ElggEntity $elgg_entity Elgg Object to load parameters from.
     */
    protected function load_from_elgg($elgg_entity) {
        parent::load_from_elgg($elgg_entity);
        $this->performance_item = (int)$elgg_entity->get("performance_item");
        $this->star_rating = (int)$elgg_entity->get("star_rating");
    }

    /**
     * Copy $this object parameters into an Elgg entity.
     *
     * @param ElggEntity $elgg_entity Elgg object instance to save $this to
     */
    protected function save_to_elgg($elgg_entity) {
        parent::save_to_elgg($elgg_entity);
        $elgg_entity->set("performance_item", (int)$this->performance_item);
        $elgg_entity->set("star_rating", (int)$this->star_rating);
    }

    static function get_by_item($item_array) {
        $performance_rating_array = array();
        foreach($item_array as $item_id) {
            $elgg_objects = elgg_get_entities_from_metadata(
                array(
                    'type' => static::TYPE, 'subtype' => static::SUBTYPE, 'metadata_names' => array("performance_item"),
                    'metadata_values' => array($item_id), 'limit' => 0
                )
            );
            if(!empty($elgg_objects)) {
                $temp_array = array();
                foreach($elgg_objects as $elgg_object) {
                    $temp_array[] = new static($elgg_object->guid, $elgg_object);
                }
                $performance_rating_array[$item_id] = $temp_array;
            } else {
                $performance_rating_array[$item_id] = null;
            }
        }
        return $performance_rating_array;
    }

    static function get_average_target_rating($target_id) {
        $rating_array = ClipitRating::get_by_target(array($target_id));
        $rating_array = $rating_array[$target_id];
        $average_rating = 0;
        $count = 0;
        if(!empty($rating_array)) {
            foreach($rating_array as $rating) {
                foreach($rating->performance_rating_array as $performance_rating_id) {
                    $prop_value_array = static::get_properties($performance_rating_id, array("star_rating"));
                    $average_rating += (int)$prop_value_array["star_rating"];
                    $count ++;
                }
            }
        }
        if(!empty($count)) {
            return $average_rating = $average_rating / $count;
        } else {
            return null;
        }
    }

    static function get_average_user_rating_for_target($user_id, $target_id) {
        $rating = ClipitRating::get_from_user_for_target($user_id, $target_id);
        $average_rating = 0;
        $count = 0;
        foreach($rating->performance_rating_array as $performance_rating_id) {
            $prop_value_array = static::get_properties($performance_rating_id, array("star_rating"));
            $average_rating += (int)$prop_value_array["star_rating"];
            $count ++;
        }
        if(!empty($count)) {
            return $average_rating = $average_rating / $count;
        } else {
            return null;
        }
    }

    static function get_average_item_rating_for_target($performance_item_id, $target_id) {
        $rating_array = ClipitRating::get_by_target(array($target_id));
        $rating_array = $rating_array[$target_id];
        $average_rating = 0;
        $count = 0;
        if(!empty($rating_array)) {
            foreach($rating_array as $rating) {
                foreach($rating->performance_rating_array as $performance_rating_id) {
                    $prop_value_array = static::get_properties($performance_rating_id, array("performance_item", "star_rating"));
                    if((int)$prop_value_array["performance_item"] == (int)$performance_item_id) {
                        $average_rating += (int)$prop_value_array["star_rating"];
                        $count ++;
                    }
                }
            }
            if(!empty($count)) {
                $average_rating = $average_rating / $count;
            }
        }
        return $average_rating;
    }
}