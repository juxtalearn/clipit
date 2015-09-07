<?php

class LADashboardHelper
{
    public static function getStumblingBlocksFromQuiz($quiz_id)
    {
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

    public static function getStumblingBlocksFromActivity($activity_id)
    {
        $tt_id = ClipitActivity::get_tricky_topic($activity_id);
        $stumbling_block_ids = ClipitTrickyTopic::get_tags($tt_id);
        $result_array = ClipitTag::get_by_id($stumbling_block_ids);
        return $result_array;
    }


    private static function belongs_to_group($item_id,$group_id,$subtype) {

        $item  =  array_pop(call_user_func(array($subtype,'get_by_id'),array($item_id)));
        $owner_id = $item->owner_id;

        if ( $owner_id === $group_id) { //owner is the group itself
            return true;
        } else { //owner is a user assigned to this group
            foreach (ClipitGroup::get_users($group_id) as $user_id) {
                error_log("$group_id:$user_id===$owner_id" );
                if ($owner_id === $user_id) {
                    return true;
                }
            }
        }
        return false;
    }

    private static function count_tag_group_relations($tag_id, $subtype, $group_id) {
        $sum = 0;
        foreach ( UBCollection::get_items($tag_id,$subtype.'-'.ClipitTag::SUBTYPE,true,false) as $item ) {
            if ( static::belongs_to_group($item,$group_id,$subtype ) ) {
                $sum++;
            }
        }
        return $sum;
    }

    private static function belongs_to_activity($item_id,$activity_id,$subtype) {

        $item  =  array_pop(call_user_func(array($subtype,'get_by_id'),array($item_id)));
        $owner_id = $item->owner_id;

        if ( $owner_id === $activity_id) { //owner is the group itself
            return true;
        } else { //owner is a user assigned to this group
            foreach (ClipitActivity::get_students($activity_id) as $user_id) {
                error_log("$activity_id:$user_id===$owner_id" );
                if ($owner_id === $user_id) {
                    return true;
                }
            }
        }
        return false;
    }

    private static function count_tag_activity_relations($tag_id, $subtype, $activity_id) {
        $sum = 0;
        foreach ( UBCollection::get_items($tag_id,$subtype.'-'.ClipitTag::SUBTYPE,true,false) as $item ) {
            if ( static::belongs_to_activity($item,$activity_id,$subtype ) ) {
                $sum++;
            }
        }
        return $sum;
    }
    public static function getStumblingBlocksUsage($activity_id, $group_id = null)
    {
        $tag_array = LADashboardHelper::getStumblingBlocksFromActivity($activity_id);
        $stumbling_block_array = array();
        if (is_null($group_id)) {
            foreach ($tag_array as $block) {
                $sum = 0;
                $sum += static::count_tag_activity_relations($block->id, ClipitFile::SUBTYPE, $activity_id);
                $sum += static::count_tag_activity_relations($block->id, ClipitStoryboard::SUBTYPE, $activity_id);
                $sum += static::count_tag_activity_relations($block->id, ClipitVideo::SUBTYPE, $activity_id);
                $sum += static::count_tag_activity_relations($block->id, ClipitComment::SUBTYPE, $activity_id);
                $stumbling_block_array[$block->name] = array('sum' => $sum, 'id' =>$block->id);
            }
        } else {
            foreach ($tag_array as $block) {
                $sum = 0;
                $sum += static::count_tag_group_relations($block->id, ClipitFile::SUBTYPE, $group_id);
                $sum += static::count_tag_group_relations($block->id, ClipitStoryboard::SUBTYPE, $group_id);
                $sum += static::count_tag_group_relations($block->id, ClipitVideo::SUBTYPE, $group_id);
                $sum += static::count_tag_group_relations($block->id, ClipitComment::SUBTYPE, $group_id);
                $stumbling_block_array[$block->name] = array('sum' => $sum, 'id' =>$block->id);
            }
        }
        return $stumbling_block_array;
    }

    public static function getGroupBundle($activityId = null, $addAll = true)
    {
        if ($addAll) {
            $returnValue = array(array('id' => 0, 'name' => elgg_echo("la_dashboard:widget:selectgroup")), array('id' => 'all', 'name' => elgg_echo("all")));

        } else {
            $returnValue = array(array('id' => 0, 'name' => elgg_echo("la_dashboard:widget:selectgroup")));
        }
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


    public static function getGroupBundlePHP($activityId = null, $addAll = true)
    {
        $bundle = LADashboardHelper::getGroupBundle($activityId, $addAll);
        $returnValue = array();
        foreach ($bundle as $item) {
            $returnValue[$item['id']] = $item['name'];
        }
        return $returnValue;
    }


    public static function getUserBundle($activityId = null)
    {
        $returnValue = array(array('id' => 0, 'name' => elgg_echo("la_dashboard:widget:selectuser")));
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
        $returnValue = array(array('id' => 0, 'name' => elgg_echo("la_dashboard:widget:quizresult:selectquiz")));
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


    public static function getProgressBundle($activityId, $group_id)
    {
        $task_ids = ClipitActivity::get_tasks($activityId);
        $act_start = new DateTime();
        $activity_start = array_pop(ClipitActivity::get_by_id(array($activityId)))->start;
        $act_start->setTimestamp($activity_start);
        $tasks = ClipitTask::get_by_id($task_ids);
        $data = array();
        foreach ($tasks as $task) {

            $object = array();
            $object['label'] = $task->name;
            $dateObject = new DateTime();
            $task_start = $dateObject->setTimestamp($task->start);
            $dateObject = new DateTime();
            $task_end = $dateObject->setTimestamp($task->end);

            $object['plannedStart']['day'] = date_diff($task_start, $act_start)->days;
            $object['plannedStart']['date'] = $task->start;
            $object['plannedEnd']['day'] = date_diff($task_end, $act_start)->days;
            $object['plannedEnd']['date'] = $task->end;
            $object['realStart']['day'] = date_diff($task_start, $act_start)->days + 1;
            $object['realStart']['date'] = $task->start + 3 * 60 * 60 * 24;
            $object['realEnd']['day'] = date_diff($task_end, $act_start)->days - 1;
            $object['realEnd']['date'] = $task->end - 3 * 60 * 60 * 24;
            $label = $task->name;
            $completed = ClipitTask::get_completed_status($task->id, $group_id);

            if ($completed) {
                error_log($completed);
            }
            $data[] = $object;
        }
        return array('data' => $data);
    }

    public static function assembleUserData($user_id, $user_name)
    {
        global $CONFIG;
        global $con;
        $con->set_charset("utf8");
        $query = "SELECT * FROM ".$CONFIG->dbprefix."entity_relationships WHERE guid_two = " . $user_id . " AND relationship LIKE 'ClipitActivity-%';";
        $relationships = mysqli_query($con, $query);
        $result_data = new stdClass();
        $result_data->user_name = $user_name;
        $result_data->user_id = $user_id;
        $streams = array();
        if ($relationships) {
            foreach ($relationships as $rel) {
                $activity_id = $rel['guid_one'];
                $activity_stream = array();
                $activity_stream_result = mysqli_query($con, "SELECT * FROM ".$CONFIG->dbprefix."activitystreams WHERE activity_id = " . $activity_id . " ORDER BY timestamp DESC;");
                while ($row = mysqli_fetch_array($activity_stream_result, MYSQLI_ASSOC)) {
                    $activity_stream[] = $row['json'];
                }
                $name_id_result = mysqli_query($con, "SELECT * FROM ".$CONFIG->dbprefix."metadata WHERE entity_guid = " . $activity_id . " AND name_id = 10;");
                $name_id = mysqli_fetch_array($name_id_result, MYSQLI_ASSOC)['value_id'];
                $name_result = mysqli_query($con, "SELECT * FROM ".$CONFIG->dbprefix."metastrings WHERE id = " . $name_id . ";");
                $name = mysqli_fetch_array($name_result, MYSQLI_ASSOC)['string'];
                $activity = new stdClass();
                $activity->aid = $activity_id;
                $activity->name = $name;
                $activity->stream = $activity_stream;
                $streams[] = $activity;
            }
        } else
            die("no mysql results found for user $user_name($user_id)");
        $result_data->activities = $streams;
        $json = json_encode(array($result_data));
        return $json;
    }
}