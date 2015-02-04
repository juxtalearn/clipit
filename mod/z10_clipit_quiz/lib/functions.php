<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   04/02/2015
 * Last update:     04/02/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
function quiz_filter_search($query){
    $quiz_ids = array();
    $query_ar = json_decode($query);
    foreach($query_ar as $s => $value){
        switch($s){
            case 'name':
                $quiz_search = array();
                $quizzes = ClipitQuiz::get_from_search($value);
                foreach ($quizzes as $quiz) {
                    $quiz_ids[] = $quiz->id;
                }
                break;
            case 'tricky_topic':
                $quiz_search = array();
                $tricky_topics = ClipitTrickyTopic::get_from_search($value);
                foreach ($tricky_topics as $tricky_topic) {
                    foreach(ClipitQuiz::get_from_tricky_topic($tricky_topic->id) as $quiz){
                        $quiz_search[] = $quiz->id;
                    }
                }
                if(empty($quiz_ids)) {
                    $quiz_ids = array_merge($quiz_ids, $quiz_search);
                } else {
                    $quiz_ids = array_intersect($quiz_ids, $quiz_search);
                }
                break;
        }
        if(empty($quiz_ids)){
            return ClipitQuiz::get_all(clipit_get_limit(10), clipit_get_offset());
        }
    }
    return $quiz_ids;
    return ClipitQuiz::get_by_id($quiz_ids);
}