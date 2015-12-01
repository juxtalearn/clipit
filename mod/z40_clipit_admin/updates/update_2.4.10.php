<?php

$quiz_array = ClipitQuiz::get_all();
foreach($quiz_array as $quiz){
    if(empty($quiz->tricky_topic)) {
        restore_quiz_tt($quiz);
    }
}
return;

function restore_quiz_tt($quiz){
    // Try to obtain TT from task->activity
    $tricky_topic = get_tt_from_task($quiz->id);
    // if it didn't work, try from parent quiz
    if(empty($tricky_topic)){
        $tricky_topic = ClipitQuiz::get_tricky_topic($quiz->cloned_from);
    }
    if(empty($tricky_topic)){
        return;
    }
    ClipitQuiz::set_tricky_topic($quiz->id, $tricky_topic);
}

function get_tt_from_task($quiz_id){
    $quiz_task = ClipitQuiz::get_task($quiz_id);
    if(empty($quiz_task)) { return 0; }
    $activity = ClipitTask::get_activity($quiz_task);
    if(empty($activity)){ return 0; }
    return ClipitActivity::get_tricky_topic($activity);
}
