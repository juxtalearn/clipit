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

// LOAD PERFORMANCE PALETTE

$json_object = json_decode(file_get_contents(elgg_get_plugins_path() . "z02_clipit_api/performance_palette.json"), true);
if(!is_array($json_object) || key($json_object)!= "performance_palette"){
    return false;
}
ClipitPerformanceItem::delete_all();
$performance_items = array();
foreach($json_object["performance_palette"] as $category_array){
    foreach($category_array as $key => $val){
        switch ($key){
            case "category":
                $category = $val;
                break;
            case "category_description":
                $category_description = $val;
                break;
            case "items":
                foreach($val as $item) {
                    $prop_value_array = array();
                    $prop_value_array["category"] = $category;
                    $prop_value_array["category_description"] = $category_description;
                    foreach ($item as $key_2 => $val_2) {
                        $prop_value_array[$key_2] = $val_2;
                    }
                    $performance_items[] = ClipitPerformanceItem::create($prop_value_array);
                }
                break;
        }
    }
}

