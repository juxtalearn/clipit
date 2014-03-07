<?php
$user = elgg_get_logged_in_user_guid();
// order activity by recent deadline
$my_activities = ClipitActivity::get_from_user($user);
?>
<script src="http://nvd3.org/lib/d3.v2.js"></script>
<script src="http://nvd3.org/lib/fisheye.js"></script>
<script src="http://nvd3.org/nv.d3.js"></script>

<link href="http://nvd3.org/css/common.css" rel="stylesheet">
<link href="http://nvd3.org/src/nv.d3.css" rel="stylesheet">
<link href="http://nvd3.org/css/syntax.css" rel="stylesheet">
<style>
    .module-group_activity svg {
        height: 200px;
    }
    .module-group_activity svg .nvd3 .nv-axis line{
        stroke: #EBEBEB;
    }
    .module-group_activity svg text {
        font: normal 12px Helvetica;
        fill: #333333;
    }
</style>
<script>
    <?php
    $num = 1;
    foreach($my_activities as $activity){
    ?>
    nv.addGraph(function() {
        var chart = nv.models.discreteBarChart()
            .x(function(d) { return d.label })
            .y(function(d) { return d.value })
            .staggerLabels(false)
            .tooltips(false)
            .showValues(true)
            .forceY([0,100])
            .valueFormat(d3.format('f'))
            .color(['#<?php echo $activity->color; ?>']);
        chart.margin({top:10, right:10, bottom:20, left:35})
        chart.yAxis
            .tickFormat(d3.format(',f'));
        d3.select('#chart_bar<?php echo $num; ?> svg')
            .datum(
                [{key: "<?php echo $activity->name; ?>",
                    values: [
                        <?php
                        $num_group = 1;
                        $groups = ClipitActivity::get_groups($activity->id);
                        foreach($groups as $group_id){
                            $group = ClipitGroup::get_by_id(array($group_id));
                            $group = array_pop($group);
                            $value = mt_rand(20,100);
                            echo "{ 'label': 'G{$num_group}', 'value':{$value}},";
                            $num_group ++;
                        }
                        ?>
                    ]
                }]
            )
            .transition().duration(500)
            .call(chart);

        nv.utils.windowResize(chart.update);

        return chart;
    });
    <?php
    $num++;
     }
     ?>

    $(document).ready(function(){

        $("#next").click(function(){
            if ($(".charts .group_activities:visible").next().length != 0)
                $(".charts .group_activities:visible").next().show().prev().hide();
            else {
                $(".charts .group_activities:visible").hide();
                $(".charts .group_activities:first").show();
            }
            $(window).trigger('resize');
            return false;
        });

        $("#prev").click(function(){
            if ($(".charts .group_activities:visible").prev().length != 0)
                $(".charts .group_activities:visible").prev().show().next().hide();
            else {
                $(".charts .group_activities:visible").hide();
                $(".charts .group_activities:last").show();
            }
            $(window).trigger('resize');
            return false;
        });
    });
</script>
<?php
/**
 * Created by JetBrains PhpStorm.
 * User: equipo
 * Date: 6/02/14
 * Time: 12:37
 * To change this template use File | Settings | File Templates.
 */




$num = 1;

if(count($my_activities) > 1){
    $content .= '
    <a href="javascript:;" class="fa fa-chevron-right" id="next"></a>
    <a href="javascript:;" class="fa fa-chevron-left" id="prev"></a>';
}

$content .="<div class='charts'>";
foreach($my_activities as $activity){
    $show = "none";
    if($num == 1){
        $show = "block";
    }
    $content .='<div id="chart_bar'.$num.'" class="group_activities separator" style="display: '.$show.'">
                    <h3 style="color: #'.$activity->color.';">'.$activity->name.'</h3>
                    <svg></svg>
                </div>';
    $num++;
}
$content .="</div>";

$all_link = elgg_view('output/url', array(
    'href' => "linkHref",
    'text' => elgg_echo('link:view:all'),
    'is_trusted' => true,
));
echo elgg_view('landing/module', array(
    'name'      => "group_activity",
    'title'     => "Group Activity",
    'content'   => $content,
    'all_link'  => $all_link,
));