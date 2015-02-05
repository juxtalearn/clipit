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