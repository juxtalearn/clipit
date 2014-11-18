<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   17/11/2014
 * Last update:     17/11/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$quiz = get_input('quiz');
$user_id = get_input('user_id');

echo elgg_view('quizzes/list', array(
    'quiz' => $quiz,
    'task_id' => $task->id,
    'user_id' => $user_id,
    'finished_task' => ClipitQuiz::has_finished_quiz($quiz, $user_id),
    'finished' => true,
    'admin' => true
))
?>