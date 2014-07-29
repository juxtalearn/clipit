<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   23/07/14
 * Last update:     23/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$entities = elgg_extract('entities', $vars);
$activities = ClipitActivity::get_by_id($entities);
elgg_load_js("nvd3:d3_v2");
elgg_load_js("nvd3");
elgg_load_css("nvd3:css");
?>
<style>
    .module-group_activity svg {
        height: 200px;
    }
    .module-group_activity svg .nvd3 .nv-axis line{
        stroke: #EBEBEB;
    }
    .module-group_activity svg text {
        font: normal 12px Helvetica;
        fill: #999999;
    }
    .module-group_activity svg .nv-x .nv-axis text {
        fill: #000;
    }
    .module-group_activity svg .nv-axis path {
        stroke: #999999;
    }
</style>
<script>
<?php foreach($activities as $activity):?>
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
        d3.select('#chart_bar_<?php echo $activity->id;?> svg')
            .datum(
                [{key: "<?php echo $activity->name; ?>",
                    values: [
                        <?php
                        $num_group = 1;
                        $group_ids = ClipitActivity::get_groups($activity->id);
                        $groups = ClipitGroup::get_by_id($group_ids);
                        foreach($groups as $group){
                            $value = get_group_progress($group->id);
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
<?php endforeach;?>
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

<?php if(count($activities) > 1):?>
    <a href="javascript:;" class="fa fa-chevron-right" id="next"></a>
    <a href="javascript:;" class="fa fa-chevron-left" id="prev"></a>
<?php endif;?>

<div class='charts'>
<?php
$count = 0;
foreach($activities as $activity):
    $show = "block";
    if($count > 0){
        $show = "none";
    }
?>
    <div id="chart_bar_<?php echo $activity->id;?>" class="group_activities separator" style="display: <?php echo $show;?>">
        <h3 style="color: #<?php echo $activity->color;?>;"><?php echo $activity->name;?></h3>
        <svg></svg>
    </div>
<?php $count++; endforeach;?>
</div>
