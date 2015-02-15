<?php
$activity = $vars['activity'];
$quiz = $vars['quiz'];
$scale = $vars['scale'];
$group = $vars['group'];
$spider_colors = $vars['spider_colors'];


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

    foreach ($groups as $number => $group_id) {
        $quiz_results = ClipitQuiz::get_group_results_by_question($quiz_id, $group_id);
        $group = get_entity($group_id);
        $data = array();
        foreach ($sbresults as $blockname) {
            $data[$blockname] = 0;
        }
        if (is_not_null($quiz_results) && !empty($quiz_results)) {

            foreach ($quiz_results as $sb_id => $value) {
                $sb = get_entity($sb_id);
                $sb_name = $sb->name;
                $value = rand(1, 100);
                $data[strval($sb_name)] = floatval($value);
            }
        }
        $data = json_encode($data);
        $results[$number] = array("name" => $group->name, "data" => strval($data), "color" => $spider_colors[$number]);
    }
} elseif
($scale == ClipitGroup::SUBTYPE
) {
    $number = 0;
    foreach ($group as $current_group) {
        $users = ClipitGroup::get_users($current_group->id);
        foreach ($users as $user_id) {
            $quiz_results = ClipitQuiz::get_user_results_by_question($quiz_id, $user_id);
            $user = get_entity($user_id);
            $data = array();
            foreach (array_keys($min_values) as $blockname) {
                $data[$blockname] = 0;
            }
            if (is_not_null($quiz_results) && !empty($quiz_results)) {
                foreach ($quiz_results as $sb_id => $value) {
                    $sb = get_entity($sb_id);
                    $sb_name = $sb->name;
                    $value = rand(0, 100);
                    $data[strval($sb_name)] = floatval($value);
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
        'axis' => $question_names,
        'results' => $results,
    ))

    ?>
<?php } else {
    $message = elgg_echo("la_dashboard:no_results"); //No results found:
    echo <<<HTML
        <div id="<?php echo $chart_identifier ?>">
           $message
        </div>
HTML;
} ?>