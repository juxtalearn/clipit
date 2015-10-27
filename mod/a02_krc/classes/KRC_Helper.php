<?php


class KRC_Helper
{
    public static function getStumblingBlocksFromQuiz($quiz_id)
    {
        $stumbling_blocks = array();
        $questions = ClipitQuiz::get_quiz_questions($quiz_id);
        foreach ($questions as $question_id) {
            $sbs_for_question = ClipitQuizQuestion::get_tags($question_id);
            $stumbling_blocks = array_merge($stumbling_blocks, $sbs_for_question);
        }
        $result_array = array();
        foreach ($stumbling_blocks as $sb_id) {
            $sb = get_entity($sb_id);
            $result_array[$sb_id] = $sb->name;
        }
        return $result_array;
    }
}