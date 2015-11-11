<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   04/02/2015
 * Last update:     04/02/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
function quiz_filter_search($query){
    $item_ids = array();
    $query_ar = json_decode($query);
    foreach($query_ar as $s => $value){
        switch($s){
            case 'name':
                $item_search = array();
                $quizzes = ClipitQuiz::get_from_search($value);
                foreach ($quizzes as $quiz) {
                    $item_ids[] = $quiz->id;
                }
                break;
            case 'tricky_topic':
                $item_search = array();
                $tricky_topics = ClipitTrickyTopic::get_from_search($value);
                foreach ($tricky_topics as $tricky_topic) {
                    foreach(ClipitQuiz::get_from_tricky_topic($tricky_topic->id) as $quiz){
                        $item_search[] = $quiz->id;
                    }
                }
                if(empty($item_ids)) {
                    $item_ids = array_merge($item_ids, $item_search);
                } else {
                    $item_ids = array_intersect($item_ids, $item_search);
                }
                break;
        }
    }
    return $item_ids;
}

/**
 * @param $quiz
 * @param $questions
 * @param $images_tmp
 * @param $images_name
 * @throws InvalidParameterException
 */
function quiz_save($quiz, $questions, $images_tmp, $images_name){
    $questions_id = array();
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
    $quiz_data = array(
        'name' => $quiz['title'],
        'description' => $quiz['description'],
        'tricky_topic' => $quiz['tricky_topic'],
        'view_mode' => $quiz['view'],
        'max_time' => $total_time,
        'target' => $quiz['target'],
    );
    if($quiz_id = $quiz['id']){
    //    Edit Quiz properties
        ClipitQuiz::set_properties($quiz_id, $quiz_data);
    } else {
    //    Create Quiz
        $quiz_id = ClipitQuiz::create($quiz_data);
    }
    ClipitQuiz::set_quiz_questions($quiz_id, $questions_id);
}