<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   16/06/14
 * Last update:     16/06/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
elgg_load_js('fullcalendar:moment');
$quiz_id = elgg_extract("quiz", $vars);
$task_id = elgg_extract("task_id", $vars);
$user_id = elgg_extract("user_id" ,$vars);
$finished = elgg_extract("finished" ,$vars);
$finished_task = elgg_extract("finished_task" ,$vars);

$task = array_pop(ClipitTask::get_by_id(array($task_id)));
$quiz = array_pop(ClipitQuiz::get_by_id(array($quiz_id)));
$questions = ClipitQuizQuestion::get_by_id($quiz->quiz_question_array);
$quiz_start = ClipitQuiz::get_quiz_start($quiz->id, $user_id);
if(!$quiz_start){
    ClipitQuiz::set_quiz_start($quiz->id, elgg_get_logged_in_user_guid());
    $quiz_start = ClipitQuiz::get_quiz_start($quiz->id, elgg_get_logged_in_user_guid());
}
$date = date("H:s, d/m/Y", $quiz_start + $quiz->max_time);

$count_answer = 0;
$count_answer = count(array_pop(ClipitQuizResult::get_by_owner(array($user_id))));
?>
<style>
<style>
    .quiz-answer .fa-times, .quiz-answer .fa-check{
        width: 14px;
    }
</style>
<?php if(!$finished):?>
<script>
    var eventTime= <?php echo $quiz_start + $quiz->max_time?>; // Timestamp - Sun, 21 Apr 2013 13:00:00 GMT
    var currentTime = <?php echo time()?>; // Time()
    var diffTime = eventTime - currentTime;
    var duration = moment.duration(diffTime*1000, 'milliseconds');
    var interval = 1000;

    countdown = setInterval(function(){
        duration = moment.duration(duration - interval, 'milliseconds');
        if(duration - interval <= 0){
            $(".quiz .question :input").prop("disabled", true);
            $('.countdown').text('<?php echo elgg_echo('closed');?>');
            clearTimeout(countdown);
            return false;
        }
        $('.countdown').text(duration.hours() + "h " + duration.minutes() + "m " + duration.seconds() + "s");
    }, interval);
    $(function(){
        $(document).on("click", ".pagination li.page:not('.disabled')", function(){
            $(".question").hide();
            $(".pagination li").removeClass("active");
            $(this).addClass("active");
            var $question = $("[data-question="+$(this).attr("id")+"]");
            $question.show();
            $(".next-page").attr("id", parseInt($(this).attr("id")) + 1);
            $(".prev-page").attr("id", $(this).attr("id") - 1);

            if($(".page").length == $(this).attr("id")){
                $(".pagination .next-page").addClass("disabled");
            }else if($(this).attr("id") == 1){
                $(".pagination .prev-page").addClass("disabled");
            } else{
                $(".pagination .next-page, .pagination .prev-page").removeClass("disabled");
            }
        });
        $(document).on("click", ".pagination .prev-page, .pagination .next-page", function(){
            $(".pagination li#"+$(this).attr("id")+".page").click();
        });

        var typingTimer;                //timer identifier
        var doneTypingInterval = 500;  //time in ms, 5 second for example
        $(document).on("paste keyup change", ".quiz input[type=number], .quiz textarea", function(event){
            if(event.type == 'change' && $(this).is("textarea")){
                return false;
            }
            clearTimeout(typingTimer);
            var $obj = $(this);
            typingTimer = setTimeout(function(){ $obj.saveQuestion()}, doneTypingInterval);
        });
        $(document).on("keydown", ".quiz input, .quiz textarea", function(){
            clearTimeout(typingTimer);
        });
        $(document).on("click", ".quiz input[type=checkbox], .quiz input[type=radio]", function(){
            return $(this).saveQuestion();
        });
        $.fn.saveQuestion = function() {
            var $element = $(this);
            if($(this).attr("type") == 'checkbox'){
                var $element = $(".quiz input[type=checkbox]");
            }
            var form = $(this).closest("form").find($element.add("input:hidden"));
            var $container = $(this).closest(".question");
            $container.find(".loading-question").show()
            $container.find(".num-question").hide();
            elgg.action('quiz/take',{
                data: form.serialize(),
                success: function(json) {
                    $container.find(".loading-question").hide()
                    $container.find(".num-question").show();
                    $("#count-result").text(json.output);
                    // if finished
                    if (json.output == 'finished'){
                        window.location.href = '';
                    }
                }
            });
        };

        $("#finish-quiz").click(function(e){
            e.preventDefault();
            var that = $(this);
            var confirmOptions = {
                title: $("#questions-result").text(),
                buttons: {
                    ok: {
                        label: elgg.echo("input:ok")
                    }
                },
                message: elgg.echo("quiz:result:send"),
                callback: function(result) {
                    that.closest('form').submit();
                }
            };
            bootbox.alert(confirmOptions);
        });
    });
