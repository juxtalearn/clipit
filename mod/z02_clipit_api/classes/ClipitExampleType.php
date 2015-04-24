<?php
/**
 * Created by PhpStorm.
 * User: pebs74
 * Date: 05/12/2014
 * Time: 13:45
 */

class ClipitExampleType extends UBItem{
    /**
     * @const string Elgg entity SUBTYPE for this class
     */
    const SUBTYPE = "ClipitExampleType";

    /*
    Properties are disposed in arrays by language, in the following order:
    [0 => en, 1 => es, 2 => de, 3 => pt]
    To get the language index for a language code, use: get_language_index($lang_code);
    E.g.: to get the Spanish translation of the Item's name: $item->item_name[get_language_index("es")]
    */
    public $reference = array();
    public $item_name = array();
    public $item_description = array();
    public $category = array();
    public $category_description = array();


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
                    array("item_name", "item_description", "category", "category_description"))
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
        switch ((string)$language){
            case "en":
                $lang_index = 0;
                break;
            case "es":
                $lang_index = 1;
                break;
            case "de":
                $lang_index = 2;
                break;
            case "pt":
                $lang_index = 3;
                break;
            case "sv":
                $lang_index = 4;
                break;
            default:
                $lang_index = 0;
        }
        return $lang_index;
    }

    /**
     * Gets all Items by category, or all items grouped by category if no category is specified.
     *
     * @param string $category
     * @param string $language
     *
     * @return static[] Array of Items for the specified category
     */
    static function get_from_category($category = null, $language = "en") {
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
     * @param $reference
     * @return static|null
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