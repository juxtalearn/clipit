<?php


/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   22/04/14
 * Last update:     22/04/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
function activity_filter_search($query){
    $item_ids = array();
    $query_ar = json_decode($query);
    foreach($query_ar as $s => $value){
        switch($s){
            case 'name':
                $item_search = array();
                $quizzes = ClipitActivity::get_from_search($value);
                foreach ($quizzes as $quiz) {
                    $item_ids[] = $quiz->id;
                }
                break;
            case 'tricky_topic':
                $item_search = array();
                $tricky_topics = ClipitTrickyTopic::get_from_search($value);
                foreach ($tricky_topics as $tricky_topic) {
                    foreach(ClipitActivity::get_from_tricky_topic($tricky_topic->id) as $activity){
                        $item_search[] = $activity->id;
                    }
                }
                if(empty($item_ids)) {
                    $item_ids = array_merge($item_ids, $item_search);
                } else {
                    $item_ids = array_intersect($item_ids, $item_search);
                }
                break;
            case 'tags':
                $item_search = array();
                foreach ($value as $tag_name) {
                    $tags = ClipitTag::get_from_search($tag_name);
                    foreach ($tags as $tag) {
                        $tricky_topics = ClipitTag::get_tricky_topics($tag->id);
                        foreach($tricky_topics as $tricky_topic_id){
                            foreach(ClipitActivity::get_from_tricky_topic($tricky_topic_id) as $activity){
                                $item_search[] = $activity->id;
                            }
                        }
                    }
                }
                if(empty($item_ids)) {
                    $item_ids = array_merge($item_ids, $item_search);
                } else {
                    $item_ids = array_intersect($item_ids, $item_search);
                }
                break;
            case 'teacher':
                if(empty($item_ids)) {
                    $item_ids = array_merge($item_ids, ClipitUser::get_activities((int)$value));
                } else {
                    $item_ids = array_intersect($item_ids, ClipitUser::get_activities((int)$value));
                }
                break;
            case 'status':
                $item_search = array();
                $activities = ClipitActivity::get_all();
                foreach($activities as $activity){
                    if($activity->status == $value){
                        $item_search[] = $activity->id;
                    }
                }
                if(empty($item_ids)) {
                    $item_ids = array_merge($item_ids, $item_search);
                } else {
                    $item_ids = array_intersect($item_ids, $item_search);
                }
                break;
        }
    }
    return $item_ids;
}

function get_timestamp_from_string($string){
    return strtotime(str_replace('/', '-', $string));
}

/**
 * Get format file size
 *
 * @param int $size
 * @return string
 */
function formatFileSize( $bytes, $precision = 0) {
    $s = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
    $e = floor(log($bytes)/log(1024));

    $output = sprintf("%.{$precision}f ".$s[$e], ($bytes/pow(1024, floor($e))));

    return $output;
}

/**
 * @param $id
 * @param $message_destination
 * @return mixed
 */
function get_text_from_quote($id, $message_destination){
    $post = array_pop(ClipitPost::get_by_destination(array($message_destination)));
    return $post[$id-1];
}

/**
 * @param $text_message
 * @return mixed
 */
function text_reference($text_message, $id = 0){
    if(preg_match('/(^|[^a-z0-9_])#([0-9_]+)/i', $text_message)){
        $prex = '/#([0-9_]+)/i';
        preg_match_all($prex, $text_message, $string_regex, PREG_PATTERN_ORDER);
        $string_regexs = $string_regex[1];
        foreach($string_regexs as $string){
            if((int)$string < $id) {
                $text_message = preg_replace(
                    "/\#$string\b/",
                    '<strong class="quote-ref" data-quote-ref="' . $string . '">
                    <a class="btn">#' . $string . '</a>
                </strong>',
                    $text_message);
            }
        }


    }

    if(preg_match('/(^|[^a-z0-9_])@([a-z0-9_]+)/i',$text_message)){
        $prex = '/@([a-z0-9_]+)/i';
        preg_match_all($prex, $text_message, $string_regex, PREG_PATTERN_ORDER);
        $string_regexs = $string_regex[1];
        foreach($string_regexs as $string){
            /// OLD: "/(^|[^a-z0-9_])@".$string."/i"
            $user = array_pop(ClipitUser::get_by_login(array($string)));
            if(!empty($user)){
                $url_link = elgg_view('output/url', array(
                    'href'  => "profile/".$user->login,
                    'title' => "@".$user->login,
                    'text'  => $user->name,
                    'style' => 'border-radius:3px; background: #bae6f6;padding: 1px 5px;font-weight: bold;',
                ));
                $text_message = preg_replace("/\@".$user->login."\b/",'$1'.$url_link, $text_message);
            }
        }
    }
    return $text_message;
}

