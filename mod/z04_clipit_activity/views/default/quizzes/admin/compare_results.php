<?php
$stumbling_blocks = elgg_extract('stumbling_blocks', $vars);
$results = elgg_extract('results', $vars);
$count_results = count($results);
if ( (!isset($axis) || is_null($axis)) && isset($min_values) && is_not_null($min_values)) {
    $axis = array_keys($min_values);
}
if($count_results <= 20){
    $row_width = 250;
}elseif($count_results < 50){
    $row_width = 180;
}elseif($count_results < 80){
    $row_width = 140;
}elseif($count_results >= 80){
    $row_width = 110;
}
?>
<link rel="stylesheet" type="text/css"
      href="http://ajax.googleapis.com/ajax/libs/dojo/1.10.4/dojo/resources/dojo.css"/>
<link rel="stylesheet" type="text/css"
      href="http://ajax.googleapis.com/ajax/libs/dojo/1.10.4/dijit/themes/dijit.css"/>
<link rel="stylesheet" type="text/css"
      href="http://ajax.googleapis.com/ajax/libs/dojo/1.10.4/dijit/themes/claro/claro.css"/>
<script src="http://ajax.googleapis.com/ajax/libs/dojo/1.10.4/dojo/dojo.js"></script>
<style>
    table{
        margin-top: 20px !important;
    }
    table tr{
        width: auto;
        display: inline-block;
        margin-right: 10px;
        margin-bottom: 10px;
    }
    table tr td{
        width: <?php echo $row_width;?>px;
        position: relative;
    }

    #quiz-widget-15322 > svg > rect{
        fill: rgb(236, 247, 252);
        stroke: transparent;
    }
    .dijitCheckBox{
        opacity: 0;
    }
    .dojoxLegendIcon{
        display: none;
    }
    table tr td label {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        display: inline-block;
        max-width: <?php echo $row_width-20;?>px;
        vertical-align: middle;
        color: #999;
        cursor: pointer;
        outline: 0 !important;
    }
    label.dojoxLegendText:before {
        content: '';
        background-color: #000;
        border-radius: 100%;
        width: 16px;
        height: 16px;
        position: absolute;
        left: -3px;
        top: 0;
        transition: all .3s;
    }
    <?php foreach($results as $k => $r):?>
    table tr:nth-child(<?php echo $k+1;?>) label.dojoxLegendText:hover:after {
        content: '<?php echo $r['name'];?>';
        position: absolute;
        left: 17px;
        background-color: #fff;
        z-index: 333;
    }
    table tr:nth-child(<?php echo $k+1;?>) .dijitCheckBoxChecked ~ label.dojoxLegendText:before,
    table tr:nth-child(<?php echo $k+1;?>) [class*="dijitCheckedFocused"] ~ label.dojoxLegendText:before{
        background-color: <?php echo $r['color']?> !important;
    }
    table tr:nth-child(<?php echo $k+1;?>) [class="dijit dijitReset dijitInline dijitCheckBox"] ~ label.dojoxLegendText:before,
    table tr:nth-child(<?php echo $k+1;?>) [class*="dijitCheckBoxFocused"] ~ label.dojoxLegendText:before{
        background: #fff;
        box-shadow: inset 0 0 0 2px  <?php echo $r['color']?>;
    }
    <?php endforeach;?>
</style>
<div class="Claro">
    <div id="quiz-widget-15322"
         style="width: 100%;  margin: 0px auto 0px auto;height:400px;"></div>
    <div id="legendNode-quiz-widget-15322"></div>

    <script>
        require(["dojox/charting/Chart2D", "dojox/charting/themes/Claro",
                "dojox/charting/plot2d/Spider",
                "dojox/charting/axis2d/Base", "dojox/charting/widget/SelectableLegend",
                "dojox/charting/action2d/Tooltip", "dojo/ready", "dojox/charting/axis2d/Default","dojox/charting/plot2d/Default",],
            function (Chart, Theme, Spider, Base, SelectableLegend, Tooltip, ready) {
                ready(function () {
                    var chart = new dojox.charting.Chart("quiz-widget-15322");
                    chart.setTheme(Theme);
                    chart.addPlot("default", {
                        type: "Spider",
                        labelOffset: -10,
                        seriesFillAlpha: 0.3,
                        markerSize: 3,
                        precision: 0,
                        animationType:   dojo.fx.easing.linear,
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
                            echo("chart.addSeries(\"".$series['name']."\", {data: data[$i]}, {fill: \"".($series['color'])."\", hidden: true});");
                            $i+=1;
                        }
                        foreach ($axis as $label) {
                            echo("chart.addAxis(\"".$label."\", {type: \"Base\", min: 0, max: 100 });");
                        }
                        ?>
                    chart.render();
                    var legend =  new SelectableLegend({chart: chart,horizontal:false,style:"width: 100%; height: 100px; margin: 0px auto 0px auto; overflow:scroll;"}, 'legendNode-quiz-widget-15322');
                    new Tooltip(chart, 'default');
                });
            }
        )
    </script>
</div>

<div id="spider" class="spider" style="float:left;"></div>
<div style="float:left;">
    <div id="spiderLegend"></div>
</div>