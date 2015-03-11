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
$all_activities = ClipitActivity::get_by_id(ClipitUser::get_activities(elgg_get_logged_in_user_guid()));
foreach($all_activities as $my_activity){
    if($my_activity->status != ClipitActivity::STATUS_CLOSED){
        $activities[$my_activity->id] = $my_activity;
    }
}
$activity = reset($activities);
?>
<script>
<?php
    if($activity):
?>
    nv.addGraph(function() {
        var chart = nv.models.discreteBarChart()
            .x(function(d) { return d.label })
            .y(function(d) { return d.value })
            .tooltips(true)
            .staggerLabels(false)
            .tooltipContent(function(key, y, e, graph) {
                var name = graph.point.ctext;
                return  name
            })
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
                        $groups = ClipitGroup::get_by_id($group_ids, 0, 0, 'name');
                        foreach($groups as $group){
                            $value = get_group_progress($group->id);
                            echo "{ 'label': 'G{$num_group}', 'value':{$value}, 'ctext':'{$group->name}'},";
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
    <?php endif;?>
    activity_group_status_data = function(){
        var content = $(this).find('.chart-js');
        if($(this).find('svg').length == 0) {
            elgg.get('ajax/view/dashboard/modules/group_status_data', {
                data: {entity: $(this).data('entity')},
                success: function (data) {
                    content.html(data);
                }
            });
        }
    };
    $(document).ready(function(){

        $("#next").click(function() {
            if ($(".charts .group_activities:visible").next().length != 0){
                $(".charts .group_activities:visible").next().fadeIn(activity_group_status_data).prev().hide();
            } else {
                $(".charts .group_activities:visible").hide();
                $(".charts .group_activities:first").show();
            }
            $(window).trigger('resize');
            return false;
        });

        $("#prev").click(function(){
            if ($(".charts .group_activities:visible").prev().length != 0)
                $(".charts .group_activities:visible").prev().fadeIn(activity_group_status_data).next().hide();
            else {
                $(".charts .group_activities:visible").hide();
                $(".charts .group_activities:last").fadeIn(activity_group_status_data);
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
    <div data-entity="<?php echo $activity->id;?>" id="chart_bar_<?php echo $activity->id;?>" class="group_activities separator" style="display: <?php echo $show;?>">
        <h3 style="color: #<?php echo $activity->color;?>;"><?php echo $activity->name;?></h3>
        <div class="chart-js">
        <?php if($count > 0):?>
            <?php echo elgg_view('page/components/loading_block', array('height' => '200px', 'text' => elgg_echo('loading:charts')));?>
        <?php else:?>
            <svg></svg>
        <?php endif;?>
        </div>
    </div>
    <?php
    $count++;
endforeach;
?>
</div>
<style>
.chart-js .separator{
    border: 0;
}
</style>