/**
 * URL video parser
 *
 * @param $url
 * @return array|bool
 */
function is_video_provider($url){
    if ( $parse_url = parse_url($url) ) {
        if ( !isset($parts["scheme"]) )
        {
            $url = "http://$url";
        }
    }
    if(!isset($url) || !filter_var($url, FILTER_VALIDATE_URL)){
        return false;
    }
    $video_patterns = array('#(((http://)?)|(^./))(((www.)?)|(^./))youtube\.com/watch[?]v=([^\[\]()<.,\s\n\t\r]+)#i'
    ,'#(((http://)?)|(^./))(((www.)?)|(^./))youtu\.be/([^\[\]()<.,\s\n\t\r]+)#i'
    ,'/(http:\/\/)(www\.)?(vimeo\.com\/groups)(.*)(\/videos\/)([0-9]*)/'
    ,'/(http:\/\/)(www\.)?(vimeo.com\/)([0-9]*)/'
    ,'/(https:\/\/)(www\.)?(vimeo.com\/)([0-9]*)/');
    $favicon_url_base = "http://www.google.com/s2/favicons?domain=";

    foreach($video_patterns as $video_pattern){
        if (preg_match($video_pattern, $url) > 0){
            // Youtube
            if (strpos($url, 'youtube.com') != false || strpos($url, 'youtu.be') != false) {
                preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $url, $matches);
                return 'http://www.youtube.com/watch?v='.$matches[0];
                // Vimeo
            } else if (strpos($url, 'vimeo.com') != false) {
                preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=vimeo.com/)[^&\n]+#", $url, $matches);
                return "http://vimeo.com/{$matches[0]}";
            }
        }
    }
        return false;
}
function get_video_url_embed($url){
    if (strpos($url, 'youtube.com') != false || strpos($url, 'youtu.be') != false) {
        preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $url, $matches);
        $embed_url = "//youtube.com/embed/".$matches[0];
    } else if (strpos($url, 'vimeo.com') != false) {
        preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=vimeo.com/)[^&\n]+#", $url, $matches);
        $embed_url = "//player.vimeo.com/video/".$matches[0];
    } else {
        return false;
    }
    return $embed_url;
}

/**
 * Get formated time
 * @param int $seconds
 * @return string (hh:mm:ss|mm:ss)
 */
function get_format_time($seconds = 0){
    $time = gmdate("i:s", $seconds);
    if($seconds >=  3600){
        $time = gmdate("H:i:s", $seconds);
    }
    return $time;
}
function difficulty_bar($difficulty, $limit=6, $colors = false){
    $content = "";
    if($difficulty < 3){
        $color = "bg-green";
    }elseif($difficulty >=3 && $difficulty <= 4){
        $color = "bg-yellow";
    }else{
        $color = "bg-red";
    }
    if(!$colors) {
        $color = "bg-blue";
    }
    for($i=1; $i<=$limit; $i++){
        if($i > $difficulty){
            $color = "bg-blue-lighter";
        }
        $content .= '<div class="'.$color.'" style="border-radius: 100px;display: inline-block;width: 12px; height: 12px;">&nbsp;</div> ';
    }
    $content .= "<span class='hide'>{$difficulty}</span>";
    return $content;
}
function rubric_rating_value($value = 0){
    if($value == 0 || !$value){
        return '-';
    } else {
        return floor($value*100)/10;
    }
}
/**
 * Star rating view
 *
 * @param float $average
 * @param int $number
 * @return string
 */
