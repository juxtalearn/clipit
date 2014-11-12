<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   21/07/14
 * Last update:     21/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$entity_id = get_input('entity-id');
$entity = array_pop(ClipitTask::get_by_id(array($entity_id)));
$task = array_pop(get_input('task'));
$task_array = $task;
$quiz = get_input('quiz');

if($task['feedback-form'] && $task['title'] == "") {
    $task_array = $task['feedback-form'];
}

$updated = ClipitTask::set_properties($entity_id, array(
    'name' => $task_array['title'],
    'description' => $task_array['description'],
    'start' => get_timestamp_from_string($task_array['start']),
    'end' => get_timestamp_from_string($task_array['end']),
//    'quiz' => $task_array['quiz']
));
if($entity->task_type == ClipitTask::TYPE_RESOURCE_DOWNLOAD){
    $files = array_filter(get_input('attach_files'));
    ClipitTask::set_files($entity_id, $files);
    $videos = array_filter(get_input('attach_videos'));
    ClipitTask::set_videos($entity_id, $videos);
    $storyboards = array_filter(get_input('attach_storyboards'));
    ClipitTask::set_storyboards($entity_id, $storyboards);
}


if($entity->task_type == ClipitTask::TYPE_QUIZ_TAKE){
    $quiz = get_input('quiz');
    // Set questions to Quiz
    $questions = get_input('question');

    foreach($questions as $question){
        $values = array();
        $validations = array();
        $tags = array();
        switch($question['type']){
            case ClipitQuizQuestion::TYPE_SELECT_MULTI:
                foreach($question['select_multi'] as $select){
                    if($select['value']) {
                        $values[] = $select['value'];
                        if (isset($select['correct'])) {
                            $validations[] = true;
                        } else {
                            $validations[] = false;
                        }
                    }
                }
                break;
            case ClipitQuizQuestion::TYPE_SELECT_ONE:
                foreach($question['select_one'] as $select){
                    if($select['value']){
                        $values[] = $select['value'];
                        if(isset($select['correct'])){
                            $validations[] = true;
                        } else {
                            $validations[] = false;
                        }
                    }
                }
                break;
            case ClipitQuizQuestion::TYPE_TRUE_FALSE:
                $validations[] = $question['true_false'];
                break;
            case ClipitQuizQuestion::TYPE_NUMBER:
                $validations[] = $question['number'];
                break;
            case ClipitQuizQuestion::TYPE_STRING:
                $validations[] = $question['string'];
                break;
        }
        $tags = array_filter($question['tags']);
        if($question['id_parent']){
            $questions_id[] = $question['id_parent'];
            ClipitQuizQuestion::set_properties($question['id_parent'], array(
                'name' => $question['title'],
                'description' => $question['description'],
                'difficulty' => $question['difficulty'],
                'option_type' => $question['type'],
                'option_array' => $values,
                'validation_array' => $validations,
                'tag_array' => $tags
            ));
        } else {
            // new QuizQuestion
            $questions_id[] = ClipitQuizQuestion::create(array(
                'name' => $question['title'],
                'description' => $question['description'],
                'difficulty' => $question['difficulty'],
                'option_type' => $question['type'],
                'option_array' => $values,
                'validation_array' => $validations,
                'tag_array' => $tags
            ));
        }
    }
    $time = $quiz['time'];
    $total_time = (int)($time['d']*86400) + ($time['h']*3600) + ($time['m']*60);
    ClipitQuiz::set_properties($quiz['id'], array(
        'name' => $quiz['title'],
        'description' => $quiz['description'],
        'view_mode' => $quiz['view'],
        'max_time' => $total_time
    ));
    ClipitQuiz::set_quiz_questions($quiz['id'], $questions_id);
}
if($task['feedback'] && $task['feedback-form']){
    $task_array = $task['feedback-form'];
    $new_task_id = ClipitTask::create(array(
        'name' => $task_array['title'],
        'description' => $task_array['description'],
        'task_type' => $task_array['type'],
        'start' => get_timestamp_from_string($task_array['start']),
        'end' => get_timestamp_from_string($task_array['end']),
        'parent_task' => $entity_id,
        'quiz' => $task_array['type'] == ClipitTask::TYPE_QUIZ_TAKE ? $task_array['quiz'] : 0
    ));
    $task_object = array_pop(ClipitTask::get_by_id(array($entity_id)));
    ClipitActivity::add_tasks($task_object->activity, array($new_task_id));

}

if($updated){
    system_message(elgg_echo('task:updated'));
} else {
    register_error(elgg_echo("task:cantupdate"));
}

forward(REFERRER);