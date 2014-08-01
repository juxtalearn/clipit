<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   17/07/14
 * Last update:     17/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$activity = elgg_extract('entity', $vars);
$groups = ClipitGroup::get_by_id($activity->group_array);
$start = $activity->start;
$end = $activity->end;
// (today - start) / (end - start) * 100
$activity_progress = round(((time() - $start)/($end - $start)) * 100);
if($activity_progress < 0){
    $activity_progress = 0;
}
?>
<script>
$(function(){
    $(document).on("click", "#panel-expand-all",function(){
        $(".expand").parent(".panel").find(".panel-collapse").collapse('show');
        $(".group-info").click();
    });
    $(document).on("click", "#panel-collapse-all",function(){
        $(".expand").parent(".panel").find(".panel-collapse").collapse('hide');
    });
    $(document).on("click", ".group-info",function(){
        var content = $(this).parent(".panel").find(".group-content");
        var gr_id = $(this).data("group");
        if(content.is(':empty')){
            content.html('<i class="fa fa-spinner fa-spin fa-2x blue"></i>');
            $.get( elgg.config.wwwroot+"ajax/view/activity/admin/dashboard/group_info", {group_id: gr_id}, function( data ) {
                content.html(data);
            });
        }
    });
});
</script>
<?php
$users_array = array('us_1', 'us_2', 'us_3', 'us_4', 'us_5', 'us_6', 'us_7', 'us_8', 'us_9', 'us_10', 'us_11');
$max_students = 5;
$total_groups = ceil((count($users_array) / $max_students));
$array_f = array_fill(0, $total_groups, array());


$g_array[0] = array($users_array[0], $users_array[3], $users_array[6], $users_array[9]);
$g_array[1] = array($users_array[1], $users_array[4], $users_array[7], $users_array[10]);
$g_array[2] = array($users_array[2], $users_array[5], $users_array[8]);
///
$g_array = array(
    array(
        $users_array[0],
        $users_array[3],
        $users_array[6],
        $users_array[9]
    ),
    array(
        $users_array[1],
        $users_array[4],
        $users_array[7],
        $users_array[10]
    ),
    array(
        $users_array[2],
        $users_array[5],
        $users_array[8]
    )
);
//var_dump($g_array);
//$g_array = array();
//for($i = 0; $i < count($users_array); $i++){
////    $g_array[$i] = "";
//    /*for($x = 0; $x < $total_groups; $x++){
//        if($x%2){
//            $g_array[$i] = $users_array[$i];
//        }
//    }*/
//    for($x = 0; $x < $total_groups; $x++){
//        $g_array[$x] = "pepe";
//    }
//}
/////
//$g_array = array();
//$pesoMochila=0;
//$posicion=0;
//while($pesoMochila < $max_students && $posicion < count($users_array)) {
//            $p = $users_array[$posicion];
//            if($pesoMochila + $posicion <= $max_students) {
//                //mochila.add(tmp);
//                //$pesoMochila += tmp.peso;
//                $pesoMochila += $posicion;
//                $g_array[] = $pesoMochila;
//            }
//            $posicion++;
//        }
//
//var_dump($g_array);
//
//
//$g_array = array();
//for($i = 0; $i < $total_groups; $i++){
////    $g_array[] = array('èè');
////    for($x = 0; $x < $i; $x++){
////        $g_array[] = $x;
////    }
//    for($x = 0; $x < count($users_array); $x++){
//        $g_array[$i] = $users_array[$x];
//    }
//}
//var_dump($g_array);
//
//$g_array = array();
//for($i = 0; $i < count($users_array); $i++){
//    for($x = 0; $x < $total_groups; $x++){
//        $g_array[] = $users_array[$i];
//    }
//}
//var_dump($g_array);
//$g_array = array();
//for($i = 0; $i < $total_groups; $i++){
//    for($x = $i; $x < count($users_array); $x++){
//        $g_array[$i] = $users_array[$x];
//    }
//}
//var_dump($g_array);
?>
<?php echo elgg_view('activity/admin/dashboard/activity_status', array('entity' => $activity));?>
<hr>
<h3>Activity progress</h3>
<div class="margin-bottom-20">
    <div style="position: relative;">
        <?php echo elgg_view("page/components/progressbar", array(
            'value' => $activity_progress,
            'width' => '100%',
        ));
        ?>
        <?php
        foreach(ClipitTask::get_by_id($activity->task_array) as $task):
            $task_progress = round((($task->start - $start)/($end - $start)) * 100);
        ?>
            <div style="position: absolute; top:0; left: <?php echo $task_progress+0.3;?>%">
                <?php echo elgg_view('output/url', array(
                    'title' =>  elgg_echo('activity:task'). ": ".$task->name,
                    'text' => '',
                    'style' => "opacity: 0.7;".($activity_progress > $task_progress ? "color:#fff;": ""),
                    'class' => 'fa fa-exclamation',
                    'href' => "clipit_activity/{$activity->id}/tasks/view/{$task->id}",
                ));
                ?>
            </div>
        <?php endforeach;?>
    </div>
    <small class="show margin-top-5">
        <strong><?php echo elgg_echo('start');?>: </strong>
        <?php echo elgg_view('output/friendlytime', array('time' => $activity->start));?>
        <span class="pull-right">
        <strong><?php echo elgg_echo('end');?>: </strong>
            <?php echo elgg_view('output/friendlytime', array('time' => $activity->end));?>
    </span>
    </small>
</div>
<p>
    <?php echo elgg_view('output/url', array(
        'title' => elgg_echo('expand:all'),
        'text' => elgg_echo('expand:all'),
        'href' => "javascript:;",
        'id' => 'panel-expand-all',
    ));
    ?>
    <span class="text-muted">|</span>
    <?php echo elgg_view('output/url', array(
        'title' => elgg_echo('collapse:all'),
        'text' => elgg_echo('collapse:all'),
        'href' => "javascript:;",
        'id' => 'panel-collapse-all',
    ));
    ?>
</p>
<?php if($groups):?>
    <div class="panel-group" id="gr_accordion">
        <?php
        foreach($groups as $group):
            $group_progress = get_group_progress($group->id);
        ?>
            <div class="panel panel-blue">
                <div class="panel-heading expand group-info" data-group="<?php echo $group->id;?>">
                    <small class="pull-right">
                        <div class="progressbar-mini progressbar-blue inline-block">
                            <div data-value="<?php echo $group_progress;?>" style="width: <?php echo $group_progress;?>%"></div>
                        </div>
                        <strong class="inline-block blue margin-left-5"><?php echo $group_progress;?>%</strong>
                    </small>
                    <h4 class="margin-0">
                        <a data-toggle="collapse" class="show" data-parent="#gr_accordion" href="#gr_<?php echo $group->id;?>">
                            <?php echo $group->name;?>
                        </a>
                    </h4>
                </div>
                <div id="gr_<?php echo $group->id;?>" class="panel-collapse collapse">
                    <div class="panel-body group-content"></div>
                </div>
            </div>
        <?php endforeach;?>
    </div>
<?php endif;?>