function star_rating_view($average = 0, $number = 5){
    $rest = number_format(($average - floor($average)), 2);
    $average_ceil = ceil($average);
    $qualifications = array(elgg_echo('qual:bad'), elgg_echo('qual:poor'), elgg_echo('qual:regular'), elgg_echo('qual:good'), elgg_echo('qual:gorgeous'));
    $output = "";
    for($i = 1; $i<=$number; $i++){
        $star_class = "fa-star empty";
        if($average_ceil >= $i){
            $star_class = "fa-star";
            if($rest > .25 && $average_ceil == $i){
                $star_class = "fa-star";
                if($rest < .76){
                    $star_class = "fa-star-half-o";
                } else if($rest < .6){
                    $star_class = "fa-star empty";
                }
            }
        }
        $output .= '<i class="fa '.$star_class.'" data-rating="'.$i.'"></i> ';
    }
    return $output;
}
function get_task_completed_count(ClipitTask $task){
    $activity = array_pop(ClipitActivity::get_by_id(array($task->activity)));
    switch($task->task_type){
        case ClipitTask::TYPE_VIDEO_UPLOAD:
            $text = count($task->video_array)."/".count($activity->group_array);
            $count  = (count($task->video_array)/count($activity->group_array)) * 100;
            break;
        case ClipitTask::TYPE_FILE_UPLOAD:
            $text = count($task->storyboard_array)."/".count($activity->group_array);
            $count  = (count($task->storyboard_array)/count($activity->group_array)) * 100;
            break;
        case ClipitTask::TYPE_VIDEO_FEEDBACK:
        case ClipitTask::TYPE_FILE_FEEDBACK:
            $completed = 0;
            foreach($activity->student_array as $user_id){
//                if(ClipitTask::get_completed_status($task->id, $user_id)
//                    && (count(ClipitTask::get_storyboards($task->parent_task)) > 0
//                        || count(ClipitTask::get_videos($task->parent_task)) > 0)){
                if(ClipitTask::get_completed_status($task->id, $user_id)){
                    $completed++;
                }
            }
            $text = $completed."/".count($activity->student_array);
            $count  = ($completed/count($activity->student_array)) * 100;
            break;
        case ClipitTask::TYPE_RESOURCE_DOWNLOAD:
            $completed = 0;
            foreach($activity->student_array as $user_id){
                if(ClipitTask::get_completed_status($task->id, $user_id)){
                    $completed++;
                }
            }
            $text = $completed."/".count($activity->student_array);
            $count  = ($completed/count($activity->student_array)) * 100;
            break;
        case ClipitTask::TYPE_QUIZ_TAKE:
            $completed = 0;
            foreach($activity->student_array as $user_id){
                if(ClipitTask::get_completed_status($task->id, $user_id)){
                    $completed++;
                }
            }
            $text = $completed."/".count($activity->student_array);
            $count  = ($completed/count($activity->student_array)) * 100;
            break;
    }
    return array(
        'text' => $text,
        'count' => round($count)
    );
}
/**
 * Get task status
 *
 * @param ClipitTask $task
 * @param $activity_id
 * @return array
 */
