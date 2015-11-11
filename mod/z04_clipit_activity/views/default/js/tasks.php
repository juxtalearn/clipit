<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   23/07/14
 * Last update:     23/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
?>
//<script>
elgg.provide('clipit.task');
elgg.provide('clipit.task.admin');
clipit.task.init = function() {
    $(document).on("click", ".feedback-check", clipit.task.feedbackCheck);
    $(document).on("click", "#add_task", clipit.task.addTask);
    // Task templates
    $(document).on("change", "#select-task-template", clipit.task.loadTemplate);

    // Rubric task
    $(document).on("click", ".rubric-refresh", clipit.task.rubricRefreshList);
    $(document).on("click", ".rubric-select", clipit.task.rubricSelect);
    $(document).on("click", ".rubric-unselect", clipit.task.rubricUnselect);
    // Quiz task
    $(document).on("click", ".quiz-refresh", clipit.task.quizRefreshList);
    $(document).on("click", ".quiz-select", clipit.task.quizSelect);
    $(document).on("click", ".quiz-unselect", clipit.task.quizUnselect);

    $(document).on("click", ".btns-task-select .thumbnail:not(.selected)", clipit.task.onSelect);
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
        feedback_content.show().find('.task-type-container').fadeIn('fast');
//        feedback_content
//            .show()
//            .find(".input-task-title")
//            .focus();
        // Show rubric list
        clipit.task.rubricList(feedback_content);
    } else {
        feedback_content.hide();
    }
};

