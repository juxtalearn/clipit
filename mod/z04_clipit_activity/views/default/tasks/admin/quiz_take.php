<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   24/07/14
 * Last update:     24/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$activity = elgg_extract('activity', $vars);
$task = elgg_extract('task', $vars);
$quiz = elgg_extract('quiz', $vars);
$entities_ids = array_keys($entities);
$users = elgg_extract('entities', $vars);
$users = ClipitUser::get_by_id($users);
$groups = ClipitActivity::get_groups($activity->id);
?>
<script src="http://www.chartjs.org/assets/Chart.min.js"></script>

<style>
    .multimedia-preview .img-preview{
        width: 65px;
        max-height: 65px;
    }
    .multimedia-preview img {
        width: 100%;
    }
    .task-status{
        display: none;
    }
</style>
<script>
    $(function(){
//        $(".question-results").each(function() {
//            var counts = $(this).find('.counts');
//            elgg.get("ajax/view/quizzes/admin/results", {
//                dataType: "json",
//                data: {
//                    quiz: <?php //echo $quiz->id;?>//,
//                    count: true,
//                    question: $(this).data('question'),
//                    task: <?php //echo $task->id;?>
//                },
//                success: function (output) {
//                    counts.find(".a-error").text(output.error);
//                    counts.find(".a-correct").text(output.correct);
//                    counts.find(".a-pending").text(output.pending);
//                }
//            });
//        });

        $(document).on("click", ".save-annotation", function(){
            var container = $(this).parent(".annotate"),
                form = $(this).closest("form");
            tinymce.triggerSave();
            elgg.action(form.attr("action"), {
                data: form.serialize(),
                success: function(){
                    container.slideToggle();
                }
            });
        });
        $(document).on("click", ".results-filter", function(){
            var content = $(this).parent(".panel").find(".panel-body");
            if(content.is(':empty')) {
                content.html('<i class="fa fa-spinner fa-spin fa-2x blue"></i>');
                elgg.get("ajax/view/quizzes/admin/results", {
                    data: {
                        users: $(this).data("users"),
                        type: $(this).data("type"),
                        quiz: $(this).closest(".quiz-questions").data("quiz")
                    },
                    success: function (data) {
                        content.html(data);
                    }
                });
            }
        });
        $(document).on("click", ".view-answer", function(){
            var content = $(this).closest("li").find(".answer"),
                question_id = $(this).closest(".panel-results").data("question");
            content.toggle();
            if(content.is(':empty')) {
                content.html('<i class="fa fa-spinner fa-spin fa-2x blue"></i>');
                elgg.get("ajax/view/quizzes/admin/results", {
                    data: {
                        user: $(this).attr("id"),
                        type: 'answer',
                        question: question_id
                    },
                    success: function (data) {
                        content.html(data);
                    }
                });
            }
        });
        $(document).on("click", "#panel-expand-all",function(){
            $(".expand").parent(".panel").find(".panel-collapse").collapse('show');
            $(".question-results").click();
        });
        $(document).on("click", "#panel-collapse-all",function(){
            $(".expand").parent(".panel").find(".panel-collapse").collapse('hide');
        });
        $(document).on("click", ".question-results",function(){
            var content = $(this).parent(".panel").find(".panel-main");
            var question_id = $(this).data("question");
            if(content.is(':empty')){
                content.html('<i class="fa fa-spinner fa-spin fa-2x blue"></i>');
                $.get( elgg.config.wwwroot+"ajax/view/quizzes/admin/results", {
                        quiz: <?php echo $quiz->id;?>,
                        question: question_id,
                        task: <?php echo $task->id;?>
                    },
                    function( data ) {
                        content.html(data);
                        var error_filter = content.find(".results-filter[data-type='error']"),
                            pending_filter = content.find(".results-filter[data-type='pending']");
                        if(parseInt(error_filter.find('.count').text()) > 0){
                            error_filter.click();
                            error_filter.parent(".panel").find(".collapse").collapse('show');
                        } else if(parseInt(error_filter.find('.count').text()) == 0){
                            pending_filter.click();
                            pending_filter.parent(".panel").find(".collapse").collapse('show');
                        }
                    });
            }
        });
//
//
//

//        $(".show-questions").on("show.bs.collapse",function() {
        $(".show-questions").on("click", function() {
            var that = $(this),
                user_id = that.closest('li').data('entity'),
                content = that.closest('li').find('.questions');
            if(content.is(':empty')) {
                content.html('<i class="fa fa-spinner fa-spin fa-2x blue"></i>');
                elgg.get("ajax/view/quizzes/admin/results", {
                    data: {
                        quiz: <?php echo $quiz->id;?>,
                        type: 'results',
                        user: user_id
                    },
                    success: function (data) {
                        content.html(data);
                    }
                });
            }
        });
        $(".show-chart").on("click", function() {
            var that = $(this),
                user_id = that.closest('li').data('entity'),
                content = that.closest('li').find('.chart');
            if(content.is(':empty')) {
                content.html('<i class="fa fa-spinner fa-spin fa-2x blue"></i>');
                elgg.get("ajax/view/quizzes/admin/results", {
                    data: {
                        quiz: <?php echo $quiz->id;?>,
                        type: 'chart',
                        user: user_id
                    },
                    success: function (data) {
                        content.html(data);
                    }
                });
            }
        });
        $(".show-data").on("click", function() {
            var that = $(this),
                id = that.attr('href'),
                entity_id = that.closest('li').data('entity'),
                content = $(id);
            if(content.is(':empty')) {
                content.html('<i class="fa fa-spinner fa-spin fa-2x blue"></i>');
                elgg.get("ajax/view/quizzes/admin/results", {
                    data: {
                        quiz: <?php echo $quiz->id;?>,
                        type: 'result_'+ that.data('entity-type'),
                        entity: entity_id,
                        entity_type: that.data('type')
                    },
                    success: function (data) {
                        content.html(data);
                    }
                });
            }
        });
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            var id = $(this).attr('href'),
                container = $(id).find('li');
            if(container.find('.a-error').text().indexOf('-') >= 0) {
                elgg.get("ajax/view/quizzes/admin/results", {
                    dataType: "json",
                    data: {
                        quiz: <?php echo $quiz->id;?>,
                        count: true,
                        type: id.replace('#', '')
                    },
                    success: function (output) {
                        $.each(output, function (i, data) {
                            container.eq(i).find(".a-error").text(data.error);
                            container.eq(i).find(".a-correct").text(data.correct);
                            container.eq(i).find(".a-pending").text(data.pending);
                        });
                    }
                });
            }
        });
        // Start first tab
        $('a[data-toggle="tab"]:first').tab('show');

        var hash = window.location.hash.replace('#', '');
        console.log(hash);
        var collapse = $("[href='#user_"+hash+"']");
        if(collapse.length > 0){
            collapse.click();
        }

    });
