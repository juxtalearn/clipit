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
function expose_quiz_functions() {
    $api_suffix = "clipit.quiz.";
    $class_suffix = "ClipitQuiz::";
    expose_common_functions($api_suffix, $class_suffix);
    expose_function(
        $api_suffix . "add_quiz_questions", $class_suffix . "add_quiz_questions", array(
            "id" => array("type" => "int", "required" => true),
            "quiz_question_array" => array("type" => "array", "required" => true)
        ), "Add Quiz Questions by Id", 'POST', false, true
    );
    expose_function(
        $api_suffix . "set_quiz_questions", $class_suffix . "set_quiz_questions", array(
            "id" => array("type" => "int", "required" => true),
            "quiz_question_array" => array("type" => "array", "required" => true)
        ), "Set Quiz Questions by Id", 'POST', false, true
    );
    expose_function(
        $api_suffix . "remove_quiz_questions", $class_suffix . "remove_quiz_questions", array(
            "id" => array("type" => "int", "required" => true),
            "quiz_question_array" => array("type" => "array", "required" => true)
        ), "Remove Quiz Questions by Id", 'POST', false, true
    );
    expose_function(
        $api_suffix . "get_quiz_questions", $class_suffix . "get_quiz_questions",
        array("id" => array("type" => "int", "required" => true)), "Get Quiz Questions", 'GET', false, true
    );
}
