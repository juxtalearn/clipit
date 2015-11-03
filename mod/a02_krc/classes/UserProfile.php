<?php


class UserProfile
{
    const CONTEXT = "http://www.juxtalearn.org";
    const QUIZ_RATING = "quiz_rating";
    const VIDEO_RATING = "video_rating";
    const STORYBOARD_RATING = "storyboard_rating";
    const FILE_RATING = "file_rating";

    /**
     * @var ElggUser|false
     */
    protected $user;

    function __construct($userId)
    {
        $this->user = get_user($userId);
    }

    function add_quizresults($quiz_id)
    {
        $quiz = array_pop(ClipitQuiz::get_by_id($quiz_id));
        if ($quiz) {
            $this->update_from_quiz($quiz);
        }
    }

    function add_videoresults($video_id)
    {
    }

    //TODO
    function get_level_for_tag($tagid)
    {
        return $this->retrieve_rating($tagid);
    }


    public function update_from_quiz(ClipitQuiz $quiz) {
        $results = ClipitQuiz::get_user_results_by_tag($quiz->id);
        if ( !empty ($results) ) {
            foreach( $results as $tag_id => $value) {
                $this->update_type_rating($tag_id, QUIZ_RATING, $value);
            }
        }
    }


    public function update_from_quizresult(ClipitQuizResult $quizresult) {
        $results = ClipitQuizQuestion::get_tags($quizresult->quiz_question);
        if ( !empty ($results) ) {
            foreach( $results as $tag_id) {
                if ( $quizresult->correct === true) {
                    $this->update_type_rating($tag_id, QUIZ_RATING, 1.0);
                } else {
                    $this->update_type_rating($tag_id, QUIZ_RATING, 0.0);
                }
            }
        }
    }


    protected function retrieve_rating($stumbling_block_id, $type = "all")
    {
        $rating = 0;

        if  ($type == "all") {
            $amount = 0;
            $tmpType = QUIZ_RATING;
            $tmprating = $this->user->getMetaData("$stumbling_block_id$tmpType");
            if ( $tmprating ) {
                $rating += $tmprating;
                $amount++;
            }
            $tmpType = VIDEO_RATING;
            $tmprating = $this->user->getMetaData("$stumbling_block_id$tmpType");
            if ( $tmprating ) {
                $rating += $tmprating;
                $amount++;
            }
            $tmpType = STORYBOARD_RATING;
            $tmprating = $this->user->getMetaData("$stumbling_block_id$tmpType");
            if ( $tmprating ) {
                $rating += $tmprating;
                $amount++;
            }
            $rating+=$tmpType = FILE_RATING;
            $tmprating = $this->user->getMetaData("$stumbling_block_id$tmpType");
            if ( $tmprating ) {
                $rating += $tmprating;
                $amount++;
            }
            if  ($amount !==0) {
                $rating = round($rating/$amount,5);
            } else {
                $rating = 0.0;
            }

        } else {
            $rating = $this->user->getMetaData("$stumbling_block_id$type");
        }
        return $rating;
    }

    protected function update_type_rating($stumbling_block_id, $type, $new_value)
    {
        $current_rating = $this->retrieve_rating($stumbling_block_id, $type);
        switch ($type) {
            case QUIZ_RATING:
                //(Value found in user profile * 0.5 + new result) / 1.5

                if (!($current_rating === false)) {
                    $new_rating = ($current_rating * 0.5 + $new_value) / 1.5;
                } else {
                    $new_rating = $new_value;
                }
                break;
            case VIDEO_RATING:
            case STORYBOARD_RATING:
            case FILE_RATING:
                if (!($current_rating === false)) {
                    $new_rating = $current_rating + $new_value;
                } else {
                    $new_rating = $new_value;
                }
                break;
        }
        $this->user->setMetaData("$stumbling_block_id$type", $new_rating);
        return $new_rating;
    }

    private function update_quiz_rating($stumbling_block_id, $type, $new_value)
    {
        return $this->update_type_rating($stumbling_block_id, QUIZ_RATING, $new_value);
    }
} 