function get_task_status(ClipitTask $task, $group_id = 0, $user_id = null){
    if(!$user_id){
        $user_id = elgg_get_logged_in_user_guid();
    }
    if(!$group_id){
        $group_id = ClipitGroup::get_from_user_activity($user_id, $task->activity);
    }
    $role = array_pop(ClipitUser::get_properties($user_id, array('role')));
    $status = array(
        'icon' => '<i class="fa fa-minus yellow"></i>',
        'text' => elgg_echo('task:pending'),
        'color' => 'yellow',
        'status' => false
    );
    if(hasTeacherAccess($role)){
        $status['text'] = false;
    }
    if(time() < $task->start &&  $task->task_type != ClipitTask::TYPE_OTHER){
        return $status;
    }
    switch($task->task_type){
        case ClipitTask::TYPE_OTHER:
            if(ClipitTask::get_completed_status($task->id, $user_id)){
                $status = array(
                    'icon' => '<i class="fa fa-check green"></i>',
                    'text' => elgg_echo('task:completed'),
                    'color' => 'green',
                    'status' => ClipitTask::get_completed_status($task->id, $group_id),
                );
            }
//            return $status;
            break;
        case ClipitTask::TYPE_VIDEO_UPLOAD:
            foreach($task->video_array as $video_id){
                $group_video = ClipitVideo::get_group($video_id);
                if($group_id == $group_video){
                    $status = array(
                        'icon' => '<i class="fa fa-check green"></i>',
                        'text' => elgg_echo('task:completed'),
                        'color' => 'green',
                        'status' => ClipitTask::get_completed_status($task->id, $group_id),
                        'result' => $video_id
                    );
                }
            }
            break;
        case ClipitTask::TYPE_FILE_UPLOAD:
            foreach($task->storyboard_array as $storyboard_id){
                $group_sb = ClipitStoryboard::get_group($storyboard_id);
                if($group_id == $group_sb){
                    $status = array(
                        'icon' => '<i class="fa fa-check green"></i>',
                        'text' => elgg_echo('task:completed'),
                        'color' => 'green',
                        'status' => ClipitTask::get_completed_status($task->id, $group_id),
                        'result' => $storyboard_id
                    );
                }
            }
            break;
        case ClipitTask::TYPE_FILE_FEEDBACK:

            $entities = ClipitTask::get_storyboards($task->parent_task);
            $evaluation_list = get_filter_evaluations($entities, $task->activity, $user_id);
            $total = count($evaluation_list["evaluated"]) + count($evaluation_list["no_evaluated"]);
            $total_evaluated = count($evaluation_list["evaluated"]);
            $text = "";
            if($total > 0){
                $text = $total_evaluated."/".$total;
            }
            if(ClipitTask::get_completed_status($task->id, $user_id)){
                $custom = array(
                    'icon' => '<i class="fa fa-check green"></i>',
                    'text' => $text." ".elgg_echo('task:completed'),
                    'color' => 'green',
                );
            } else {
                $custom = array(
                    'icon' => '<i class="fa fa-minus yellow"></i>',
                    'text' => $text." ".elgg_echo('task:pending'),
                    'color' => 'yellow',
                );
            }
            $status = array_merge(
                array(
                    'count' => $text,
                    'status' => ClipitTask::get_completed_status($task->id, $user_id)
                ), $custom);
            break;
        case ClipitTask::TYPE_VIDEO_FEEDBACK:
            $entities = ClipitTask::get_videos($task->parent_task);
            $evaluation_list = get_filter_evaluations($entities, $task->activity, $user_id);
            $total = count($evaluation_list["evaluated"]) + count($evaluation_list["no_evaluated"]);
            $total_evaluated = count($evaluation_list["evaluated"]);
            $text = "";
            if($total > 0){
                $text = $total_evaluated."/".$total;
            }
            if(ClipitTask::get_completed_status($task->id, $user_id)){
                $custom = array(
                    'icon' => '<i class="fa fa-check green"></i>',
                    'text' => $text." ".elgg_echo('task:completed'),
                    'color' => 'green',
                );
            } else {
                $custom = array(
                    'icon' => '<i class="fa fa-minus yellow"></i>',
                    'text' => $text." ".elgg_echo('task:pending'),
                    'color' => 'yellow',
                );
            }
            $status = array_merge(
                array(
                    'count' => $text,
                    'status' => ClipitTask::get_completed_status($task->id, $user_id)
                ), $custom);
            break;
        case ClipitTask::TYPE_QUIZ_TAKE:
            $quiz_id = $task->quiz;
            if($task->status == ClipitTask::STATUS_FINISHED) {
                if (ClipitQuiz::has_finished_quiz($quiz_id, $user_id)) {
                    $status = array(
                        'icon' => '<i class="fa fa-check green"></i>',
                        'text' => elgg_echo('task:completed'),
                        'color' => 'green',
                    );
                } else {
                    $status = array(
                        'icon' => '<i class="fa fa-times red"></i>',
                        'text' => elgg_echo('task:not_completed'),
                        'color' => 'red',
                        'status' => true
                    );
                }
            } else {
                $text = ClipitQuiz::questions_answered_by_user($task->quiz, $user_id).'/'.count(ClipitQuiz::get_quiz_questions($task->quiz));
                $status = array(
                    'icon' => '<i class="fa fa-minus yellow"></i>',
                    'text' => $text.' '.elgg_echo('task:pending'),
                    'color' => 'yellow',
                    'status' => false
                );
                if(!get_config('quiz_results_after_task_end') && ClipitQuiz::has_finished_quiz($quiz_id, $user_id)){
                    $status = array(
                        'icon' => '<i class="fa fa-check green"></i>',
                        'text' => elgg_echo('task:completed'),
                        'color' => 'green',
                    );
                }
            }
            break;
        case ClipitTask::TYPE_RESOURCE_DOWNLOAD:
            switch(ClipitTask::get_status($task->id)){
                case ClipitTask::STATUS_FINISHED:
                case ClipitTask::STATUS_ACTIVE:
                    if(ClipitTask::get_completed_status($task->id, $user_id)){
                        $status = array(
                            'icon' => '<i class="fa fa-check green"></i>',
                            'text' => elgg_echo('task:completed'),
                            'color' => 'green',
                        );
                    } elseif(ClipitTask::get_status($task->id) == ClipitTask::STATUS_ACTIVE) {
                        $status = array(
                            'icon' => '<i class="fa fa-minus yellow"></i>',
                            'text' => elgg_echo('task:pending'),
                            'color' => 'yellow',
                            'status' => false
                        );
                    } else {
                        $status = array(
                            'icon' => '<i class="fa fa-times red"></i>',
                            'text' => elgg_echo('task:not_completed'),
                            'color' => 'red',
                            'status' => true
                        );
                    }
                    break;
            }
            break;
    }

    if($task->end <= time() && $status['status'] === false){
        $status = array(
            'icon' => '<i class="fa fa-times red"></i>',
            'text' => $text." ".elgg_echo('task:not_completed'),
            'count' => $text,
            'color' => 'red',
            'status' => false
        );
    }
    if(hasTeacherAccess($role)){
        $status['text'] = false;
    }
    return $status;
}