</script>
<?php endif;?>
<?php if($quiz->view_mode == ClipitQuiz::VIEW_MODE_PAGED):?>
<script>
$(function(){
    $(".question").hide().first().show();
});
</script>
<?php endif;?>
<?php if(!$finished):?>
<div class="bg-info pull-right">
    <i class="fa fa-clock-o pull-left" style="font-size: 56px;"></i>
    <div class="content-block">
        <h4 class="margin-0">Tiempo para hacer el examen</h4>
        <h3 class="text-muted margin-0 margin-top-10">
            <span class="countdown"><i class="fa fa-spinner fa-spin blue"></i></span>
        </h3>
        <small>Termina a las <?php echo $date;?></small>
    </div>
</div>
<?php endif;?>

<?php if(!$vars['admin']):?>
    <h4><?php echo $quiz->name;?></h4>
    <?php echo $quiz->description;?>
<?php endif;?>

<div class="clearfix"></div>
<h4 id="questions-result">
    <strong class="text-muted">
        <span id="count-result"><?php echo $count_answer;?></span>/<?php echo count($questions);?>
    </strong>
    Preguntas contestadas
</h4>
<?php if(!$vars['admin']):?>
    <div class="pull-right"><small style="text-transform: uppercase"><?php echo elgg_echo('difficulty');?></small></div>
<?php endif;?>
<hr>
<?php if($quiz->view_mode == ClipitQuiz::VIEW_MODE_PAGED):?>
<div class="margin-bottom-20">
    <div class="text-center">
        <?php if(!$finished && !$finished_task):?>
            <?php echo elgg_view('input/submit',
                array(
                    'value' => elgg_echo('finish'),
                    'id' => 'finish-quiz',
                    'class' => "btn btn-primary pull-right"
                ));
            ?>
        <?php endif;?>
        <ul class="pagination margin-0">
            <li class="prev-page disabled" id="1"><a href="javascript:;"><i class="fa fa-angle-double-left"></i> Anterior</a></li>
            <?php for($i=1; $i <= count($questions); $i++):?>
                <li id="<?php echo $i;?>" class="<?php echo $i==1? 'active':'';?> page">
                    <a href="javascript:;"><?php echo $i;?></a>
                </li>
            <?php endfor;?>
            <li class="next-page" id="2"><a href="javascript:;">Siguiente <i class="fa fa-angle-double-right"></i></a></li>
        </ul>
    </div>
</div>
<?php endif;?>
<div class="quiz">
<?php
$num = 1;
foreach($questions as $question):
    $result = ClipitQuizResult::get_from_question_user($question->id, $user_id);
