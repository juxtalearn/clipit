
<?php
//elgg_load_css('dojotoolkitcss');
/*
Helper view for showing a dojo spiderweb
*/
extract($vars);

$chart_identifier = "quiz-widget-$widget_id";

if ( (!isset($axis) || is_null($axis)) && isset($min_values) && is_not_null($min_values)) {
    $axis = array_keys($min_values);
}

?>

<div id="<?php echo $chart_identifier ?>"
     style="width: 100%;  margin: 0px auto 0px auto;"></div>
    <div id="legendNode-<?php echo $chart_identifier ?>"></div>
        <script>

require(["dojox/charting/Chart2D", "dojox/charting/themes/Claro",
     "dojox/charting/plot2d/Spider",
    "dojox/charting/axis2d/Base", "dojox/charting/widget/SelectableLegend",
    "dojox/charting/action2d/Tooltip", "dojo/ready", "dojox/charting/axis2d/Default","dojox/charting/plot2d/Default",],
                function (Chart, Theme, Spider, Base, SelectableLegend, Tooltip, ready) {
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
                        $i=0;
                        $e = count($results)-1;
                        foreach ($results as $number=>$series) {
                            if ($i == 0) {
                                echo("var data = [".$series['data'].",\n");
                                  if ($e === 0) {
                                    echo "];\n";
                                }
                            }
                            elseif ($i == $e) {
                                  echo($series['data']."];\n");
                            }
                            else {
                                echo($series['data'].",");
                            }
                            $i++;
                        }
                        $i=0;
                        foreach ($results as $number=>$series) {
                            echo("chart.addSeries(\"".$series['name']."\", {data: data[$i]}, {fill: \"".$series['color']."\"});");
                            $i+=1;

                        }
                        foreach ($axis as $label) {
                            echo("chart.addAxis(\"".$label."\", {type: \"Base\", min: 0, max: 100 });");
                        }
                        ?>
chart.render();

var legend =  new SelectableLegend({chart: chart,horizontal:false,style:"width: 100%; height: 100px; margin: 0px auto 0px auto; overflow:scroll;"}, 'legendNode-<?php echo $chart_identifier?>');
// new Tooltip({chart:chart}, 'default');
});
}
)
</script>