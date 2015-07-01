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
 * A key term (Label) which can be linked from any Resource as metadata for richer linkage, searching and context.
 */
class ClipitLabel extends UBItem {
    /**
     * @const string Elgg entity SUBTYPE for this class
     */
    const SUBTYPE = "ClipitLabel";

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
}