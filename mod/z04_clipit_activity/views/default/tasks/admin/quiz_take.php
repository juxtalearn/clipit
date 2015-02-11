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
?>
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
        $(".question-results").each(function() {
            var counts = $(this).find('.counts');
            elgg.get("ajax/view/quizzes/admin/results", {
                dataType: "json",
                data: {
                    quiz: <?php echo $quiz->id;?>,
                    count: true,
                    question: $(this).data('question'),
                    task: <?php echo $task->id;?>
                },
                success: function (output) {
                    counts.find(".a-error").text(output.error);
                    counts.find(".a-correct").text(output.correct);
                    counts.find(".a-pending").text(output.pending);
                }
            });
        });

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
//        $(".show-questions").on("show.bs.collapse",function() {
        $(".show-questions").on("click", function() {
            var that = $(this),
                user_id = $(this).data('user'),
                content = that.closest('li').find('.questions');
            content.html('<i class="fa fa-spinner fa-spin fa-2x blue"></i>');
            elgg.get("ajax/view/quizzes/admin/results", {
                data: {
                    quiz: <?php echo $quiz->id;?>,
                    type: 'results',
                    task: <?php echo $task->id;?>,
                    user: user_id
                },
                success: function (data) {
                    content.html(data);
                }
            });
        });
        var hash = window.location.hash.replace('#', '');
        console.log(hash);
        var collapse = $("[href='#user_"+hash+"']");
        if(collapse.length > 0){
            collapse.click();
        }

    });
</script>
<p>
    <?php echo elgg_view('output/url', array(
        'title' => elgg_echo('expand:all'),
        'text' => elgg_echo('expand:all'),
        'href' => "javascript:;",
        'id' => 'panel-expand-all',
    ));
    ?>
    <span class="text-muted">|</span>
    <?php echo elgg_view('output/url', array(
        'title' => elgg_echo('collapse:all'),
        'text' => elgg_echo('collapse:all'),
        'href' => "javascript:;",
        'id' => 'panel-collapse-all',
    ));
    ?>
</p>
<ul class="col-md-12" style="display: none;">
    <?php
    $students_select = array('' => 'All students');
    $students = ClipitUser::get_by_id($activity->student_array);
    foreach($students as $student):
        $students_select[$student->id] = $student->name;
        ?>
        <li class="list-item">
            <div class="pull-right">
                <div class="margin-right-10 inline-block">
                    <small class="margin-right-10">
                        <i class="fa fa-times red"></i> <strong class="a-error">1</strong>
                    </small>
                    <small class="margin-right-10">
                        <i class="fa fa-check green"></i> <strong class="a-correct">0</strong>
                    </small>
                    <small class="margin-right-10">
                        <i class="fa fa-clock-o yellow"></i> <strong class="a-pending">8</strong>
                    </small>
                </div>
                <span class="pull-right">
                    <a class="btn-primary btn btn-xs"> <?php echo elgg_echo('view');?></a>
                    <a class="margin-left-10 btn-icon btn-border-blue btn btn-xs fa fa-bar-chart-o"></a>
                </span>
            </div>
            <?php echo elgg_view("page/elements/user_block", array("entity" => $student)); ?>
        </li>
    <?php endforeach;?>
</ul>
<div class="col-md-12">
    <hr>
    <div style="display: none;">
        <?php echo elgg_view("input/dropdown", array(
            'name' => 'student',
            'style' => 'padding: 5px;',
            'class' => 'form-control margin-bottom-10',
            'options_values' => $students_select
        ));
        ?>
        <!--        <canvas style="background: rgb(236, 247, 252);padding: 10px;width: 100% !important;" id="myChart" width="" height="250"></canvas>-->
    </div>

</div>

