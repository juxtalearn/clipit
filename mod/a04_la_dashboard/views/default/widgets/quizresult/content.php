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
if (isset($widget->quiz_id) && is_not_null($widget->quiz_id)) {
    $quiz = get_entity($widget->quiz_id);
}
if (isset($widget->group_id) && is_not_null($widget->group_id)) {
    $group = get_entity($widget->group_id);
}
if (isset($widget->scale) && is_not_null($widget->scale)) {
    $scale = $widget->scale;
}
if (elgg_instanceof($activity,'object', ClipitActivity::SUBTYPE) && elgg_instanceof($quiz, 'object', ClipitQuiz::SUBTYPE) && (elgg_instanceof($group, 'object', ClipitGroup::SUBTYPE) || $scale == 2)) {
    $quiz_id = $quiz->guid;
    $min_value = array();
    $max_value = array();
    //Als erstes rausfinden welche SBs beteiligt sind
    $sbresults = ClipitQuiz::get_quiz_results_by_tag($quiz_id);
    foreach ($sbresults as $sb=>$value) {
        $min_value[$sb] = float(PHP_INT_MAX);
        $max_value[$sb] = float(0);

    }
    if ($scale == ClipitActivity::SUBTYPE) {
        $groups = ClipitActivity::get_groups($activity->guid);
        foreach ($groups as $number->$group_id) {
            $quiz_results = ClipitQuiz::get_group_results_by_tag($quiz_id, $group_id);
            $group = get_entity($group_id);
            foreach($quiz_results as $sb->$value) {
                $data[$sb] = $value;
                if ($value > $max_value[$sb]) {
                    $max_value[$sb] = int($value);
                }
                if ($value < $min_value[$sb]) {
                    $min_value[$sb] = int($value);
                }
            }
            $data = json_encode($data);
            $results[$number] = array("name" => $group->name, "data" => $data, "color" => $spider_colors[$number]);
        }
    } elseif ($scale == ClipitGroup::SUBTYPE) {
        $users = ClipitGroup::get_users($group->guid);
        foreach ($users as $number->$user_id) {
            $quiz_results = ClipitQuiz::get_user_results_by_tag($quiz_id, $user_id);
            $user = get_entity($user_id);
            foreach($quiz_results as $sb->$value) {
                $data[$sb] = $value;
                if ($value > $max_value[$sb]) {
                    $max_value[$sb] = int($value);
                }
                if ($value < $min_value[$sb]) {
                    $min_value[$sb] = int($value);
                }
            }
            $data = json_encode($data);
            $results[$number] = array("name" => $user->name, "data" => $data, "color" => $spider_colors[$number]);
        }
    }
    if (is_not_null($results)) { ?>
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

                    chart.addSeries("min", {data: minmax[0]}, {fill: "blue"}); //Workaround for a bug if the spider is not capable of calculating the correct min/max values for its axix
                    chart.addSeries("max", {data: minmax[1]}, {fill: "blue"}); //Workaround for a bug if the spider is not capable of calculating the correct min/max values for its axix
                    <?php
                    foreach ($results as $series) {
                        echo('chart.addSeries("'.$series['name'].'", {data: '.$series['data'].'}, {fill: "'.$series['color'].'"});');
                    }
                    ?>
                    chart.render();
                    chart.removeSeries("min");//Workaround for a bug if the spider is not capable of calculating the correct min/max values for its axix
                    chart.removeSeries("max");//Workaround for a bug if the spider is not capable of calculating the correct min/max values for its axix
                    new SelectableLegend({chart:chart}, 'legendNode-<?php echo $chart_identifier?>');
                    // new Tooltip({chart:chart}, 'default');
                });
            }
        )
    </script>

    <?php}
    //No results found:
    else { ?>
        <div id="no_results">
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