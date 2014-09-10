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

$FILE_NAME = "pedagogical_palette.json";
$KEY_NAME = "pedagogical_palette";
// Check if Performance Palette has already been loaded.
if(get_config($KEY_NAME) === true) {
    return;
} else {
    set_config($KEY_NAME, true);
}
// Parse json containing Performance Palette Items
$json_object = json_decode(file_get_contents(elgg_get_plugins_path() . "z02_clipit_api/libraries/pedagogical_palette/". $FILE_NAME), true);
if(!is_array($json_object) || key($json_object) != $KEY_NAME) {
    return false;
}

// Clean previous Pedagogical Items
ClipitTag::delete_all();
ClipitTrickyTopic::delete_all();

// Add Pedagogical Items
foreach($json_object[$KEY_NAME] as $tricky_topic_array) {
    foreach($tricky_topic_array as $key => $val) {
        switch($key) {
            case "tricky_topic":
                $tricky_topic = $val;
                $prop_value_array = array();
                $prop_value_array["name"] = $tricky_topic;
                $tricky_topic_id = ClipitTrickyTopic::create($prop_value_array);
                break;
            case "items":
                $tag_id_array = array();
                foreach($val as $item) {
                    $prop_value_array = array();
                    foreach($item as $key_2 => $val_2) {
                        $prop_value_array[$key_2] = $val_2;
                    }
                    $tag_id_array[] = ClipitTag::create($prop_value_array);
                }
                ClipitTrickyTopic::add_tags($tricky_topic_id, $tag_id_array);
                break;
        }
    }
}

