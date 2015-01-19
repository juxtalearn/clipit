<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   16/07/14
 * Last update:     16/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */

// Activity setup
$activity_name = get_input('activity-title');
$activity_description = get_input('activity-description');
$activity_start = get_input('activity-start');
$activity_end = get_input('activity-end');
$activity_tt = get_input('tricky-topic');

$activity_id = ClipitActivity::create(array(
    'name' => $activity_name,
    'description' => $activity_description,
    'start' => get_timestamp_from_string($activity_start),
    'end' => get_timestamp_from_string($activity_end),
    'tricky_topic' => $activity_tt
));
// Tasks
$tasks = get_input('task');
foreach($tasks as $task){
    $task_id = ClipitTask::create(array(
        'name' => $task['title'],
        'description' => $task['description'],
        'task_type' => $task['type'],
        'start' => get_timestamp_from_string($task['start']),
        'end' => get_timestamp_from_string($task['end']),
        'quiz' => $task['type'] == ClipitTask::TYPE_QUIZ_TAKE ? $task['quiz'] : 0
    ));
    ClipitActivity::add_tasks($activity_id, array($task_id));
    if($task['feedback']){
        $feedback = $task['feedback-form'];
        if($feedback['title'] && $feedback['type'] && $feedback['start'] && $feedback['end'] ){
            $feedback_task_id = ClipitTask::create(array(
                'name' => $feedback['title'],
                'description' => $feedback['description'],
                'task_type' => $feedback['type'],
                'start' => get_timestamp_from_string($feedback['start']),
                'end' => get_timestamp_from_string($feedback['end']),
                'parent_task' => $task_id
            ));
            ClipitActivity::add_tasks($activity_id, array($feedback_task_id));
        }
    }
    $quiz = '';
    $questions = '';
    if($task['quiz'] && $task['type'] == ClipitTask::TYPE_QUIZ_TAKE){
        $quiz = $task['quiz'];
        // Set questions to Quiz
        $questions = $quiz['question'];
        $questions_id = array();
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
            'max_time' => $total_time
        ));
        ClipitTask::set_properties($task_id, array('quiz' => $quiz_id));
        ClipitQuiz::add_quiz_questions($quiz_id, $questions_id);
    }
}
// Called users
$called_users = get_input('called_users');
ClipitActivity::add_students($activity_id, $called_users);
/**
 * Groups creation
 */
$filter = false;
$groups_creation = get_input('groups_creation');
$max_users = get_input('max-users');
switch($groups_creation){
    // Teacher make groups
    case 1:
        $groups = get_input('group');
        $group_mode = ClipitActivity::GROUP_MODE_TEACHER;
        $filter = "?filter=groups";
        break;
    // Student makes groups
    case 2:
        $group_mode = ClipitActivity::GROUP_MODE_STUDENT;
        shuffle($called_users);
        $total_groups = ceil(count($called_users)/$max_users[2]);
        $chunks = split_chunks($called_users, $total_groups);
        $num = 1;
        foreach($chunks as $users_array){
            $groups[] = array(
                'name' => elgg_echo('group'). " ". $num,
            );
            $num++;
        }
        ClipitActivity::set_properties($activity_id, array('max_group_size' => $max_users[2]));
        break;
    // Random
    case 3:
        shuffle($called_users);
        $total_groups = ceil(count($called_users)/$max_users[3]);
        $chunks = split_chunks($called_users, $total_groups);
        $num = 1;
        foreach($chunks as $users_array){
            $groups[] = array(
                'name' => elgg_echo('group'). " ". $num,
                'users' => implode(",", $users_array)
            );
            $num++;
        }
        ClipitActivity::set_properties($activity_id, array('max_group_size' => $max_users[3]));
        $group_mode = ClipitActivity::GROUP_MODE_SYSTEM;
        break;
}
ClipitActivity::set_properties($activity_id, array('group_mode' => $group_mode));
if($groups_creation){
    foreach($groups as $group){
        $group_id = ClipitGroup::create(array(
            'name' => $group['name'],
        ));
        if($group['users']){
            $users = explode(",", $group['users']);
            ClipitGroup::add_users($group_id, $users);
        }
        ClipitActivity::add_groups($activity_id, array($group_id));
    }
}
// Add me as teacher
$user_id = elgg_get_logged_in_user_guid();
ClipitActivity::add_teachers($activity_id, array($user_id));

$object = ClipitSite::lookup($activity_id);
system_message(elgg_echo("activity:created", array($object['name'])));
forward("clipit_activity/{$activity_id}/admin".$filter);