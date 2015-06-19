<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   09/04/2015
 * Last update:     09/04/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */

$activity_id = get_input('entity-id');
$tasks = get_input('task');
$quiz = get_input('quiz');

foreach ($tasks as $task) {
    $is_correct = false;
    if($task['feedback-form'] && $task['title'] == "") {
        $task = $task['feedback-form'];
    }

    $task_properties = array(
        'name' => $task['title'],
        'description' => $task['description'],
        'start' => date_create_from_format('d/m/y H:i', $task['start'])->getTimestamp(),
        'end' => date_create_from_format('d/m/y H:i', $task['end'])->getTimestamp(),
        'rubric' => ($task['rubric'])
    );
    if ($task_id = get_input('task-id')) {
        $entity_id = $task_id;
        // Update an existing task
        $updated = ClipitTask::set_properties($task_id, $task_properties);
        // Set task type from entity
        $entity = array_pop(ClipitTask::get_by_id(array($task_id)));
        if($entity){
            $is_correct = true;
            $correct_msg = elgg_echo('task:updated');
        } else {
            $error_msg = elgg_echo("task:cantupdate");
        }
        $task_type = $entity->task_type;
        $activity_id = $entity->activity;
    } else {
        // Create new task
        $task_type = $task['type'];
        $quiz_id = 0;
        if ($task_type==ClipitTask::TYPE_QUIZ_TAKE && $task['quiz_id']) {
            $quiz_id = ClipitQuiz::create_clone($task['quiz_id']);
        }
        $task_properties = array_merge($task_properties, array(
            'quiz' => $quiz_id,
            'task_type' => $task_type,
        ));
        $task_id = ClipitTask::create($task_properties);
        if($task_id){
            $is_correct = true;
            $correct_msg = elgg_echo('task:created');
        } else {
            $error_msg = elgg_echo("task:cantcreate");
        }
        ClipitActivity::add_tasks($activity_id, array($task_id));
    }

    switch($task_type){
        case ClipitTask::TYPE_RESOURCE_DOWNLOAD:
                $files = get_input('attach_files');
                $videos = get_input('attach_videos');
                $storyboards = get_input('attach_storyboards');
            ClipitTask::set_files($task_id, array_filter($files));
            ClipitTask::set_videos($task_id, array_filter($videos));
            ClipitTask::set_storyboards($task_id, array_filter($storyboards));
            break;
        case ClipitTask::TYPE_VIDEO_UPLOAD:
        case ClipitTask::TYPE_STORYBOARD_UPLOAD:
            // check if feedback form is filled
            if($task['feedback']) {
                $feedback = $task['feedback-form'];
                if ($feedback['title'] && $feedback['type'] && $feedback['start'] && $feedback['end']) {
                    $feedback_task_id = ClipitTask::create(array(
                        'name' => $feedback['title'],
                        'description' => $feedback['description'],
                        'task_type' => $feedback['type'],
                        'start' => date_create_from_format('d/m/y H:i', $feedback['start'])->getTimestamp(),
                        'end' => date_create_from_format('d/m/y H:i', $feedback['end'])->getTimestamp(),
                        'parent_task' => $task_id,
                        'rubric' => ($feedback['rubric'])
                    ));
                    ClipitActivity::add_tasks($activity_id, array($feedback_task_id));
                }
            }
            break;
        case ClipitTask::TYPE_QUIZ_TAKE:
            if($entity_id) {
                $quiz = $task['quiz'];
                // Set questions to Quiz
                $questions = $quiz['question'];
                $images_tmp = array_pop($_FILES['task']['tmp_name']);
                $images_name = array_pop($_FILES['task']['name']);
                foreach ($questions as $input_id => $question) {
                    $values = array();
                    $validations = array();
                    $tags = array();
                    switch ($question['type']) {
                        case ClipitQuizQuestion::TYPE_SELECT_MULTI:
                            $num = 1;
                            foreach ($question['select_multi'] as $select) {
                                if (trim($select['value'])!='' && is_array($select)) {
                                    $values[] = $select['value'];
                                    if (in_array($num, $question['select_multi']['correct'])) {
                                        $validations[] = 1;
                                    } else {
                                        $validations[] = 0;
                                    }
                                    $num++;
                                }
                            }
                            break;
                        case ClipitQuizQuestion::TYPE_SELECT_ONE:
                            $num = 1;
                            foreach ($question['select_one'] as $select) {
                                if (trim($select['value'])!='' && is_array($select)) {
                                    $values[] = $select['value'];
                                    if ($question['select_one']['correct'] == $num) {
                                        $validations[] = 1;
                                    } else {
                                        $validations[] = 0;
                                    }
                                    $num++;
                                }
                            }
                            break;
                        case ClipitQuizQuestion::TYPE_TRUE_FALSE:
                            $a = array_fill(0, 2, 0);
                            switch ($question['true_false']) {
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
                    $image_tmp = $images_tmp['quiz']['question'][$input_id]['image'];
                    $image_name = $images_name['quiz']['question'][$input_id]['image'];
                    if ($image_name && $image_tmp) {
                        $image = ClipitFile::create(array(
                            'name' => $image_name,
                            'temp_path' => $image_tmp
                        ));
                    } elseif ($question['image']['url']) {
                        $image = $question['image']['url'];
                    } else {
                        $image = false;
                    }
                    $video = $question['video'];
                    if (filter_var($video, FILTER_VALIDATE_URL) === false) {
                        $video = false;
                    }
                    $question_data = array(
                        'name' => $question['title'],
                        'description' => $question['description'],
                        'order' => $question['order'],
                        'difficulty' => $question['difficulty'],
                        'option_type' => $question['type'],
                        'option_array' => $values,
                        'validation_array' => $validations,
                        'video' => $video,
                        'image' => $image,
                        'tag_array' => $tags
                    );
                    if ($question['id']) {
                        $questions_id[] = $question['id'];
                        ClipitQuizQuestion::set_properties($question['id'], $question_data);
                    } else {
                        // new QuizQuestion
                        $question_id = ClipitQuizQuestion::create($question_data);
                        $questions_id[] = $question_id;
                        if ($question['id_parent']) {
                            ClipitQuizQuestion::link_parent_clone($question['id_parent'], $question_id);
                        }
                    }
                }
                $time = $quiz['time'];
                $total_time = (int)($time['d'] * 86400) + ($time['h'] * 3600) + ($time['m'] * 60);
                ClipitQuiz::set_properties($quiz['id'], array(
                    'name' => $quiz['title'],
                    'description' => $quiz['description'],
                    'view_mode' => $quiz['view'],
                    'max_time' => $total_time,
                    'target' => $quiz['target'],
                ));
                ClipitQuiz::set_quiz_questions($quiz['id'], $questions_id);
            }
            break;
    }
}

if($is_correct){
    system_message($correct_msg);
} else {
    register_error($error_msg);
}

forward(REFERRER);