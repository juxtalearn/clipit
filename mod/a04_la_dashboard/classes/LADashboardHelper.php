<?php

class LADashboardHelper
{
    public static function getStumblingBlocksFromQuiz($quiz_id) {
        $stumbling_blocks = array();
        $questions = ClipitQuiz::get_quiz_questions($quiz_id);
        foreach ($questions as $question_id) {
            $sbs_for_question = ClipitQuizQuestion::get_tags($question_id);
            $stumbling_blocks = array_merge($stumbling_blocks, $sbs_for_question);
        }
        $result_array = array();
        foreach ($stumbling_blocks as $sb_id) {
            $sb = get_entity($sb_id);
            $result_array[$sb_id] = $sb->name;
        }
//        error_log("HelperResults($quiz_id): ".print_r($result_array, true));
        return $result_array;
    }

    public static function getGroupBundle($activityId = null)
    {
        $returnValue = array(array('id' => 0, 'name' => elgg_echo("la_dashboard:widget:quizresult:selectgroup")),array('id'=> 'all','name'=>elgg_echo("all")));
        if (isset($activityId)) {
            $group_ids = ClipitActivity::get_groups($activityId);
            $groups = ClipitGroup::get_by_id($group_ids);
            foreach ($groups as $group) {
                $bundle = array('id' => $group->id, 'name' => $group->name);
                $returnValue[] = $bundle;
            }
        }
        return $returnValue;
    }


    public static function getGroupBundlePHP($activityId = null)
    {
        $bundle = LADashboardHelper::getGroupBundle($activityId);
        $returnValue = array();
        foreach ($bundle as $item) {
            $returnValue[$item['id']] = $item['name'];
        }
        return $returnValue;
    }


    public static function getUserBundle($activityId = null)
    {
        $returnValue = array(array('id' => 0, 'name' => elgg_echo("la_dashboard:widget:quizresult:selectuser")));
        if (isset($activityId)) {
            $user_ids = ClipitActivity::get_students($activityId);
             $users = ClipitUser::get_by_id($user_ids);
            foreach ($users as $user) {
                $bundle = array('id' => $user->id, 'name' => $user->name);
                $returnValue[] = $bundle;
            }
        }
        return $returnValue;
    }


    public static function getUserBundlePHP($activityId = null)
    {
        $bundle = LADashboardHelper::getUserBundle($activityId);
        $returnValue = array();
        foreach ($bundle as $item) {
            $returnValue[$item['id']] = $item['name'];
        }
        return $returnValue;
    }



    public static function getQuizTasks($activityId = null)
    {
        $task_ids = ClipitActivity::get_tasks($activityId);
        $returnValue = array(array('id' => 0, 'name' => elgg_echo("la_dashboard:widget:quizresult:selectTask")));
        if (isset($activityId)) {
            $tasks = ClipitTask::get_by_id($task_ids);
            foreach ($tasks as $task) {
                if ($task->task_type == ClipitTask::TYPE_QUIZ_TAKE) {
                    if ($task->quiz) {
                        $bundle = array('id' => $task->quiz, 'name' => $task->name);
                        $returnValue[] = $bundle;
                    } else {
                        error_log("WARNING: quiztask without quiz found. Task ID: $task->id");
                    }
                }
            }
        }
        return $returnValue;
    }

    public static function getQuizTasksPHP($activityId = null)
    {
        $bundle = LADashboardHelper::getQuizTasks($activityId);
        $returnValue = array();
        foreach ($bundle as $item) {
            $returnValue[$item['id']] = $item['name'];
        }

        return $returnValue;
    }


    public static function getProgressBundle($activityId,$group_id) {
        $task_ids = ClipitActivity::get_tasks($activityId);
        $act_start = new DateTime();
        $activity_start = array_pop(ClipitActivity::get_by_id(array($activityId)))->start;
        $act_start->setTimestamp($activity_start);
        $tasks = ClipitTask::get_by_id($task_ids);
        $data = array();
        foreach ($tasks as $task){

            $object=array();
            $object['label']=$task->name;
            $dateObject = new DateTime();
            $task_start=$dateObject->setTimestamp($task->start);
            $dateObject = new DateTime();
            $task_end=$dateObject->setTimestamp($task->end);

            $object['plannedStart']['day']=date_diff($task_start,$act_start)->days;
            $object['plannedStart']['date']=$task->start;
            $object['plannedEnd']['day']= date_diff($task_end,$act_start)->days;
            $object['plannedEnd']['date']= $task->end;
            $object['realStart']['day']= date_diff($task_start,$act_start)->days+1;
            $object['realStart']['date']= $task->start + 3000*60*60*24;
            $object['realEnd']['day']= date_diff($task_end,$act_start)->days-1;
            $object['realEnd']['date']=$task->end - 3000*60*60*24;
            $label = $task->name;
            $completed = ClipitTask::get_completed_status($task->id,$group_id);

            if  ( $completed ) {
                error_log($completed);
            }
            $data[]=$object;
        }
        return array('data' =>$data);
    }
}