<div role="tabpanel">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#students" aria-controls="profile" role="tab" data-toggle="tab">Estudiantes</a></li>
        <li role="presentation"><a href="#groups" aria-controls="groups" role="tab" data-toggle="tab">Grupos</a></li>
        <li role="presentation"><a href="#activity" aria-controls="activity" role="tab" data-toggle="tab">Actividad</a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="students" style="padding: 10px;">
            <ul>
            <?php
            $students_select = array('' => 'All students');
            $students = ClipitUser::get_by_id($activity->student_array);
            foreach($students as $student):
                $students_select[$student->id] = $student->name;
            ?>
                <li class="list-item">
                    <div class="pull-right">
                        <div class="margin-right-10 inline-block">
                            <small class="margin-right-10">
                                <i class="fa fa-times red"></i> <strong class="a-error">1</strong>
                            </small>
                            <small class="margin-right-10">
                                <i class="fa fa-check green"></i> <strong class="a-correct">0</strong>
                            </small>
                            <small class="margin-right-10">
                                <i class="fa fa-clock-o yellow"></i> <strong class="a-pending">8</strong>
                            </small>
                        </div>
                        <span class="pull-right">
                            <a href="#user-questions-<?php echo $student->id;?>"
                               class="show-questions btn-primary btn btn-xs btn-icon fa-comments fa"
                               data-toggle="collapse"
                               data-user="<?php echo $student->id;?>"
                               ></a>
                            <a href="#user-chart-<?php echo $student->id;?>"
                               class="margin-left-10 btn-icon btn-border-blue btn btn-xs fa fa-bar-chart-o"
                               data-toggle="collapse"
                               aria-expanded="false" aria-controls="user-chart-<?php echo $student->id;?>"></a>
                        </span>
                    </div>
                    <?php echo elgg_view("page/elements/user_block", array("entity" => $student)); ?>
                    <div class="clearfix"></div>
                    <div>
                        <div class="collapse margin-top-10 questions" id="user-questions-<?php echo $student->id;?>"></div>
                        <div class="collapse margin-top-10" style="margin-left: 35px;" id="user-chart-<?php echo $student->id;?>">
                            <canvas class="myChart" style="background: rgb(236, 247, 252);padding: 10px;width: 100% !important;"  width="800" height="500"></canvas>
                        </div>
                    </div>
                </li>
            <?php endforeach;?>
            </ul>
        </div>
        <div role="tabpanel" class="tab-pane" id="questions" style="padding: 10px;">
            <ul>
            <?php
            $num = 1;
            $questions = ClipitQuizQuestion::get_by_id($quiz->quiz_question_array);
            foreach($questions as $question):
                ?>
                <li class="list-item">
                    <div class="pull-right">
                        <div class="margin-right-10 inline-block">
                            <small class="margin-right-10">
                                <i class="fa fa-times red"></i> <strong class="a-error">1</strong>
                            </small>
                            <small class="margin-right-10">
                                <i class="fa fa-check green"></i> <strong class="a-correct">0</strong>
                            </small>
                            <small class="margin-right-10">
                                <i class="fa fa-clock-o yellow"></i> <strong class="a-pending">8</strong>
                            </small>
                        </div>
                        <span class="pull-right">
                            <a class="btn-primary btn btn-xs btn-icon fa-comments fa"></a>
                            <a class="margin-left-10 btn-icon btn-border-blue btn btn-xs fa fa-bar-chart-o"></a>
                        </span>
                    </div>
                    <strong class="text-muted"><?php echo $num;?>.</strong> <a><?php echo $question->name;?></a>
                </li>
                <?php
                $num++;
            endforeach;
            ?>
            </ul>
        </div>
        <div role="tabpanel" class="tab-pane" id="groups" style="padding: 10px;">
            <ul>
                <?php for($i=1;$i<=5;$i++):?>
                <li class="list-item">
                    <div class="pull-right">
                        <div class="margin-right-10 inline-block">
                            <small class="margin-right-10">
                                <i class="fa fa-times red"></i> <strong class="a-error">1</strong>
                            </small>
                            <small class="margin-right-10">
                                <i class="fa fa-check green"></i> <strong class="a-correct">0</strong>
                            </small>
                            <small class="margin-right-10">
                                <i class="fa fa-clock-o yellow"></i> <strong class="a-pending">8</strong>
                            </small>
                        </div>
                        <span class="pull-right">
                            <a class="btn-primary btn btn-xs btn-icon fa-comments fa"></a>
                            <a class="margin-left-10 btn-icon btn-border-blue btn btn-xs fa fa-bar-chart-o"></a>
                        </span>
                    </div>
                    <a><i class="fa fa-users"></i> Grupo <?php echo $i;?></a>
                </li>
                <?php endfor;?>
            </ul>
        </div>
    </div>