</script>
<div role="tabpanel">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation">
            <a href="#students" aria-controls="profile" role="tab" data-toggle="tab"><?php echo elgg_echo('students');?></a>
        </li>
        <?php if($groups):?>
        <li role="presentation">
            <a href="#groups" aria-controls="groups" role="tab" data-toggle="tab"><?php echo elgg_echo('groups');?></a>
        </li>
        <?php endif;?>
        <li role="presentation">
            <a href="#activity" aria-controls="activity" role="tab" data-toggle="tab"><?php echo elgg_echo('activity');?></a>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane margin-top-10 active" id="students" style="padding: 10px;">
            <ul>
            <?php
            $students_select = array('' => 'All students');
            $students = ClipitUser::get_by_id($activity->student_array);
            foreach($students as $student):
                $students_select[$student->id] = $student->name;
            ?>
                <li class="list-item" data-entity="<?php echo $student->id;?>">
                    <div class="pull-right">
                        <div class="margin-right-10 inline-block">
                            <small class="margin-right-10">
                                <i class="fa fa-times red"></i> <strong class="a-error">-</strong>
                            </small>
                            <small class="margin-right-10">
                                <i class="fa fa-check green"></i> <strong class="a-correct">-</strong>
                            </small>
                            <small class="margin-right-10">
                                <i class="fa fa-minus yellow"></i> <strong class="a-pending">-</strong>
                            </small>
                        </div>
                        <span class="pull-right">
                            <a href="#questions-<?php echo $student->id;?>"
                               class="show-data btn-primary btn btn-xs btn-icon fa-comments fa"
                               data-type="student"
                               data-entity-type="questions"
                               data-toggle="collapse"
                                ></a>
                            <a href="#chart-<?php echo $student->id;?>"
                               class="show-data margin-left-10 btn-icon btn-border-blue btn btn-xs fa fa-bar-chart-o"
                               data-toggle="collapse"
                               data-type="student"
                               data-entity-type="chart"
                               aria-expanded="false"
                                ></a>
                        </span>
                    </div>
                    <?php echo elgg_view("page/elements/user_block", array("entity" => $student)); ?>
                    <div class="clearfix"></div>
                    <div>
                        <div class="collapse margin-top-10 chart" style="margin-left: 35px;" id="chart-<?php echo $student->id;?>"></div>
                        <div class="collapse margin-top-10 questions" id="questions-<?php echo $student->id;?>"></div>
                    </div>
                </li>
            <?php endforeach;?>
            </ul>
        </div>
        <?php if($groups):?>
        <div role="tabpanel" class="tab-pane margin-top-10" id="groups" style="padding: 10px;">
            <ul>
                <?php foreach(ClipitGroup::get_by_id($groups) as $group):?>
                <li class="list-item" data-entity="<?php echo $group->id;?>">
                    <div class="pull-right">
                        <div class="margin-right-10 inline-block">
                            <small class="margin-right-10">
                                <i class="fa fa-times red"></i> <strong class="a-error">-</strong>
                            </small>
                            <small class="margin-right-10">
                                <i class="fa fa-check green"></i> <strong class="a-correct">-</strong>
                            </small>
                            <small class="margin-right-10">
                                <i class="fa fa-minus yellow"></i> <strong class="a-pending">-</strong>
                            </small>
                        </div>
                        <span class="pull-right">
                            <a href="#questions-<?php echo $group->id;?>"
                               class="show-data btn-primary btn btn-xs btn-icon fa-comments fa"
                               data-type="group"
                               data-entity-type="questions"
                               data-toggle="collapse"
                                ></a>
                            <a href="#chart-<?php echo $group->id;?>"
                               class="show-data margin-left-10 btn-icon btn-border-blue btn btn-xs fa fa-bar-chart-o"
                               data-toggle="collapse"
                               data-type="group"
                               data-entity-type="chart"
                               aria-expanded="false"></a>
                        </span>
                    </div>
                    <?php
                        echo elgg_view("page/components/modal_remote", array('id'=> "group-{$group->id}" ));
                        echo elgg_view('output/url', array(
                            'href'  => "ajax/view/modal/group/view?id={$group->id}",
                            'text'  => '<i class="fa fa-users"></i> '.$group->name,
                            'title' => $group->name,
                            'data-toggle'   => 'modal',
                            'data-target'   => '#group-'.$group->id
                        ));
                    ?>
                    <small class="show">
                        <?php echo count($group->user_array);?> <?php echo elgg_echo('students');?>
                    </small>
                    <div class="clearfix"></div>
                    <div>
                        <div class="collapse margin-top-10 chart" style="margin-left: 35px;" id="chart-<?php echo $group->id;?>"></div>
                        <div class="collapse margin-top-10 questions" id="questions-<?php echo $group->id;?>"></div>
                    </div>
                </li>
                <?php endforeach;?>
            </ul>
        </div>
        <?php endif;?>
        <div role="tabpanel" class="tab-pane margin-top-10" id="activity" style="padding: 10px;">
            <ul>
                <li data-entity="<?php echo $activity->id;?>">
                <a href="#questions-<?php echo $activity->id;?>"
                   class="show-data btn-primary btn btn-xs btn-icon fa-comments fa"
                   data-type="activity"
                   data-entity-type="questions"
                   data-toggle="collapse"
                    ></a>
                <a href="#chart-<?php echo $activity->id;?>"
                   class="show-data margin-left-10 btn-icon btn-border-blue btn btn-xs fa fa-bar-chart-o"
                   data-toggle="collapse"
                   data-type="activity"
                   data-entity-type="chart"
                   aria-expanded="false"></a>
                <div>
                    <div class="collapse margin-top-10 chart" style="margin-left: 35px;" id="chart-<?php echo $activity->id;?>"></div>
                    <div class="collapse margin-top-10 questions" id="questions-<?php echo $activity->id;?>"></div>
                </div>
                </li>
            </ul>
        </div>
    </div>

</div>

<div>
<!--    --><?php //echo elgg_view('widgets/quizresult/content');?>
</div>
