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
    global $CONFIG;
    loadFiles(elgg_get_plugins_path() . "clipit_api/libraries/");
    clipit_expose_api();
    $CONFIG->JXL_SECRET = "697fe3f81946fb59a714471cd688360b";
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
