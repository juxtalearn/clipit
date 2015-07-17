<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   11/11/2014
 * Last update:     11/11/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
?>
//<script>
elgg.provide('clipit.quiz');

clipit.quiz.init = function() {
    $(".finish-quiz").click(clipit.quiz.finishConfirmation);
    $('.chart, .questions').on('show.bs.collapse', clipit.task.admin.quiz.showData);
    $('.print-data').click(clipit.task.admin.quiz.printData);
};
elgg.register_hook_handler('init', 'system', clipit.quiz.init);
clipit.quiz.translated = function(){
    return elgg.echo();
};
clipit.quiz.saveQuestion = function(e){
    var $element = $(this);
    if(arguments[0].object){
       $element = arguments[0].object;
    }
    if($element.attr("type") == 'checkbox'){
        var $element = $(".quiz input[type=checkbox]");
    }
    var form = $element.closest("form"),
        form_data = form.find($element.add("input:hidden")).serialize(),
        $container = $element.closest(".question")
        answers = $container.find('.question-answer');
    $container.find(".loading-question").show();
    $container.find(".num-question").hide();
    form.find('.finish-quiz').prop('disabled', true);
    answers.find(':input, textarea').prop('disabled', true);
    elgg.action('quiz/take',{
        data: form_data,
        success: function(json) {
            form.find('.finish-quiz').prop('disabled', false);
            answers.find(':input, textarea').prop('disabled', false);
            $container.find(".loading-question").hide();
            $container.find(".num-question").show();
            $("#count-result").text(json.output);
            // if finished
            if (json.output == 'finished'){
                window.location.href = '';
            }
        }
    });
};
clipit.quiz.finishConfirmation = function(e){
    e.preventDefault();
    var that = $(this),
        type = $(this).data('type'),
        $modal = $( $(this).data('target') );
        $modal.find('.modal-title').text($("#questions-result").text());
    if(type) {
        switch (type) {
            case 'finish':
                that.after('<input type="hidden" name="finish" value="true" />');
                break;
            case 'save':
                break;
        }
        that.closest('form').submit();
    }
};
clipit.quiz.create = function(options){
    var defaults = {};
    var opt =  $.extend({}, defaults, options),
        that = $(opt.quiz),
        $quiz = $(opt.quiz),
        $question = that.find('.question');
    $questions = that.find('.questions');

    function Question(object){
        var self = this;
        this.question;
        this.question_type_selected;
        this._init = function(){
            // Reorder questions
            self.getNum();
            // Trigger events
            self.question.find(".remove-question").on("click", function(){
                return self.delete();
            });
            self.question.find(".add-result").on("click", function(){
                self.question_type_selected = $(this).closest(".show-question");
                return self.addResult();
            });
            //self.question.find("input[type=radio]").on("click", function(){
            $(self.question).on("click", "input[type=radio]", function(){
                self.question.find(".results input[type=radio]").prop('checked', false);
                $(this).prop('checked', true);
            });
            // Tags chosen
            self.question.find(".tags-select").chosen({disable_search_threshold: 1});
            // jQuery UI slider
            self.difficultySlider( self.question.find(".difficulty-slider") );
            // Question types select
            self.question.find(".select-question-type").on("change", function(){
                var question_type = $("[data-question='"+$(this).val()+"']");
                self.question.find(".show-question").hide();
                if(self.question.find(question_type).length > 0) {
                    self.question.find(question_type).show();
                }
            });
            // Question Stumbling Blocks
            self.question.find(".select-all-tags").on("click", function(){
                var container = $(this).parent('div'),
                    isChecked = $(this).prop('checked');
                $(this).prop('disabled', true);
                container.find('input[type=checkbox]').click();
                container.find('input[type=checkbox]').prop('checked', isChecked);
                $(this).prop('disabled', false);
            });
            $(self.question).on("click", ".tags-list input[type=checkbox]", function(){
                var stumbling_block = $(this).val(),
                    table = self.question.find('.examples-list');
                if(!$(this).is(':checked')) {
                    table.find('tr[data-stumbling_block=' + stumbling_block + ']').remove();
                    if(table.find('tr[data-example]').length == 0){
                        table.hide();
                    }
                } else {
                    elgg.getJSON('ajax/view/questions/examples', {
                        data: {
                            'stumbling_block': stumbling_block
                        },
                        success: function (data) {
                            if(data.length > 0){
                                table.fadeIn();
                            }
                            $.each(data, function (i, item) {
                                if (table.find('tr[data-example=' + item.example + ']').length == 0) {
                                    table.find('tbody').append(
                                        $('<tr/>')
                                            .attr({
                                                'data-example': item.example,
                                                'data-stumbling_block': stumbling_block
                                            })
                                            .append('<td style="padding-top: 10px;" colspan="2">' + item.content + '</td>')
                                    ).show();
                                }
                            });
                        }
                    });
                }
            });
            // Examples from Stumbling Blocks
            $(self.question).on("click", ".examples-list .btn-reflection", function(){
                $(this).closest('td').find('.reflection-list').toggle();
            });
            self.question.find(".close-table").on("click", function(){
                $(this).closest('.examples-list').find('tbody').toggle();
            });
        };
        this.difficultySlider = function($elem){
            return $elem.slider({
                range: "min",
                value: $elem.find("input").val(),
                min: 1,
                max: 6,
                step: 1,
                create: function(event, ui){
                    $elem.find("a").append($("<span/>"));
                    var value = $elem.find("input").val();
                    if(value < 4){
                        $elem.find(".ui-slider-range").addClass("green");
                    }else if(value >= 4 && ui.value <= 5){
                        $elem.find(".ui-slider-range").addClass("yellow");
                    }else{
                        $elem.find(".ui-slider-range").addClass("red");
                    }
                },
                slide: function( event, ui ) {
                    $elem.find("a span" ).text( ui.value );
                    $elem.find("input" ).val( ui.value );
                    $elem.find(".ui-slider-range").removeClass().addClass("ui-slider-range");
                    if(ui.value < 3){
                        $elem.find(".ui-slider-range").addClass("green");
                    }else if(ui.value >= 3 && ui.value <= 4){
                        $elem.find(".ui-slider-range").addClass("yellow");
                    }else{
                        $elem.find(".ui-slider-range").addClass("red");
                    }
                }
            });
            $elem.find(" a span" ).text(  $(this).find("input").val() );
        };
        this.create = function(from_tag, value){
            if(!value && !from_tag){
                var from_tag = false,
                    value = null;
            }

            elgg.get('ajax/view/activity/admin/tasks/quiz/add_type',{
                data: {
                    type: "question",
                    tricky_topic: opt.tricky_topic,
                    question: value,
                    num: $question.length + 1,
                    input_prefix: opt.input_prefix
                },
                success: function(content){

                    var $content = $($.parseHTML(content));
                    if($quiz.find(".question").length > 0 ){
                        $quiz.find(".questions").append($content);
                    } else {
                        $quiz.find(".questions").html($content);
                    }

                    self.question = $content;
                    if(from_tag){
                        var question_type = self.question.find(".select-question-type").val();
                        self.question.find("[data-question='" + question_type + "']").show();
                        self.question.find("textarea").click();
                        $quiz.find('.questions-select')
                            .val('')
                            .trigger('chosen:updated');
                    }
                    return self._init();
                }
            });
        };
        this.delete = function(){
            self.question.remove();
            return self.getNum();
        };
        this.getNum = function(){
            self.sortableOrder();
            return $quiz.find(".question").each(function(i){
                $(this).find(".question-num").text((i+1) + ".");
                $(this).find(".input-order").val(i+1);
            });
        };
        this.addResult = function(){
            return elgg.get('ajax/view/activity/admin/tasks/quiz/add_type',{
                data: {
                    type:   self.question_type_selected.data("question"),
                    id:     self.question_type_selected.attr("id"),
                    num:    self.question_type_selected.find(".result").length + 1,
                    input_prefix: opt.input_prefix
                },
                success: function(content){
                    self.question_type_selected
                        .find(".results")
                        .append(content)
                        .find("input")
                        .focus();
                }
            });
        };
        this.sortableOrder = function(){
            return $questions.sortable({
                dropOnEmpty: true,
                handle: '.reorder-question',
                update: function(event, ui) {
                    self.getNum();
                }
            });
        }
    };
    // Select Tricky Topic
    var previous_value = '';
    $quiz.find(".select-tricky_topic").focus(function() {
        <!--    $quiz.on("focus", ".select-tricky_topic", function(e){-->
        previous_value = $(this).val();
    }).change(function() {
        var tricky_topic = $quiz.find(".select-tricky_topic option:selected").val();
        $quiz.find(".add-question").hide();
        if(tricky_topic == ''){
            return false;
        }

        opt.tricky_topic = tricky_topic;
        $quiz.find(".add-question").show();
        if($quiz.find(".question").length > 0){
            var confirmOptions = {
                title: elgg.echo("question:areyousure"),
                buttons: {
                    confirm: {
                        label: elgg.echo("input:yes")
                    },
                    cancel: {
                        label: elgg.echo("input:no"),
                        className: "btn-border-blue btn-default"
                    }
                },
                message: elgg.echo('quiz:tricky_topic:danger'),
                callback: function(result) {
                    if(result) {
                        $quiz.find(".questions").html("");
                        $quiz.find(".dynamic-table").html("").hide();
                    } else {
                        $quiz.find(".select-tricky_topic option[value="+previous_value+"]").prop("selected", true);
                    }
                }
            };
            bootbox.confirm(confirmOptions);
        }
    });
    // Create a Question button
    that.find(".create-question").bind("click",function() {
        var q = new Question($(this));
        return q.create();
    });
    that.on("click", ".get-clones", function(){
        var tr = $(this).closest("tr")
        id = $(this).attr("id"),
            tr_clones = $("[data-clone="+id+"]");
        if(tr_clones.length > 0){
            tr_clones.toggle();
            return false;
        }
        elgg.get('ajax/view/activity/admin/tasks/quiz/add_type',{
            data: {
                type: "question_list_clone",
                id: id
            },
            success: function(content){
                tr.after(content);
            }
        });
    });
    // Question select from tag
    $quiz.on("click", ".from-tags", function(){
        <!--    that.on("click", ".from-tags", function(){-->
        var $that = $(this);
        $quiz.find(".dynamic-table").toggle();
        if($quiz.find("table.datatable").length > 0){
            return false;
        }
        elgg.get('ajax/view/activity/admin/tasks/quiz/add_type',{
            data: {
                type:   'question_list_from_tags',
                tricky_topic: opt.tricky_topic,
                input_prefix: opt.input_prefix
            },
            success: function(content){
                $content = $(content);
                $quiz.find(".dynamic-table").html($content);
                $content.find("table.datatable").dynatable({
                    features: {pushState: false},
                    dataset: {
                        sorts: { dnumber: 1 },
                        perPageDefault: 10
                    },
                    params: {
                        records: 'filas'
                    },
                    inputs: {
                        queries: $('.search-difficulty'),
                        queryEvent: 'blur change keyup',
                        paginationClass: 'pagination',
                        paginationLinkClass: 'cursor-pointer',
                        paginationActiveClass: 'active',
                        paginationDisabledClass: 'disabled',
                        pageText: elgg.echo('pages')+': ',
                        searchText: '',
                        perPageText: elgg.echo('show')+':',
                        paginationPrev: elgg.echo('prev'),
                        paginationNext: elgg.echo('next'),
                        recordCountText: elgg.echo('showing'),
                        recordCountPageBoundTemplate: '{pageLowerBound} '+elgg.echo('to')+' {pageUpperBound} '+elgg.echo('of'),
                        recordCountPageUnboundedTemplate: '{recordsShown} '+elgg.echo('of')
                    }
                });
                $content.find(".dynatable-search input")
                    .attr("placeholder", elgg.echo('search'))
                    .addClass('form-control')
                    .css({"width": "auto", "display": "inline-block"});
            }
        });
    });
    that.on("click", ".questions-select", function(){
        var q = new Question($(this));
        q.create(true, $(this).attr("id"));
    });
    return $quiz.find(".question").each(function(){
        var q = new Question();
        q.question = $(this);
        q._init();
    });
};

/**
 * Clipit Quiz admin task
 */
elgg.provide('clipit.task.admin.quiz');
clipit.task.admin.quiz.init = function() {
    $(document).on("click", ".save-annotation", clipit.task.admin.quiz.saveAnnotation);
};
elgg.register_hook_handler('init', 'system', clipit.task.admin.quiz.init);

clipit.task.admin.quiz.showChart = function(e){
    var that = $(this),
        user_id = that.closest('li').data('entity'),
        content = that.closest('li').find('.chart');
    if(content.is(':empty')) {
        content.html('<i class="fa fa-spinner fa-spin fa-2x blue"></i>');
        elgg.get("ajax/view/quizzes/admin/results", {
            data: {
                quiz: e.data.quiz,
                type: 'chart',
                user: user_id
            },
            success: function (data) {
                content.html(data);
            }
        });
    }
};
clipit.task.admin.quiz.showData = function(e){
    var that = $(this),
        $item = $('a[href="#'+ that.attr('id') +'"]')
        quiz_id = $item.closest('#quiz-admin').data('quiz'),
        id = $item.attr('href'),
        entity_id = $item.closest('li').data('entity');
    if(that.is(':empty')) {
        that.html('<i class="fa fa-spinner fa-spin fa-2x blue"></i>');
        elgg.get("ajax/view/quizzes/admin/results", {
            data: {
                quiz: quiz_id,
                type: 'result_'+ $item.data('entity-type'),
                entity: entity_id,
                entity_type: $item.data('type')
            },
            success: function (data) {
                var result = that.html(data);
                // Print mode
                if (e.data != undefined) {
                    if ($item.data('entity-type') == 'questions') {
                        // Show all results of each question
                        result.find('.question-result').collapse('show');
                    }
                    if ((e.data.count == e.data.total)) {
                        setTimeout(function(){
                            $('.bootbox').modal('hide');
                            window.print();
                        }, 500);
                    }
                }
            }
        });
    }
};
clipit.task.admin.quiz.printData = function (){
    var alertOptions = {
        backdrop: 'static',
        keyboard: true,
        title: elgg.echo(elgg.echo('loading')+"..."),
        buttons: {
            ok: {
                className: "hide"
            }
        },
        message: elgg.echo('quiz:print:alert')
    };
    bootbox.alert(alertOptions);
    var i = 0,
        tab = $('#quiz-admin .tab-pane.active'),
        $elements = tab.find('.results'),
        total = $elements.length;
    $elements.each(function(){
        i++;
        if($(this).hasClass('collapse')) {
            $(this).on('show.bs.collapse',
                {'print': true, 'count': i, 'total': total},
                clipit.task.admin.quiz.showData
            ).collapse('show');
        } else {
            if(i == total ){
                $('.bootbox').modal('hide');
                window.print();
            }
        }
    });
};

clipit.task.admin.quiz.onShowTab = function(e){
    var id = $(this).attr('href'),
        container = $(id).find('li');
    if(container.find('.status').is(':hidden')) {
        elgg.get("ajax/view/quizzes/admin/results", {
            dataType: "json",
            data: {
                quiz: e.data.quiz,
                count: true,
                type: id.replace('#', '')
            },
            success: function (output) {
                $.each(output, function (i, data) {
                    container.eq(i).find('.loading').remove();
                    if(data.not_finished) {
                        container.eq(i).find(".msg-not-finished").text(data.not_finished);
                    } else {
                        container.eq(i).find(".counts").show();
                        container.eq(i).find(".a-correct").text(data.correct);
                        container.eq(i).find(".answered").text(data.answered);
                    }
                });
            }
        });
    }
};
clipit.task.admin.quiz.saveAnnotation = function(){
    var container = $(this).parent(".annotate"),
        form = $(this).closest("form");
    tinymce.triggerSave();
    elgg.action(form.attr("action"), {
        data: form.serialize(),
        success: function(){
            container.slideToggle();
        }
    });
};