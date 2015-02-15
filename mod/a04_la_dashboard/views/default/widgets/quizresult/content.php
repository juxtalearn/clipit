<?php
elgg_load_js("dojotoolkit");

$spider_colors = array("FF0000", "00FF00", "0000FF", "FFFF00", "FF00FF", "00FFFF", "000000",
    "800000", "008000", "000080", "808000", "800080", "008080", "808080",
    "C00000", "00C000", "0000C0", "C0C000", "C000C0", "00C0C0", "C0C0C0",
    "400000", "004000", "000040", "404000", "400040", "004040", "404040",
    "200000", "002000", "000020", "202000", "200020", "002020", "202020",
    "600000", "006000", "000060", "606000", "600060", "006060", "606060",
    "A00000", "00A000", "0000A0", "A0A000", "A000A0", "00A0A0", "A0A0A0",
    "E00000", "00E000", "0000E0", "E0E000", "E000E0", "00E0E0", "E0E0E0");
$widget = $vars['entity'];
$widget_id = $widget->guid;
$chart_identifier = "quiz-widget-$widget_id";
//First we need to verify the settings for this widget
$to_be_configured = false;
if (isset($widget->activity_id) && is_not_null($widget->activity_id)) {
    $activity = ClipitActivity::get_by_id(array($widget->activity_id))[0];
} else {
    $to_be_configured = true;
}
if (isset($widget->task_id) && is_not_null($widget->task_id)) {
    $task = ClipitQuiz::get_by_id(array($widget->task_id))[0];
    error_log("Task:".print_r($task,true));
} else {
    $to_be_configured = true;
}
if (isset($widget->scale) && is_not_null($widget->scale)) {
    error_log("Scale:".print_r($scale,true));
    $scale = $widget->scale;
} else {
    $to_be_configured = true;
}

if (isset($widget->group_id) && is_not_null($widget->group_id)) {
    $group = ClipitGroup::get_by_id(array($widget->group_id))[0];
    error_log("Group".print_r($group,true));
} else {
    if  ($to_be_configured === false && $scale != ClipitActivity::SUBTYPE) {
        $to_be_configured = true;
    }
}

if ($to_be_configured) {
    $message = elgg_echo("la_dashboard:please_config_widget");
echo <<< HTML
    <div id="widget_not_configured">
           $message
        </div>
HTML;
} else {
    $quiz_id = $task->guid;
    $min_values = array();
    $max_values = array();
    $results = array();
    //Als erstes rausfinden welche SBs beteiligt sind
    $sbresults = ClipitQuiz::get_quiz_results_by_tag($quiz_id);
    foreach ($sbresults as $sb_id => $value) {
        $sb = get_entity($sb_id);
        $sb_name = $sb->name;
        $min_values[strval($sb_name)] = PHP_INT_MAX;
        $max_values[strval($sb_name)] = 0;

    }
    if ($scale == ClipitActivity::SUBTYPE) {
        $groups = ClipitActivity::get_groups($activity->guid);
        foreach ($groups as $number => $group_id) {
            $quiz_results = ClipitQuiz::get_group_results_by_tag($quiz_id, $group_id);
            $group = get_entity($group_id);
            if (is_not_null($quiz_results) && !empty($quiz_results)) {
                $data = array();
                foreach ($quiz_results as $sb_id => $value) {
                    $sb = get_entity($sb_id);
                    $sb_name = $sb->name;
                    $value = rand(1, 100);
                    $data[strval($sb_name)] = floatval($value);
                    if ($value > $max_values[$sb_name]) {
                        $max_values[strval($sb_name)] = floatval($value);
                    }
                    if ($value < $min_values[$sb_name]) {
                        $min_values[strval($sb_name)] = floatval($value);
                    }
                }
            }
            $data = json_encode($data);
            $results[$number] = array("name" => $group->name, "data" => strval($data), "color" => $spider_colors[$number]);
        }
    } elseif ($scale == ClipitGroup::SUBTYPE) {
        $users = ClipitGroup::get_users($group->id);
        error_log($widget->group->id. "*" . $group->id ."*".print_r($users,true));
        foreach ($users as $number => $user_id) {
            $quiz_results = ClipitQuiz::get_user_results_by_tag($quiz_id, $user_id);
            $user = get_entity($user_id);
            if (is_not_null($quiz_results) && !empty($quiz_results)) {
                $data = array();
                foreach ($quiz_results as $sb_id => $value) {
                    $sb = get_entity($sb_id);
                    $sb_name = $sb->name;
                    $value = rand(1, 100);
                    $data[strval($sb_name)] = floatval($value);
                    if ($value > $max_values[$sb_name]) {
                        $max_values[strval($sb_name)] = floatval($value);
                    }
                    if ($value < $min_values[$sb_name]) {
                        $min_values[strval($sb_name)] = floatval($value);
                    }
                }
            }
            $data = json_encode($data);
            $results[$number] = array("name" => $user->name, "data" => strval($data), "color" => $spider_colors[$number]);
        }
    }
    if (is_not_null($results) && !empty($results)) {
        echo elgg_view('dojovis/quizspider', array(
            'widget_id' => $widget_id,
            'min_values' => $min_values,
            'max_values' => $max_values,
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
    }
} ?>