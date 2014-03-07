<?php
/**
 * JuxtaLearn ClipIt API
 * PHP version:     >= 5.2
 * Creation date:   2013-10-10
 * Last update:     $Date$
 *
 * @author          Pablo Llinás Arnaiz <pebs74@gmail.com>
 * @version         $Version$
 * @link            http://juxtalearn.org
 * @license         GNU Affero General Public License v3
 *                  (http://www.gnu.org/licenses/agpl-3.0.txt)
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, version 3.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 * You should have received a copy of the GNU Affero General Public License
 * along with this program. If not, see
 * http://www.gnu.org/licenses/agpl-3.0.txt.
 */

/**
 * Register the init method
 */
elgg_register_event_handler('init', 'system', 'clipit_api_init');

/**
 * Initialization method which loads objects, libraries, exposes the REST API, and registers test classes.
 */
function clipit_api_init(){
    loadFiles(elgg_get_plugins_path() . "clipit_api/libraries/");
    clipit_expose_api();
    //clipit_register_subtypes();
}

function clipit_register_subtypes(){
    $subtype_class_array = array(
        "clipit_activity" => "ClipitActivity",
        "clipit_comment" => "ClipitComment",
        "clipit_file" => "ClipitFile",
        "clipit_group" => "ClipitGroup",
        "clipit_message" => "ClipitMessage",
        "clipit_palette" => "ClipitPalette",
        "clipit_quiz" => "ClipitQuiz",
        "clipit_quiz_question" => "ClipitQuizQuestion",
        "clipit_quiz_result" => "ClipitQuizResult",
        "clipit_storyboard" => "ClipitStoryboard",
        "clipit_tag" => "ClipitTag",
        "clipit_task" => "ClipitTask",
        "clipit_trickytopic" => "ClipitTrickyTopic",
        "clipit_video" => "ClipitVideo");
    foreach($subtype_class_array as $subtype => $class){
        if(get_subtype_id("object", $subtype)){
            update_subtype("object", $subtype, $class);
        } else{
            add_subtype("object", $subtype, $class);
        }
    }
}

///**
// * Method which runs and collects results for PHP Unit tests.
// *
// * @param $hook
// * @param $type
// * @param $value
// * @param $params
// * @return array
// */
//function clipit_api_tests($hook, $type, $value, $params){
//    $test_files = elgg_get_file_list(elgg_get_plugins_path()."clipit_api/tests/", array(), array(), array(".php"));
//    foreach($test_files as $file){
//        $value[] = $file;
//    }
//    return $value;
//}
