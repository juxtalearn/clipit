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
    case 'groups':
        $quiz = array_pop(ClipitQuiz::get_by_id(array($quiz_id)));
        $task = array_pop(ClipitTask::get_by_id(array(ClipitQuiz::get_task($quiz->id))));
        $groups = ClipitActivity::get_groups($task->activity);
        $output = array();
        $questions = $quiz->quiz_question_array;
        $groups = ClipitGroup::get_by_id($groups);
        natural_sort_properties($groups, 'name');
        foreach($groups as $group){
            $answered = 0;
            $correct = 0;
            $error = 0;
            $pending = 0;
            foreach($group->user_array as $user_id) {
                foreach ($questions as $question_id) {
                    $result = ClipitQuizResult::get_from_question_user($question_id, $user_id);
                    if($result){
                        $answered++;
                    }
                    if (!$result) {
                        $pending++;
                    } elseif ($result->correct) {
                        $correct++;
                    } else {
                        $error++;
                    }
                }
            }

            $total = $correct+$error+$pending;
            $output[] = array(
                'correct' => round(($correct*100)/$total)."%",
                'answered' => elgg_echo('quiz:out_of:answered', array(
                                $answered,
                                count($questions)*count($group->user_array)
                            ))
            );
        }
        echo json_encode($output);
        die;
        break;
    case 'students':
        $quiz = array_pop(ClipitQuiz::get_by_id(array($quiz_id)));
        $task = array_pop(ClipitTask::get_by_id(array(ClipitQuiz::get_task($quiz->id))));
        $users = ClipitActivity::get_students($task->activity);
        $output = array();
        $questions = $quiz->quiz_question_array;
        foreach($users as $user_id){
            $correct = 0;
            $error = 0;
            $pending = 0;
            foreach($questions as $question_id) {
                $result = ClipitQuizResult::get_from_question_user($question_id, $user_id);
                if(!$result) {
                    $pending++;
                } elseif ($result->correct) {
                    $correct++;
                } else {
                    $error++;
                }
            }
            $answered = ClipitQuiz::questions_answered_by_user($quiz_id, $user_id);
            if(ClipitQuiz::has_finished_quiz($quiz_id, $user_id)) {
                $total = $correct+$error+$pending;
                $output[] = array(
                    'correct' => round(($correct*100)/$total)."%",
                    'answered' => elgg_echo('quiz:out_of:answered', array(
                                    $answered,
                                    count($questions)
                                ))
                );
            } else {
                $output[] = array(
                    'not_finished' => elgg_echo('quiz:out_of:answered', array(
                                        $answered,
                                        count($questions)
                                    )) . " - ". elgg_echo('quiz:not_finished')
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
                $total_answered = true;
                $users = ClipitGroup::get_users($entity_id);
                break;
            case 'activity':
                $total_answered = true;
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
                        if($show_status && $result):
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
        echo elgg_view('quizzes/chart/radar', array('data' => $data, 'labels' => $output, 'id' => $entity_id));

        break;
}
?>
