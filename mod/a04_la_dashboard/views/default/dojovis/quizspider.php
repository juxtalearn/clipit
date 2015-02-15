
<?php
//elgg_load_css('dojotoolkitcss');
/*
Helper view for showing a dojo spiderweb
*/

$widget_id = $vars['widget_id'];
$min_values = $vars['min_values'];
$max_values = $vars['max_values'];
$axis = $vars['axis'];
$results = $vars['results'];
$chart_identifier = "quiz-widget-$widget_id";

if ( (!isset($axis) || is_null($axis)) && isset($min_values) && is_not_null($min_values)) {
    $axis = array_keys($min_values);
}

?>

<div id="<?php echo $chart_identifier ?>"
     style="width: 320px; height: 320px; margin: 0px auto 0px auto;"></div>
    <div id="legendNode-<?php echo $chart_identifier ?>"></div>
        <script>

require(["dojox/charting/Chart2D", "dojox/charting/themes/MiamiNice", "dojox/charting/axis2d/Default",
    "dojox/charting/plot2d/Default", "dojox/charting/plot2d/Spider",
    "dojox/charting/axis2d/Base", "dojox/charting/widget/SelectableLegend",
    "dojox/charting/action2d/Tooltip", "dojo/ready"],
                function (Chart, Theme, Default, Default, Spider, Base, SelectableLegend, Tooltip, ready) {
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
//                            echo("var minmax = [".json_encode($min_values).",\n");
//                            echo("  ".json_encode($max_values)."];\n");
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
                        foreach ($axis as $label) {
                            echo("\t\t\t\t\tchart.addAxis(\"".$label."\", {type: \"Base\", min: 0, max: 100 });\n");
                        }
                        ?>
chart.render();
new SelectableLegend({chart: chart,horizontal:false,style:"width: 300px; height: 100px; margin: 0px auto 0px auto; overflow:scroll;"}, 'legendNode-<?php echo $chart_identifier?>');
// new Tooltip({chart:chart}, 'default');
});
}
)
</script>