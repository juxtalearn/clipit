<?php
/**
 * Created by PhpStorm.
 * User: Oliver
 * Date: 15.10.2014
 * Time: 15:19
 */

class UserProfile {
    protected $user;

    function __construct($userId) {
        $this->$user = get_user($userId);
    }

    function add_quizresults($quiz_id) {
        //KnowledgeRepresentationComponent::get_quiz_rating($user_id, $stumbling_block_id);
    }
    function add_videoresults($video_id) {

    }

} 