/**
 * Get group progress from activity
 *
 * @param $group_id
 * @return float
 */
function get_group_progress($group_id){
    $activity_id = ClipitGroup::get_activity($group_id);
    $activity = array_pop(ClipitActivity::get_by_id(array($activity_id)));
    $individual_tasks = array(
        ClipitTask::TYPE_VIDEO_FEEDBACK,
        ClipitTask::TYPE_FILE_FEEDBACK,
        ClipitTask::TYPE_QUIZ_TAKE,
        ClipitTask::TYPE_RESOURCE_DOWNLOAD
    );
    $total = 0;
    $completed = 0;
    $group_users = ClipitGroup::get_users($group_id);
    $tasks = ClipitTask::get_by_id($activity->task_array);
    $count = count($activity->task_array) == 0 ? 1 :count($activity->task_array);
    $each = round(100/$count);
    foreach($tasks as $task){
        if (in_array($task->task_type, $individual_tasks)) {
            $each_part = $each/(count($group_users));
            foreach ($group_users as $user_id) {
                if (ClipitTask::get_completed_status($task->id, $user_id)) {
                    $completed += $each_part;
                }
            }
        } else {
            if (ClipitTask::get_completed_status($task->id, $group_id)) {
                $completed += $each;
            }
        }
    }
    return round($completed);
}

/**
 * Get current activity status
 *
 * @param $status ClipitActivity->status
 * @return array
 */
