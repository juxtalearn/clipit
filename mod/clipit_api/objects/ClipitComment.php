<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   2013-10-10
 * Last update:     $Date$
 *
 * @author          Pablo Llinás Arnaiz <pebs74@gmail.com>, JuxtaLearn Project
 * @version         $Version$
 * @link            http://juxtalearn.org
 * @license         GNU Affero General Public License v3
 *                  (http://www.gnu.org/licenses/agpl-3.0.txt)
 *                  This program is free software: you can redistribute it and/or modify
 *                  it under the terms of the GNU Affero General Public License as
 *                  published by the Free Software Foundation, version 3.
 *                  This program is distributed in the hope that it will be useful,
 *                  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *                  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 *                  GNU Affero General Public License for more details.
 *                  You should have received a copy of the GNU Affero General Public License
 *                  along with this program. If not, see
 *                  http://www.gnu.org/licenses/agpl-3.0.txt.
 */
namespace clipit;

/**
 * Alias so classes outside of this namespace can be used without path.
 * @use \ElggObject
 *
 * @use pebs\PebsItem
 */
use \ElggObject;
use pebs\PebsItem;

/**
 * Class ClipitComment
 *
 * @package clipit
 */
class ClipitComment extends PebsItem{
    //    Inherited properties:
    //    /**
    //    * @const string Elgg entity TYPE for this class
    //    */
    //    const TYPE = "object";
    //    /**
    //    * @const string Elgg entity SUBTYPE for this class
    //    */
    //    const SUBTYPE = "";
    //    /**
    //    * @var int Unique Id of this instance
    //    */
    //    public $id = -1;
    //    /**
    //    * @var string Name of this instance
    //    */
    //    public $name = "";
    //    /**
    //    * @var string Description of this instance
    //    */
    //    public $description = "";
    /**
     * @var int Id of item this comment is targeting
     */
    public $target = -1;
    /**
     * @var int Id of user who posted the comment
     */
    public $author = -1;
    /**
     * @var int Timestamp when the comment was posted
     */
    public $time_created = -1;
    /**
     * @var bool Overall rating opinion: true = good, false = bad
     */
    public $overall = false;
    /**
     * @var array List of "rating_name"=>"rating_value" elements
     */
    public $rating_array = array();


    /**
     * Loads a ClipitComment instance from the system.
     *
     * @param int $id Id of Comment to load
     * @return ClipitComment|null Returns Comment instance, or null if error
     */
    protected function _load($id){
        if(!$elgg_object = new ElggObject((int)$id)){
            return null;
        }
        $elgg_type = $elgg_object->type;
        $elgg_subtype = get_subtype_from_id($elgg_object->subtype);
        if(($elgg_type != $this::TYPE) || ($elgg_subtype != $this::SUBTYPE)){
            return null;
        }
        $this->id = (int)$elgg_object->guid;
        $this->name = (string)$elgg_object->name;
        $this->description = (string)$elgg_object->description;
        $this->target = (int)$elgg_object->target;
        $this->author = (int)$elgg_object->author;
        $this->time_created = (int)$elgg_object->time_created;
        $this->overall = (bool)$elgg_object->overall;
        $this->rating_array = (array)$elgg_object->rating_array;
        return $this;
    }

    /**
     * Saves this instance to the system
     *
     * @return bool|int Returns the Id of the saved instance, or false if error
     */
    function save(){
        if($this->id == -1){
            $elgg_object = new ElggObject();
            $elgg_object->subtype = (string)$this::SUBTYPE;
        } elseif(!$elgg_object = new ElggObject($this->id)){
            return false;
        }
        $elgg_object->name = (string)$this->name;
        $elgg_object->description = (string)$this->description;
        $elgg_object->target = (int)$this->target;
        $elgg_object->author = (int)$this->author;
        $elgg_object->overall = (bool)$this->overall;
        $elgg_object->rating_array = (array)$this->rating_array;
        $elgg_object->save();
        return $this->id = $elgg_object->guid;
    }

    /**
     * Create a new ClipitComment instance, and save it into the system.
     * @param string $name
     * @param string $description
     * @param int $target
     * @param int $author
     * @param bool $overall
     * @param array $rating_array
     * @return bool|int Returns the new Comment If, or false if error
     */
    static function create($name = "",
                           $description = "",
                           $target,
                           $author,
                           $overall,
                           $rating_array = null){
        $prop_value_array["name"] = (string)$name;
        $prop_value_array["description"] = (string)$description;
        $prop_value_array["target"] = (int)$target;
        $prop_value_array["author"] = (int)$author;
        $prop_value_array["overall"] = (bool)$overall;
        $prop_value_array["rating_array"] = (array)$rating_array;
        $comment = new ClipitComment();
        return $comment->setProperties($prop_value_array);
    }
}

