<?php
/**
 * Created by PhpStorm.
 * User: pebs74
 * Date: 08/07/2014
 * Time: 16:37
 */

if(get_config("performance_palette") == true){
    return false;
} else{
    set_config("performance_palette", true);
}
$json_object = json_decode(file_get_contents("performance_palette.json"), true);
if(!is_array($json_object) || key($json_object)!= "performance_palette"){
    return false;
}
ClipitPerformanceItem::delete_all();
$performance_items = array();
$category = "";
$category_description = "";
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

