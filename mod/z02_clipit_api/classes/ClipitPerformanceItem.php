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
 * @deprecated
 * A Performance item which can be linked from Resources to denote that it has been applied to them, and allows for
 * richer linkage, searching and context of Resources.
 */
class ClipitPerformanceItem extends UBItem {
    /**
     * @const string Elgg entity SUBTYPE for this class
     */
    const SUBTYPE = "ClipitPerformanceItem";

    public $example = "";
    public $category = "";
    public $category_description = "";

    /**
     * Gets all Items by category, or all items grouped by category if no category is specified.
     *
     * @param string $category
     *
     * @return static[] Array of Items for the specified category
     */
    static function get_from_category($category = null)
    {
        $performance_items = static::get_all();
        if (empty($category)) {
            $return_array = array();
            foreach ($performance_items as $performance_item) {
                $return_array[$performance_item->category][] = $performance_item;
            }
        } else {
            $return_array = array();
            foreach ($performance_items as $performance_item) {
                if ($performance_item->category == $category) {
                    $return_array[$category][] = $performance_item;
                }
            }
        }
        return $return_array;
    }

    /**
     * Loads object parameters stored in Elgg
     *
     * @param ElggEntity $elgg_entity Elgg Object to load parameters from.
     */
    protected function copy_from_elgg($elgg_entity)
    {
        parent::copy_from_elgg($elgg_entity);
        $this->example = (string)$elgg_entity->get("example");
        $this->category = (string)$elgg_entity->get("category");
        $this->category_description = (string)$elgg_entity->get("category_description");
    }

    /**
     * Copy $this object parameters into an Elgg entity.
     *
     * @param ElggEntity $elgg_entity Elgg object instance to save $this to
     */
    protected function copy_to_elgg($elgg_entity)
    {
        parent::copy_to_elgg($elgg_entity);
        $elgg_entity->set("example", (string)$this->example);
        $elgg_entity->set("category", (string)$this->category);
        $elgg_entity->set("category_description", (string)$this->category_description);
    }
}