<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   11/07/14
 * Last update:     11/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
?>
<script>
$(function(){
    $(document).on("click", "#reload",function(){
        //var step_forms = ".step input:not([type='button']), .step select";
        var step_forms = "input:not([type='button']), select, textarea";
        $(".step").each(function(){
            var step_num = parseInt($(this).attr("id").replace("step_", ""));

            $($(this).find(step_forms)).each(function(){
                var label = $(this).parent("div").find("label");
                var content = '<div class="col-md-4 text-right text-muted"><strong>'+label.text()+'</strong></div>';
                content += '<div class="col-md-8">'+$(this).val()+'</div>';
//                if($(this).val() != '' && label.text() != ''){
//                    $("#step_1_data").append(content);
//                }
                switch (step_num){
                    case 1:
                        var content = step_1_data($(this));
                        $("#step_1_data").append(content);
                        break;
                    case 2:
                        var content = step_2_data($(this));
                        $("#step_2_data").append(content);
                        break;
                    case 3:
                        var content = step_3_data($(this));
                        $("#step_3_data").append(content);
                        break;
                }
                console.log($(this).val());
            });
        });

    });
    var step_1_data = function(that){
        // Activity setup
        var label = that.parent("div").find("label");
        var value = that.val();
        if(that.attr("id") == 'tricky_topic_list'){
            value = that.find("option:selected").text();
        }
        var content = '<div class="col-md-4 text-right text-muted"><strong>'+label.text()+'</strong></div>';
        content += '<div class="col-md-8">'+value+'</div>';
        return content;
    }
    var step_2_data = function(that){
        // Tasks
        var label = that.parent("div").find("label");
        var value = that.val();
        if(that.attr("name") == 'task-type[]'){
            value = that.find("option:selected").text();
        }
        if(that.attr("name") == 'feedback[]'){
            label = that.parent("label");
            if(that.is(":checked")){
                value = "Yes";
            } else {
                value = "No";
            }
        }
        //if(that.closest(".task").find(".feedback-module input[name='feedback[]']").is(":checked"))
        if(
//            !that.closest('.feedback_form').is(":hidden")
            that.closest(".task").find(".feedback-module input[name='feedback[]']").is(":checked")
            ){
            var content = '<div class="col-md-4 text-right text-muted"><strong>'+label.text()+'</strong></div>';
            content += '<div class="col-md-8">'+value+'</div>';
            if(that.attr("name") == 'feedback[]'){
                content += '<div class="col-md-12"><hr></div>';
            }
        }
        return content;
    }
    var step_3_data = function(object){
        // Students & Groups
        var label = object.parent("div").find("label");
        var content = '<div class="col-md-4 text-right text-muted"><strong>'+label.text()+'</strong></div>';
        content += '<div class="col-md-8">'+object.val()+'</div>';
        return content;
    }
    //
//    $("input[name='activity-title'").val("Teorias del hiperenlace");
//    $("input[name='activity-start'").val("21/07/2014");
//    $("input[name='activity-end'").val("28/07/2014");
//    $("input[name='video-description'").val("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam sit amet dui ac odio rutrum mollis non nec mauris. Aliquam pellentesque est sodales leo suscipit");
//    $("input[name='activity-tricky-topic'").val("2455");
});
</script>
<a id="reload">RELOAD</a>
<div id="summary" class="row step" style="display: none">
    <div class="col-md-12">
        <h3 class="title-block"><?php echo elgg_echo('summary');?></h3>
        <div class="col-md-6">
            <h4><?php echo elgg_echo('activity:setup');?></h4>
            <div class="row" id="step_1_data">
<!--                <div class="col-md-3 text-right text-muted"><strong>--><?php //echo elgg_echo("activity:title");?><!--</strong></div>-->
<!--                <div class="col-md-6">PEPADKSOADA</div>-->
            </div>
            <h4><?php echo elgg_echo('tasks');?></h4>
            <div class="row" id="step_2_data"></div>
        </div>
    </div>
</div>