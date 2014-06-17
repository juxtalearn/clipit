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
 * Register the init method
 */
elgg_register_event_handler('init', 'system', 'clipit_api_init');

/**
 * Initialization method which loads objects, libraries, exposes the REST API, and registers test classes.
 */
function clipit_api_init(){
    //loadFiles(elgg_get_plugins_path() . "z02_clipit_api/classes/");
    loadFiles(elgg_get_plugins_path() . "z02_clipit_api/libraries/clipit_rest_api/");
    loadFiles(elgg_get_plugins_path() . "z02_clipit_api/libraries/juxtalearn-cookie-authentication/");
    loadFiles(elgg_get_plugins_path() . "z02_clipit_api/libraries/simple_xlsx/");
    expose_clipit_api();
    elgg_register_page_handler('youtube_auth', 'youtube_auth_page_handler');
    elgg_register_page_handler("data_input", "data_input_page_handler");
    load_performance_palette();
}

function youtube_auth_page_handler($page){
    $title = "YouTube Authentication";
    $params = array(
        'content' => elgg_view("youtube_auth"),
        'title' => $title,
        'filter' => "",
    );
    $body = elgg_view_layout('one_column', $params);

    echo elgg_view_page($title, $body);
}

function data_input_page_handler($page){
    $title = "ClipIt Setup";
    $params = array(
        'content' => elgg_view("data_input"),
        'title' => $title,
        'filter' => "",
    );
    $body = elgg_view_layout('one_column', $params);

    echo elgg_view_page($title, $body);
}

function load_performance_palette(){
    if(get_config("performance_palette") == true){
        return;
    } else{
        set_config("performance_palette", true);
    }
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
}

