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
//<script>
elgg.provide('clipit.task');
elgg.provide('clipit.task.admin');
clipit.task.init = function() {
    $(document).on("click", ".feedback-check", clipit.task.feedbackCheck);
    $(document).on("click", "#add_task", clipit.task.addTask);
    $(document).on("change", ".task-types", clipit.task.types);
    // Rubric task
    $(document).on("click", ".rubric-refresh", clipit.task.rubricRefreshList);
    $(document).on("click", ".rubric-select", clipit.task.rubricSelect);
    $(document).on("click", ".rubric-unselect", clipit.task.rubricUnselect);
    // Quiz task
    $(document).on("click", ".quiz-refresh", clipit.task.quizRefreshList);
    $(document).on("click", ".quiz-select", clipit.task.quizSelect);
    $(document).on("click", ".quiz-unselect", clipit.task.quizUnselect);
};
elgg.register_hook_handler('init', 'system', clipit.task.init);
clipit.task.admin.init = function() {
};
elgg.register_hook_handler('init', 'system', clipit.task.admin.init);


clipit.task.admin.fullCalendarSetDefault = function(){
    return  {
        monthNames: JSON.parse(elgg.echo('calendar:month_names')),
        monthNamesShort: JSON.parse(elgg.echo('calendar:month_names_short')),
        dayNames: JSON.parse(elgg.echo('calendar:day_names')),
        dayNamesShort: JSON.parse(elgg.echo('calendar:day_names_short')),
        dayNamesMin: JSON.parse(elgg.echo('calendar:day_names_min')),
        buttonText: {
            month: elgg.echo('calendar:month'),
            week: elgg.echo('calendar:week'),
            day: elgg.echo('calendar:day'),
            list: elgg.echo('calendar:agenda')
        }
    };
};

clipit.task.feedbackCheck = function(){
    var parent = $(this).closest(".task"),
        feedback_content = parent.find(".feedback_form"),
        that = $(this);
    if($(this).find("input").is(':checked')){
        var task_end = parent.find(".input-task-end").val();
        if(task_end.length > 0){
            task_end = moment(task_end, 'DD/MM/YY').hour(0).minute(0).format('DD/MM/YY HH:mm');
            feedback_content.find(".input-task-start").val(task_end);
        }
        feedback_content
            .show()
            .find(".input-task-title")
            .focus();
        // Show rubric list
        clipit.task.rubricList(parent);
    } else {
        feedback_content.hide();
    }
};

clipit.task.rubricList = function($task){
    var container = $task.find(".rubric-select-list"),
        input_prefix = $task.find("input[name='input_prefix']"),
        input_prefix_val = '';
    if(input_prefix.length > 0){
        input_prefix_val = input_prefix.val()+'[feedback-form]';
    }
    container.html('<i class="fa fa-spinner fa-spin fa-2x blue"></i>').fadeIn('fast');
    elgg.get('ajax/view/rubric/list', {
        data: {
            'select': true,
            'input_prefix': input_prefix_val
        },
        success: function (data) {
            container.html(data);
        }
    });
};
clipit.task.rubricRefreshList = function(){
    clipit.task.rubricList($(this).closest('.task'));
};
clipit.task.rubricSelect = function(){
    var task_container = $(this).closest('.rubric-select-list'),
        rubric_id = $(this).closest('tr').attr('id');
    task_container.find('table tr').not('#'+ rubric_id).fadeOut(300, function(){$(this).remove();});
    task_container.find('.input-rubric-id').val(rubric_id);
    // Change button to unselect type
    $(this).removeClass('rubric-select')
        .addClass('rubric-unselect btn-border-red')
        .text(elgg.echo('btn:remove'));
};
clipit.task.rubricUnselect = function(){
    clipit.task.rubricList($(this).closest('.task'));
};

