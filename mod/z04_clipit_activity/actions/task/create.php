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
$tasks = get_input('task');

foreach($tasks as $task){
    if($quiz_id = $task['quiz_id']){
        $quiz_id = ClipitQuiz::create_clone($task['quiz_id']);
    }
    $task_id = ClipitTask::create(array(
        'name' => $task['title'],
        'description' => $task['description'],
        'task_type' => $task['type'],
        'start' => get_timestamp_from_string($task['start'])+(60*1),
        'end' => get_timestamp_from_string($task['end'])+(60*60*24)-(60*1),
        'quiz' => ($task['type']==ClipitTask::TYPE_QUIZ_TAKE && $task['quiz_id']) ? $quiz_id : 0
    ));
    ClipitActivity::add_tasks($entity_id, array($task_id));
    if($task['type'] == ClipitTask::TYPE_QUIZ_TAKE && !$task['quiz_id']){
        $quiz = $task['quiz'];
        // Set questions to Quiz
        $questions = $quiz['question'];
        foreach($questions as $question){
            $values = array();
            $validations = array();
            $tags = array();
            switch($question['type']){
                case ClipitQuizQuestion::TYPE_SELECT_MULTI:
                    foreach($question['select_multi'] as $select){
                        $values[] = $select['value'];
                        if(isset($select['correct'])){
                            $validations[] = 1;
                        } else {
                            $validations[] = 0;
                        }
                    }
                    break;
                case ClipitQuizQuestion::TYPE_SELECT_ONE:
                    foreach($question['select_one'] as $select){
                        $values[] = $select['value'];
                        if(isset($select['correct'])){
                            $validations[] = 1;
                        } else {
                            $validations[] = 0;
                        }
                    }
                    break;
                case ClipitQuizQuestion::TYPE_TRUE_FALSE:
                    $a = array_fill(0, 2, 0);
                    switch($question['true_false']){
                        case 'true':
                            $a[0] = 1;
                            break;
                        case 'false':
                            $a[1] = 1;
                            break;
                    }
                    $validations = $a;
                    break;
                case ClipitQuizQuestion::TYPE_NUMBER:
                    $validations[] = $question['number'];
                    break;
            }
            $tags = array_filter($question['tags']);
            $question_id = ClipitQuizQuestion::create(array(
                'name' => $question['title'],
                'description' => $question['description'],
                'difficulty' => $question['difficulty'],
                'option_type' => $question['type'],
                'option_array' => $values,
                'validation_array' => $validations,
                'tag_array' => $tags
            ));
            $questions_id[] = $question_id;
            if($question['id_parent']){
                ClipitQuizQuestion::link_parent_clone($question['id_parent'], $question_id);
            }
        }
        $time = $quiz['time'];
        $total_time = (int)($time['d']*86400) + ($time['h']*3600) + ($time['m']*60);
        $quiz_id = ClipitQuiz::create(array(
            'name' => $quiz['title'],
            'description' => $quiz['description'],
            'view_mode' => $quiz['view'],
            'max_time' => $total_time,
            'target' => $quiz['target']
        ));
        ClipitTask::set_properties($task_id, array('quiz' => $quiz_id));
        ClipitQuiz::add_quiz_questions($quiz_id, $questions_id);
    }
    if($task['type'] == ClipitTask::TYPE_RESOURCE_DOWNLOAD){
        $files = array_filter(get_input('attach_files'));
        ClipitTask::add_files($task_id, $files);
        $videos = array_filter(get_input('attach_videos'));
        ClipitTask::add_videos($task_id, $videos);
        $storyboards = array_filter(get_input('attach_storyboards'));
        ClipitTask::add_storyboards($task_id, $storyboards);
    }
    if($task['feedback']){
        $feedback = $task['feedback-form'];
        if($feedback['title'] && $feedback['type'] && $feedback['start'] && $feedback['end'] ){
            $feedback_task_id = ClipitTask::create(array(
                'name' => $feedback['title'],
                'description' => $feedback['description'],
                'task_type' => $feedback['type'],
                'start' => get_timestamp_from_string($feedback['start'])+(60*1),
                'end' => get_timestamp_from_string($feedback['end'])+(60*60*24)-(60*1),
                'parent_task' => $task_id
            ));
            ClipitActivity::add_tasks($entity_id, array($feedback_task_id));
        }
    }
}
forward(REFERRER);