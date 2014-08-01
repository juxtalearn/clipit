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
<script src="http://arshaw.com/js/fullcalendar-2.0.2/lib/moment.min.js"></script>
<script>
$(function(){
    $(".activity-datepicker").datepicker({
        //minDate: '<?php echo date("d/m/Y", time());?>',
    });
    $(document).on("click", ".change-status", function(){
        var status = $(this).data("status");
        switch(status){
            case 'active':
                $(this).parent("a").popover('show');
                var current_date = new Date().getTime();
                var days_ago = moment(current_date - (60*60*24*1*1000)).format("DD/MM/YYYY"); // 1 days ago
                $("#activity-start").val(days_ago).focus();
                break;
            case 'closed':
                $(this).parent("a").popover('show');
                var current_date = new Date().getTime();
                var days_ago = moment(current_date - (60*60*24*1*1000)).format("DD/MM/YYYY"); // 1 days ago
                $("#activity-end").val(days_ago).focus();
                break;
        }
    });
});
</script>
<?php echo elgg_view("input/hidden", array(
    'name' => 'entity-id',
    'value' => $activity->id,
));
?>
<?php echo elgg_view("input/hidden", array(
    'name' => 'calendar',
    'value' => 1,
));
?>
<div class="row">
    <div class="col-md-3">
        <small class="show margin-bottom-5"><?php echo elgg_echo('current_status');?></small>
        <strong class="blue cursor-default">
            <i class="fa fa-<?php echo $status['icon'];?> <?php echo $status['color'];?>"></i>
            <?php echo $status['text'];?>
        </strong>
    </div>
    <div class="col-md-2">
        <small class="show margin-bottom-5"><?php echo elgg_echo('change_to');?></small>
        <?php echo elgg_view('output/url', array(
            'title' => elgg_echo('change_to') .": ". $status['change_to'],
            'text' => $status['btn_change_to'],
            'data-toggle' => "popover",
            'style' => "display:block;",
            'rel' => "popover",
            'data-placement' => "bottom",
            'data-content' => "Lorem ipsum bla bla bla"
        ));
        ?>
    </div>
    <div class="col-md-3">
        <small class="show margin-bottom-5"><?php echo elgg_echo('start');?></small>
        <?php echo elgg_view("input/text", array(
            'name' => 'activity-start',
            'class' => 'form-control activity-datepicker',
            'id' => 'activity-start',
            'style' => 'padding: 0;margin: 0;height: 25px;padding-left: 10px;',
            'value' => date("d/m/Y", $activity->start),
        ));
        ?>
    </div>
    <div class="col-md-4">
        <small class="show margin-bottom-5"><?php echo elgg_echo('end');?></small>
        <div class="row">
            <div class="col-md-8">
                <?php echo elgg_view("input/text", array(
                    'name' => 'activity-end',
                    'class' => 'form-control activity-datepicker',
                    'id' => 'activity-end',
                    'style' => 'padding: 0;margin: 0;height: 25px;padding-left: 10px;',
                    'value' => date("d/m/Y", $activity->end),
                ));
                ?>
            </div>
            <div class="col-md-4">
                <?php
                echo elgg_view('input/submit', array(
                    'value' => elgg_echo('apply'),
                    'style' => 'vertical-align: sub',
                    'class' => "btn btn-primary btn-xs",
                ));
                ?>
            </div>
        </div>
    </div>
</div>