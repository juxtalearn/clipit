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

class ClipitRubricRating extends UBItem{
    /**
     * @const string Elgg entity SUBTYPE for this class
     */
    const SUBTYPE = "ClipitRubricRating";
    const REL_RUBRICRATING_RUBRICITEM = "ClipitRubricRating-ClipitRubricItem";

    // ID of ClipitRating this rubric rating is included in
    public $rating = 0;
    // ID of the rated Rubric Item
    public $rubric_item = 0;
    // Rubric level selected (0 = unselected, 1+ = selected rubric level)
    public $level = 0;
    // Score for the level selected
    public $score = 0.0;

    /**
     * Saves this instance to the system.
     *
     * @param  bool $double_save if $double_save is true, this object is saved twice to ensure
     * that all properties are updated properly. E.g. the time created property can only be set
     * on ElggObjects during an update. Defaults to false.
     * @return bool|int Returns the Id of the saved instance, or false if error
     */
    protected function save($double_save = false)
    {
        parent::save($double_save);
        static::set_rubric_item($this->id, $this->rubric_item);
        return $this->id;
    }

    static function set_rubric_item($id, $rubric_id)
    {
        return UBCollection::set_items($id, array($rubric_id), static::REL_RUBRICRATING_RUBRICITEM);
    }

    static function get_rubric_item($id)
    {
        return (int)array_pop(UBCollection::get_items($id, static::REL_RUBRICRATING_RUBRICITEM));
    }

    /**
     * Loads object parameters stored in Elgg
     *
     * @param ElggEntity $elgg_entity Elgg Object to load parameters from.
     */
    protected function copy_from_elgg($elgg_entity)
    {
        parent::copy_from_elgg($elgg_entity);
        $this->rubric_item = (int)static::get_rubric_item($this->id);
        $this->level = (int)$elgg_entity->get("level");
        if (!empty($this->rubric_item)) {
            $rubric_item = array_pop(ClipitRubricItem::get_by_id(array($this->rubric_item)));
            $this->score = (float)$rubric_item->level_increment * $this->level;
        }
        $rating_array = UBCollection::get_items($this->id, ClipitRating::REL_RATING_RUBRICRATING, true);
        if(!empty($rating_array)){
            $this->rating = (int)array_pop($rating_array);
        }
    }

    /**
     * Copy $this object parameters into an Elgg entity.
     *
     * @param ElggEntity $elgg_entity Elgg object instance to save $this to
     */
    protected function copy_to_elgg($elgg_entity)
    {
        parent::copy_to_elgg($elgg_entity);
        $elgg_entity->set("level", (int)$this->level);
    }

    static function get_by_item($item_array)
    {
        $rubric_rating_array = array();
        foreach ($item_array as $item_id) {
            $elgg_objects = elgg_get_entities_from_metadata(
                array(
                    'type' => static::TYPE, 'subtype' => static::SUBTYPE, 'metadata_names' => array("rubric_item"),
                    'metadata_values' => array($item_id), 'limit' => 0
                )
            );
            if (!empty($elgg_objects)) {
                $temp_array = array();
                foreach ($elgg_objects as $elgg_object) {
                    $temp_array[] = new static($elgg_object->guid, $elgg_object);
                }
                $rubric_rating_array[$item_id] = $temp_array;
            } else {
                $rubric_rating_array[$item_id] = null;
            }
        }
        return $rubric_rating_array;
    }

    /**
     * Get the average Rubric Rating for a Target
     *
     * @param int $target_id IF of Target with Rubric Ratings
     * @return float|null The Average Rubric rating [0.0 .. 1.0]
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
                foreach ($rating->rubric_rating_array as $rubric_rating_id) {
                    $prop_value_array = static::get_properties($rubric_rating_id, array("score"));
                    $average_rating += (float)$prop_value_array["score"];
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
     * Get the average Rubric Rating of each Rubric Item for a Target
     *
     * @param int $target_id ID of Target with Rubric Ratings
     * @return array Array of [rubric_item_id] => (float)[0.0 .. 1.0]item_average_rating
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
                foreach ($rating->rubric_rating_array as $rubric_rating_id) {
                    $prop_value_array = static::get_properties($rubric_rating_id, array("rubric_item", "score"));
                    $rubric_item = $prop_value_array["rubric_item"];
                    $score = $prop_value_array["score"];
                    if (!isset($average_rating[$rubric_item])) {
                        $average_rating[$rubric_item] = (float)$score;
                        $count[$rubric_item] = 1;
                    } else {
                        $average_rating[$rubric_item] += (float)$score;
                        $count[$rubric_item]++;
                    }
                }
            }
            if (!empty($count)) {
                foreach ($count as $rubric_item => $total) {
                    $average_rating[$rubric_item] = $average_rating[$rubric_item] / $total;
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
            foreach ($rating->rubric_rating_array as $rubric_rating_id) {
                $prop_value_array = static::get_properties($rubric_rating_id, array("score"));
                $average_rating += (float)$prop_value_array["score"];
                $count++;
            }
        }
        if (!empty($count)) {
            return $average_rating = $average_rating / $count;
        } else {
            return null;
        }
    }
}