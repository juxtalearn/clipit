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
        var hash = window.location.hash.replace('#', '');
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
<div class="panel-group quiz-questions" id="accordion_users" data-quiz="<?php echo $quiz->id;?>">
<?php
$i=1;
$entities = $users;
foreach(ClipitQuizQuestion::get_by_id($quiz->quiz_question_array) as $question):
?>
    <div class="panel panel-blue">
        <a name="<?php echo $question->id;?>"></a>
        <div class="panel-heading cursor-pointer expand question-results" data-question="<?php echo $question->id;?>" style="padding: 10px;">
            <h4 class="panel-title blue" data-toggle="collapse" data-parent="#accordion_users" href="#user_<?php echo $question->id;?>">
                <div class="pull-right blue">
                    <?php echo difficulty_bar($question->difficulty);?>
                </div>
                <strong><?php echo $i;?>.</strong>
                <?php echo $question->name;?>
            </h4>
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
        </div>
        <div id="user_<?php echo $question->id;?>" class="panel-collapse collapse">
            <div class="panel-body panel-main" style="padding: 5px 0;"></div>
        </div>
    </div>
<?php $i++; endforeach;?>
</div>