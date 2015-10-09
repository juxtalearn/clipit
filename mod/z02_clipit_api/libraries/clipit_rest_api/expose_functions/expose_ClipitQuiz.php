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
        $api_suffix . "evaluate_results", $class_suffix . "evaluate_results",
        array("id" => array("type" => "int", "required" => true)),
        "Evaluate all results from a Quiz", "POST", false, true
    );
    expose_function(
        $api_suffix . "get_task", $class_suffix . "get_task", array(
            "id" => array("type" => "int", "required" => true)
        ), "Get Task in which Quiz is inside of", 'GET', false, true
    );
    expose_function(
        $api_suffix . "get_tricky_topic", $class_suffix . "get_tricky_topic", array(
            "id" => array("type" => "int", "required" => true)
        ), "Get the Tricky Topic a Quiz is related to", "GET", false, true
    );
    expose_function(
        $api_suffix . "set_tricky_topic", $class_suffix . "set_tricky_topic", array(
            "id" => array("type" => "int", "required" => true),
            "tricky_topic_id" => array("type" => "int", "required" => true)
        ), "Set Tricky Topic for a Quiz", "POST", false, true
    );
    expose_function(
        $api_suffix . "get_from_tricky_topic", $class_suffix . "get_from_tricky_topic", array(
            "tricky_topic_id" => array("type" => "int", "required" => true)
        ), "Get Quizzes related to a Tricky Topic", "GET", false, true
    );
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
    expose_function(
        $api_suffix . "set_quiz_start", $class_suffix . "set_quiz_start",
        array(
            "id" => array("type" => "int", "required" => true),
            "user_id" => array("type" => "int", "required" => true)),
        "Set Quiz Start Time", 'POST', false, true
    );
    expose_function(
        $api_suffix . "get_quiz_start", $class_suffix . "get_quiz_start",
        array(
            "id" => array("type" => "int", "required" => true),
            "user_id" => array("type" => "int", "required" => true)),
        "Get Quiz Start Time", 'GET', false, true
    );
    expose_function(
        $api_suffix . "set_quiz_as_finished", $class_suffix . "set_quiz_as_finished",
        array(
            "id" => array("type" => "int", "required" => true),
            "user_id" => array("type" => "int", "required" => true)),
        "Mark a Quiz as finished for a user", 'POST', false, true
    );
    expose_function(
        $api_suffix . "has_finished_quiz", $class_suffix . "has_finished_quiz",
        array(
            "id" => array("type" => "int", "required" => true),
            "user_id" => array("type" => "int", "required" => true)),
        "Returns true if User has finished a quiz, or false ir not", 'GET', false, true
    );
    expose_function(
        $api_suffix . "questions_answered_by_user", $class_suffix . "questions_answered_by_user",
        array(
            "id" => array("type" => "int", "required" => true),
            "user_id" => array("type" => "int", "required" => true)),
        "Returns the number of questions of a quiz answered by a user", 'GET', false, true
    );
    expose_function(
        $api_suffix . "get_user_results_by_question", $class_suffix . "get_user_results_by_question",
        array(
            "id" => array("type" => "int", "required" => true),
            "user_id" => array("type" => "int", "required" => true)),
        "Returns an array with normalized results by question for a user", 'GET', false, true
    );
    expose_function(
        $api_suffix . "get_group_results_by_question", $class_suffix . "get_group_results_by_question",
        array(
            "id" => array("type" => "int", "required" => true),
            "group_id" => array("type" => "int", "required" => true)),
        "Returns an array with normalized results by question for a group", 'GET', false, true
    );
    expose_function(
        $api_suffix . "get_user_results_by_tag", $class_suffix . "get_user_results_by_tag",
        array(
            "id" => array("type" => "int", "required" => true),
            "user_id" => array("type" => "int", "required" => true)),
        "Returns an array with normalized results by tag for a user", 'GET', false, true
    );
    expose_function(
        $api_suffix . "get_group_results_by_tag", $class_suffix . "get_group_results_by_tag",
        array(
            "id" => array("type" => "int", "required" => true),
            "group_id" => array("type" => "int", "required" => true)),
        "Returns an array with normalized results by tag for a group", 'GET', false, true
    );
    expose_function(
        $api_suffix . "get_group_results_by_tag", $class_suffix . "get_group_results_by_tag",
        array(
            "id" => array("type" => "int", "required" => true)),
        "Returns an array with normalized results by tag for the whole quiz", 'GET', false, true
    );
    expose_function(
        $api_suffix . "export_to_excel", $class_suffix . "export_to_excel",
        array(
            "id" => array("type" => "int", "required" => true)),
        "Exports a whole Quiz to Excel format", 'GET', false, true
    );
}
