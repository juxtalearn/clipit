<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   7/07/14
 * Last update:     7/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
elgg_load_js("jquery:dynatable");
?>
<script>
$(function(){
    $(document).on("change", "#tricky-topic", function(){
        var content = $("#tricky_topic_view");
        if($(this).val() == 0){
            content.hide();
            return false;
        }
        content.show().html('<i class="fa fa-spinner fa-spin blue"></i>');
        $.ajax({
            url: elgg.config.wwwroot+"ajax/view/tricky_topic/list",
            type: "POST",
            data: {
                tricky_topic : $(this).val(),
                show_tags: 'list'
            },
            success: function(html){
                content.html(html);
            }
        });
    });
    $(document).on("click", "#save-tricky-topic", function(){
        var container  = $("#form-tricky-topic"),
            form = container.find("#form-add-tricky-topic"),
            form_data = elgg.security.addToken($.param(form.find(":input").serializeArray())).replace("?", "&");
        if(!form.find(':input').valid()){
            return false;
        }
        container.html($("<i class='fa fa-spinner fa-2x fa-spin blue'/>"));
        elgg.action('tricky_topic/save', {
            data: form_data,
            success: function(json){
                container.html(json.output)
                container.find("option:selected").change();
            }
        });
    });
    $(document).on("click", "#add-tricky-topic", function(){
        $(this).parent("div").toggleClass("hide");
        $("#select-tricky-topic").toggle();
        $("#form-add-tricky-topic").toggle().find("input:first").focus();
    });
    $(document).on("click", "#next_step", function(){
        var form = $("#form-tricky-topic");
        if(form.is(":visible")){
            form.find("#save-tricky-topic").click();
        }
    });
    // Advanced options
    $('#input-activity-open').click(function(){
        $('.grouping-mode').hide();
    });
    $('#input-activity-closed').click(function(){
        $('.grouping-mode').show();
    });
});
</script>
<style>
    ul.ui-menu.ui-autocomplete{
        background-color: #fff;
        cursor: default;
        font-size: 14px;
        -webkit-box-shadow: 0 6px 12px rgba(0,0,0,0.2);
        box-shadow: 0 6px 12px rgba(0,0,0,0.2);
        padding: 3px;
        max-width: 350px;
    }
    ul.ui-menu.ui-autocomplete li {
        border-bottom: 1px solid #eee;
    }
    ul.ui-menu.ui-autocomplete li:last-child {
        border-bottom: 0;
    }
    ul.ui-menu.ui-autocomplete li > a {
        display: block;
        padding: 3px;
        padding-left: 10px;
        font-weight: bold;
    }
    ul.ui-menu.ui-autocomplete li:hover > a, ul.ui-menu.ui-autocomplete li >a.ui-state-focus{
        color: #fff;
        text-decoration: none;
        background: #32b4e5;
    }
</style>
<script>
    var datepicker_setup = function(){
        var activity_form = $("#activity-create");
        $(".activity-date").datepicker({
            firstDay: 1,
            minDate: activity_form.find("input[name=activity-start]").val(),
            maxDate: activity_form.find("input[name=activity-end]").val(),
            onClose: function (text, inst) {
                $(activity_form
                    .find(".input-task-start, .input-task-end, input[name='activity-end']"))
                    .datepicker( "option", "minDate", activity_form.find("input[name=activity-start]").val());
                if($(this).hasClass('input-task-start')){
                    var $task_end = $(this).closest('.task').find('.input-task-end'),
                        task_start_val = $(this).val();
                    $task_end.datepicker( "option", "minDate", task_start_val);
                }
                $(activity_form
                    .find(".input-task-start, .input-task-end, input[name='activity-start']"))
                        .datepicker( "option", "maxDate", activity_form.find("input[name=activity-end]").val() );
            }
        });
    }
