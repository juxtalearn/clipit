<?php
/**
 * Created by PhpStorm.
 * User: pebs74
 * Date: 20/01/2015
 * Time: 16:55
 */
// Tricky Topic education level is now a string (instead of int) and is assigned one of the possible constants defined.
// This script transforms old int codes to string constants.
$tt_array = ClipitTrickyTopic::get_all();
foreach($tt_array as $tt){
    if(empty($tt->education_level)){
        continue;
    }
    $prop_value_array = array();
    switch((int)$tt->education_level){
        case 1:
            $prop_value_array["education_level"] = ClipitTrickyTopic::EDUCATION_LEVEL_PRIMARY;
            break;
        case 2:
            $prop_value_array["education_level"] = ClipitTrickyTopic::EDUCATION_LEVEL_GCSE;
            break;
        case 3:
            $prop_value_array["education_level"] = ClipitTrickyTopic::EDUCATION_LEVEL_ALEVEL;
            break;
        case 4:
            $prop_value_array["education_level"] = ClipitTrickyTopic::EDUCATION_LEVEL_UNIVERSITY;
            break;
        default:
            continue;
    }
    if(!empty($prop_value_array)) {
        ClipitTrickyTopic::set_properties($tt->id, $prop_value_array);
    }
}

// Relation between TTs and Examples is not top-down (before it was down-up).
// This script redefines the new relationship, but all properties and functions remain the same.
$example_array = ClipitExample::get_all();
foreach($example_array as $example){
    $old_rel = UBCollection::get_items($example->id, "ClipitExample-ClipitTrickyTopic");
    if(empty($old_rel)){
        continue;
    }
    $tt_id = (int)array_pop($old_rel);
    ClipitTrickyTopic::add_examples($tt_id, array($example->id));
    UBCollection::remove_all_items($example->id, "ClipitExample-ClipitTrickyTopic");
}
