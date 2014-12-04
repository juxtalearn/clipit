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
 * TO BE @deprecated by ClipitStumblingBlockRating
 * A rating of whether a Tag has correctly been covered in a Resource. It is contained inside of a ClipitRating instance
 * which points to a specific Resource.
 */
class ClipitTagRating extends UBItem {
    /**
     * @const string Elgg entity SUBTYPE for this class
     */
    const SUBTYPE = "ClipitTagRating";
    /**
     * @var int ID of the Tag that this rating refers to.
     */
    public $tag_id = 0;
    /**
     * @var bool Defines whether the linked Tag has been correctly covered or not.
     */
    public $is_used = null;

    /**
     * Loads object parameters stored in Elgg
     *
     * @param ElggEntity $elgg_entity Elgg Object to load parameters from.
     */
    protected function copy_from_elgg($elgg_entity) {
        parent::copy_from_elgg($elgg_entity);
        $this->tag_id = (int)$elgg_entity->get("tag_id");
        $this->is_used = (bool)$elgg_entity->get("is_used");
    }

    /**
     * Copy $this object parameters into an Elgg entity.
     *
     * @param ElggEntity $elgg_entity Elgg object instance to save $this to
     */
    protected function copy_to_elgg($elgg_entity) {
        parent::copy_to_elgg($elgg_entity);
        $elgg_entity->set("tag_id", (int)$this->tag_id);
        $elgg_entity->set("is_used", (bool)$this->is_used);
    }

    static function get_average_target_rating($target_id) {
        $rating_array = ClipitRating::get_by_target(array($target_id));
        $rating_array = $rating_array[$target_id];
        $average_rating = 0;
        $count = 0;
        foreach($rating_array as $rating) {
            foreach($rating->tag_rating_array as $tag_rating_id) {
                $tag_rating = new static($tag_rating_id);
                if($tag_rating->is_used) {
                    $average_rating ++;
                }
                $count ++;
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
        foreach($rating->tag_rating_array as $tag_rating_id) {
            $tag_rating = new static($tag_rating_id);
            if($tag_rating->is_used) {
                $average_rating ++;
            }
            $count ++;
        }
        if(!empty($count)) {
            return $average_rating = $average_rating / $count;
        } else {
            return null;
        }
    }
}