clipit.task.rubricList = function($task){
    var container = $task.find(".rubric-select-list"),
        input_prefix = $task.find("input[name='input_prefix']"),
        input_prefix_val = '';
    if(input_prefix.length > 0){
//        input_prefix_val = input_prefix.val()+'[feedback-form]';
        input_prefix_val = input_prefix.val();
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

clipit.task.quizRefreshList = function(){
    clipit.task.refresh($(this).closest('.task'));
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
    clipit.task.refresh($(this).closest('.task'));
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
clipit.task.selectTest = function(hook, type, params, value){
    if(params.type == '<?php echo ClipitTask::TYPE_QUIZ_TAKE;?>'){
        var $task = params.element,
            $container = params.container;

        elgg.get('ajax/view/quiz/list', {
            data: {
                'activity_create': true,
                'tricky_topic': params.tricky_topic,
                'input_prefix': params.input_prefix
            },
            success: function (data) {
                $container.html(data).show();
            }
        });
    }
    return value;
};
elgg.register_hook_handler('clipit:task:type', 'system', clipit.task.selectTest);

clipit.task.selectResource_download = function(hook, type, params, value){
    if(params.type == '<?php echo ClipitTask::TYPE_RESOURCE_DOWNLOAD;?>'){
        var $task = params.element,
            $container = params.container;
        elgg.get('ajax/view/multimedia/attach/list', {
            success: function (data) {
                $container.html(data).show();
                var $attach_list = $container.find('.attach_list');
                $attach_list.show();
                $attach_list.attach_multimedia({
                    data: {
                        'entity_id': (params.entity_id ? params.entity_id : params.tricky_topic),
                        'input_prefix': params.input_prefix
                    }
                }).loadBy("files");
            }
        });

    }
    return value;
};
elgg.register_hook_handler('clipit:task:type', 'system', clipit.task.selectResource_download);

clipit.task.selectOther = function(hook, type, params, value){
    if(params.type == '<?php echo ClipitTask::TYPE_OTHER;?>'){
        var $task = params.element,
            $container = params.container;
        $container.html('').hide();
    }
    return value;
};
elgg.register_hook_handler('clipit:task:type', 'system', clipit.task.selectOther);

clipit.task.selectVideo_upload = function(hook, type, params, value){
    if(params.type == '<?php echo ClipitTask::TYPE_VIDEO_UPLOAD;?>'){
        var $task = params.element,
            $container = params.container,
            $feedback_task = $task.find('.feedback_task');
        $container.hide();
        $task.find('.feedback-module').fadeIn('fast');
        $feedback_task.find('.feedback-task-type').val('<?php echo ClipitTask::TYPE_VIDEO_FEEDBACK;?>');
    }
    return value;
};
elgg.register_hook_handler('clipit:task:type', 'system', clipit.task.selectVideo_upload);

clipit.task.selectFile_upload = function(hook, type, params, value){
    if(params.type == '<?php echo ClipitTask::TYPE_FILE_UPLOAD;?>'){
        var $task = params.element,
            $container = params.container,
            $feedback_task = $task.find('.feedback_task');
        $container.hide();
        $task.find('.feedback-module').fadeIn('fast');
        $feedback_task.find('.feedback-task-type').val('<?php echo ClipitTask::TYPE_FILE_FEEDBACK;?>');
    }
    return value;
};
elgg.register_hook_handler('clipit:task:type', 'system', clipit.task.selectFile_upload);

clipit.task.onSelect = function(e){
    e.preventDefault();
    var task_type = $(this).data('task-type'),
        $form = $(this).closest('form'),
        $task = $(this).closest('.task'),
        $container = $task.find(".main_task .task-type-container"),
        defaults = {
            'id': $(this).data('task-type').replace('#', ''),
            'element': $task,
            'type': task_type,
            'container': $container
        },
        data = {};
    // default settings
    $container.hide().html('');
    if(task_type != '<?php echo ClipitTask::TYPE_VIDEO_UPLOAD;?>' && task_type != '<?php echo ClipitTask::TYPE_FILE_UPLOAD;?>') {
        $task.find('.feedback-module').hide();
        $task.find('.feedback-module').find('input').prop('checked', false);
        $task.find('.feedback_form').hide();
    }

    $(this).find('input[type="radio"]').prop('checked', true);

    if($("#tricky-topic").val() != ''){
        data.tricky_topic = $("#tricky-topic").val();
    }
    if($task.find("input[name='input_prefix']").length > 0){
        data.input_prefix = $task.find("input[name='input_prefix']").val();
    }
    if($form.find("input[name='entity-id']").length > 0){
        data.entity_id = $form.find("input[name='entity-id']").val();
    }

    var params = $.extend({}, defaults, data);
    $(this).closest('.btns-task-select').find('.thumbnail.active').removeClass('active');
    $(this).addClass('active');
    $container.fadeIn('fast').html('<i class="fa fa-spinner fa-spin fa-2x blue"></i>');
    // Advanced options
    var $options_container = $task.find('.task-advanced-options'),
        $options = $options_container.filter('[data-options="'+ task_type +'"]');
    $options_container.find('.task-advanced-options-collapse').addClass('collapse').removeClass('in');
    $options_container.hide().find('.select-options').hide();
    if($options.length > 0){
        $options_container.fadeIn('slow');
        $options.show();
    }
    // Trigger task type event
    elgg.trigger_hook('clipit:task:type', 'system', params, "");
};
clipit.task.refresh = function($task){
    $task.find('.btns-task-select .active').click();
};

var task_template = [];
clipit.task.getTemplates = function(){
    task_template = elgg.trigger_hook('clipit:task:template', 'system');
    for(name in task_template){
        $('#select-task-template').append('<option value="'+ name +'">'+ task_template[name].name[elgg.get_language()] +'</option>');
    }
};
clipit.task.echoTemplate = function(message){
    var language = elgg.get_language(),
        default_language = 'en';
    if(message[language] == undefined){
        return message[default_language];
    }
    return message[language];
};
clipit.task.countTemplateTasks = function(json){
    var count = 0;
    for (i in json.tasks){
        count++;
        if(json.tasks[i].feedback != undefined) {
            count++;
        }
    }
    return count;
};
clipit.task.setTemplateDates = function(date, $element_start, $element_end){
    var start_minutes = Math.floor(moment.unix(date.start).minute()/15)*15,
        end_minutes = Math.floor(moment.unix(date.end).minute()/15)*15;
    $element_start.val(moment.unix(date.start).minute(start_minutes).format('DD/MM/YYYY HH:mm'))
    $element_end.val(moment.unix(date.end).minute(end_minutes).format('DD/MM/YYYY HH:mm'));
};

clipit.task.loadTemplate = function(){
    var name = $(this).val();
    var content = $(".task-list"),
        total_tasks = clipit.task.countTemplateTasks(task_template[name]),
        start = $('input[name="activity-start"]').val(),
        end = $('input[name="activity-end"]').val(),
        diff = (moment(end, 'DD/MM/YYYY').hour(23).minute(59).unix() - moment(start, 'DD/MM/YYYY').minute(15).unix())/total_tasks;

    content.html('');
    var task_start = moment(start, 'DD/MM/YYYY').minute(15).unix();

    $.each(task_template[name].tasks, function (key, data) {
        var loading = $('<li class="list-item"><i class="fa fa-spinner fa-spin fa-2x blue-lighter" style="padding:15px;"/></li>').appendTo(content);
        $.get( "ajax/view/activity/create/task_list", function( result ) {
            loading.remove();
            var $task = $(result).appendTo(content),
                $main_task = $task.find('.main_task')
                date = {};
            $main_task.find('.input-task-title').val(clipit.task.echoTemplate(data.name));
            $main_task.find('.input-task-description').val(clipit.task.echoTemplate(data.description));
            $main_task.find('[data-task-type="'+ data.task_type +'"]').trigger('click');

            date.start = task_start,
            date.end = task_start + diff,
            task_start = date.end;
            clipit.task.setTemplateDates(date, $main_task.find('.input-task-start'), $main_task.find('.input-task-end'));

            // If feedback exists
            if(data.feedback != undefined){
                $task.find('.feedback-check input')
                    .prop('checked', true)
                    .closest('.feedback-check').trigger('click');
                var data_feedback = data.feedback,
                    $feedback_task = $task.find('.feedback_task');
                $feedback_task.find('.input-task-title').val(clipit.task.echoTemplate(data_feedback.name));
                $feedback_task.find('.input-task-description').val(clipit.task.echoTemplate(data_feedback.description));
                $feedback_task.find('[data-task-type="'+ data_feedback.task_type +'"]').trigger('click');
                date.start = task_start,
                date.end = task_start + diff,
                task_start = date.end;
                clipit.task.setTemplateDates(date, $feedback_task.find('.input-task-start'), $feedback_task.find('.input-task-end'));
            }

        });
    });
};