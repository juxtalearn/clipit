<?php
/**
 * Clipit - Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   2013-10-10
 * Last update:     $Date$
 * @author          Pablo Llinás Arnaiz <pebs74@gmail.com>, URJC Clipit Team
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 * @subpackage      clipit_api
 */

/**
 * Expose class functions for the Clipit REST API
 */
function expose_quiz_result_functions() {
    $api_suffix = "clipit.quiz_result.";
    $class_suffix = "ClipitQuizResult::";
    expose_common_functions($api_suffix, $class_suffix);
    expose_function(
        $api_suffix . "get_quiz_question", $class_suffix . "get_quiz_question",
        array("id" => array("type" => "int", "required" => true)), "Get Quiz Question for this Quiz Result", 'GET',
        false, true
    );
    expose_function(
        $api_suffix . "get_by_quiz_question", $class_suffix . "get_by_quiz_question",
        array("quiz_question_array" => array("type" => "array", "required" => true)),
        "Get Quiz Results by Quiz Question Id", 'GET', false, true
    );
    expose_function(
        $api_suffix . "evaluate_result", $class_suffix . "evaluate_result",
        array("id" => array("type" => "int", "required" => true)),
        "Evaluate a Quiz Result, and update the 'correct' property", 'POST', false, true
    );
    expose_function(
        $api_suffix . "get_from_question_user", $class_suffix . "get_from_question_user",
        array(
            "quiz_question_id" => array("type" => "int", "required" => true),
            "user_id" => array("type" => "int", "required" => true)),
        "Get Quiz Result for a Question by a user", "GET", false, true
    );
}