function get_activity_status($status){
    switch($status){
        case ClipitActivity::STATUS_ENROLL:
            $output = array(
                'icon' => 'clock-o',
                'color' => 'yellow',
                'text' => elgg_echo('status:enroll'),
                'change_to' => elgg_echo('status:active'),
                'btn_change_to' => '<span class="change-status btn btn-border-green btn-xs" data-status="active"><strong><i class="fa fa-play green"></i> '.elgg_echo('status:active').'</strong></span>'
            );
            break;
        case ClipitActivity::STATUS_ACTIVE:
            $output = array(
                'icon' => 'play',
                'color' => 'green',
                'text' => elgg_echo('status:active'),
                'text_tooltip' => elgg_echo('status:change_to:closed:tooltip'),
                'change_to' => elgg_echo('status:closed'),
                'btn_change_to' => '<span class="change-status btn btn-border-red btn-xs" data-status="closed"><strong><i class="fa fa-stop red"></i> '.elgg_echo('status:closed').'</strong></span>'
            );
            break;
        case ClipitActivity::STATUS_CLOSED:
            $output = array(
                'icon' => 'stop',
                'color' => 'red',
                'text' => elgg_echo('status:closed'),
                'text_tooltip' => elgg_echo('status:change_to:active:tooltip'),
                'change_to' => elgg_echo('status:active'),
                'btn_change_to' => '<span class="change-status btn btn-border-green btn-xs" data-status="active"><strong><i class="fa fa-play green"></i> '.elgg_echo('status:active').'</strong></span>'
            );
            break;
    }
    return $output;
}

/**
 * array_chunk() php function, balanced
 *
 * @param $l
 * @param $n
 * @return array
 */
function split_chunks($l, $n){

    $result = array_fill(0, $n, array());
    $sums   = array_fill(0, $n, 0);
    $c = 0;
    foreach ($l as $e){
        foreach ($sums as $i=>$sum){
            if ($c == $sum){
                $result[$i][] = $e;
                break;
            } // if
        } // foreach
        $sums[$i] += $e;
        $c = min($sums);
    } // foreach
    return $result;
}

/**
 * Education level for Tricky Topic
 *
 * @param string $level
 * @return array
 */
function get_education_levels($level = ''){
    $default_ed_levels = array(
        ClipitTrickyTopic::EDUCATION_LEVEL_PRIMARY,
        ClipitTrickyTopic::EDUCATION_LEVEL_GCSE,
        ClipitTrickyTopic::EDUCATION_LEVEL_ALEVEL,
        ClipitTrickyTopic::EDUCATION_LEVEL_UNIVERSITY,
    );
    $ed_levels = array('' => '');
    foreach($default_ed_levels as $ed_level){
        $ed_levels[$ed_level] = elgg_echo('education_level:'.$ed_level);
    }
    if($level){
        return $ed_levels[$level];
    } else {
        return $ed_levels;
    }
}

function get_rubric_items_from_resource($resource_id){
    $object = ClipitSite::lookup($resource_id);
    $task_id = $object['subtype']::get_task($resource_id);
    if($task_child_id = ClipitTask::get_child_task($task_id)) {
        $task_feedback = array_pop(ClipitTask::get_by_id(array(ClipitTask::get_child_task($task_id))));
        $rubric = array_pop(ClipitRubric::get_by_id(array($task_feedback->rubric)));
        if (count($rubric->rubric_item_array) > 0) {
            return ClipitRubricItem::get_by_id($rubric->rubric_item_array, 0, 0, 'time_created', false);
        }
    }
    return false;
}

function get_task_properties_action($task){
    $date_format = 'd/m/y H:i';
    if(preg_match("/(\w{2})\/(\w{2})\/(\w{4})/", $task['start'])){ // dd/mm/yyyy
        $date_format = 'd/m/Y H:i';
    }
    return array(
        'name' => $task['title'],
        'description' => $task['description'],
        'start' => date_create_from_format($date_format, $task['start'])->getTimestamp(),
        'end' => date_create_from_format($date_format, $task['end'])->getTimestamp(),
    );
}

function hasTeacherAccess($role){
    if(!$role){
        $user = array_pop(ClipitUser::get_by_id(array(elgg_get_logged_in_user_guid())));
        $role = $user->role;
    }
    if($role == ClipitUser::ROLE_TEACHER || $role == ClipitUser::ROLE_ADMIN){
        return true;
    }
    return false;
}