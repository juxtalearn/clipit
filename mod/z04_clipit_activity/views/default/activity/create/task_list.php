<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   7/07/14
 * Last update:     7/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$id = uniqid();
?>
<script>
$(function(){
//   datepicker_setup();
    $("[data-task='<?php echo $id;?>'] .datepicker").each(function() {
        var defaults = {hour: 0, minute: 0};
        if($(this).hasClass('input-task-end')){
            defaults = {hour: 23, minute: 45};
        }
        var activity_start = moment($('input[name="activity-start"').val(), 'DD/MM/YYYY').format('DD/MM/YY'),
            activity_end = moment($('input[name="activity-end"').val(), 'DD/MM/YYYY').format('DD/MM/YY');
        $(this).datetimepicker(clipit.datetimepickerDefault(
            $.extend(defaults, {
                minDate: activity_start ,
                maxDate: activity_end,
                timeText: "<?php echo elgg_echo('time');?>",
                closeText: "<?php echo elgg_echo('accept');?>"
            })
        ));
    });
});
</script>
<li class="list-item col-md-12 task" data-task="<?php echo $id;?>">
    <?php echo elgg_view('activity/create/task', array('task_type' => 'upload', 'id' => $id, 'required' => false));?>
    <ul class="feedback_form" style="margin-left: 20px;display: none">
        <li style="padding: 10px;background: #fafafa;" class="col-md-12">
            <div class="col-mds-12">
                <h4><?php echo elgg_echo('task:feedback');?></h4>
            </div>
            <?php echo elgg_view('activity/create/task', array('task_type' => 'feedback', 'id' => $id));?>
        </li>
    </ul>
</li>
