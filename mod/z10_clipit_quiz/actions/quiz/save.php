<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   02/02/2015
 * Last update:     02/02/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */

$quiz = get_input('quiz');
// Set questions to Quiz
$questions = $quiz['question'];
$questions_id = array();

$images_tmp = array_pop($_FILES['quiz']['tmp_name']);
$images_name = array_pop($_FILES['quiz']['name']);

foreach($questions as $input_id => $question){
    $values = array();
    $validations = array();
    $tags = array();
    switch($question['type']){
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
    $image_tmp = $images_tmp[$input_id]['image'];
    $image_name = $images_name[$input_id]['image'];
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
    $tags = array_filter($question['tags']);
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
    } elseif($question['id_parent']){
        $question_id = ClipitQuizQuestion::create_clone($question['id_parent'], false);
        ClipitQuizQuestion::set_properties($question_id, array_merge(
            $question_data,
            array('time_created' => time())
        ));
        $questions_id[] = $question_id;
    } else {
        // new QuizQuestion
        $questions_id[] = ClipitQuizQuestion::create($question_data);
    }

}
$time = $quiz['time'];
$total_time = (int)($time['d']*86400) + ($time['h']*3600) + ($time['m']*60);

$quiz_data = array(
    'name' => $quiz['title'],
    'description' => $quiz['description'],
    'tricky_topic' => $quiz['tricky_topic'],
    'view_mode' => $quiz['view'],
    'max_time' => $total_time,
    'target' => $quiz['target']
);
if($quiz_id = $quiz['id']){
//    Edit Quiz properties
    ClipitQuiz::set_properties($quiz_id, $quiz_data);
    $href = 'quizzes/view/'.$quiz_id;
} else {
//    Create Quiz
    $quiz_id = ClipitQuiz::create($quiz_data);
    $href = 'quizzes';
}

ClipitQuiz::set_quiz_questions($quiz_id, $questions_id);

system_message(elgg_echo('quiz:created'));
forward($href);