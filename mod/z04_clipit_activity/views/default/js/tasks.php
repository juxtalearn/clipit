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
?>
$(document).on("click", ".feedback-check",function(){
    var parent = $(this).closest(".task");
    var feedback_content = parent.find(".feedback_form");
    if($(this).find("input").is(':checked')){
        var task_end = parent.find(".input-task-end").val();
        if(task_end.length > 0){
            feedback_content.find(".input-task-start").val(task_end);
        }
        feedback_content
        .show()
        .find(".input-task-title")
        .focus();
    } else {
        feedback_content.hide();
    }
});

$(document).on("change", ".task-types",function(){
    var task_types = ['video_upload', 'storyboard_upload'];
    var content = $(this).closest(".task");
    content_feedback = content.find(".feedback-module");
    if($.inArray($(this).val(), task_types) != -1){
        switch($(this).val()){
            case "video_upload":
                content.find('.feedback_form .task-types').val('video_feedback');
                break;
            case "storyboard_upload":
                content.find('.feedback_form .task-types').val('storyboard_feedback');
                break;
        }
        content_feedback.show();
    } else {
        content_feedback.hide();
        content.find('.feedback_form').hide();
        content_feedback.find("input[type=checkbox]").prop('checked', false);
    }
    content.find(".quiz-module").hide();
    if($(this).val() == 'quiz_take'){
        content.find(".quiz-module").show();
    }
});
$(document).on("click", "#add_task",function(){
    var content = $(".task-list");
    $.get( "ajax/view/activity/create/task_list", function( data ) {
        content.append(data);
    });
});