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

class ClipitTagRating extends UBItem {

    const SUBTYPE = "ClipitTagRating";

    public $tag_id = 0;
    public $is_used = null;

    protected function load_from_elgg($elgg_object){
        parent::load_from_elgg($elgg_object);
        $this->tag_id = (int)$elgg_object->get("tag_id");
        $this->is_used = (bool)$elgg_object->get("is_used");
    }

    protected function copy_to_elgg($elgg_object){
        parent::copy_to_elgg($elgg_object);
        $elgg_object->set("tag_id", (int)$this->tag_id);
        $elgg_object->set("is_used", (bool)$this->is_used);
    }


    static function get_average_target_rating($target_id){
        $rating_array = ClipitRating::get_by_target(array($target_id));
        $rating_array = $rating_array[$target_id];
        $average_rating = 0;
        $count = 0;
        foreach($rating_array as $rating){
            foreach($rating->tag_rating_array as $tag_rating_id){
                $tag_rating = new static($tag_rating_id);
                if($tag_rating->is_used){
                    $average_rating++;
                }
                $count++;
            }
        }
        if(!empty($count)){
            return $average_rating = $average_rating / $count;
        } else{
            return null;
        }
    }

    static function get_average_user_rating_for_target($user_id, $target_id){
        $rating = ClipitRating::get_from_user_for_target($user_id, $target_id);
        $average_rating = 0;
        $count = 0;
        foreach($rating->tag_rating_array as $tag_rating_id){
            $tag_rating = new static($tag_rating_id);
            if($tag_rating->is_used){
                $average_rating++;
            }
            $count++;
        }
        if(!empty($count)){
            return $average_rating = $average_rating / $count;
        } else{
            return null;
        }

    }
}