?>
    <div class="question form-group border-bottom-blue-lighter" data-question="<?php echo $num;?>">
        <?php if(!$vars['admin']):?>
        <div class="text-center pull-right">
            <?php echo difficulty_bar($question->difficulty);?>
        </div>
        <?php endif;?>
    <h4>
        <?php if($finished_task && $question->option_type != ClipitQuizQuestion::TYPE_STRING):?>
            <?php if($result->correct):?>
                <i class="fa fa-check green"></i>
            <?php else: ?>
                <i class="fa fa-times red"></i>
            <?php endif;?>
        <?php endif;?>
        <strong class="text-muted inline-block">
            <span class="num-question"><?php echo $num;?>.</span>
            <i class="fa fa-spinner fa-spin blue loading-question" style="display: none;"></i>
        </strong>
        <?php echo $question->name;?>
    </h4>
    <div class="margin-left-20 quiz-answer ">
        <?php if($description = $question->description):?>
            <div class="text-muted margin-bottom-10" style="margin-top: -10px;">
                <?php echo $description;?>
            </div>
        <?php endif;?>
    <?php switch($question->option_type):
        case ClipitQuizQuestion::TYPE_SELECT_MULTI:
            $i = 1;
            foreach($question->option_array as $option):
                $checked = '';
                if(in_array(($i-1), $result->answer) && $result){
                    $checked = 'checked';
                }
            ?>
        <label style="font-weight: normal">
            <?php if($finished):?>
                <input type="checkbox" disabled <?php echo in_array(($i-1), $result->answer) ? 'checked' : '';?>/>
                <?php if($question->validation_array[$i-1] && $finished_task):?>
                    <strong><?php echo $option;?></strong>
                <?php else:?>
                    <?php echo $option;?>
                <?php endif;?>
            <?php else:?>
                <input type="checkbox" value="<?php echo $i;?>" <?php echo $checked;?> name="question[<?php echo $question->id;?>][]" />
                <?php echo $option;?>
            <?php endif;?>
        </label>
        <?php
                $i++;
            endforeach;
        break;
        case ClipitQuizQuestion::TYPE_SELECT_ONE:
            $i = 1;
            foreach($question->option_array as $option):
                $checked = '';
                if($result->answer == $i-1 && $result){
                    $checked = 'checked';
                }
                ?>
                <label style="font-weight: normal">
                    <?php if($finished):?>
                        <input type="radio" disabled <?php echo $checked;?>/>
                        <?php if($question->validation_array[$i-1] && $finished_task):?>
                           <strong><?php echo $option;?></strong>
                        <?php else: ?>
                            <?php echo $option;?>
                        <?php endif;?>
                    <?php else:?>
                        <input type="radio" value="<?php echo $i;?>" <?php echo $checked;?> name="question[<?php echo $question->id;?>]" />
                        <?php echo $option;?>
                    <?php endif;?>
                </label>
            <?php
            $i++;
            endforeach;
        break;
        case ClipitQuizQuestion::TYPE_TRUE_FALSE:
            ?>
            <div>
            <?php if($finished):?>
            <label class="inline-block margin-right-20" style="font-weight: normal">
                <input type="radio" disabled <?php echo $result->answer == 'true' ? 'checked' : '';?>/>
                <?php if($question->validation_array[0] == 'true' && $finished_task):?>
                    <strong><?php echo elgg_echo('true');?></strong>
                <?php else:?>
                    <?php echo elgg_echo('true');?>
                <?php endif;?>
            </label>
            <label class="inline-block margin-right-20" style="font-weight: normal">
                <input type="radio" disabled <?php echo $result->answer == 'false' ? 'checked' : '';?>/>
                <?php if($question->validation_array[0] == 'false' && $finished_task):?>
                    <strong><?php echo elgg_echo('false');?></strong>
                <?php else:?>
                    <?php echo elgg_echo('false');?>
                <?php endif;?>
            </label>
            <?php else:?>
                <label class="inline-block margin-right-20" style="font-weight: normal">
                    <input type="radio" <?php echo $result->answer == 'true' ? 'checked' : '';?> name="question[<?php echo $question->id;?>]" value="true"/>
                    <?php echo elgg_echo('true');?>
                </label>
                <label class="inline-block" style="font-weight: normal">
                    <input type="radio" <?php echo $result->answer == 'false' ? 'checked' : '';?> name="question[<?php echo $question->id;?>]" value="false"/>
                    <?php echo elgg_echo('false');?>
                </label>
            <?php endif;?>
            </div>
            <?php
        break;
        case ClipitQuizQuestion::TYPE_STRING:
            ?>
            <?php if($finished):?>
                <?php if($result->answer):?>
                <div style="padding: 10px; background: #fafafa;">
                    <?php echo nl2br($result->answer);?>
                </div>
                <?php endif;?>
            <?php else:?>
                <?php echo elgg_view("input/plaintext", array(
                    'name'  => 'question['.$question->id.']',
                    'class' => 'form-control',
                    'value' => $result->answer ? $result->answer : '',
                    'rows' => 5
                ));
                ?>
            <?php endif;?>
            <?php
        break;
        case ClipitQuizQuestion::TYPE_NUMBER:
            ?>
            <?php if($finished):?>
                <?php if($result->correct && $finished_task):?>
                    <strong><?php echo $result->answer;?></strong>
                <?php else:?>
                    <?php echo $result->answer;?>
                <?php endif;?>
                <?php if(!$result->correct && $finished_task):?>
                    <small class="show">Solución: <strong><?php echo $question->validation_array[0];?></strong></small>
                <?php endif;?>
            <?php else:?>
                <input type="number" value="<?php echo $result->answer;?>" class="form-control" style="width: auto;" name="question[<?php echo $question->id;?>]"/>
            <?php endif;?>
            <?php
            break;
    endswitch;
    ?>
        <?php if($result->description && !$vars['admin']):?>
        <div class="bg-info margin-top-10" style="padding: 10px;">
            <i class="fa fa-user blue"></i> <small>Teacher's annotate:</small>
            <div>
                <?php echo $result->description;?>
            </div>
        </div>
        <?php endif; ?>
        <?php if($vars['admin'] && $finished_task):?>
            <?php echo elgg_view_form('quiz/question_annotate', array(
                'body' => elgg_view('quizzes/admin/annotation', array('result' => $result, 'question' => $question))
            ));?>
        <?php endif;?>
    </div>
    </div>
    <div class="clearfix"></div>
<?php
$num++;
endforeach;
    echo elgg_view('input/hidden', array(
        'name' => 'entity-id',
        'id' => 'entity-id',
        'value' => $quiz->id
    ));
    echo elgg_view('input/hidden', array(
        'name' => 'task-id',
        'id' => 'task-id',
        'value' => $task_id
    ));
?>
    <?php if((!$finished && !$finished_task) && $quiz->view_mode == ClipitQuiz::VIEW_MODE_LIST):?>
    <div class="margin-top-20">
        <?php echo elgg_view('input/submit',
            array(
                'value' => elgg_echo('finish'),
                'id' => 'finish-quiz',
                'class' => "btn btn-primary pull-right"
            ));
        ?>
    </div>
    <?php endif;?>
</div>
