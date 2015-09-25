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
    case 'compare_results':
        $spider_colors = array(
            "E7DF1A", "98BF0E", "ED1E79", "4174B5", "EC7227", "019B67", "E4391B",
            "14B8DD", "795548", "3f51b5", "e91e63","FF0000", "00FF00", "0000FF",
            "FFFF00", "FF00FF", "00FFFF", "000000", "800000", "008000", "000080",
            "808000", "800080", "008080", "808080", "C00000", "00C000", "0000C0",
            "C0C000", "C000C0", "00C0C0", "C0C0C0", "400000", "004000", "000040",
            "404000", "400040", "004040", "404040", "200000", "002000", "000020",
            "202000", "200020", "002020", "202020", "600000", "006000", "000060",
            "606000", "600060", "006060", "606060", "A00000", "00A000", "0000A0",
            "A0A000", "A000A0", "00A0A0", "A0A0A0", "E00000", "00E000", "0000E0",
            "E0E000", "E000E0", "00E0E0", "E0E0E0"
        );

        function get_random_colors($count){
            $colors = array();
            for ($i = 0; $i < $count; $i++) {
                $colors[] =  '#'.str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT) .
                    str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT) .
                    str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
            }

            return $colors;
        }

        $task_id = ClipitQuiz::get_task($quiz_id);
        $stumbling_blocks = array();
        $tricky_topic_id = ClipitQuiz::get_tricky_topic($quiz_id);
        $tricky_topic_id = 2856;
        $stumbling_blocks = ClipitTrickyTopic::get_tags($tricky_topic_id);
        $stumbling_blocks = ClipitTag::get_by_id(array_values($stumbling_blocks));
        switch(get_input('entity_type')){
            case 'students':
                $users = ClipitActivity::get_students(ClipitTask::get_activity($task_id));
                $spider_colors  = get_random_colors(count($users)+1);
                natsort($users);
                $i=0;

                foreach ($users as $number => $user_id) {
                    $quiz_results = ClipitQuiz::get_user_results_by_tag($quiz_id, $user_id);
                    $user = get_entity($user_id);

                    $data = array();
                    foreach($stumbling_blocks as $stumbling_block){
                        $data[strval($stumbling_block->name)] = 0;
                    }
                    if (is_not_null($quiz_results) && !empty($quiz_results)) {
                        foreach ($quiz_results as $sb_id => $value) {
                            $sb = ClipitSite::lookup($sb_id);
                            $data[strval($sb['name'])] = floatval($value) * 100;
                        }
                    }
                    $data = json_encode($data);
                    $results[$i] = array("name" => $user->name, "data" => strval($data), "color" => $spider_colors[$i]);
                    $i+=1;
                }
                break;
            case 'groups':
                $groups = ClipitActivity::get_groups(ClipitTask::get_activity($task_id));
                $spider_colors  = get_random_colors(count($groups)+1);
                natsort($groups);
                $i=0;
                foreach ($groups as $number => $group_id) {
                    $quiz_results = ClipitQuiz::get_group_results_by_tag($quiz_id, $group_id);
                    $group = get_entity($group_id);

                    $data = array();
                    foreach($stumbling_blocks as $stumbling_block){
                        $data[strval($stumbling_block->name)] = 0;
                    }
                    if (is_not_null($quiz_results) && !empty($quiz_results)) {
                        foreach ($quiz_results as $sb_id => $value) {
                            $sb = ClipitSite::lookup($sb_id);
                            $data[strval($sb['name'])] = floatval($value)*100;
                        }
                    }
                    $data = json_encode($data);
                    $results[$i] = array("name" => $group->name, "data" => strval($data), "color" => $spider_colors[$i]);
                    $i+=1;
                }
                break;
        }
        echo elgg_view('quizzes/admin/compare_results', array(
            'stumbling_blocks' => $stumbling_blocks,
            'results' => $results,
        ));
        break;
    case 'groups':
        $quiz = array_pop(ClipitQuiz::get_by_id(array($quiz_id)));
        $task = array_pop(ClipitTask::get_by_id(array(ClipitQuiz::get_task($quiz->id))));
        $groups = ClipitActivity::get_groups($task->activity);
        $output = array();
        $questions = $quiz->quiz_question_array;
        $groups = ClipitGroup::get_by_id($groups);
        natural_sort_properties($groups, 'name');
        $users_started = ClipitQuiz::get_started_users($quiz_id);
        foreach($groups as $group){
            $answered = 0;
            $correct = 0;
            $error = 0;
            $pending = 0;
            $started = 0;

            foreach($group->user_array as $user_id) {
                if(in_array($user_id, $users_started)){
                    $started++;
                }
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
            $total_started_users = $started.'/'.count($group->user_array);
            $completed =  (round( ( (($answered) / ($total_started_users)) / count($questions) ), 2 ))*100;
            $rating = (round((($correct)/$answered), 2))*100;
            $success_class_started = $total_started_users >= 100 ? 'green' : '';
            $success_class_completed = $completed >= 100 ? 'green' : '';
            $success_class_rating = $rating >= 100 ? 'green' : '';
            $output[] = array(
                'answered' =>
                    '<div>
                        <strong class="pull-right '.$success_class_started.'">'.$total_started_users.'</strong>
                        <span class="text-truncate" style="width: 100px;">'.elgg_echo('quiz:participants').'</span>
                    </div>'.
                    '<div>
                        <strong class="pull-right '.$success_class_completed.'">'.$completed.'%</strong>
                        <span class="text-truncate" style="width: 100px;">'.elgg_echo('quiz:progress').'</span>
                    </div>'.
                    '<div>
                        <strong class="pull-right '.$success_class_rating.'">'.$rating.'%</strong>
                        <span class="text-truncate" style="width: 100px;">'.elgg_echo('quiz:score').'</span>
                    </div>'
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
                        <?php if($total_answered):?>
                            <small>
                                <?php echo elgg_echo('quiz:out_of:answered', array(
                                        count(array_filter($total_results)),
                                        count($users)*count($questions)
                                    ));
                                ?>
                            </small>
                        <?php endif;?>
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
