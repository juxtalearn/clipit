<?php
extract($_GET);
$activity = array_pop(ClipitActivity::get_by_id(array($activity_id)));
$quiz1 = array_pop(ClipitQuiz::get_by_id(array($quiz1_id)));
$quiz2 = array_pop(ClipitQuiz::get_by_id(array($quiz2_id)));
$target = get_entity($target_id);

//$group = ClipitGroup::get_by_id(array($group_id));
$quiz = array_pop(ClipitQuiz::get_by_id(array($quiz_id)));
$spider_colors = array("FF0000", "00FF00", "0000FF", "FFFF00", "FF00FF", "00FFFF", "000000",
    "800000", "008000", "000080", "808000", "800080", "008080", "808080",
    "C00000", "00C000", "0000C0", "C0C000", "C000C0", "00C0C0", "C0C0C0",
    "400000", "004000", "000040", "404000", "400040", "004040", "404040",
    "200000", "002000", "000020", "202000", "200020", "002020", "202020",
    "600000", "006000", "000060", "606000", "600060", "006060", "606060",
    "A00000", "00A000", "0000A0", "A0A000", "A000A0", "00A0A0", "A0A0A0",
    "E00000", "00E000", "0000E0", "E0E000", "E000E0", "00E0E0", "E0E0E0");
?>
<head>
    <link rel="stylesheet" type="text/css"
          href="http://ajax.googleapis.com/ajax/libs/dojo/1.10.4/dojo/resources/dojo.css"/>
    <link rel="stylesheet" type="text/css"
          href="http://ajax.googleapis.com/ajax/libs/dojo/1.10.4/dijit/themes/dijit.css"/>
    <link rel="stylesheet" type="text/css"
          href="http://ajax.googleapis.com/ajax/libs/dojo/1.10.4/dijit/themes/claro/claro.css"/>
    <script src="http://ajax.googleapis.com/ajax/libs/dojo/1.10.4/dojo/dojo.js"></script>
</head>
<body class="Claro">
<?php
if (($scale == ClipitGroup::SUBTYPE &&  elgg_instanceof($target, 'object', ClipitGroup::SUBTYPE))
    || (elgg_instanceof($target, 'user', ClipitUser::SUBTYPE) && $scale == ClipitUser::SUBTYPE)
    || $scale == ClipitActivity::SUBTYPE
) {
    $min_values = array();
    $max_values = array();
    $results = array();
    $quizzes = array(0 => $quiz1, 1 => $quiz2);
    $sbresults1 = LADashboardHelper::getStumblingBlocksFromQuiz($quiz1_id);
    $sbresults2 = LADashboardHelper::getStumblingBlocksFromQuiz($quiz2_id);
    $sbresults = array_merge($sbresults1, $sbresults2);

    $task_names = array();
    $task_id1 = ClipitQuiz::get_task($quiz1_id);
    $task1 = array_pop(ClipitTask::get_by_id(array($task_id1)));
    $task_names[$quiz1->id] = $task1->name;
    $task_id2 = ClipitQuiz::get_task($quiz2_id);
    $task2 = array_pop(ClipitTask::get_by_id(array($task_id2)));
    $task_names[$quiz2->id] = $task2->name;


    echo '<span class="activity_quiz_headline">' . $activity->name . ' - ' . $task1->name . ' / ' . $task2->name . ' </span>';
    echo "<span class=\"activity_quiz_headline\"></span>";

    foreach ($sbresults as $key => $sb_name) {
        $min_values[strval($sb_name)] = PHP_INT_MAX;
        $max_values[strval($sb_name)] = 0;
    }

    switch ($scale) {
        case ClipitActivity::SUBTYPE:
            $group_entities = array();
            $groups = ClipitActivity::get_groups($activity_id);
            $amount = count($groups);
            foreach ($groups as $number => $group_id) {
                $group = get_entity($group_id);
                $group_entities[intval($group_id)] = $group;
                $group_name = $group->name;

            }
            foreach ($quizzes as $number => $quiz) {
                $data = array_fill_keys(array_keys($min_values),0);
                foreach ($group_entities as $group) {
                    $quiz_results = ClipitQuiz::get_group_results_by_tag($quiz->id, $group->guid);
                    if (is_not_null($quiz_results) && !empty($quiz_results)) {
                        foreach ($quiz_results as $sb_id => $value) {
                            $sb = get_entity($sb_id);
                            $sb_name = $sb->name;
                            $data[$sb_name] = $data[$sb_name] + (floatval($value) / $amount * 100);
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
            break;
        case ClipitGroup::SUBTYPE:
            //$user_entities = array();
            $users = ClipitGroup::get_users($target->guid);
            $amount = count($users);
            foreach ($quizzes as $number => $quiz) {
                $data = array_fill_keys(array_keys($min_values),0);
                foreach ($users as $user_id) {
                    $quiz_results = ClipitQuiz::get_user_results_by_tag($quiz->id, $user_id);
                    if (is_not_null($quiz_results) && !empty($quiz_results)) {
                        foreach ($quiz_results as $sb_id => $value) {
                            $sb = get_entity($sb_id);
                            $sb_name = $sb->name;
                            $data[$sb_name] = $data[$sb_name] + (floatval($value) / $amount * 100);
                        }
                        if ($data[$sb_name] > $max_values[$sb_name]) {
                            $max_values[strval($sb_name)] = floatval($data[$sb_name]);
                        }
                        if ($data[$sb_name] < $min_values[$sb_name]) {
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
            break;
        case ClipitUser::SUBTYPE:
            $user = get_entity($target->guid);
            foreach ($quizzes as $number => $quiz) {
                $data = array();
                foreach (array_keys($min_values) as $blockname) {
                    $data[$blockname] = 0;
                }
                $user_name = $user->name;
                $quiz_results = ClipitQuiz::get_user_results_by_tag($quiz->id, $target_id);
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
            break;
    };
    if (is_not_null($results) && !empty($results)) {
        echo elgg_view('dojovis/quizspider', array(
            'widget_id' => $widget_id,
            'min_values' => $min_values,
            'max_values' => $max_values,
            'results' => $results,
        ));
    }
    else { //No results found:?>
        <div id="<?php echo $chart_identifier ?>">
            <?php echo elgg_echo("la_dashboard:no_results"); ?>
        </div>
    <?php }
} ?>
</body>

