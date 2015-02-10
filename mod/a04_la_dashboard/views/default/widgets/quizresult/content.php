<?php
elgg_load_js("dojotoolkit");


$widget = $vars['entity'];
$widget_id = $widget->guid;

?>
<div id="quiz-widget-<?php echo $widget_id ?>" style="width: 320px; height: 320px; margin: 0px auto 0px auto;"></div>
<script>
    require(["dojox/charting/Chart2D", "dojox/charting/axis2d/Default", "dojox/charting/plot2d/Default", "dojox/charting/plot2d/Spider", "dojox/charting/axis2d/Base","dojo/ready"],
        function(Chart, Default, Default, Spider, Base, ready) {
            ready(function () {
                var chart = new dojox.charting.Chart("quiz-widget-<?php echo $widget_id ?>");
                chart.addPlot("default", {
                    type: "Spider",
                    labelOffset: -10,
                    seriesFillAlpha: 0.2,
                    markerSize: 3,
                    precision: 0,
                    spiderType: "polygon"
                });

                var data = [{"Osmosis": 0, "Diffusion": 0, "Genetic Drift": 0, "Potential": 0, "Voltage": 0},
                    {"Osmosis": 100, "Diffusion": 100, "Genetic Drift": 100, "Potential": 100, "Voltage": 100},
                    {"Osmosis": 53, "Diffusion": 26, "Genetic Drift": 25, "Potential": 45, "Voltage": 55},
                    {"Osmosis": 20, "Diffusion": 100, "Genetic Drift": 45, "Potential": 30, "Voltage": 10}];

                chart.addSeries("min", {data: data[0]}, {fill: "blue"});
                chart.addSeries("max", {data: data[1]}, {fill: "blue"});
                chart.addSeries("Student1", {data: data[2]}, {fill: "blue"});
                chart.addSeries("Student2", {data: data[3]}, {fill: "red"});
                chart.render();
                chart.removeSeries("min");
                chart.removeSeries("max");
            });
        }
    )
</script>

