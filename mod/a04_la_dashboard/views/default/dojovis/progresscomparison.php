<?php
//elgg_load_css('dojotoolkitcss');
/*
Helper view for showing a dojo spiderweb
*/

$widget_id = $vars['widget_id'];
$activity_id = $vars['activity_id'];
$group_id = $vars['group_id'];

$chart_identifier = "quiz-widget-$widget_id";
?>

<div id="<?php echo $chart_identifier ?>"
     style="width: 100%; height: 320px; margin: 0px auto 0px auto;"></div>
<div id="legendNode-<?php echo $chart_identifier ?>"></div>
<script>
    require(["dojox/charting/plot2d/Candlesticks", "dojox/charting/plot2d/Lines",
            "dojox/charting/Chart", "dojox/charting/themes/Shrooms", "dojox/charting/action2d/Tooltip",
            "dojox/charting/action2d/Magnify", "dojox/charting/widget/Legend", 'dojo/request', "dojo/domReady", "dojox/charting/Theme",
            "dojo/json", "dojox/charting/axis2d/Default"],
        function (Candlesticks, Lines, Chart, theme, Tooltip, Magnify, Legend, request, ready) {
            ready(function () {
                function draw(jsondata) {

                    var data = jsondata,
                        labels = [],
                        realStart = [],
                        realEnd = [],
                        planned = [],
                        labelFunc = function (text, value) {
                            return value === 0 ? " " : labels[value - 1];
                        };


                    data.data.forEach(function (d, i) {
                        labels.push(d.label);
                        realStart.push({
                    x: i + 1,
                    y: d.realStart.day,
                    tooltip: "<span>" + d.label + "</br>start: " + new Date(d.realStart.date * 1000).toLocaleDateString()
                    + "</span>"
                });
                realEnd.push({
                    x: i + 1,
                    y: d.realEnd.day,
                    tooltip: "<span>" + d.label + "</br>end: " + new Date(d.realEnd.date * 1000).toLocaleDateString()
                    + "</span>"
                });
                planned.push({
                    open: d.plannedStart.day,
                    close: d.plannedEnd.day,
                    high: d.plannedStart.day,
                    low: d.plannedEnd.day,
                    tooltip: "<span>" + d.label + "</br>start: " + new Date(d.plannedStart.date * 1000).toLocaleDateString() + "</br>end: " +
                    new Date(d.plannedEnd.date * 1000).toLocaleDateString() + "</span>"
                });
                    });

                    theme.markers = {
                        CIRCLE: "m-3,0 c0,-4 6,-4 6,0 m-6,0 c0,4 6,4 6,0"
                    };
                    var chart = new dojox.charting.Chart("<?php echo $chart_identifier ?>");

                    chart.setTheme(theme)
                        .addPlot("start", {
                            type: "Default",
                            markers: true,
                            tension: "X"
                        })
                        .addSeries("Start",
                        realStart,
                        {
                            plot: "start",
                            legend: "Actual start"
                        })
                        .addPlot("end", {
                            type: "Default",
                            markers: true,
                            tension: "X"
                        })
                        .addSeries("End",
                        realEnd, {
                            plot: "end",
                            legend: "Actual end"
                        })
                        .addPlot("planned", {
                            type: "Candlesticks",
                            gap: 3,
                            minBarSize: 10,
                            maxBarSize: 20
                        })
                        .addSeries("Planned", planned, {
                            plot: "planned",
                            legend: "Planned start and end"
                        })
                        .addAxis("x", {
                            title: "Task",
                            includeZero: false,
                            titleOrientation: "away",
                            minorTicks: false,
                            labelFunc: labelFunc
                        })
                        .addAxis("y", {
                            title: "Days since start",
                            vertical: true,
                            fixLower: "major",
                            fixUpper: "major",
                            natural: true
                        });
                    new Tooltip(chart, "start");
                    new Tooltip(chart, "end");
                    new Tooltip(chart, "planned");
                    new Magnify(chart, "start");
                    new Magnify(chart, "end");
                    chart.render();
                    new Legend({chart: chart, horizontal: false, style:'width:100%;'}, "legendNode-<?php echo $chart_identifier?>");
                }

                request.get("<?php echo elgg_get_site_url()?>ajax/view/metrics/get_progress?id=<?php echo $activity_id?>&gid=<?php echo $group_id?>", {handleAs: 'json'}).then(function (data) {
                        //handle success
                        draw(data);
                    }, function (err) {
                        //handle errors
                        alert('An error occured:' + err);
                    },
                    function (evt) {
                        //handle progress
                        //do nothing
                    });

            });
        }
    )
</script>