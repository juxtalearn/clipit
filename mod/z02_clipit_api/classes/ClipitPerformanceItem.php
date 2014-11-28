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
 * A Performance item which can be linked from Resources to denote that it has been applied to them, and allows for
 * richer linkage, searching and context of Resources.
 */
class ClipitPerformanceItem extends UBItem {
    /**
     * @const string Elgg entity SUBTYPE for this class
     */
    const SUBTYPE = "ClipitPerformanceTranslation";

    /*
    Properties are disposed in arrays by language, in the following order: [0 => en, 1 => es, 2 => de, 3 => pt]
    E.g.: to get the Spanish translation of the Item's description: $item->description[1]
    */
    public $reference = array();
    public $item_name = array();
    public $item_description = array();
    public $example = array();
    public $category = array();
    public $category_description = array();


    /**
     * Loads object parameters stored in Elgg
     *
     * @param ElggEntity $elgg_entity Elgg Object to load parameters from.
     */
    protected function copy_from_elgg($elgg_entity) {
        parent::copy_from_elgg($elgg_entity);
        $this->reference = (string)$elgg_entity->get("reference");
        $this->item_name = (array)$elgg_entity->get("item_name");
        $this->item_description = (array)$elgg_entity->get("item_description");
        $this->example = (array)$elgg_entity->get("example");
        $this->category = (array)$elgg_entity->get("category");
        $this->category_description = (array)$elgg_entity->get("category_description");
    }

    /**
     * Copy $this object parameters into an Elgg entity.
     *
     * @param ElggEntity $elgg_entity Elgg object instance to save $this to
     */
    protected function copy_to_elgg($elgg_entity) {
        parent::copy_to_elgg($elgg_entity);
        $elgg_entity->set("reference", (string)$this->reference);
        $elgg_entity->set("item_name", (array)$this->item_name);
        $elgg_entity->set("item_description", (array)$this->item_description);
        $elgg_entity->set("example", (array)$this->example);
        $elgg_entity->set("category", (array)$this->category);
        $elgg_entity->set("category_description", (array)$this->category_description);
    }

    static function create($prop_value_array){
        if(isset($prop_value_array["reference"])){
            $item = static::get_by_reference($prop_value_array["reference"]);
            return static::set_properties($item->id, $prop_value_array);
        }
        return static::set_properties(null, $prop_value_array);
    }

    static function set_properties($id, $prop_value_array){
        if(!$item = new static($id)) {
            return false;
        }

        if(!isset($prop_value_array["language"])){
            $lang_pos = 0;
        }else{
            $language = $prop_value_array["language"];
            switch ($language){
                case "en":
                    $lang_pos = 0;
                    break;
                case "es":
                    $lang_pos = 1;
                    break;
                case "de":
                    $lang_pos = 2;
                    break;
                case "pt":
                    $lang_pos = 3;
                    break;
                default:
                    $lang_pos = 0;
            }
        }

        unset($prop_value_array["language"]);

        foreach($prop_value_array as $prop => $value) {
            if(!array_key_exists($prop, static::list_properties()) && $prop != "language") {
                throw new InvalidParameterException("ERROR: One or more property names do not exist.");
            }
            if($prop == "id") {
                continue; // cannot set an item's ID or language.
            }
            // Check for multilanguage properties
            if(array_search(
                    $prop,
                    array("item_name", "item_description", "example", "category", "category_description"))
                !== false){
                $item->$prop[$lang_pos] = $value;
            } else {
                $item->$prop = $value;
            }
        }
        if (array_key_exists("time_created",$prop_value_array)) {
            return $item->save(true);
        } else {
            return $item->save(false);
        }
    }

    /**
     * Gets all Items by category, or all items grouped by category if no category is specified.
     *
     * @param string $category
     *
     * @return static[] Array of Items for the specified category
     */
    static function get_by_category($category = null) {
        $performance_items = static::get_all();
        $category_array = array();
        if (empty($category)) {
            foreach ($performance_items as $performance_item) {
                $category_array[$performance_item->category[0]][] = $performance_item;
            }
        } else {
            foreach ($performance_items as $performance_item) {
                if ($performance_item->category[0] == $category) {
                    $category_array[] = $performance_item;
                }
            }
        }
        return $category_array;
    }

    /**
     * @param $reference
     * @return static|null
     */
    static function get_by_reference($reference){
        $performance_items = static::get_all();
        foreach($performance_items as $item){
            if($item->reference == $reference) {
                return $item;
            }
        }
        return null;
    }
}