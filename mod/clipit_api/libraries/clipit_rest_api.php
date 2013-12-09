<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   2013-10-10
 * Last update:     $Date$
 *
 * @author          Pablo Llinás Arnaiz <pebs74@gmail.com>, JuxtaLearn Project
 * @version         $Version$
 * @link            http://juxtalearn.org
 * @license         GNU Affero General Public License v3
 *                  (http://www.gnu.org/licenses/agpl-3.0.txt)
 *                  This program is free software: you can redistribute it and/or modify
 *                  it under the terms of the GNU Affero General Public License as
 *                  published by the Free Software Foundation, version 3.
 *                  This program is distributed in the hope that it will be useful,
 *                  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *                  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 *                  GNU Affero General Public License for more details.
 *                  You should have received a copy of the GNU Affero General Public License
 *                  along with this program. If not, see
 *                  http://www.gnu.org/licenses/agpl-3.0.txt.
 */

/**
 * Expose all functions for the ClipIt REST API
 */
function expose_clipit_api(){
    $suffix_list = array(
        "clipit.activity." => "ClipitActivity::",
        "clipit.comment." => "ClipitComment::",
        "clipit.file." => "ClipitFile::",
        "clipit.group." => "ClipitGroup::",
        "clipit.palette." => "ClipitPalette::",
        "clipit.quiz." => "ClipitQuiz::",
        "clipit.quiz.question." => "ClipitQuizQuestion::",
        "clipit.quiz.result." => "ClipitQuizResult::",
        "clipit.site." => "ClipitQuizSite::",
        "clipit.sta." => "ClipitSTA::",
        "clipit.storyboard." => "ClipitStoryboard::",
        "clipit.taxonomy." => "ClipitTaxonomy::",
        "clipit.taxonomy.sb." => "ClipitTaxonomySB::",
        "clipit.taxonomy.tag." => "ClipitTaxonomyTag::",
        "clipit.taxonomy.tc." => "ClipitTaxonomyTC::",
        "clipit.user." => "ClipitUser::",
        "clipit.video." => "ClipitVideo::");
    foreach($suffix_list as $api_suffix => $class_suffix){
        expose_common_functions($api_suffix, $class_suffix);
    }
    expose_activity_functions();
    expose_comment_functions();
    expose_file_functions();
    expose_group_functions();
    expose_palette_functions();
    expose_quiz_functions();
    expose_quiz_question_functions();
    expose_quiz_result_functions();
    expose_site_functions();
    expose_sta_functions();
    expose_storyboard_functions();
    expose_taxonomy_functions();
    expose_taxonomy_sb_functions();
    expose_taxonomy_tag_functions();
    expose_taxonomy_tc_functions();
    expose_user_functions();
    expose_video_functions();
}

function expose_common_functions($api_suffix, $class_suffix){
    expose_function(
        $api_suffix."list_properties",
        $class_suffix."list_properties",
        null,
        "Get class properties",
        'GET', false, true);
    expose_function(
        $api_suffix."get_properties",
        $class_suffix."get_properties",
        array(
             "id" => array(
                 "type" => "int",
                 "required" => true),
             "prop_array" => array(
                 "type" => "array",
                 "required" => true)),
        "Get property=>value array",
        'GET', false, true);
    expose_function(
        $api_suffix."set_properties",
        $class_suffix."set_properties",
        array(
             "id" => array(
                 "type" => "int",
                 "required" => true),
             "prop_value_array" => array(
                 "type" => "array",
                 "required" => true)),
        "Set property=>value array and save into the system",
        'POST', false, true);
    expose_function(
        $api_suffix."create",
        $class_suffix."create",
        array(
             "prop_value_array" => array(
                 "type" => "array",
                 "required" => true)),
        "Create a new instance, set property=>value array and save into the system",
        'POST', false, true);

    expose_function(
        $api_suffix."delete_by_id",
        $class_suffix."delete_by_id",
        array(
             "id_array" => array(
                 "type" => "array",
                 "required" => true)),
        "Delete instances by Id",
        'POST', false, true);
    expose_function(
        $api_suffix."get_all",
        $class_suffix."get_all",
        array(
             "limit" => array(
                 "type" => "int",
                 "required" => false)),
        "Get all instances",
        'GET', false, true);
    expose_function(
        $api_suffix."get_by_id",
        $class_suffix."get_by_id",
        array(
             "id_array" => array(
                 "type" => "array",
                 "required" => true)),
        "Get instances by Id",
        'GET', false, true);
}

function expose_activity_functions(){
}

function expose_comment_functions(){
    $api_suffix = "clipit.comment.";
    $class_suffix = "ClipitComment::";
    expose_function(
        $api_suffix."get_by_author",
        $class_suffix."get_by_author",
        array(
             "author_array" => array(
                 "type" => "array",
                 "required" => true)),
        "Get all Comments by Author Id",
        'GET', false, true);
}

function expose_file_functions(){
}

function expose_group_functions(){
}

function expose_palette_functions(){
}

function expose_quiz_functions(){
    $api_suffix = "clipit.quiz.";
    $class_suffix = "ClipitQuiz::";
    expose_function(
        $api_suffix."add_questions",
        $class_suffix."add_questions",
        array(
             "id" => array(
                 "type" => "int",
                 "required" => true),
             "question_array" => array(
                 "type" => "array",
                 "required" => true)),
        "Add Quiz Questions by Id",
        'POST', false, true);
    expose_function(
        $api_suffix."remove_questions",
        $class_suffix."remove_questions",
        array(
             "id" => array(
                 "type" => "int",
                 "required" => true),
             "question_array" => array(
                 "type" => "array",
                 "required" => true)),
        "Remove Quiz Questions by Id",
        'POST', false, true);
    expose_function(
        $api_suffix."get_questions",
        $class_suffix."get_questions",
        array(
             "id" => array(
                 "type" => "int",
                 "required" => true)),
        "Get Quiz Questions",
        'GET', false, true);
}

function expose_quiz_question_functions(){
    $api_suffix = "clipit.quiz.question.";
    $class_suffix = "ClipitQuizQuestion::";
    expose_function(
        $api_suffix."get_results",
        $class_suffix."get_results",
        array(
             "id" => array(
                 "type" => "int",
                 "required" => true)),
        "Get Quiz Results for the specified Quiz",
        'GET', false, true);
    expose_function(
        $api_suffix."add_taxonomy_tags",
        $class_suffix."add_taxonomy_tags",
        array(
             "id" => array(
                 "type" => "int",
                 "required" => true),
             "taxonomy_tag_array" => array(
                 "type" => "array",
                 "required" => true)),
        "Add Taxonomy Tags by Id",
        'POST', false, true);
    expose_function(
        $api_suffix."remove_taxonomy_tags",
        $class_suffix."remove_taxonomy_tags",
        array(
             "id" => array(
                 "type" => "int",
                 "required" => true),
             "taxonomy_tag_array" => array(
                 "type" => "array",
                 "required" => true)),
        "Remove Taxonomy Tags by Id",
        'POST', false, true);
    expose_function(
        $api_suffix."get_taxonomy_tags",
        $class_suffix."get_taxonomy_tags",
        array(
             "id" => array(
                 "type" => "int",
                 "required" => true)),
        "Get Taxonomy Tags from a Quiz",
        'GET', false, true);
}

function expose_quiz_result_functions(){
    $api_suffix = "clipit.quiz.result.";
    $class_suffix = "ClipitQuizResult::";
    expose_function(
        $api_suffix."get_by_question",
        $class_suffix."get_by_question",
        array(
             "quiz_question_array" => array(
                 "type" => "array",
                 "required" => true)),
        "Get instances by Question Id",
        'GET', false, true);
}

function expose_site_functions(){
}

function expose_sta_functions(){
}

function expose_storyboard_functions(){
}

function expose_taxonomy_functions(){
}

function expose_taxonomy_sb_functions(){
}

function expose_taxonomy_tag_functions(){
}

function expose_taxonomy_tc_functions(){
}

function expose_user_functions(){
    $api_suffix = "clipit.user.";
    $class_suffix = "ClipitUser::";
    expose_function(
        $api_suffix."get_by_login",
        $class_suffix."get_by_login",
        array(
             "login_array" => array(
                 "type" => "array",
                 "required" => true)),
        "Get all instances by Login",
        'GET', false, true);
    expose_function(
        $api_suffix."get_by_email",
        $class_suffix."get_by_email",
        array(
             "email_array" => array(
                 "type" => "array",
                 "required" => true)),
        "Get all instances by email. The result is a nested array, with an array of users per email.",
        'GET', false, true);
    expose_function(
        $api_suffix."get_by_role",
        $class_suffix."get_by_role",
        array(
             "role_array" => array(
                 "type" => "array",
                 "required" => true)),
        "Get all instances by role. The result is a nested array, with an array of users per role.",
        'GET', false, true);
}

function expose_video_functions(){
    $api_suffix = "clipit.video.";
    $class_suffix = "ClipitVideo::";
    expose_function(
        $api_suffix."add_comments",
        $class_suffix."add_comments",
        array(
             "id" => array(
                 "type" => "int",
                 "required" => true),
             "comment_array" => array(
                 "type" => "array",
                 "required" => true)),
        "Add Comments by Id to a Video",
        'POST', false, true);
    expose_function(
        $api_suffix."remove_comments",
        $class_suffix."remove_comments",
        array(
             "id" => array(
                 "type" => "int",
                 "required" => true),
             "comment_array" => array(
                 "type" => "array",
                 "required" => true)),
        "Remove Comments by Id from a Video",
        'POST', false, true);
    expose_function(
        $api_suffix."get_comments",
        $class_suffix."get_comments",
        array(
             "id" => array(
                 "type" => "int",
                 "required" => true)),
        "Get Comments from a Video",
        'GET', false, true);
}