</div>

<div class="clearfix"></div>
<!-- TESTING RADAR CHART -->
<canvas style="background: rgb(236, 247, 252);padding: 10px;width: 100% !important;" id="myChart" width="800" height="500"></canvas>
<!-- TESTING RADAR CHART -->
<script src="http://www.chartjs.org/assets/Chart.min.js"></script>
<script>
    var data = {
//        labels: <?php //echo json_encode($tt);?>//,
        labels: ["Eating", "Drinking", "Sleeping", "Designing", "Coding", "Cycling", "Running"],
        datasets: [
//            {
//                label: "My First dataset",
//                fillColor: "rgba(220,220,220,0.2)",
//                strokeColor: "rgba(220,220,220,1)",
//                pointColor: "rgba(220,220,220,1)",
//                pointStrokeColor: "#fff",
//                pointHighlightFill: "#fff",
//                pointHighlightStroke: "rgba(220,220,220,1)",
//                data: [65, 59, 90, 81, 56, 55, 40]
//            },
            {
                label: "My Second dataset",
                fillColor: "rgba(151,187,205,0.2)",
                strokeColor: "rgba(151,187,205,1)",
                pointColor: "rgba(151,187,205,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(151,187,205,1)",
                data: [28, 48, 40, 19, 96, 27, 100, 28, 48, 40, 19, 96, 27, 100]
            }
        ]
    };
    $(function(){
        var ctx = document.getElementsByClassName("myChart");
        for(var i=0;i<ctx.length;i++){
            cs = ctx[i].getContext("2d");
            new Chart(cs).Radar(data, {
                pointDot: false
            });
        }

    });
</script>
<div>
<!--    --><?php //echo elgg_view('widgets/quizresult/content');?>
</div>
<div class="panel-group quiz-questions" id="accordion_users" data-quiz="<?php echo $quiz->id;?>">
    <?php
    $i=1;
    $entities = $users;
    foreach(ClipitQuizQuestion::get_by_id($quiz->quiz_question_array) as $question):
    ?>
        <div class="panel panel-blue">
            <a name="<?php echo $question->id;?>"></a>
            <div class="panel-heading cursor-pointer expand question-results"
                 data-toggle="collapse"
                 data-parent="#accordion_users"
                 href="#user_<?php echo $question->id;?>"
                 data-question="<?php echo $question->id;?>" style="padding: 10px;">
                <h4 class="panel-title blue" >
                    <div class="pull-right blue">
                        <?php echo difficulty_bar($question->difficulty);?>
                        <i class="fa fa-angle-down blue margin-left-5"></i>
                    </div>
                    <strong><?php echo $i;?>.</strong>
                    <?php echo $question->name;?>
                    <div class="margin-top-5 margin-left-20 counts">
                        <small class="margin-right-10">
                            <i class="fa fa-times red"></i> <strong class="a-error">-</strong>
                        </small>
                        <small class="margin-right-10">
                            <i class="fa fa-check green"></i> <strong class="a-correct">-</strong>
                        </small>
                        <small class="margin-right-10">
                            <i class="fa fa-clock-o yellow"></i> <strong class="a-pending">-</strong>
                        </small>
                    </div>
                </h4>
            </div>
            <div id="user_<?php echo $question->id;?>" class="panel-collapse collapse">
                <div class="panel-body panel-main" style="padding: 5px 0;"></div>
            </div>
        </div>
        <?php $i++; endforeach;?>
</div>