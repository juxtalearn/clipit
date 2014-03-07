<?php


/**
 * Class ClipitComment
 *
 * @package clipit
 */
class ClipitComment extends UBItem{
    /**
     * @const string Elgg entity subtype for this class
     */
    const SUBTYPE = "clipit_comment";
    const REL_COMMENT_TARGET = "comment-target";
    /**
     * @var bool Overall rating opinion: true = good, false = bad
     */
    public $overall = false;
    /**
     * @var array Ratings in the form: rating_array["rating_name"]=>"rating_value"
     */
    public $rating_array = array();
    /**
     * @var array Comments in the form: comment_array["comment_name"]=>"comment"
     */
    public $comment_array = array();


    protected function _load($elgg_object){
        parent::_load($elgg_object);
        $this->overall = (bool)$elgg_object->overall;
        $this->rating_array = (array)$elgg_object->rating_array;
        $this->comment_array = (array)$elgg_object->comment_array;
    }

    /**
     * Saves this instance to the system.
     *
     * @return bool|int Returns the Id of the saved instance, or false if error
     */
    function save(){
        if($this->id == -1){
            $elgg_object = new ElggObject();
            $elgg_object->subtype = (string)static::SUBTYPE;
        } elseif(!$elgg_object = new ElggObject($this->id)){
            return false;
        }
        $elgg_object->name = (string)$this->name;
        $elgg_object->description = (string)$this->description;
        $elgg_object->overall = (bool)$this->overall;
        $elgg_object->rating_array = (array)$this->rating_array;
        $elgg_object->comment_array = (array)$this->comment_array;
        $elgg_object->access_id = ACCESS_PUBLIC;
        $elgg_object->save();
        $this->owner_id = (int)$elgg_object->owner_guid;
        $this->time_created = (int)$elgg_object->time_created;
        return $this->id = $elgg_object->guid;
    }

    static function get_by_target($target_array){
        foreach($target_array as $target_id){
            $rel_array = get_entity_relationships($target_id, true);
            foreach($rel_array as $rel){
                if($rel->relationship == ClipitComment::REL_COMMENT_TARGET){
                    $temp_array[] = new ClipitComment($rel->guid_one);
                }
            }
            if(isset($temp_array)){
                $comment_array[] = $temp_array;
            }
        }
        if(!isset($comment_array)){
            return array();
        }
        return $comment_array;
    }

    static function set_target($id, $target_id){
        if(!$comment = new ClipitComment($id)){
            return null;
        }
        return add_entity_relationship($comment->id, ClipitComment::REL_COMMENT_TARGET, $target_id);
    }

    static function get_target($id){
        if(!$comment = new ClipitComment($id)){
            return null;
        }
        $rel_array = get_entity_relationships($comment->id);
        if(empty($rel_array) || count($rel_array) != 1){
            return null;
        }
        $rel = array_pop($rel_array);
        if($rel->relationship != ClipitComment::REL_COMMENT_TARGET){
            return null;
        }
        return $rel->guid_two;
    }


}

