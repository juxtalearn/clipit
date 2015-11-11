<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   02/02/2015
 * Last update:     02/02/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */

$quiz = get_input('quiz');
// Set questions to Quiz
$questions = $quiz['question'];
$questions_id = array();

$images_tmp = array_pop($_FILES['quiz']['tmp_name']);
$images_name = array_pop($_FILES['quiz']['name']);
quiz_save(
    $quiz,
    $quiz['question'],
    array_pop($_FILES['quiz']['tmp_name']),
    array_pop($_FILES['quiz']['name'])
);

if($quiz['id']){
    $href = 'quizzes/view/'.$quiz['id'];
} else {
    $href = 'quizzes';
}

system_message(elgg_echo('quiz:created'));
forward($href);