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
 * @subpackage      urjc_backend
 */

/**
 * Class UBCollection
 *
 */
abstract class UBCollection{
    /**
     * @const string Elgg entity SUBTYPE for this class
     */
    const SUBTYPE = "collection";

    /**
     * Adds Items to a Collection.
     *
     * @param int   $id Id from Collection to add Items to.
     * @param array $item_array Array of Item Ids to add.
     * @param string $rel_name Name of the relationship to use.
     * @param bool $exclusive Whether the added items have an exclusive relationship with the collection.
     *
     * @return bool Returns true if success, false if error
     */
    static function add_items($id, $item_array, $rel_name, $exclusive = false){
        foreach($item_array as $item_id){
            if($exclusive){
                $rel_array = get_entity_relationships($item_id, true);
                foreach($rel_array as $rel){
                    if($rel->relationship == $rel_name){
                        delete_relationship($rel->id);
                    }
                }
            }
            add_entity_relationship($id, $rel_name, $item_id);
        }
        return true;
    }

    /**
     * Get Items from a Collection.
     *
     * @param int $id Id from Collection to get Items from.
     * @param string $rel_name Name of the relationship linking the items.
     * @param bool $inverse Whether the Id specified is in the first (false) or second (true) term of the relationship.
     *
     * @return int[]|bool Returns an array of Item IDs, or false if error.
     */
    static function get_items($id, $rel_name, $inverse = false){
        $rel_array = get_entity_relationships($id, $inverse);
        $item_array = array();
        foreach($rel_array as $rel){
            if($rel->relationship == $rel_name){
                if($inverse){
                    $item_array[$rel->id] = (int)$rel->guid_one;
                } else{
                    $item_array[$rel->id] = (int)$rel->guid_two;
                }
            }
        }
        // IDs are created sequencially, so inverse ordering == reverse chrono-order
        usort($item_array, 'UBItem::sort_numbers_inv');
        return $item_array;
    }

    /**
     * Count the number of related items.
     *
     * @param int $id Item to count related items with.
     * @param string $rel_name Name of the relationship
     * @param bool $inverse position of the Item in the relationship (first = false, seccond = true)
     * @param bool $recursive Whether to count recursively or not
     * @return int Number of items related with the one specified.
     */
    static function count_items($id, $rel_name, $inverse = false, $recursive = false){
        $rel_array = get_entity_relationships($id, $inverse);
        $count = 0;
        foreach($rel_array as $rel){
            if($rel->relationship == $rel_name){
                $count++;
                if($recursive){
                    if($inverse){
                        $count += static::count_items($rel->guid_one, $inverse, $recursive);
                    } else{
                        $count += static::count_items($rel->guid_two, $inverse, $recursive);
                    }
                }
            }
        }
        return $count;
    }

    /**
     * Remove Items from a Collection.
     *
     * @param int   $id Id from Collection to remove Items from.
     * @param array $item_array Array of Item Ids to remove.
     * @param string $rel_name Name of the relationship to use.
     *
     * @return bool Returns true if success, false if error.
     */
    static function remove_items($id, $item_array, $rel_name){
        foreach($item_array as $item_id){
            remove_entity_relationship($id, $rel_name, $item_id);
        }
    }

    /**
     * Remove all items from a collection.
     *
     * @param int $id ID of the Collection to remove items from.
     * @param string $rel_name Name of the relationship to use.
     *
     * @return bool Returns true if success, false if error.
     */
    static function remove_all_items($id, $rel_name){
        return remove_entity_relationships($id, $rel_name);
    }

}