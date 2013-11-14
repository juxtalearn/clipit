<?php namespace clipit\video;
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
use \pebs\PebsItem;
use \ElggObject;

/**
 * Class ClipitVideo
 *
 * @package clipit\video
 */
class ClipitVideo extends PebsItem{
    /**
     * @const string Elgg entity sybtype for this class
     */
    const SUBTYPE = "clipit_video";
    /**
     * @var array List of ClipitComment Ids targeting this Video
     */
    public $comment_array = array();
    /**
     * @var int Id of File which holds this Video's content
     */
    public $content = -1;
    /**
     * @var array List of Taxonomy Tags applied to this Video
     */
    public $taxonomy_tag_array = array();
    /**
     * @var int Timestamp when the Video was submitted
     */
    public $time_created = -1;

    /**
     * Loads a ClipitVideo instance from the system.
     *
     * @param int $id Id of Video to load
     * @return $this|null Returns Video instance, or null if error
     */
    function load($id){
        if(!$elgg_object = new ElggObject((int)$id)){
            return null;
        }
        $elgg_type = $elgg_object->type;
        $elgg_subtype = get_subtype_from_id($elgg_object->subtype);
        if(($elgg_type != $this::TYPE) || ($elgg_subtype != $this::SUBTYPE)){
            return null;
        }
        $this->id = (int) $elgg_object->guid;
        $this->name = (string) $elgg_object->name;
        $this->description = $elgg_object->description;
        $this->$comment_array = (array)$elgg_object->comment_array;
        $this->content = (int) $elgg_object->content;
        $this->taxonomy_tag_array = (array) $elgg_object->taconomy_tag_array;
        $this->time_created = (int) $elgg_object->time_created;
        return $this;
    }

    /**
     * Saves this instance to the system
     *
     * @return bool|int Resurns the Id of the saved instance, or false if error
     */
    function save(){
        if($this->id == -1){
            $elgg_object = new ElggObject();
            $elgg_object->subtype = (string) $this::SUBTYPE;
        } elseif(!$elgg_object = new ElggObject($this->id)){
            return false;
        }
        $elgg_object->name = (string) $this->name;
        $elgg_object->description = (string) $this->description;
        $elgg_object->comment_array = (array) $this->comment_array;
        $elgg_object->content = (int) $this->content;
        $elgg_object->taxonomy_tag_array = (array)$this->taxonomy_tag_array;
        return $this->id = $elgg_object->save();
    }

}