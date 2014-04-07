<?php
/**
 * URJC Backend
 * PHP version:     >= 5.2
 * Creation date:   2013-11-01
 * Last update:     $Date$
 *
 * @author          Pablo Llinás Arnaiz <pebs74@gmail.com>, JuxtaLearn Project
 * @version         $Version$
 * @link            http://
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

/**
 * Class UBCollection
 *
 * @package urjc_backend
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
        return $item_array;
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