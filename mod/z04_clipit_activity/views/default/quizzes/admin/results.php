<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   17/11/2014
 * Last update:     17/11/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$quiz_id = get_input('quiz');
$question_id = get_input('question');
$task_id = get_input('task');
$users = get_input('users');

$default = "";
switch($type = get_input('type')){
    case 'pending':
    case 'correct':
    case 'error':
        $users = array_filter($users);
        foreach ($users as $key => $user_id):
            if(is_array($user_id)){
                $user_id = array_pop($user_id);
                $key = 'not_answered';
            }
            $user = array_pop(ClipitUser::get_by_id(array($user_id)));
            echo elgg_view('quizzes/admin/user_results', array(
                'user' => $user,
                'type' => $type,
                'quiz_id' => $quiz_id,
                'subtype' => $key,
            ));
        endforeach;
        break;
    case 'answer':
        $finished = true;
        $result = ClipitQuizResult::get_from_question_user((int)$question_id, get_input('user'));
        $question = array_pop(ClipitQuizQuestion::get_by_id(array($question_id)));
        if($result) {
            echo elgg_view('output/url', array(
                'title' => elgg_echo('quiz:question:teacher_feedback'),
                'text' => '<i class="fa fa-edit"></i> <strong>' . elgg_echo('quiz:question:annotate') . '</strong>',
                'href' => 'javascript:;',
                'class' => 'btn btn-xs btn-border-blue pull-right',
                'onclick' => '$(this).parent(\'.answer\').find(\'.annotate\').toggle()',
            ));
        }
        echo '<div class="clearfix"></div>';
        echo elgg_view_form('quiz/question_annotate', array(
            'body' => elgg_view('quizzes/admin/annotation', array('result' => $result, 'question' => $question))
        ));
        break;
    default:
        $task = array_pop(ClipitTask::get_by_id(array($task_id)));
        $quiz = array_pop(ClipitQuiz::get_by_id(array($quiz_id)));
        $entities = ClipitActivity::get_students($task->activity);
        $results = array_pop(ClipitQuizResult::get_by_quiz_question(array($question_id)));
        $finished_task = $task->end <= time() ? true : false;

        $users = array();
        $us = array();
        foreach($results as $result){
            if($result->correct) {
                $users['correct'][] = $result->owner_id;
            } else {
                $users['error'][] = $result->owner_id;;
            }
            $us[] = $result->owner_id;
        }
        foreach(array_diff($entities, $us) as $user_pending){
            if(ClipitQuiz::has_finished_quiz($quiz->id, $user_pending) || $finished_task){
                $users['error'][]['not_answered'] = $user_pending;
                $us[] = $user_pending;
            }
        }
        $users['pending'] = array_diff($entities, $us);
        if($vars['count']){
            echo json_encode(array(
                'error' => count($users['error']),
                'correct' => count($users['correct']),
                'pending' => count($entities) - count($us),
            ));
            die;
        }
        $id = uniqid();
    ?>
    <div class="panel-group panel-results" data-question="<?php echo $question_id;?>">
        <div class="panel panel-default" style="border:0;border-radius: 0;box-shadow: none;">
            <div class="panel-heading cursor-pointer results-filter"
                 data-users="<?php echo htmlentities(json_encode($users['error']));?>"
                 data-type="error">
                <h4 class="panel-title blue" href="#e_<?php echo $id;?>" data-toggle="collapse" data-parent=".panel-results" style="font-size: 18px;">
                    <div class="pull-right">
                        <span class="text-muted margin-right-10 count">
                            <?php echo count($users['error']);?>
                        </span>
                        <i class="fa fa-angle-down blue"></i>
                    </div>
                    <i class="fa fa-times blue"></i>
                    Incorrect
                </h4>
            </div>
            <div class="panel-collapse collapse" id="e_<?php echo $id;?>">
            <ul class="panel-body"></ul>
            </div>
        </div>
        <div class="panel panel-default " style="border:0;border-radius: 0;box-shadow: none;">
            <div class="panel-heading cursor-pointer results-filter"
                 data-users="<?php echo htmlentities(json_encode($users['pending']));?>"
                 data-type="pending">
                <h4 class="panel-title blue" data-toggle="collapse" href="#p_<?php echo $id;?>" data-parent=".panel-results" style="font-size: 18px;">
                    <div class="pull-right">
                        <span class="text-muted margin-right-10 count">
                            <?php echo (count($entities) - count($us));?>
                        </span>
                        <i class="fa fa-angle-down blue"></i>
                    </div>
                    <i class="fa fa-clock-o blue"></i>
                    Pending
                </h4>
            </div>
            <div class="panel-collapse collapse" id="p_<?php echo $id;?>">
                <ul class="panel-body" style="max-height: 300px;overflow-y: auto;"></ul>
            </div>
        </div>
        <div class="panel panel-default" style="border:0;border-radius: 0;box-shadow: none;">
            <div class="panel-heading cursor-pointer results-filter"
                 data-users="<?php echo htmlentities(json_encode($users['correct']));?>"
                 data-type="correct">
                <h4 class="panel-title blue" href="#c_<?php echo $id;?>" data-toggle="collapse" data-parent=".panel-results" style="font-size: 18px;">
                    <div class="pull-right">
                        <span class="text-muted margin-right-10 count">
                            <?php echo count($users['correct']);?>
                        </span>
                        <i class="fa fa-angle-down blue"></i>
                    </div>
                    <i class="fa fa-check blue"></i>
                    Correct
                </h4>
            </div>
            <div class="panel-collapse collapse" id="c_<?php echo $id;?>">
                <ul class="panel-body"></ul>
            </div>
        </div>
    </div>
    <?php
        break;
    case 'groups':
        $quiz = array_pop(ClipitQuiz::get_by_id(array($quiz_id)));
        $task = array_pop(ClipitTask::get_by_id(array(ClipitQuiz::get_task($quiz->id))));
        $groups = ClipitActivity::get_groups($task->activity);
        $output = array();
        foreach(ClipitGroup::get_by_id($groups) as $group){
            $correct = 0;
            $error = 0;
            $pending = 0;
            foreach($group->user_array as $user_id) {
                foreach ($quiz->quiz_question_array as $question_id) {
                    $result = ClipitQuizResult::get_from_question_user($question_id, $user_id);
                    if (!$result) {
                        $pending++;
                    } elseif ($result->correct) {
                        $correct++;
                    } else {
                        $error++;
                    }
                }
            }
            if(ClipitQuiz::has_finished_quiz($quiz_id, $user_id)) {
                $output[] = array(
                    'correct' => $correct,
                    'error' => $error,
                    'pending' => $pending,
                );
            } else {
                $output[] = array(
                    'not_finished' => elgg_echo('quiz:not_finished')
                );
            }
        }
        echo json_encode($output);
        die;
        break;
    case 'students':
        $quiz = array_pop(ClipitQuiz::get_by_id(array($quiz_id)));
        $task = array_pop(ClipitTask::get_by_id(array(ClipitQuiz::get_task($quiz->id))));
        $users = ClipitActivity::get_students($task->activity);
        $output = array();
        foreach($users as $user_id){
            $correct = 0;
            $error = 0;
            $pending = 0;
            foreach($quiz->quiz_question_array as $question_id) {
                $result = ClipitQuizResult::get_from_question_user($question_id, $user_id);
                if(!$result) {
                    $pending++;
                } elseif ($result->correct) {
                    $correct++;
                } else {
                    $error++;
                }
            }
            if(ClipitQuiz::has_finished_quiz($quiz_id, $user_id)) {
                $output[] = array(
                    'correct' => $correct,
                    'error' => $error,
                    'pending' => $pending,
                );
            } else {
                $output[] = array(
                    'not_finished' => elgg_echo('quiz:not_finished')
                );
            }
        }
        echo json_encode($output);
        die;
        break;
    case 'result_questions':
        $entity_id = get_input('entity');
        $quiz = array_pop(ClipitQuiz::get_by_id(array($quiz_id)));
        $show_status = false;
        switch(get_input('entity_type')){
            case 'student':
                $show_status = true;
                break;
            case 'group':
                $users = ClipitGroup::get_users($entity_id);
                break;
            case 'activity':
                $users = ClipitActivity::get_students($entity_id);
                break;
        }
    ?>
        <ul style="background: rgb(236, 247, 252);padding: 10px;margin-left: 35px;">
            <?php
            $num = 1;
            $questions = ClipitQuizQuestion::get_by_id($quiz->quiz_question_array, 0, 0, 'order');
            foreach($questions as $question):
                $total_results = array();
                foreach($users as $user_id){
                    $total_results[] = ClipitQuizResult::get_from_question_user($question->id, $user_id);
                }
                $params = array(
                    'finished_task' => true,
                    'finished' => true,
                    'question' => $question,
                );
                if($show_status){
                    $result = ClipitQuizResult::get_from_question_user($question->id, $entity_id);
                    $params['result'] = $result;
                } else {
                    $params['total_results'] = $total_results;
                }
                ?>
                <li class="list-item answer">
                    <div class="pull-right">
                        <?php
                        if($show_status):
                            echo elgg_view('output/url', array(
                                'title' => elgg_echo('quiz:teacher_annotation'),
                                'text' => '',
                                'data-target' => '#question-result-'.$question->id.'-'.$entity_id,
                                'data-toggle' => 'collapse',
                                'href' => 'javascript:;',
                                'class' => 'fa fa-edit btn btn-xs btn-border-blue btn-icon',
                                'onclick' => '$(this).closest(\'.answer\').find(\'.annotate\').toggle()',
                            ));
                        endif;
                        ?>
                        <i class="btn fa fa-angle-down blue btn-icon"
                           data-target="#question-result-<?php echo $question->id;?>-<?php echo $entity_id;?>"
                           data-toggle="collapse"></i>
                    </div>
                    <span class="pull-left margin-right-5">
                        <?php if($show_status):?>
                            <?php if(!$result):?>
                                <i class="fa fa-minus yellow"></i>
                            <?php elseif($result->correct):?>
                                <i class="fa fa-check green"></i>
                            <?php else: ?>
                                <i class="fa fa-times red"></i>
                            <?php endif;?>
                        <?php endif;?>
                        <strong class="text-muted">
                            <?php echo $num;?>.
                        </strong>
                    </span>
                    <span class="cursor-pointer blue show content-block"
                          data-target="#question-result-<?php echo $question->id;?>-<?php echo $entity_id;?>"
                          data-toggle="collapse">
                        <?php echo $question->name;?>
                    </span>
                    <div class="clearfix"></div>
                    <div id="question-result-<?php echo $question->id;?>-<?php echo $entity_id;?>"
                         class="question-result collapse"
                         style="background: #fff;padding: 5px 10px;margin-top: 5px;">
                        <?php switch($question->option_type):
                            case ClipitQuizQuestion::TYPE_SELECT_MULTI:
                                echo elgg_view('quizzes/types/select_multi', $params);
                                break;
                            case ClipitQuizQuestion::TYPE_SELECT_ONE:
                                echo elgg_view('quizzes/types/select_one', $params);
                                break;
                            case ClipitQuizQuestion::TYPE_TRUE_FALSE:
                                echo elgg_view('quizzes/types/true_false', $params);
                                break;
                            case ClipitQuizQuestion::TYPE_NUMBER:
                                echo elgg_view('quizzes/types/number', $params);
                                break;
                        endswitch;
                        ?>
                    </div>
                    <?php
                    if($show_status):
                        echo elgg_view_form('quiz/question_annotate', array(
                            'body' => elgg_view('quizzes/admin/annotation', array(
                                'result' => $result,
                                'question' => $question
                            ))
                        ));
                    endif;
                    ?>
                </li>
                <?php
                $num++;
            endforeach;
            ?>
        </ul>
    <?php
        break;
    case 'result_chart':
        $entity_id = get_input('entity');
        switch(get_input('entity_type')){
            case 'student':
                $data = ClipitQuiz::get_user_results_by_tag($quiz_id, $entity_id);
                break;
            case 'group':
                $data = ClipitQuiz::get_group_results_by_tag($quiz_id, $entity_id);
                break;
            case 'activity':
                $data = ClipitQuiz::get_quiz_results_by_tag($quiz_id);
                break;
        }
        if(!$data){
            echo elgg_view('output/empty', array('value' => elgg_echo('quiz:data:none')));
            die;
        }
        foreach($data as $tag_id => $value){
            $tag = ClipitSite::lookup($tag_id);
            $output[] = $tag['name'];
        }
        ?>
        <script>
            var data = {
                labels:  <?php echo json_encode($output);?>,
                datasets: [
                    {
                        label: '<?php echo elgg_echo('tags');?>',
                        fillColor: "rgba(50, 180, 229,0.2)",
                        strokeColor: "rgba(50, 180, 229, 0.7)",
                        pointColor: "rgba(50, 180, 229, 1)",
                        pointStrokeColor: "#fff",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(151,187,205,1)",
                        data: <?php echo json_encode(array_values($data));?>
                    }
                ]
            };
            $(function(){
                var ch = document.getElementById("canvas-chart-<?php echo $entity_id;?>").getContext("2d");
                new Chart(ch).Radar(data, {
                    pointDot: true,
                    pointLabelFontSize : 12,
                    angleLineColor : "rgba(0,0,0,.3)",
                    pointDotStrokeWidth : 2,
                    responsive: true,
                    scaleOverride: true,

                    // ** Required if scaleOverride is true **
                    scaleSteps: 1,
                    scaleStepWidth: 1,
                    scaleStartValue: 0
                });
            });
        </script>
        <canvas id="canvas-chart-<?php echo $entity_id;?>" style="background: rgb(236, 247, 252);padding: 10px;width: 100% !important;"  width="800" height="500"></canvas>
    <?php
        break;
}
//die;
//echo elgg_view('quizzes/list', array(
//    'quiz' => $quiz,
//    'task_id' => $task->id,
//    'user_id' => $user_id,
//    'finished_task' => ClipitQuiz::has_finished_quiz($quiz, $user_id),
//    'finished' => true,
//    'admin' => true
//))

?>
