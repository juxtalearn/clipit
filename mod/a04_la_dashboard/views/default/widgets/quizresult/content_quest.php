<?php
extract($vars);
//$activity = $vars['activity'];
//$quiz = $vars['quiz'];
//$scale = $vars['scale'];
//$group = $vars['group'];
//$spider_colors = $vars['spider_colors'];
//$taskname = $vars['taskname'];
//$widget_id= $vars['widget_id'];

echo '<span class="activity_quiz_headline">'.$activity->name .' - '.$taskname.'</span>';
$quiz_id = $quiz->id;
$results = array();
//Als erstes rausfinden welche SBs beteiligt sind sb_id => sb_name
$sbresults = array();
$question_ids = ClipitQuiz::get_quiz_questions($quiz->id);
$questions = ClipitQuizQuestion::get_by_id($question_ids);
foreach($questions as $question) {
    $sbresults[] = $question->name;
}
if ($scale == ClipitActivity::SUBTYPE) {
    $groups = $activity->group_array;
    $index = 0;
    foreach ($groups as $number => $group_id) {
        $quiz_results = ClipitQuiz::get_group_results_by_question($quiz_id, $group_id);
        $group = get_entity($group_id);
        $data = array();
        if (is_not_null($quiz_results) && !empty($quiz_results)) {

            foreach ($quiz_results as $sb_id => $value) {
                $sb = get_entity($sb_id);
                $sb_name = $sb->name;
                $data[strval($sb_name)] = intval($value)*100;
            }
        } else {
            foreach ($sbresults as $blockname) {
                $data[$blockname] = 0;
            }
        }
        $data = json_encode($data);
        $results[$index] = array("name" => $group->name, "data" => strval($data), "color" => $spider_colors[$index]);
        $index++;
    }
} elseif ($scale == ClipitGroup::SUBTYPE) {
    $number = 0;
    if ($group_id != 'all') {
        $group = ClipitGroup::get_by_id(array($group_id));
    } else {
        $group_ids = ClipitActivity::get_groups($activity->id);
        $group = ClipitGroup::get_by_id($group_ids);
    }

    foreach ($group as $current_group) {
        $users = ClipitGroup::get_users($current_group->id);
        foreach ($users as $user_id) {
            $quiz_results = ClipitQuiz::get_user_results_by_question($quiz_id, $user_id);
            $user = get_entity($user_id);
            $data = array_fill_keys($sbresults,0);
            if (is_not_null($quiz_results) && !empty($quiz_results)) {
                foreach ($quiz_results as $sb_id => $value) {
                    $sb = get_entity($sb_id);
                    $sb_name = $sb->name;
                    $data[strval($sb_name)] = floatval($value)*100;
                }
            } else {
                foreach ($sbresults as $blockname) {
                    $data[$blockname] = 0;
                }
            }
//                $data = json_encode($data);
            $results[$number] = array("name" => $user->name, "data" => strval(json_encode($data)), "color" => $spider_colors[$number]);
            $number += 1;
        }
    }
}
if (is_not_null($results) && !empty($results)) {
    echo elgg_view('dojovis/quizspider', array(
        'widget_id' => $widget_id,
        'axis' => $sbresults,
        'results' => $results,
    ));
 } else {

    $message = elgg_echo("la_dashboard:no_results"); //No results found:
    echo <<< HTML
    <div id="widget_not_configured">
           $message
        </div>
HTML;
} ?>