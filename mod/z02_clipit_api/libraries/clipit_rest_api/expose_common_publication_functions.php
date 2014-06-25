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

function expose_common_publication_functions($api_suffix, $class_suffix){
    expose_function(
        $api_suffix . "get_by_tags",
        $class_suffix . "get_by_tags",
        array(
            "tag_array" => array(
                "type" => "array",
                "required" => true)),
        "Get the Publications containing at least one of the specified tags.",
        'GET', false, true);
    expose_function(
        $api_suffix . "get_publish_level",
        $class_suffix . "get_publish_level",
        array(
            "id" => array(
                "type" => "int",
                "required" => true)),
        "Get Publish level for a Publication ('group', 'activity' or 'site').",
        'GET', false, true);
    expose_function(
        $api_suffix . "get_group",
        $class_suffix . "get_group",
        array(
            "id" => array(
                "type" => "int",
                "required" => true)),
        "Get the Group this Publication is inside of.",
        'GET', false, true);
    expose_function(
        $api_suffix . "get_activity",
        $class_suffix . "get_activity",
        array(
            "id" => array(
                "type" => "int",
                "required" => true)),
        "Get the Activity this Publication is inside of.",
        'GET', false, true);
    expose_function(
        $api_suffix . "get_site",
        $class_suffix . "get_site",
        array(
            "id" => array(
                "type" => "int",
                "required" => true)),
        "Get the Site this Publication is inside of.",
        'GET', false, true);
    expose_function(
        $api_suffix . "add_tags",
        $class_suffix . "add_tags",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "tag_array" => array(
                "type" => "array",
                "required" => true)),
        "Add Tags by Id to a Publication",
        'POST', false, true);
    expose_function(
        $api_suffix . "set_tags",
        $class_suffix . "set_tags",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "tag_array" => array(
                "type" => "array",
                "required" => true)),
        "Set Tags by Id to a Publication",
        'POST', false, true);
    expose_function(
        $api_suffix . "remove_tags",
        $class_suffix . "remove_tags",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "tag_array" => array(
                "type" => "array",
                "required" => true)),
        "Remove Tags by Id from a Publication",
        'POST', false, true);
    expose_function(
        $api_suffix . "get_tags",
        $class_suffix . "get_tags",
        array(
            "id" => array(
                "type" => "int",
                "required" => true)),
        "Get Tags from a Publication",
        'GET', false, true);
    expose_function(
        $api_suffix . "add_labels",
        $class_suffix . "add_labels",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "label_array" => array(
                "type" => "array",
                "required" => true)),
        "Add Labels by Id to a Publication",
        'POST', false, true);
    expose_function(
        $api_suffix . "set_labels",
        $class_suffix . "set_labels",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "label_array" => array(
                "type" => "array",
                "required" => true)),
        "Set Labels by Id to a Publication",
        'POST', false, true);
    expose_function(
        $api_suffix . "remove_labels",
        $class_suffix . "remove_labels",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "label_array" => array(
                "type" => "array",
                "required" => true)),
        "Remove Tags by Id from a Publication",
        'POST', false, true);
    expose_function(
        $api_suffix . "get_labels",
        $class_suffix . "get_labels",
        array(
            "id" => array(
                "type" => "int",
                "required" => true)),
        "Get Labels from a Publication",
        'GET', false, true);
    expose_function(
        $api_suffix . "add_performance_items",
        $class_suffix . "add_performance_items",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "performance_item_array" => array(
                "type" => "array",
                "required" => true)),
        "Add Performance Items by Id to a Publication",
        'POST', false, true);
    expose_function(
        $api_suffix . "set_performance_items",
        $class_suffix . "set_performance_items",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "performance_item_array" => array(
                "type" => "array",
                "required" => true)),
        "Set Performance Items by Id to a Publication",
        'POST', false, true);
    expose_function(
        $api_suffix . "remove_performance_items",
        $class_suffix . "remove_performance_items",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "performance_item_array" => array(
                "type" => "array",
                "required" => true)),
        "Remove Performance Items by Id from a Publication",
        'POST', false, true);
    expose_function(
        $api_suffix . "get_performance_items",
        $class_suffix . "get_performance_items",
        array(
            "id" => array(
                "type" => "int",
                "required" => true)),
        "Get Performance Items from a Publication",
        'GET', false, true);
    expose_function(
        $api_suffix . "add_comments",
        $class_suffix . "add_comments",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "comment_array" => array(
                "type" => "array",
                "required" => true)),
        "Add Comments by Id to a Publication",
        'POST', false, true);
    expose_function(
        $api_suffix . "set_comments",
        $class_suffix . "set_comments",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "comment_array" => array(
                "type" => "array",
                "required" => true)),
        "Set Comments by Id to a Publication",
        'POST', false, true);
    expose_function(
        $api_suffix . "remove_comments",
        $class_suffix . "remove_comments",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "comment_array" => array(
                "type" => "array",
                "required" => true)),
        "Remove Comments by Id from a Publication",
        'POST', false, true);
    expose_function(
        $api_suffix . "get_comments",
        $class_suffix . "get_comments",
        array(
            "id" => array(
                "type" => "int",
                "required" => true)),
        "Get Comments from a Publication",
        'GET', false, true);
}