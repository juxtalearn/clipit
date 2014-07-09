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
$tricky_topics = ClipitTrickyTopic::get_all(10);
$tt = array('Select tricky topic');
foreach($tricky_topics as $tricky_topic){
    $tt[$tricky_topic->id] = $tricky_topic->name;
}
?>
<script>
$(function(){
    $("#tricky_topic_list").change(function(){
        var content = $("#tricky_topic_view");
        if($(this).val() == 0){
            content.hide();
            return false;
        }
        content.show().html('<i class="fa fa-spinner fa-spin blue"></i>');
        $.ajax({
            url: elgg.config.wwwroot+"ajax/view/tricky_topic/list",
            type: "POST",
            data: { tricky_topic : $(this).val()},
            success: function(html){
                content.html(html);
            }
        });
    });
});
</script>
<script>
    var datepicker_setup = function(){
        var activity_form = $("#activity-create");
        $(".datepicker").datepicker({
            minDate: activity_form.find("input[name=activity-start]").val(),
            onClose: function (text, inst) {
                $(activity_form
                    .find("input[name='task-start[]'], input[name='task-end[]'], input[name='activity-end']"))
                        .datepicker( "option", "minDate", activity_form.find("input[name=activity-start]").val() );
                $(activity_form
                    .find("input[name='task-start[]'], input[name='task-end[]'], input[name='activity-start']"))
                        .datepicker( "option", "maxDate", activity_form.find("input[name=activity-end]").val() );

//                var parent = $(this).closest("li");
//                if($(this).attr("name") == 'task-start[]'){
//                    $(parent.find("input[name='task-end[]']")).datepicker( "option", "minDate", text );
//                }

//                $(parent.find("input.datepicker")).each(function(){
//                    if($(this).val().length == 0){
//                        $(this).focus();
//                    }
//                });

            }
        });
    }
$(function(){
    datepicker_setup();
    $(".button_step, .nav-steps a").click(function(){
       var step = $(this).data("step");
        // is validated
//       if($(".elgg-form-activity-create").valid()){
            $(".nav-steps li").removeClass("active");
            $("#nav-step-"+ step).parent("li").addClass("active");
            $(this).closest(".container").find(".step").hide();
            $("#step_"+ step).fadeIn();
//       }

    });
});
</script>
<?php echo elgg_view('activity/create/step_3');?>
<div id="step_1" class="row step">
    <div class="col-md-12">
        <h3 class="title-block"><?php echo elgg_echo('activity:setup');?></h3>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="activity-title"><?php echo elgg_echo("activity:title");?></label>
            <?php echo elgg_view("input/text", array(
                'name' => 'activity-title',
                'class' => 'form-control',
                'required' => true
                ));
            ?>
        </div>
        <div class="row">
            <div class="col-md-4">
                <label for="activity-start"><?php echo elgg_echo("activity:start");?></label>
                <?php echo elgg_view("input/text", array(
                    'name' => 'activity-start',
                    'class' => 'form-control datepicker',
                    'required' => true
                ));
                ?>
            </div>
            <div class="col-md-4">
                <label for="task-end"><?php echo elgg_echo("activity:end");?></label>
                <?php echo elgg_view("input/text", array(
                    'name' => 'activity-end',
                    'class' => 'form-control datepicker',
                    'required' => true
                ));
                ?>
            </div>
        </div>
        <div class="form-group margin-top-10">
            <label for="activity-description"><?php echo elgg_echo("activity:description");?></label>
            <?php echo elgg_view("input/plaintext", array(
                'name'  => 'video-description',
                'class' => 'form-control mceEditor',
                'required' => true,
                'rows'  => 6,
                ));
            ?>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="activity-tricky-topic"><?php echo elgg_echo("activity:select:tricky_topic");?></label>
            <?php echo elgg_view('input/dropdown', array(
                'name' => 'activity-tricky-topic',
                'class' => 'form-control',
                'style' => 'padding-top: 5px;padding-bottom: 5px;',
                'id' => 'tricky_topic_list',
                'options_values' => $tt
                ));
            ?>
        </div>
        <div class="row margin-0" id="tricky_topic_view" style="display: none;background: #fafafa;padding: 10px;"></div>
    </div>
    <div class="col-md-12 text-right margin-top-20">
        <?php echo elgg_view('input/button', array(
                'value' => elgg_echo('next'),
                'data-step' => 2,
                'class' => "btn btn-primary button_step",
            ));
        ?>
    </div>
</div>