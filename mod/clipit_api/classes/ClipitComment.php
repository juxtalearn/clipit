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
 * Class ClipitComment
 *
 */
class ClipitComment extends UBMessage{
    /**
     * @const string Elgg entity subtype for this class
     */
    const SUBTYPE = "clipit_comment";
    /**
     * @var int Overall rating opinionfrom 0 to 10
     */
    public $overall = -1;
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
        $this->overall = (int)$elgg_object->overall;
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
        } elseif(!$elgg_object = new ElggObject((int)$this->id)){
            return false;
        }
        $elgg_object->name = (string)$this->name;
        $elgg_object->description = (string)$this->description;
        $elgg_object->access_id = ACCESS_PUBLIC;
        $elgg_object->read_array = (array)$this->read_array;
        $elgg_object->overall = (int)$this->overall;
        $elgg_object->rating_array = (array)$this->rating_array;
        $elgg_object->comment_array = (array)$this->comment_array;
        $elgg_object->save();
        $this->id = (int)$elgg_object->guid;
        $this->owner_id = (int)$elgg_object->owner_guid;
        $this->time_created = (int)$elgg_object->time_created;
        static::set_destination($this->id, $this->destination);
        static::add_files($this->id, $this->file_array);
        return $this->id;
    }

}

