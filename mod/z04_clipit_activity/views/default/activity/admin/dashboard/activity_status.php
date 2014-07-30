<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   30/07/14
 * Last update:     30/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$activity = elgg_extract('entity', $vars);
$status = get_activity_status($activity->status);
?>
<script>
$(function(){
    $(".activity-datepicker").datepicker({
        minDate: '<?php echo date("d/m/Y", time());?>',
    });
});
</script>
<div class="row">
    <div class="col-md-3">
        <small class="show margin-bottom-5">Current status</small>
        <strong class="blue cursor-default">
            <i class="fa fa-<?php echo $status['icon'];?> <?php echo $status['color'];?>"></i>
            <?php echo $status['text'];?>
        </strong>
    </div>
    <div class="col-md-2">
        <small class="show margin-bottom-5">Change to</small>
        <?php echo elgg_view('output/url', array(
            'title' => elgg_echo('change_to') ." ". $status['text'],
            'text' => $status['btn_change_to'],
            'href' => "action/activity/admin/set_status?id={$activity->id}",
            'is_action' => true
        ));
        ?>
    </div>
    <div class="col-md-3">
        <small class="show margin-bottom-5">Start</small>
        <input type="text" class="activity-datepicker form-control" value="<?php echo date("d/m/Y", $activity->start);?>">
    </div>
    <div class="col-md-4">
        <small class="show margin-bottom-5">End</small>
        <div class="row">
            <div class="col-md-8">
                <input type="text" class="activity-datepicker form-control" value="<?php echo date("d/m/Y", $activity->end);?>">
            </div>
            <div class="col-md-4">
                <a class="btn btn-primary btn-xs" style="vertical-align: sub">Apply</a>
            </div>
        </div>
    </div>
</div>