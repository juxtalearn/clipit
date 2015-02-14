<?php
elgg_load_js("dojotoolkit");


$widget = $vars['entity'];
$widget_id = $widget->guid;
$chart_identifier = "quiz-widget-$widget_id";

?>
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

                var data = [{"Osmosis": 0, "Diffusion": 0, "Genetic Drift": 0, "Potential": 0, "Voltage": 0},
                    {"Osmosis": 100, "Diffusion": 100, "Genetic Drift": 100, "Potential": 100, "Voltage": 100},
                    {"Osmosis": 53, "Diffusion": 26, "Genetic Drift": 25, "Potential": 45, "Voltage": 55},
                    {"Osmosis": 20, "Diffusion": 12, "Genetic Drift": 35, "Potential": 55, "Voltage": 55}];

                chart.addSeries("min", {data: data[0]}, {fill: "blue"}); //Workaround for a bug if the spider is not capable of calculating the correct min/max values for its axix
                chart.addSeries("max", {data: data[1]}, {fill: "blue"}); //Workaround for a bug if the spider is not capable of calculating the correct min/max values for its axix
                chart.addSeries("Quiz1", {data: data[2]}, {fill: "blue"});
                chart.addSeries("Quiz2", {data: data[3]}, {fill: "red"});
                chart.render();
                chart.removeSeries("min");//Workaround for a bug if the spider is not capable of calculating the correct min/max values for its axix
                chart.removeSeries("max");//Workaround for a bug if the spider is not capable of calculating the correct min/max values for its axix
                new SelectableLegend({chart:chart}, 'legendNode-<?php echo $chart_identifier?>');
               // new Tooltip({chart:chart}, 'default');
            });
        }
    )
</script>

