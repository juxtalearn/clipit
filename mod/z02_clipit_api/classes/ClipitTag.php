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
 * A Tag (Stumbling Block) identifier which is linked from one or more Tricky Topics, and which can be added
 * as metadata to Items or Resources.
 */
class ClipitTag extends UBItem {
    /**
     * @const string Elgg entity SUBTYPE for this class
     */
    const SUBTYPE = "ClipitTag";

    public $ontologylink = "";

    /**
     * Create a new instance of this class, and assign values to its properties.
     *
     * @param array $prop_value_array Array of [property]=>value pairs to set into the new instance
     *
     * @return int|bool Returns instance Id if correct, or false if error
     */
    static function create($prop_value_array) {
        if(!isset($prop_value_array["name"])){
            return null;
        }
        $id_array = static::get_from_search($prop_value_array["name"], true, true);
        if(!empty($id_array)){
            return array_pop($id_array)->id;
        }
        return static::set_properties(null, $prop_value_array);
    }

    static function get_tricky_topics($id) {
        return UBCollection::get_items($id, ClipitTrickyTopic::REL_TRICKYTOPIC_TAG, true);
    }

    protected function copy_from_elgg($elgg_entity)
    {
        parent::copy_from_elgg($elgg_entity);
        $this->ontologylink = (string)$elgg_entity->get("ontologylink");
    }

    protected function copy_to_elgg($elgg_entity)
    {
        parent::copy_to_elgg($elgg_entity);
        if (!empty($this->ontologylink)) {
            $elgg_entity->set("ontologylink", (string)$this->ontologylink);
        } else {
            $elgg_entity->set("ontologylink", "<http://www.juxtalearn.org/Stumbling_Block/".str_replace(" ","_",$this->name).">");
        }
    }
    public function save(){
        return parent::save();
    }

    /**
     * Get all objects which match a $search_string
     *
     * @param string $search_string String for searching matching objects
     * @param bool   $name_only     Whether to look only in the name property, default false.
     * @param bool   $strict        Whether to match the $search_string exactly, including case, or only partially.
     * @param int    $offset        The offset of the returned array
     * @param int    $limit         The limit of the returned array
     *
     * @return static[] Returns an array of matched objects
     */
    static function get_from_search($search_string, $name_only = true, $strict = false, $limit = 0, $offset = 0) {
        $search_result = array();
        if(!$strict) {
            $search_string = strtolower($search_string);
            // get the full array of entities
            $elgg_object_array = elgg_get_entities_from_metadata(
                array('type' => static::TYPE, 'subtype' => static::SUBTYPE, 'limit' => 0, 'metadata_name_value_pairs' => array( name => 'name', value => $search_string.'%', 'operand' => 'LIKE', 'case_sensitive' => FALSE ))
            );
            $search_result = array();
            foreach($elgg_object_array as $elgg_object) {
                // search for string in name
                if(strpos(strtolower($elgg_object->name), $search_string) !== false) {
                    $search_result[(int)$elgg_object->guid] = new static((int)$elgg_object->guid, $elgg_object);
                    continue;
                }
                // if not in name, search in description
                if($name_only === false) {
                    if(strpos(strtolower($elgg_object->description), $search_string) !== false) {
                        $search_result[(int)$elgg_object->guid] = new static((int)$elgg_object->guid, $elgg_object);
                    }
                }
            }
        } else { // $strict == true
            // directly retrieve entities with name = $search_string
            $elgg_object_array = elgg_get_entities_from_metadata(
                array(
                    'type' => static::TYPE, 'subtype' => static::SUBTYPE, 'metadata_names' => array("name"),
                    'metadata_values' => array($search_string), 'limit' => 0
                )
            );
            if(!empty($elgg_object_array)) {
                foreach($elgg_object_array as $elgg_object) {
                    $search_result[(int)$elgg_object->guid] = new static((int)$elgg_object->guid, $elgg_object);
                }
            }
        }
        usort($search_result, function($a,$b){
            $length1 = strlen($a->name);
            $length2 = strlen($b->name);
            return ($length1 < $length2) ? -1 : (($length1 > $length2) ? 1 : 0);
        });
        if(empty($limit)){
            return array_slice($search_result, (int)$offset, count($search_result), true);
        } else {
            return array_slice($search_result, (int)$offset, (int)$limit, true);
        }
        //return $search_result;
    }

}