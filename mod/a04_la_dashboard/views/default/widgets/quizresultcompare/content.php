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
    $activity = array_pop(ClipitActivity::get_by_id(array($widget->activity_id)));
} else {
    $to_be_configured = true;
}
if (isset($widget->task_id1) && is_not_null($widget->task_id1)) {
    try {
        $quiz1 = array_pop(ClipitQuiz::get_by_id(array($widget->task_id1)));
    } catch (Exception $e) {
        $widget->quiz_id=null;
        $to_be_configured=true;
    }

} else {
    $to_be_configured = true;
}
if (isset($widget->task_id2) && is_not_null($widget->task_id2)) {
    try {
        $quiz2 = array_pop(ClipitQuiz::get_by_id(array($widget->task_id2)));
    } catch (Exception $e) {
        $widget->quiz_id=null;
        $to_be_configured=true;
    }

} else {
    $to_be_configured = true;
}
if (isset($widget->scale) && is_not_null($widget->scale)) {
    $scale = $widget->scale;
} else {
    $to_be_configured = true;
}

if (isset($widget->target_id) && is_not_null($widget->target_id)) {
    $target = get_entity($widget->target_id);
} else {
    if  (( $to_be_configured === false ) && $scale!=ClipitActivity::SUBTYPE) {
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

    if ((elgg_instanceof($target, 'object', ClipitGroup::SUBTYPE) && $scale == ClipitGroup::SUBTYPE)
        || (elgg_instanceof($target, 'user', ClipitUser::SUBTYPE) && $scale == ClipitUser::SUBTYPE)
        || $scale == ClipitActivity::SUBTYPE
    ) {
        $min_values = array();
        $max_values = array();
        $results = array();
        $quizzes = array(0 => $quiz1, 1 => $quiz2);
        $quiz_id1=$quiz1->id;
        $quiz_id2=$quiz2->id;
        $sbresults1 = LADashboardHelper::getStumblingBlocksFromQuiz($quiz_id1);
        $sbresults2 = LADashboardHelper::getStumblingBlocksFromQuiz($quiz_id2);
        $sbresults = array_merge($sbresults1, $sbresults2);

        $task_names = array();
        $task_id1 = ClipitQuiz::get_task($quiz_id1);
        $task1_array = ClipitTask::get_by_id(array($task_id1));
        $task1 = array_pop($task1_array);
        $task_names[$quiz1->id] = $task1->name;
        $task_id2 = ClipitQuiz::get_task($quiz_id2);
        $task2_array = ClipitTask::get_by_id(array($task_id2));
        $task2 = array_pop($task2_array);
        $task_names[$quiz2->id] = $task2->name;


        echo '<span class="activity_quiz_headline">'.$activity->name .' - '.$task1->name.' / '.$task2->name. ' </span>';

        foreach ($sbresults as $key => $sb_name) {
            $min_values[strval($sb_name)] = PHP_INT_MAX;
            $max_values[strval($sb_name)] = 0;
        }
        if ($scale == ClipitActivity::SUBTYPE) {
            $group_entities = array();
            $groups = ClipitActivity::get_groups($activity->guid);
            $anzahl = count($groups);
            foreach ($groups as $number => $group_id) {
                $group = get_entity($group_id);
                $group_entities[intval($group_id)] = $group;
                $group_name = $group->name;

            }
            foreach ($quizzes as $number => $quiz) {
                $data = array();
                foreach(array_keys($min_values) as $blockname) {
                    $data[$blockname]=0;
                }
                foreach ($group_entities as $group) {
                    $quiz_results = ClipitQuiz::get_group_results_by_tag($quiz->guid, $group->guid);
                    if (is_not_null($quiz_results) && !empty($quiz_results)) {
                        foreach ($quiz_results as $sb_id => $value) {
                            $sb = get_entity($sb_id);
                            $sb_name = $sb->name;
                            $data[$sb_name] = $data[$sb_name] + (floatval($value) / $anzahl *100);
                        }
                        if ($data[$sb_name] > $max_values[$group->name]) {
                            $max_values[strval($sb_name)] = floatval($data[$sb_name]);
                        }
                        if ($data[$sb_name] < $min_values[$group->name]) {
                            $min_values[strval($sb_name)] = floatval($data[$sb_name]);
                        }
                    }
                }
                if (!empty($data)) {
                    $quiz_id = $quiz->id;
                    $task_name = $task_names[$quiz_id];
                    $results[$number] = array("name" => $task_name, "data" => strval(json_encode($data)), "color" => $spider_colors[$number]);
                }
            }
        } elseif ($scale == ClipitGroup::SUBTYPE) {
            $user_entities = array();
            $users = ClipitGroup::get_users($target->guid);
            $anzahl = count($users);
            foreach ($quizzes as $number => $quiz) {
                $data = array();
                foreach(array_keys($min_values) as $blockname) {
                    $data[$blockname]=0;
                }
                foreach ($user_entities as $user) {
                    $quiz_results = ClipitQuiz::get_user_results_by_tag($quiz->guid, $group->guid);
                    if (is_not_null($quiz_results) && !empty($quiz_results)) {
                        foreach ($quiz_results as $sb_id => $value) {
                            $sb = get_entity($sb_id);
                            $sb_name = $sb->name;
                            $data[$sb_name] = $data[$sb_name] + (floatval($value) / $anzahl *100);
                        }
                        if ($data[$sb_name] > $max_values[$group->name]) {
                            $max_values[strval($sb_name)] = floatval($data[$sb_name]);
                        }
                        if ($data[$sb_name] < $min_values[$group->name]) {
                            $min_values[strval($sb_name)] = floatval($data[$sb_name]);
                        }
                    }

                }
                if (!empty($data)) {
                    $quiz_id = $quiz->id;
                    $task_name = $task_names[$quiz_id];
                    $results[$number] = array("name" => $task_name, "data" => strval(json_encode($data)), "color" => $spider_colors[$number]);
                }
            }
        } elseif ($scale == ClipitUser::SUBTYPE) {
            $user = get_entity($target->guid);
            foreach ($quizzes as $number => $quiz) {
                $data = array();
                foreach(array_keys($min_values) as $blockname) {
                    $data[$blockname]=0;
                }
                $user_name = $user->name;
                $quiz_results = ClipitQuiz::get_user_results_by_tag($quiz->guid, $user->guid);
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
                if (!empty($data)) {
                    $quiz_id = $quiz->id;
                    $task_name = $task_names[$quiz_id];
                    $results[$number] = array("name" => $task_name, "data" => strval(json_encode($data)), "color" => $spider_colors[$number]);
                }
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


        <?php } //No results found:
        else { ?>
            <div id="<?php echo $chart_identifier ?>">
                <?php echo elgg_echo("la_dashboard:no_results"); ?>
            </div>
        <?php }
    }
} ?>