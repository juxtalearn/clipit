<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   18/07/14
 * Last update:     18/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$activity = elgg_extract('entity', $vars);
$tasks = ClipitTask::get_by_id($activity->task_array);
elgg_load_js("fullcalendar:moment");
elgg_load_js("fullcalendar");
elgg_load_css("fullcalendar");
$id = uniqid();
?>
<script>
    <?php echo elgg_view("js/admin_tasks", array('entity' => $activity, 'tasks' => $tasks));?>
</script>
<div class="quest">
    <div class="create-question" data-tricky_topic="10">crear</div>
    <div class="add-result">add result</div>
</div>
<script>
    $.fn.quiz = function (options) {
        var defaults = {};
        var opt =  $.extend({}, defaults, options),
            that = $(this),
            $quiz = $(this),
            $question = that.find('.question');
            $questions = that.find('.questions');
//        var question = function(){
//          options.that();
//        };
        var question = {
            _init: function(qObj){
                var that = this;
                this.$question = $quiz.find('.question');
                this.$question_type = qObj.find(".show-question");
//                that.find(".tags-select").chosen({disable_search_threshold: 1});
//                that.find(".questions-select").chosen().change(this.select());
                $quiz.find("#add-result").bind("click", function(){
                    return that.addResult($(this));
                });

                this.setNum();
            },
            create: function(){
                var obj = this;
                elgg.get('ajax/view/activity/admin/tasks/quiz/add_type',{
                    data: {
                        type: "question",
                        tricky_topic: $(this).data("tricky_topic"),
                        num: $question.length + 1
                    },
                    success: function(content){
                        if(that.length > 0 ){
                            that.append(content);
                        } else {
                            that.html(content);
                        }
                        return obj._init($(content));
                    }
                });
            },
            select: function(){
                return elgg.get('ajax/view/activity/admin/tasks/quiz/add_type',{
                    data: {
                        type: "question",
                        question: $(this).val(),
                        tricky_topic: that.find(".create-question").data("tricky_topic"),
                        num: that.find(".question").length + 1
                    },
                    success: function(content){
                        that.find(".question:last").after(content);
                        that.find('.questions-select')
                            .val('')
                            .trigger('chosen:updated');
                    }
                });
            },
            addResult: function($obj){
                var parent = $(this).closest(".show-question");
                console.log($obj);
               return elgg.get('ajax/view/activity/admin/tasks/quiz/add_type',{
                    data: {
                        type: this.parent.data("question"),
                        id: parent.attr("id"),
                        num: parent.find(".result").length + 1
                    },
                    success: function(content){
                        parent.find(".results").append(content).find("input").focus();
                    }
                });
            },
            setNum: function(){
                console.log("ety");
                return $question.each(function(i){
                    $(this).find(".question-num").text((i+1) + ".");
                });
            }
        };
        var methods = {
            _init: function(){

            },
            _test: function () {
                return that.text();
            },
            texto: function () {
                return this._test();
            }
        }
        methods._init();
        // Create Question
//        $(document).on("click", ".create-question",function() {
        that.find(".create-question").bind("click",function() {
            question.create();
        });

        return methods;
    };