clipit.task.types = function(){
    var task_types = ['video_upload', 'storyboard_upload'];
    var content = $(this).closest(".task");
    var that = $(this);
    content_feedback = content.find(".feedback-module");
    var tricky_topic_val = '',
        input_prefix_val = '';
    if($("#tricky-topic").val()){
        tricky_topic_val = $("#tricky-topic").val();
    }
    var input_prefix = content.find("input[name='input_prefix']");
    if(input_prefix.length > 0){
        input_prefix_val = input_prefix.val();
    }
    content.find(".task-type-container").html('').hide();
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
    var $attach_list =  that.closest(".task").find(".attach_list");
    if($(this).val() == '<?php echo ClipitTask::TYPE_RESOURCE_DOWNLOAD;?>'){
        var entity_id = tricky_topic_val;
        if(that.closest("form").find("input[name='entity-id']").length > 0){
            var entity_id = that.closest("form").find("input[name='entity-id']").val();
            input_prefix_val = '';
        }
        $attach_list.toggle();
        $attach_list.attach_multimedia({
            data: {
                'entity_id': entity_id,
                'input_prefix': input_prefix_val
            }
        }).loadBy("files");
    } else {
        $attach_list.hide();
    }
    content.find(".quiz-module").hide();
    if($(this).val() == 'quiz_take'){
        content.find(".quiz-module").show();
        content.find(".task-type-container").fadeIn('fast').html('<i class="fa fa-spinner fa-spin fa-2x blue"></i>');
        elgg.get('ajax/view/quiz/list', {
            data: {
                'activity_create': true,
                'tricky_topic': tricky_topic_val,
                'input_prefix': input_prefix_val
            },
            success: function (data) {
                content.find(".task-type-container").html(data).show();
            }
        });
    }

};
clipit.task.quizRefreshList = function(){
    $(this).closest('.task').find('.task-types').trigger('change');
};

clipit.task.quizSelect = function(){
    var task_container = $(this).closest('.task-type-container'),
        quiz_id = $(this).closest('tr').attr('id');
    task_container.find('table tr').not('#'+ quiz_id).fadeOut(300, function(){$(this).remove();});
    task_container.find('.input-quiz-id').val(quiz_id);
    // Change button to unselect type
    $(this).removeClass('quiz-select')
        .addClass('quiz-unselect btn-border-red')
        .text(elgg.echo('btn:remove'));
};
clipit.task.quizUnselect = function(){
    var task_container = $(this).closest('.task-type-container');
    task_container.closest('.task').find('.task-types').trigger('change');
};
clipit.task.addTask = function(){
    var content = $(".task-list"),
        loading = $('<i class="fa fa-spinner fa-spin fa-2x blue-lighter" style="padding:15px;"/>').appendTo(content);
    $.get( "ajax/view/activity/create/task_list", function( data ) {
        loading.remove();
        content.append(data);
    });
};

// Admin task functions
clipit.task.admin.fullCalendar = function(data){
    return $.extend(data.messages, {
        firstDay: 1,
            header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        eventAfterAllRender: function(){
            var content = $(".fc-header-left, .fc-header-right");
            content.find('.fc-header-space').remove();
            content.removeClass().addClass("btn-group btn-group-sm")
                .find('.fc-button').removeClass()
                .addClass("btn btn-default btn-border-blue");
            content.find('.fc-icon-right-single-arrow').removeClass().addClass("fa fa-caret-right")
            content.find('.fc-icon-left-single-arrow').removeClass().addClass("fa fa-caret-left");
            $(".fc-header td:eq(0)").addClass('pull-left');
            $(".fc-header td:eq(2)").addClass('pull-right');
        },
        editable: false,
        events: data.events,
        eventRender: function(event, element) {
            $(element).find(".fc-event-inner").prepend($(event.icon).removeClass('blue').addClass('margin-right-10 margin-left-5'));
        },
        eventClick: function(event, calEvent, jsEvent, view, element) {
            $("[data-target='#edit-task-"+event.id+"']").click();
        },
        dayRender: function(date, cell) {
            var date_formated = date.add(-2, 'hours').format("X"); // Added -2hours T00:00:00
            var data_start = data.start-(60*60*4);
            if(date_formated >= data_start && date_formated <= data.end ){
                $(cell).addClass('fc-ranged');
            }
        },
        dayClick: function(date, jsEvent, view) {
            var date_formated = date.add(+2, 'hours').format("X"); // Added +2hours T00:00:00
            var data_end = data.end+(60*60*4);
            if(date_formated >= data.start && date_formated <= data_end ){
                date.hour(0).minute(0);
                var new_task_modal = $("#create-new-task");
                new_task_modal.modal('show');
                new_task_modal.find(".input-task-start").val(date.format('DD/MM/YY HH:mm'));
                new_task_modal.find(".input-task-end").val('');
            } else {
                return false;
            }
        }
    });
};