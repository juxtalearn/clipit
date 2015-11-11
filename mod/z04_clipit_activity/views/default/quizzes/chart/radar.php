<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   13/02/2015
 * Last update:     13/02/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$id = elgg_extract('id', $vars);
$labels = elgg_extract('labels', $vars);
$data = elgg_extract('data', $vars);
elgg_load_js('jquery:chartjs');
?>
<script>
    var data = {
        labels:  <?php echo json_encode($labels);?>,
        datasets: [
            {
                label: '<?php echo elgg_echo('tags');?>',
                fillColor: "rgba(50, 180, 229,0.2)",
                strokeColor: "rgba(50, 180, 229, 0.7)",
                pointColor: "rgba(50, 180, 229, 1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(151,187,205,1)",
                data: <?php echo json_encode(array_values($data));?>
            }
        ]
    };
    $(function(){
        var ch = document.getElementById("canvas-chart-<?php echo $id;?>").getContext("2d");
        new Chart(ch).Radar(data, {
            pointDot: true,
            pointLabelFontSize : 12,
            angleLineColor : "rgba(0,0,0,.3)",
            pointDotStrokeWidth : 2,
            responsive: true,
            scaleOverride: true,
            datasetStrokeWidth : 5,
            tooltipTemplate: "<%if (label){%><%=label%>: <%}%><%= Math.round((value*100)) %>%",

            // ** Required if scaleOverride is true **
            scaleSteps: 1,
            scaleStepWidth: 1,
            scaleStartValue: 0
        });
    });
</script>
<canvas id="canvas-chart-<?php echo $id;?>" style="background: rgb(236, 247, 252);padding: 10px;width: 100% !important;"  width="800" height="500"></canvas>