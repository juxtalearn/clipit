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
if (isset($widget->activity_id) && is_not_null($widget->activity_id)) {
    $activity = get_entity($widget->activity_id);
}
if (isset($widget->task_id1) && is_not_null($widget->task_id1)) {
    $task1 = get_entity($widget->task_id1);
}
if (isset($widget->task_id2) && is_not_null($widget->task_id2)) {
    $task2 = get_entity($widget->task_id2);
}
if (isset($widget->target_id) && is_not_null($widget->target_id)) {
    $target = get_entity($widget->target_id);
}
if (isset($widget->scale) && is_not_null($widget->scale)) {
    $scale = $widget->scale;
}
error_log("Target: ".print_r($target,true)."\nScale: ".$scale);
if (elgg_instanceof($activity,'object', ClipitActivity::SUBTYPE) && elgg_instanceof($task1, 'object', ClipitQuiz::SUBTYPE) && elgg_instanceof($task2, 'object', ClipitQuiz::SUBTYPE) &&
    ((elgg_instanceof($target, 'object', ClipitGroup::SUBTYPE) && $scale == ClipitGroup::SUBTYPE)
        || (elgg_instanceof($target, 'user', ClipitUser::SUBTYPE) && $scale == ClipitUser::SUBTYPE)
        || $scale == ClipitActivity::SUBTYPE)) {
    $min_values = array();
    $max_values = array();
    $results = array();
    $quizzes = array(0 => $task1, 1 => $task2);
    if ($scale == ClipitActivity::SUBTYPE) {
        $group_entities = array();
        $groups = ClipitActivity::get_groups($activity->guid);
        foreach ($groups as $number=>$group_id) {
            $group = get_entity($group_id);
            $group_entities[intval($group_id)] = $group;
            $group_name = $group->name;
            $min_values[strval($group_name)] = PHP_INT_MAX;
            $max_values[strval($group_name)] = 0;

        }
        foreach ($quizzes as $number=>$quiz) {
            $data = array();
            foreach ($group_entities as $group) {
                $quiz_results = ClipitQuiz::get_group_results_by_tag($quiz->guid, $group->guid);
                if (is_not_null($quiz_results) && !empty($quiz_results)) {
                    $sum = 0;
                    $median = 0;
                    foreach ($quiz_results as $sb_id => $value) {
                        $sum = $sum + $value;
                    }
                    $median = $sum / count($quiz_results);
                    $median = rand(1, 100) / count($quiz_results);
                    $data[strval($group->name)] = floatval($median);
                    if ($median > $max_values[$group->name]) {
                        $max_values[strval($group->name)] = floatval($median);
                    }
                    if ($median < $min_values[$group->name]) {
                        $min_values[strval($group->name)] = floatval($median);
                    }
                }
            }
            $data = json_encode($data);
            $results[$number] = array("name" => $quiz->name, "data" => strval($data), "color" => $spider_colors[$number]);
        }
    } elseif ($scale == ClipitGroup::SUBTYPE) {
        $user_entities = array();
        $users = ClipitGroup::get_users($target->guid);
        foreach ($users as $number=>$user_id) {
            $user = get_entity($user_id);
            $user_entities[intval($user_id)] = $user;
            $user_name = $user->name;
            $min_values[strval($user_name)] = PHP_INT_MAX;
            $max_values[strval($user_name)] = 0;

        }
        foreach ($quizzes as $number=>$quiz) {
            $data = array();
            foreach ($user_entities as $user) {
                $user_name = $user->name;
                $quiz_results = ClipitQuiz::get_user_results_by_tag($quiz->guid, $user->guid);
                if (is_not_null($quiz_results) && !empty($quiz_results)) {
                    $sum = 0;
                    $median = 0;
                    foreach ($quiz_results as $sb_id => $value) {
                        $sum = $sum + $value;
                    }
                    $median = $sum / count($quiz_results);
                    $median = rand(1, 100) / count($quiz_results);
                    $data[strval($user_name)] = floatval($median);
                    if ($median > $max_values[$user->name]) {
                        $max_values[strval($user_name)] = floatval($median);
                    }
                    if ($median < $min_values[$user->name]) {
                        $min_values[strval($user_name)] = floatval($median);
                    }
                }
            }
            $data = json_encode($data);
            $results[$number] = array("name" => $quiz->name, "data" => strval($data), "color" => $spider_colors[$number]);
        }
    } elseif ($scale == ClipitUser::SUBTYPE) {
        $user = get_entity($target->guid);
        $sbresults = ClipitQuiz::get_quiz_results_by_tag($quiz_id);
        foreach ($sbresults as $sb_id=>$value) {
            $sb = get_entity($sb_id);
            $sb_name = $sb->name;
            $min_values[strval($sb_name)] = PHP_INT_MAX;
            $max_values[strval($sb_name)] = 0;

        }
        foreach ($quizzes as $number=>$quiz) {
            $data = array();
            $user_name = $user->name;
            $quiz_results = ClipitQuiz::get_user_results_by_tag($quiz->guid, $user->guid);
            foreach($quiz_results as $sb_id=>$value) {
                $sb = get_entity($sb_id);
                $sb_name = $sb->name;
                $value = rand(1,100);
                $data[strval($sb_name)] = floatval($value);
                if ($value > $max_values[$sb_name]) {
                    $max_values[strval($sb_name)] = floatval($value);
                }
                if ($value < $min_values[$sb_name]) {
                    $min_values[strval($sb_name)] = floatval($value);
                }
            }
            $data = json_encode($data);
            $results[$number] = array("name" => $quiz->name, "data" => strval($data), "color" => $spider_colors[$number]);
        }
    }
    if (is_not_null($results) && !empty($results)) {?>
        <div id="<?php echo $chart_identifier ?>" style="width: 320px; height: 320px; margin: 0px auto 0px auto;"></div>
        <div id="legendNode-<?php echo $chart_identifier?>"></div>
        <script>

            require(["dojox/charting/Chart2D", "dojox/charting/themes/MiamiNice", "dojox/charting/axis2d/Default",
                    "dojox/charting/plot2d/Default", "dojox/charting/plot2d/Spider",
                    "dojox/charting/axis2d/Base","dojox/charting/widget/SelectableLegend",
                    "dojox/charting/action2d/Tooltip","dojo/ready"],
                function(Chart, Theme, Default, Default, Spider, Base, SelectableLegend, Tooltip, ready) {
                    ready(function () {
                        var chart = new dojox.charting.Chart("<?php echo $chart_identifier?>");

                        chart.setTheme(Theme);
                        chart.addPlot("default", {
                            type: "Spider",
                            labelOffset: -10,
                            seriesFillAlpha: 0.2,
                            markerSize: 3,
                            precision: 0,
                            spiderType: "polygon"
                        });
                        <?php
                            echo("var minmax = [".json_encode($min_values).",\n");
                            echo("  ".json_encode($max_values)."];\n");
                        ?>
                        <?php
                        foreach ($results as $number=>$series) {
                            if ($number == 0) {
                                echo("var data = [".$series['data'].",\n");
                            }
                            elseif ($number == count($results)-1) {
                                echo("\t\t\t\t\t\t\t\t\t".$series['data']."];\n");
                            }
                            else {
                                echo("\t\t\t\t\t\t\t\t\t".$series['data'].",\n");
                            }
                        }
                        foreach ($results as $number=>$series) {
                            echo("\t\t\t\t\t\tchart.addSeries(\"".$series['name']."\", {data: data[$number]}, {fill: \"".$series['color']."\"});\n");
                        }
                        foreach ($min_values as $achsenbeschriftung=>$min_wert_der_achse) {
                            echo("\t\t\t\t\tchart.addAxis(\"".$achsenbeschriftung."\", {type: \"Base\", min: 0, max: 100 });\n");
                        }
                        ?>
                        chart.render();
                        new SelectableLegend({chart:chart}, 'legendNode-<?php echo $chart_identifier?>');
                        // new Tooltip({chart:chart}, 'default');
                    });
                }
            )
        </script>

    <?php }
    //No results found:
    else { ?>
        <div id="<?php echo $chart_identifier ?>">
            <?php echo elgg_echo("la_dashboard:no_results"); ?>
        </div>
    <?php }?>

<?php }
//No valid configuration:
else { ?>
    <div id="widget_not_configured">
        <?php echo elgg_echo("la_dashboard:please_config_widget"); ?>
    </div>


<?php }?>