$(function(){
    datepicker_setup();
    $(".nav-steps li").on("click", function(e) {
            e.preventDefault();
            return false;

    });
    $(document).on("click", ".button_step, .nav-steps a",function(){
        // Step 4 (Make groups) empty
        $("#nav-step-4").hide();
        $("#step_4").html('');
        var step = $(this).data("step");
        var current_step = parseInt($(".step:visible").attr("id").replace("step_", ""));
        // is validated
        if(($(this).attr("id") == 'next_step' || $(this).attr("id") == 'back_step')  || step > current_step){
            if(!$("#activity-create").valid()){
                return false;
            }
        }
        if(step > 0){
            $(".nav-steps li").removeClass('disabled');
            if(step == 2 && $('.task-list li').length == 0){
                $("#add_task").click();
            }
        } else {
            $(".nav-steps li").slice(2,4).addClass('disabled');
        }
        $(".nav-steps li").removeClass("active");
        $("#nav-step-"+ step).parent("li").addClass("active");
        $(this).closest(".container").find(".step").hide();
        $("#step_"+ step).fadeIn();

    });
    $(window).bind('beforeunload', function(){
        return '<?php echo elgg_echo('exit:page:confirmation');?>';
    });
    $(document).on("click", '#finish_setup', function(e){
        if(!$("#activity-create").valid()){
            return false;
        }
        $(window).unbind('beforeunload');
    });
});
</script>
<div id="step_1" style="display: none;" class="row step">
    <div class="col-md-6" id="form-tricky-topic">
        <?php echo elgg_view("activity/create/tricky_topics");?>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="activity-title"><?php echo elgg_echo("activity:title");?></label>
            <?php echo elgg_view("input/text", array(
                'name' => 'activity-title',
                'class' => 'form-control',
                'autofocus' => true,
                'required' => true
                ));
            ?>
        </div>
        <div class="row">
            <div class="col-md-4">
                <label for="activity-start"><?php echo elgg_echo("activity:start");?></label>
                <?php echo elgg_view("input/text", array(
                    'name' => 'activity-start',
                    'class' => 'form-control datepicker activity-date',
                    'required' => true,
                    'data-rule-regex' => '(.{2})\/(.{2})\/(.{4})$',
                    'data-msg-regex' => 'dd/mm/yyyy',
                ));
                ?>
            </div>
            <div class="col-md-4">
                <label for="activity-end"><?php echo elgg_echo("activity:end");?></label>
                <?php echo elgg_view("input/text", array(
                    'name' => 'activity-end',
                    'class' => 'form-control datepicker activity-date',
                    'required' => true,
                    'data-rule-regex' => '(\w{2})\/(\w{2})\/(\w{4})$',
                    'data-msg-regex' => 'dd/mm/yyyy',
                ));
                ?>
            </div>
        </div>
        <div class="form-group margin-top-10">
            <label for="activity-description"><?php echo elgg_echo("description");?></label>
            <?php echo elgg_view("input/plaintext", array(
                'name'  => 'activity-description',
                'class' => 'form-control',
                'required' => true,
                'rows'  => 6,
                ));
            ?>
        </div>
        <div>
            <a data-toggle="collapse" href="#activity-advanced-options">
                <strong><i class="fa fa-cog"></i> <?php echo elgg_echo('options:advanced');?></strong>
            </a>
            <div class="collapse margin-top-10" id="activity-advanced-options">
                <?php echo elgg_view('forms/activity/admin/options');?>
            </div>
        </div>
    </div>

    <div class="col-md-12 text-right margin-top-20">
        <hr>
        <?php echo elgg_view('input/button', array(
            'value' => elgg_echo('back'),
            'data-step' => 0,
            'id' => 'back_step',
            'class' => "btn btn-primary btn-border-blue pull-left button_step",
        ));
        ?>
        <?php echo elgg_view('input/button', array(
                'value' => elgg_echo('next'),
                'data-step' => 2,
                'id' => 'next_step',
                'class' => "btn btn-primary button_step",
            ));
        ?>
    </div>
</div>