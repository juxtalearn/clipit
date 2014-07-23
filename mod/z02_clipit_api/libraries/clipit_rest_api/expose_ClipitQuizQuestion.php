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
 * Expose class functions for the ClipIt REST API
 */
function expose_quiz_question_functions() {
    $api_suffix = "clipit.quiz_question.";
    $class_suffix = "ClipitQuizQuestion::";
    expose_common_functions($api_suffix, $class_suffix);
    expose_function(
        $api_suffix . "add_quiz_results", $class_suffix . "add_quiz_results", array(
            "id" => array("type" => "int", "required" => true),
            "quiz_result_array" => array("type" => "array", "required" => true)
        ), "Add Quiz Results for the specified Quiz", 'POST', false, true
    );
    expose_function(
        $api_suffix . "set_quiz_results", $class_suffix . "set_quiz_results", array(
            "id" => array("type" => "int", "required" => true),
            "quiz_result_array" => array("type" => "array", "required" => true)
        ), "Set Quiz Results for the specified Quiz", 'POST', false, true
    );
    expose_function(
        $api_suffix . "remove_quiz_results", $class_suffix . "remove_quiz_results", array(
            "id" => array("type" => "int", "required" => true),
            "quiz_result_array" => array("type" => "array", "required" => true)
        ), "Remove Quiz Results from the specified Quiz", 'POST', false, true
    );
    expose_function(
        $api_suffix . "get_quiz_results", $class_suffix . "get_quiz_results",
        array("id" => array("type" => "int", "required" => true)), "Get Quiz Results from the specified Quiz", 'GET',
        false, true
    );
    expose_function(
        $api_suffix . "add_tags", $class_suffix . "add_tags", array(
            "id" => array("type" => "int", "required" => true),
            "tag_array" => array("type" => "array", "required" => true)
        ), "Add Tags by Id", 'POST', false, true
    );
    expose_function(
        $api_suffix . "set_tags", $class_suffix . "set_tags", array(
            "id" => array("type" => "int", "required" => true),
            "tag_array" => array("type" => "array", "required" => true)
        ), "Set Tags by Id", 'POST', false, true
    );
    expose_function(
        $api_suffix . "remove_tags", $class_suffix . "remove_tags", array(
            "id" => array("type" => "int", "required" => true),
            "tag_array" => array("type" => "array", "required" => true)
        ), "Remove Tags by Id", 'POST', false, true
    );
    expose_function(
        $api_suffix . "get_tags", $class_suffix . "get_tags", array("id" => array("type" => "int", "required" => true)),
        "Get Taxonomy Tags from a Quiz", 'GET', false, true
    );
}
