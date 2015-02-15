<?php

class LADashboardHelper
{
    public static function getGroupBundle($activityId = null)
    {
        $returnValue = array(array('id' => 0, 'name' => elgg_echo("la_dashboard:widget:quizresult:selectgroup")));
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
            error_log("UserIds:".print_r($user_ids,true));//DEBUG
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
}