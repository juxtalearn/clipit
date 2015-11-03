<?php
/**
 * Created by PhpStorm.
 * User: malzahn
 * Date: 03.11.2015
 * Time: 21:19
 */
$results = ClipitQuizResult::get_all();
foreach ($results as $result) {
   $userid =  $result->owner_id;
    $profile = new UserProfile($userid);
    $profile->update_from_quizresult($result);
    error_log("processing ... $result->id");
}