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
if (isset($widget->task_id) && is_not_null($widget->task_id)) {
    $task = get_entity($widget->task_id);
}
if (isset($widget->group_id) && is_not_null($widget->group_id)) {
    $group = get_entity($widget->group_id);
}
if (isset($widget->scale) && is_not_null($widget->scale)) {
    $scale = $widget->scale;
}

if (elgg_instanceof($activity,'object', ClipitActivity::SUBTYPE) && elgg_instanceof($task, 'object', ClipitQuiz::SUBTYPE) && (elgg_instanceof($group, 'object', ClipitGroup::SUBTYPE) || $scale == ClipitActivity::SUBTYPE)) {
    $quiz_id = $task->guid;
    $min_values = array();
    $max_values = array();
    $results = array();
    //Als erstes rausfinden welche SBs beteiligt sind
    $sbresults = ClipitQuiz::get_quiz_results_by_tag($quiz_id);
    foreach ($sbresults as $sb_id=>$value) {
        $sb = get_entity($sb_id);
        $sb_name = $sb->name;
        $min_values[strval($sb_name)] = PHP_INT_MAX;
        $max_values[strval($sb_name)] = 0;

    }
    if ($scale == ClipitActivity::SUBTYPE) {
        $groups = ClipitActivity::get_groups($activity->guid);
        foreach ($groups as $number=>$group_id) {
            $quiz_results = ClipitQuiz::get_group_results_by_tag($quiz_id, $group_id);
            $group = get_entity($group_id);
            if (is_not_null($quiz_results) && !empty($quiz_results)) {
                $data = array();
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
            }
            $data = json_encode($data);
            $results[$number] = array("name" => $group->name, "data" => strval($data), "color" => $spider_colors[$number]);
        }
    } elseif ($scale == ClipitGroup::SUBTYPE) {
        $users = ClipitGroup::get_users($group->guid);
        foreach ($users as $number=>$user_id) {
            $quiz_results = ClipitQuiz::get_user_results_by_tag($quiz_id, $user_id);
            $user = get_entity($user_id);
            if (is_not_null($quiz_results) && !empty($quiz_results)) {
                $data = array();
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
            }
            $data = json_encode($data);
            $results[$number] = array("name" => $user->name, "data" => strval($data), "color" => $spider_colors[$number]);
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
/*                    var data = [{"Osmosis": 0, "Diffusion": 0, "Genetic Drift": 0, "Potential": 0, "Voltage": 0},
                        {"Osmosis": 100, "Diffusion": 100, "Genetic Drift": 100, "Potential": 100, "Voltage": 100},
                        {"Osmosis": 53, "Diffusion": 26, "Genetic Drift": 25, "Potential": 45, "Voltage": 55},
                        {"Osmosis": 20, "Diffusion": 100, "Genetic Drift": 45, "Potential": 30, "Voltage": 10}];
*/
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
                            echo("\t\t\t\t\t\t\t\t".$series['data']."];\n");
                        }
                        else {
                            echo("\t\t\t\t\t\t\t\t".$series['data'].",\n");
                        }
                    }
                    foreach ($results as $number=>$series) {
                        echo("\t\t\t\t\tchart.addSeries(\"".$series['name']."\", {data: data[$number]}, {fill: \"".$series['color']."\"});\n");

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