$(function(){

    $.fn.difficulty = function(){
        $(this).slider({
            range: "min",
            value: $(this).find("input").val(),
            min: 1,
            max: 10,
            step: 1,
            create: function(event, ui){
                $(this).find("a").append($("<span/>"));
                var value = $(this).find("input").val();
                if(value < 5){
                    $(this).find(".ui-slider-range").addClass("green");
                }else if(value >= 5 && ui.value < 8){
                    $(this).find(".ui-slider-range").addClass("yellow");
                }else if(value >= 8){
                    $(this).find(".ui-slider-range").addClass("red");
                }
            },
            slide: function( event, ui ) {
                $(this).find("a span" ).text( ui.value );
                $(this).find("input" ).val( ui.value );
                $(this).find(".ui-slider-range").removeClass().addClass("ui-slider-range");
                if(ui.value < 5){
                    $(this).find(".ui-slider-range").addClass("green");
                }else if(ui.value >= 5 && ui.value < 8){
                    $(this).find(".ui-slider-range").addClass("yellow");
                }else if(ui.value >= 8){
                    $(this).find(".ui-slider-range").addClass("red");
                }
            }
        });
        $(this).find(" a span" ).text(  $(this).find("input").val() );
    };

    $(document).on("change", ".task-types",function() {
        if($(this).val() == 'quiz_take') {
            elgg.get('ajax/view/activity/admin/tasks/quiz/quiz', {
                success: function (data) {
                    $("#task-type-container").html(data);
                }
            });
        }
    });
    $(".tags-select").chosen({disable_search_threshold: 1});
    $(".questions-select").chosen().change(function(){
        elgg.get('ajax/view/activity/admin/tasks/quiz/add_type',{
            data: {
                type: "question",
                question: $(this).val(),
                tricky_topic: $("#create-question").data("tricky_topic"),
                num: $(".question").length + 1
            },
            success: function(content){
                $(".question:last").after(content);
                $('.questions-select')
                    .val('')
                    .trigger('chosen:updated');
            }
        });
    });
    $(document).on("change", ".select-question", function(){
        var question = $(this).val();
        var $container = $(this).closest(".question");
        $container.find(".show-question").hide();
        if($container.find("[data-question='"+question+"']").length > 0) {
            $container.find(".show-question[data-question='" + question + "']").show();
        }
    });
    $(document).on("click", "#create-question", function(){
        var $container = $('.questions');
        elgg.get('ajax/view/activity/admin/tasks/quiz/add_type',{
            data: {
                type: "question",
                tricky_topic: $(this).data("tricky_topic"),
                num: $(".questions .question").length + 1
            },
            success: function(content){
                if($container.length > 0 ){
                    $container.append(content);
                } else {
                    $container.html(content);
                }

            }
        });
    });
    $(document).on("click", "#add-result", function(){
        var parent = $(this).closest(".show-question");
//        var $data = <?php //echo json_encode(elgg_view('activity/admin/tasks/quiz/types/select_one', array('id' => $id, 'num' => $i)));?>//;
//        $data.find("input").attr("placeholder", "testing");
//        parent.find(".results").append(data);
        elgg.get('ajax/view/activity/admin/tasks/quiz/add_type',{
            data: {
                type: parent.data("question"),
                id: parent.attr("id"),
                num: parent.find(".result").length + 1
            },
            success: function(content){
                parent.find(".results").append(content).find("input").focus();
            }
        });
    });
});
</script>
<div>
    <small class="show"><?php echo elgg_echo('view_as');?></small>
    <?php echo elgg_view('output/url', array(
        'href'  => "javascript:;",
        'id' => 'calendar',
        'class' => 'btn btn-xs btn-border-blue active button-view-as',
        'text'  => '<i class="fa fa-calendar"></i> Calendar',
    ));
    ?>
    <?php echo elgg_view('output/url', array(
        'href'  => "javascript:;",
        'id' => 'list',
        'class' => 'btn btn-xs btn-border-blue button-view-as',
        'text'  => '<i class="fa fa-th-list"></i> List',
    ));
    ?>
</div>

<button type="button" data-toggle="modal" data-target="#create-new-task" class="btn btn-default margin-top-10">
    <?php echo elgg_echo('task:create'); ?>
</button>
<hr>
<!-- Calendar view -->
<div id="full-calendar" class="view-element" data-view="calendar"></div>
<script>
    $(function(){
        $(document).on("change", "select.task-types", function(){
            var $attach_list =  $(".attach_list[data-attach='<?php echo $id;?>']");
            if($(this).val() == '<?php echo ClipitTask::TYPE_RESOURCE_DOWNLOAD;?>'){
                $attach_list.toggle();
                $attach_list.attach_multimedia({
                    data: {
                        list: $(this).data("menu"),
                        entity_id: "<?php echo $activity->id;?>"
                    }
                }).loadBy("files");
            } else {
                $attach_list.hide();
            }
        });
    });
</script>
<?php echo elgg_view_form('task/create', array('data-validate' => "true" ), array('entity'  => $activity, 'id' => $id)); ?>

<div class="margin-bottom-20 view-element" data-view="list" style="display: none"></div>
<ul>
    <?php
    foreach($tasks as $task):
        // Task edit (modal remote)
        echo '<li>'.elgg_view("page/components/modal_remote", array('id'=> "edit-task-{$task->id}" )).'</li>';
        if(!$task->parent_task):
    ?>
            <?php echo elgg_view('activity/admin/tasks/list', array('task' => $task));?>
            <?php
            if($task_id = ClipitTask::get_child($task->id)):
                $task = array_pop(ClipitTask::get_by_id(array($task_id)));
            ?>
                <?php echo elgg_view('activity/admin/tasks/list', array('task' => $task, 'feedback_task' => true));?>
            <?php endif; ?>
        <?php endif; ?>
    <?php endforeach;?>
</ul>