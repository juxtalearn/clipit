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
 * A Performance element which can be linked from Resources to denote that it has been applied to them, and allows for
 * richer linkage, searching and context of Resources.
 */
class ClipitPerformanceItem extends UBItem {
    /**
     * @const string Elgg entity SUBTYPE for this class
     */
    const SUBTYPE = "ClipitPerformanceItem";
    public $item_id = "";
    public $language = "";
    public $category = "";
    public $category_description = "";
    public $example = "";

    /**
     * Loads object parameters stored in Elgg
     *
     * @param ElggEntity $elgg_entity Elgg Object to load parameters from.
     */
    protected function copy_from_elgg($elgg_entity) {
        parent::copy_from_elgg($elgg_entity);
        $this->item_id = (string)$elgg_entity->get("item_id");
        $this->language = (string)$elgg_entity->get("language");
        $this->category = (string)$elgg_entity->get("category");
        $this->category_description = (string)$elgg_entity->get("category_description");
        $this->example = (string)$elgg_entity->get("example");
    }

    /**
     * Copy $this object parameters into an Elgg entity.
     *
     * @param ElggEntity $elgg_entity Elgg object instance to save $this to
     */
    protected function copy_to_elgg($elgg_entity) {
        parent::copy_to_elgg($elgg_entity);
        $elgg_entity->set("item_id", (string)$this->item_id);
        $elgg_entity->set("language", (string)$this->language);
        $elgg_entity->set("category", (string)$this->category);
        $elgg_entity->set("category_description", (string)$this->category_description);
        $elgg_entity->set("example", (string)$this->example);
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
        if(empty($category)) {
            foreach($performance_items as $performance_item) {
                $category_array[$performance_item->category][] = $performance_item;
            }
        } else {
            foreach($performance_items as $performance_item) {
                if($performance_item->category == $category) {
                    $category_array[] = $performance_item;
                }
            }
        }
        return $category_array;
    }

    static function get_for_language($id, $language){
        $initial_item = new static($id);
        $all_items = static::get_all();
        foreach($all_items as $item){
            if($item->item_id == $initial_item->item_id && $item->language == $language){
                return $item;
            }
        }
        return $initial_item;
    }
}