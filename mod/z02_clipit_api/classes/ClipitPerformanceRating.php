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

/**
 * @deprecated
 * A 5-star Rating on a Performance Items applied to a Resource, submitted by a user as evaluation feedback.
 */
class ClipitPerformanceRating extends UBItem {
    /**
     * @const string Elgg entity SUBTYPE for this class
     */
    const SUBTYPE = "ClipitPerformanceRating";
    public $performance_item = 0;
    public $star_rating = 0;

    static function get_by_item($item_array)
    {
        $performance_rating_array = array();
        foreach ($item_array as $item_id) {
            $elgg_objects = elgg_get_entities_from_metadata(
                array(
                    'type' => static::TYPE, 'subtype' => static::SUBTYPE, 'metadata_names' => array("performance_item"),
                    'metadata_values' => array($item_id), 'limit' => 0
                )
            );
            if (!empty($elgg_objects)) {
                $temp_array = array();
                foreach ($elgg_objects as $elgg_object) {
                    $temp_array[] = new static($elgg_object->guid, $elgg_object);
                }
                $performance_rating_array[$item_id] = $temp_array;
            } else {
                $performance_rating_array[$item_id] = null;
            }
        }
        return $performance_rating_array;
    }

    /**
     * Get the average Performance Rating for a Target
     *
     * @param int $target_id IF of Target with Performance Ratings
     * @return float|null The Average Performance star rating [0.0 - 5.0]
     * @throws InvalidParameterException
     */
    static function get_average_rating_for_target($target_id)
    {
        $rating_array = ClipitRating::get_by_target(array($target_id));
        $rating_array = $rating_array[$target_id];
        $average_rating = 0;
        $count = 0;
        if (!empty($rating_array)) {
            foreach ($rating_array as $rating) {
                foreach ($rating->performance_rating_array as $performance_rating_id) {
                    $prop_value_array = static::get_properties($performance_rating_id, array("star_rating"));
                    $average_rating += (int)$prop_value_array["star_rating"];
                    $count++;
                }
            }
        }
        if (!empty($count)) {
            return $average_rating = $average_rating / $count;
        } else {
            return null;
        }
    }

    /**
     * Get the average Performance Rating of each Performance Item for a Target
     *
     * @param int $target_id ID of Target with Performance Ratings
     * @return array Array of [(int)performance_item_id] => (float[0.0 - 5.0])item_average_rating
     * @throws InvalidParameterException
     */
    static function get_item_average_rating_for_target($target_id)
    {
        $rating_array = ClipitRating::get_by_target(array($target_id));
        $rating_array = $rating_array[$target_id];
        $average_rating = array();
        $count = array();
        if (!empty($rating_array)) {
            foreach ($rating_array as $rating) {
                foreach ($rating->performance_rating_array as $performance_rating_id) {
                    $prop_value_array = static::get_properties($performance_rating_id, array("performance_item", "star_rating"));
                    $performance_item = $prop_value_array["performance_item"];
                    $star_rating = $prop_value_array["star_rating"];
                    if (!isset($average_rating[$performance_item])) {
                        $average_rating[$performance_item] = (int)$star_rating;
                        $count[$performance_item] = 1;
                    } else {
                        $average_rating[$performance_item] += (int)$star_rating;
                        $count[$performance_item]++;
                    }
                }
            }
            if (!empty($count)) {
                foreach ($count as $performance_item => $total) {
                    $average_rating[$performance_item] = $average_rating[$performance_item] / $total;
                }
            }
        }
        return $average_rating;
    }

    static function get_average_user_rating_for_target($user_id, $target_id)
    {
        $rating = ClipitRating::get_user_rating_for_target($user_id, $target_id);
        $average_rating = 0;
        $count = 0;
        if (!empty($rating)) {
            foreach ($rating->performance_rating_array as $performance_rating_id) {
                $prop_value_array = static::get_properties($performance_rating_id, array("star_rating"));
                $average_rating += (int)$prop_value_array["star_rating"];
                $count++;
            }
        }
        if(!empty($count)) {
            return $average_rating = $average_rating / $count;
        } else {
            return null;
        }
    }

    /**
     * Loads object parameters stored in Elgg
     *
     * @param ElggEntity $elgg_entity Elgg Object to load parameters from.
     */
    protected function copy_from_elgg($elgg_entity)
    {
        parent::copy_from_elgg($elgg_entity);
        $this->performance_item = (int)$elgg_entity->get("performance_item");
        $this->star_rating = (int)$elgg_entity->get("star_rating");
    }

    /**
     * Copy $this object parameters into an Elgg entity.
     *
     * @param ElggEntity $elgg_entity Elgg object instance to save $this to
     */
    protected function copy_to_elgg($elgg_entity)
    {
        parent::copy_to_elgg($elgg_entity);
        $elgg_entity->set("performance_item", (int)$this->performance_item);
        $elgg_entity->set("star_rating", (int)$this->star_rating);
    }
}