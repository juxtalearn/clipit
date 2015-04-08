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
    'start' => get_timestamp_from_string($task_array['start'])+(60*1),
    'end' => get_timestamp_from_string($task_array['end'])+(60*60*24)-(60*1),
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
    $quiz = $task_array['quiz'];
    // Set questions to Quiz
    $questions = $quiz['question'];
    $images_tmp = array_pop($_FILES['task']['tmp_name']);
    $images_name = array_pop($_FILES['task']['name']);
    foreach($questions as $input_id => $question){
        $values = array();
        $validations = array();
        $tags = array();
        switch($question['type']){
            case ClipitQuizQuestion::TYPE_SELECT_MULTI:
                foreach($question['select_multi'] as $select){
                    if($select['value']) {
                        $values[] = $select['value'];
                        if (isset($select['correct'])) {
                            $validations[] = 1;
                        } else {
                            $validations[] = 0;
                        }
                    }
                }
                break;
            case ClipitQuizQuestion::TYPE_SELECT_ONE:
                foreach($question['select_one'] as $select){
                    if($select['value']){
                        $values[] = $select['value'];
                        if(isset($select['correct'])){
                            $validations[] = 1;
                        } else {
                            $validations[] = 0;
                        }
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
        $image_tmp = $images_tmp['quiz']['question'][$input_id]['image'];
        $image_name = $images_name['quiz']['question'][$input_id]['image'];
        if($image_name && $image_tmp) {
            $image = ClipitFile::create(array(
                'name' => $image_name,
                'temp_path' => $image_tmp
            ));
        } elseif($question['image']['url']){
            $image = $question['image']['url'];
        } else {
            $image = false;
        }
        $video = $question['video'];
        if (filter_var($video, FILTER_VALIDATE_URL) === false){
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
        if($question['id']) {
            $questions_id[] = $question['id'];
            ClipitQuizQuestion::set_properties($question['id'], $question_data);
        } else {
            // new QuizQuestion
            $question_id = ClipitQuizQuestion::create($question_data);
            $questions_id[] = $question_id;
            if($question['id_parent']){
                ClipitQuizQuestion::link_parent_clone($question['id_parent'], $question_id);
            }
        }
    }
    $time = $quiz['time'];
    $total_time = (int)($time['d']*86400) + ($time['h']*3600) + ($time['m']*60);
    ClipitQuiz::set_properties($quiz['id'], array(
        'name' => $quiz['title'],
        'description' => $quiz['description'],
        'view_mode' => $quiz['view'],
        'max_time' => $total_time,
        'target' => $quiz['target'],
    ));
    ClipitQuiz::set_quiz_questions($quiz['id'], $questions_id);
}
if($task['feedback'] && $task['feedback-form']){
    $task_array = $task['feedback-form'];
    $new_task_id = ClipitTask::create(array(
        'name' => $task_array['title'],
        'description' => $task_array['description'],
        'task_type' => $task_array['type'],
        'start' => get_timestamp_from_string($task_array['start'])+(60*1),
        'end' => get_timestamp_from_string($task_array['end'])+(60*60*24)-(60*1),

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