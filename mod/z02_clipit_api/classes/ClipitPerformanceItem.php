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
    const SUBTYPE = "ClipitPerformanceItem";
    // Language codes and indices
    const EN_CODE = "en";
    const EN_INDEX = 0;

    const ES_CODE = "es";
    const ES_INDEX = 1;

    const DE_CODE = "de";
    const DE_INDEX = 2;

    const PT_CODE = "pt";
    const PT_INDEX = 3;

    const SV_CODE = "sv";
    const SV_INDEX = 4;
    /*
    Properties are disposed in arrays by language, in the following order:
    [0 => en_value, 1 => es_value, 2 => de_value, 3 => pt_value, ...]
    To get the language index for a language code, use: get_language_index($lang_code);
    E.g.: to get the Spanish translation of the Item's name: $item->item_name[get_language_index("es")]
    */
    public $reference = 0;
    public $item_name = array();
    public $item_description = array();
    public $example = array();
    public $category = array();
    public $category_description = array();

    function __construct($id = null, $elgg_object = null) {
        $empty_string = "-EMPTY-";
        $this->item_name = array_fill(0, 10, $empty_string);
        $this->item_description = array_fill(0, 9, $empty_string);
        $this->example = array_fill(0, 10, $empty_string);
        $this->category = array_fill(0, 10, $empty_string);
        $this->category_description = array_fill(0, 10, $empty_string);
        parent::__construct($id, $elgg_object);
    }

    /**
     * Loads object parameters stored in Elgg
     *
     * @param ElggEntity $elgg_entity Elgg Object to load parameters from.
     */
    protected function copy_from_elgg($elgg_entity) {
        parent::copy_from_elgg($elgg_entity);
        $this->reference = (int)$elgg_entity->get("reference");
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
        $elgg_entity->set("reference", (int)$this->reference);
        $elgg_entity->set("item_name", (array)$this->item_name);
        $elgg_entity->set("item_description", (array)$this->item_description);
        $elgg_entity->set("example", (array)$this->example);
        $elgg_entity->set("category", (array)$this->category);
        $elgg_entity->set("category_description", (array)$this->category_description);
    }

    static function create($prop_value_array){
        if(isset($prop_value_array["reference"])){
            $item = static::get_by_reference((int)$prop_value_array["reference"]);
            if(!empty($item)) {
                return static::set_properties($item->id, $prop_value_array);
            }
        }
        // Reference is missing or invalid, clear to create new reference
        unset($prop_value_array["reference"]);
        return static::set_properties(null, $prop_value_array);
    }

    static function set_properties($id, $prop_value_array){
        if(!$item = new static($id)) {
            return false;
        }
        if(!isset($prop_value_array["language"])){
            $lang_index = 0;
        }else{
            $lang_index = static::get_language_index($prop_value_array["language"]);
            unset($prop_value_array["language"]);
        }
        if(!isset($prop_value_array["reference"])){
            $prop_value_array["reference"] = static::get_next_reference();
        }
        $property_list = (array)static::list_properties();
        foreach($prop_value_array as $prop => $value) {
            if(!array_key_exists($prop, $property_list) && $prop != "language") {
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
                $prop_array = (array)$item->$prop;
                $prop_array[$lang_index] = $value;
                $item->$prop = (array)$prop_array;
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

    static function get_language_index($language){
        switch ($language){
            case static::EN_CODE:
                return static::EN_INDEX;
            case static::ES_CODE:
                return static::ES_INDEX;
            case static::DE_CODE:
                return static::DE_INDEX;
            case static::PT_CODE:
                return static::PT_INDEX;
            case static::SV_CODE:
                return static::SV_INDEX;
            default:
                return static::EN_INDEX;
        }
    }

    static function get_index_language($index){
        switch($index) {
            case static::EN_INDEX:
                return static::EN_CODE;
            case static::ES_INDEX:
                return static::ES_CODE;
            case static::DE_INDEX:
                return static::DE_CODE;
            case static::PT_INDEX:
                return static::PT_CODE;
            case static::SV_INDEX:
                return static::SV_CODE;
            default:
                return static::EN_CODE;
        }
    }

    static function get_next_reference(){
        $all_items = static::get_all(0,0,"reference",false);
        return (int)$all_items[0]->reference+1;
    }

    /**
     * Gets all Items by category, or all items grouped by category if no category is specified.
     *
     * @param string $category
     * @param string $language
     *
     * @return static[] Array of Items for the specified category
     */
    static function get_by_category($category = null, $language = "en") {
        $performance_items = static::get_all();
        $category_array = array();
        $lang_index = static::get_language_index($language);
        if (empty($category)) {
            foreach ($performance_items as $performance_item) {
                $category_array[$performance_item->category[$lang_index]][] = $performance_item;
            }
        } else {
            foreach ($performance_items as $performance_item) {
                if ($performance_item->category[$lang_index] == $category) {
                    $category_array[] = $performance_item;
                }
            }
        }
        return $category_array;
    }

    /**
     * Gets an item by reference
     *
     * @param int $reference Item reference number
     * @return static|null Returns the referenced item, or null if not found.
     */
    static function get_by_reference($reference){
        $performance_items = static::get_all();
        foreach($performance_items as $item){
            if((int)$item->reference == (int)$reference) {
                return $item;
            }
        }
        return null;
    }
}