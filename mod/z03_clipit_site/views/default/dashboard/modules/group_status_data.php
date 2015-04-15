<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   10/03/2015
 * Last update:     10/03/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$activity_id = get_input('entity');
$data_type = get_input('type');
if($data_type == 'group_status'){
    $output = array();
    $user_id = elgg_get_logged_in_user_guid();
    $entities = get_input('entities');
    foreach($entities as $entity_id){
        $group_id = ClipitGroup::get_from_user_activity($user_id, $entity_id);
        $output[$group_id] = get_group_progress($group_id);
    }
    echo json_encode($output);
    die;
}
$activity = array_pop(ClipitActivity::get_by_id(array($activity_id)));
?>

<?php if($data_type == 'activity_group_status'):?>
<svg></svg>
<script>
    nv.addGraph(function() {
        var chart = nv.models.discreteBarChart()
            .x(function (d) {
                return d.label
            })
            .y(function (d) {
                return d.value
            })
            .tooltips(true)
            .staggerLabels(false)
            .tooltipContent(function (key, y, e, graph) {
                var name = graph.point.ctext;
                return name
            })
            .showValues(true)
            .forceY([0, 100])
            .valueFormat(d3.format('f'))
            .color(['#<?php echo $activity->color; ?>']);
        chart.margin({top: 10, right: 10, bottom: 20, left: 35})
        chart.yAxis
            .tickFormat(d3.format(',f'));
        d3.select('#chart_bar_<?php echo $activity->id;?> svg')
            .datum(
            [{
                key: "<?php echo $activity->name; ?>",
                values: [
                    <?php
                    $num_group = 1;
                    $group_ids = ClipitActivity::get_groups($activity->id);
                    $groups = ClipitGroup::get_by_id($group_ids, 0, 0, 'name');
                    natural_sort_properties($groups, 'name');
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
</script>
<?php endif;?>