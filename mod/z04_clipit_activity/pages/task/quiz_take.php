<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   10/10/2014
 * Last update:     10/10/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$quiz_id = $task->quiz;

// Teacher view
if(hasTeacherAccess($user->role)){
    $users = ClipitActivity::get_students($activity->id);
    if($users){
        $body = elgg_view('tasks/admin/quiz_take', array(
            'activity' => $activity,
            'entities'    => $users,
            'quiz' => array_pop(ClipitQuiz::get_by_id(array($quiz_id))),
            'task' => $task,
        ));
    } else {
        $body = elgg_view('output/empty', array('value' => elgg_echo('users:none')));
    }
} elseif($user->role == ClipitUser::ROLE_STUDENT) {
    $href = "clipit_activity/{$activity->id}/quizzes";

    $finished_task = $task->end <= time() ? true : false;
    $finished = false;
    if (ClipitQuiz::has_finished_quiz($quiz_id, $user_id) || $finished_task) {
        $finished = true;
    }
    if ($task->results_after_finished && $finished) {
        $finished_task = true;
    }
    $quiz = array_pop(ClipitQuiz::get_by_id(array($quiz_id)));
    $questions = ClipitQuizQuestion::get_by_id($quiz->quiz_question_array, 0, 0, 'order');
    if($task->quiz_random_order){
        // Random questions
        shuffle($questions);
    }
    $body = elgg_view_form('quiz/take',
        array('body' =>
            elgg_view('quizzes/list', array(
                'quiz' => $quiz,
                'questions' => $questions,
                'href' => $href,
                'task' => $task,
                'user_id' => elgg_get_logged_in_user_guid(),
                'finished_task' => $finished_task,
                'finished' => $finished
            ))
        ));
}