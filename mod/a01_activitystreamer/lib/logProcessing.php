<?php
function storeJSON($action)
{
    global $con;
    global $transaction_stmt;
    $action['object']['content'] = urldecode($action['object']['content']);
    $action['object']['content'] = strip_tags($action['object']['content']);
    $action['object']['objectTitle'] = urldecode($action['object']['objectTitle']);
    $action['object']['objectTitle'] = strip_tags($action['object']['objectTitle']);
    $activity_json = json_encode($action);
    if ($transaction_stmt instanceof mysqli_stmt && $action['verb'] != "Ignore") {
        $transaction_stmt->bind_param('ssiiiiissi', $action['transactionId'], $activity_json, $action['actor']['actorId'], $action['object']['objectId'], $action['object']['groupId'],
            $action['object']['courseId'], $action['object']['activityId'], $action['verb'], $action['actor']['objectType'], $action['published']);
        $transaction_stmt->execute();
    } else {
        error_log(mysqli_error($con));
    }
}

function processURL($url)
{
    $object_Id = 0;
    $values = explode("/", $url);
    $object_Id = end($values);
    return $object_Id;
}

function convertURLToActivityStream($url)
{
    GLOBAL $con;

    $transaction_id = $_SESSION['tid'];
    $object_Id = processURL($url);
    if ($object_Id != 0) {
        $published = time();
        $user = elgg_get_logged_in_user_entity();
        $ip_address = sanitise_string($_SERVER['REMOTE_ADDR']);
        if (is_null($ip_address)) {
            $ip_address = "";
        }
        $actor['IPAddress'] = $ip_address;
        $actor['displayName'] = $user->name;
        $actor['actorId'] = $user->guid;
        // $actor['objectType'] = $transaction[0]['Role'];
        // $actor['groupId'] = $transaction[0]['GroupId'];
        // $actor['courseId'] = $transaction[0]['CourseId'];
        // $actor['activityId'] = $transaction[0]['ActivityId'];

        $object = get_entity($object_Id);
        if (!is_null($object)) {
            $verb = "view";
            $object['objectId'] = $object->guid;
            $object['displayName'] = $object->title;
            $object['objectType'] = $object->getType();
            $object['objectSubtype'] = $object->getSubtype();
            $object['objectClass'] = $object->getClass();
            $object['ownerGUID'] = $object->getOwnerGUID();
            $object['content'] = "";
            $activity_id = 0;
            $group_id = 0;
            $course_id = 0;
            if (class_exists(ClipitActivity) AND class_exists(ClipitGroup)) {
                $temp_array = get_entity_relationships($object['objectId'], true);
                foreach ($temp_array as $rel) {
                    if ($rel->relationship == ClipitActivity::REL_ACTIVITY_FILE OR $rel->relationship == ClipitActivity::REL_ACTIVITY_TASK OR $rel->relationship == ClipitActivity::REL_ACTIVITY_VIDEO) {
                        $activity_id = $rel->guid_one;
                    } elseif ($rel->relationship == ClipitGroup::REL_GROUP_FILE /*OR $rel->relationship == ClipitGroup::REL_GROUP_TASK OR $rel->relationship == ClipitGroup::REL_GROUP_VIDEO */) {
                        $group_id = $rel->guid_one;
                    }
                    //TODO Add support for courses when available
                }

                //$role = ClipitUser::get_properties($performed_by, array("role"));
            }
            $object['groupId'] = $group_id;
            $object['courseId'] = $course_id;
            $object['activityId'] = $activity_id;
        } else {
            $verb = "Unidentified";
            mysqli_query($con, "INSERT INTO `tracking` " .
                "(transaction_id, url) " .
                "VALUES ('" . $transaction_id . "', '" . $url . "');");
        }
    } else {
        mysqli_query($con, "INSERT INTO `tracking` " .
            "(transaction_id, url) " .
            "VALUES ('" . $transaction_id . "', '" . $url . "');");
        $verb = "Unidentified";
    }
    $activity = array('actor' => $actor, 'verb' => $verb, 'object' => $object, 'published' => $published, 'transactionId' => $transaction_id);
    return $activity;
}

function convertLogTransactionToActivityStream($transaction)
{
    global $con;
    set_time_limit(300);
    $transaction = removeAPILogins($transaction);

    global $CONFIG;
    $actor = array('IPAddress' => "", 'displayName' => "", 'actorId' => "", 'objectType' => "", 'groupId' => "", 'courseId' => "", 'activityId' => "");
    $verb = "";
    $object = array('objectId' => "", 'objectTitle' => "", 'objectType' => "", 'objectSubtype' => "", 'objectClass' => "", 'ownerGUID' => "", 'content' => "", 'targetId' => "", 'groupId' => "", 'courseId' => "", 'activityId' => "");
    $published = "";
    $transaction_id = $transaction[0]['TransactionId'];
    $type = determineActivityType($transaction);

// 	Getting the data about the actor is always the same, since we can just use the first log entry from the transaction
    $actor['IPAddress'] = $transaction[0]['IPAddress'];
    $actor['displayName'] = $transaction[0]['UserName'];
    $actor['actorId'] = $transaction[0]['UserId'];
    $actor['objectType'] = $transaction[0]['Role'];
    $actor['groupId'] = $transaction[0]['GroupId'];
    $actor['courseId'] = $transaction[0]['CourseId'];
    $actor['activityId'] = $transaction[0]['ActivityId'];

    if (is_null($actor['objectType']) || $actor['objectType'] == "") {
        $user_properties = ClipitUser::get_properties($actor['actorId']);
        if (is_not_null($user_properties) && !empty($user_properties['role']) && !($user_properties['role'] == "")) {
            $actor['objectType'] = $user_properties['role'];
        } else {
            $actor['objectType'] = "n/a";
        }
    }

    // For some values, we need to determine the line number
    $l = 0;

    // These will most likely be zero, but sometimes we can put a value into them...
    $course_id = 0;
    $group_id = 0;


//	Same is true for the published value except for mocked up versions...
    $published = $transaction[0]['Timestamp'];

//  The rest is up to the identified action:
    switch ($type) {
        case "Unidentified":
            $verb = "Unidentified";
            break;
        case "Discussion": //Posts and comments
            $object['objectTitle'] = $transaction[0]['ObjectTitle'];
            $l = findValue($transaction, "create", ClipitPost::SUBTYPE, "ObjectId", TRUE);
            if ($l > 0) {
                //If we find a create, we need to make sure there are no updates in the same transaction:
                $l = findValue($transaction, "update", ClipitPost::SUBTYPE, "ObjectId", TRUE);
                if ($l > 0) {
                    //If we find an update, we need to make sure its the second update
                    if (isset($transaction[$l + 1]['Event']) && $transaction[$l + 1]['Event'] == "update") {
                        $l = $l + 1;
                    }
                } else {
                    //Reset to create line:
                    $l = findValue($transaction, "create", ClipitPost::SUBTYPE, "ObjectId", TRUE);
                }
            } else {
                $l = findValue($transaction, "create", ClipitComment::SUBTYPE, "ObjectId", TRUE);

            }
            $verb = "annotate";
            $object['objectId'] = $transaction[$l]['ObjectId'];
            $object['objectType'] = $transaction[$l]['ObjectType'];
            $object['objectSubtype'] = $transaction[$l]['ObjectSubtype'];
            $object['objectClass'] = $transaction[$l]['ObjectClass'];
            $object['ownerGUID'] = $transaction[$l]['OwnerGUID'];
            $object['content'] = $transaction[$l]['Content'];
            $published = $transaction[$l]['Timestamp'];

            $values = findValue($transaction, "create", $transaction[$l]['ObjectSubtype'] . "-destination", "Content", FALSE);
            if (!(strpos($values, "-") !== false) && !($values == "new")) {
//                error_log("Missing destination line!");
                $verb = "Unidentified";
                break;
            } else {
                if ($values == "new") {
                    $target_id = "new";
                } else {
                    $ids = preg_split('/[-]/', $values);
                    $target_id = $ids[1];
                }
            }


            if ($target_id == "new") {
                $activity_id = determineActivityId($transaction[$l]['ObjectId']);
                if ($activity_id == 0) {
                    $group_id = getGroupIdFromObjectId($transaction[$l]['ObjectId']);
                    $target_id = $group_id;
                } else {
                    $target_id = $activity_id;
                }
            } else {
                $activity_id = determineActivityId($target_id);
            }

            $type = determineObjectType($target_id);
            $object['targetId'] = $target_id;
            $object['targetType'] = $type[0];
            $object['targetSubtype'] = $type[1];
            $object['targetTitle'] = getObjectTitle($target_id);

            if ($activity_id > 0 && $group_id == 0) {
                $group_id = determineGroupId($transaction[0]['UserId'], $activity_id);
            } else {
                //If activityId couldn't be determined it might be due to object beeing posted to a group instead of to an activity
                if ($group_id == 0) {
                    $group_id = getGroupIdFromObjectId($target_id);
                }
                $group = get_entity($group_id);
                if ($group instanceof ElggEntity && $group->getSubtype() == ClipitGroup::SUBTYPE) {
                    $activity_id = getActivityIdFromGroupId($group_id);
                } else {
                    //if target is a video it we have to determine the task where it was posted and determine the activitiy_id from that one
                    if ($type[1] == ClipitVideo::SUBTYPE) {

                        $task_id = determineTaskId($target_id);
                        $activity_id = determineActivityId($task_id);
                    }
                }


            }



            /*
                        if ($transaction[$l]['ObjectSubtype'] == ClipitPost::SUBTYPE && ($target_id == 0 || $target_id == "")) {
                            error_log("Missing target: ".$object['objectId']);
                        }
            **/
            $object['groupId'] = $group_id;
            $object['courseId'] = $course_id;
            $object['activityId'] = $activity_id;

            //$verb = $transaction[$l]['ObjectSubtype'];
            break;
        case "Login":
            $verb = "login";
            $object['objectType'] = "site";
            $object['objectSubtype'] = $transaction[0]['ObjectSubtype'];
            $object['objectClass'] = $transaction[0]['ObjectClass'];
            $object['ownerGUID'] = $transaction[0]['OwnerGUID'];
            $object['content'] = elgg_get_site_url($CONFIG->site_guid);
            $object['groupId'] = "0";
            $object['courseId'] = "0";
            $object['activityId'] = "0";
            break;
        case "VideoUpload":
            $verb = "upload";
            $l = findValue($transaction, "create", ClipitVideo::SUBTYPE, "ObjectId", TRUE);
            $object['objectTitle'] = $transaction[$l]['Content'];
            $object['objectId'] = $transaction[$l]['ObjectId'];
            $object['objectType'] = $transaction[$l]['ObjectType'];
            $object['objectSubtype'] = $transaction[$l]['ObjectSubtype'];
            $object['objectClass'] = $transaction[$l]['ObjectClass'];
            $object['ownerGUID'] = $transaction[$l]['OwnerGUID'];
            $object['content'] = $transaction[$l]['Content'];
            $published = $transaction[$l]['Timestamp'];

            $video_id = $transaction[$l]['ObjectId'];
            $activity_id = determineActivityId($video_id);
            if ($activity_id > 0) {
                $group_id = determineGroupId($transaction[0]['UserId'], $activity_id);
            } else {
                //If activityId couldn't be determined it might be due to object being posted to a group instead of an activity
                $group_id = getGroupIdFromObjectId($video_id);
                $group = get_entity($group_id);
                if ($group instanceof ElggEntity && $group->getSubtype() == ClipitGroup::SUBTYPE) {
                    $activity_id = getActivityIdFromGroupId($group_id);
                } else {
                    //perhaps it was assigned to a task
                    $task_id = determineTaskId($video_id);
                    $activity_id = determineActivityId($task_id);
                }
            }
            $type = determineObjectType($activity_id);
            $object['targetId'] = $activity_id;
            $object['targetType'] = $type[0];
            $object['targetSubtype'] = $type[1];

            $object['groupId'] = $group_id;
            $object['courseId'] = $course_id;
            $object['activityId'] = $activity_id;
            foreach ($transaction as $key => $line) {
                if ($line['Event'] == 'create' && $line['ObjectType'] == 'relationship') {
                    $temptrans[0] = $line;
                    $activity = convertLogTransactionToActivityStream($temptrans);
                    storeJSON($activity);
                }
            }

            break;
        case "CreateQuiz":
            $verb = "create";
            $l = findValue($transaction, "create", ClipitQuiz::SUBTYPE, "ObjectId", TRUE);

            $object['objectTitle'] = $transaction[$l]['Content'];
            $object['objectId'] = $transaction[$l]['ObjectId'];
            $object['objectType'] = $transaction[$l]['ObjectType'];
            $object['objectSubtype'] = $transaction[$l]['ObjectSubtype'];
            $object['objectClass'] = $transaction[$l]['ObjectClass'];
            $object['ownerGUID'] = $transaction[$l]['OwnerGUID'];
            $object['content'] = $transaction[$l]['Content'];
            $published = $transaction[$l]['Timestamp'];

//            ob_start();
//            var_dump($transaction);
//            $outputasdf = ob_get_contents();
//            ob_end_clean();
//            error_log('testtestestetst '. $outputasdf);

            $quiz_id = $transaction[$l]['ObjectId'];
            $task_id = determineTaskId($quiz_id);
            $activity_id = determineActivityId($task_id);
//            if ($activity_id > 0) {
//                $group_id = determineGroupId($transaction[0]['UserId'], $activity_id);
//            } else {
//                //If activityId couldn't be determined it might be due to object beeing posted to a group instead of an activity
//                $group_id = getGroupIdFromObjectId($video_id);
//                $group = get_entity($group_id);
//                if ($group instanceof ElggEntity && $group->getSubtype() == ClipitGroup::SUBTYPE) {
//                    $activity_id = getActivityIdFromGroupId($group_id);
//                }
//            }
            $type = determineObjectType($activity_id);
            $object['targetId'] = $activity_id;
            $object['targetType'] = $type[0];
            $object['targetSubtype'] = $type[1];

            $object['groupId'] = $group_id;
            $object['courseId'] = $course_id;
            $object['activityId'] = $activity_id;
            foreach ($transaction as $key => $line) {
                if ($line['Event'] == 'create' && $line['ObjectType'] == 'relationship' && $line['Content'] != NULL) {
                    $temptrans[0] = $line;
                    $activity = convertLogTransactionToActivityStream($temptrans);
                    storeJSON($activity);
                }
            }

            break;
        case "FileUpload":
            $verb = "upload";
            $l = findValue($transaction, "create", ClipitFile::SUBTYPE, "ObjectId", TRUE);
            $object['objectTitle'] = $transaction[$l]['Content'];
            $object['objectId'] = $transaction[$l]['ObjectId'];
            $object['objectType'] = $transaction[$l]['ObjectType'];
            $object['objectSubtype'] = $transaction[$l]['ObjectSubtype'];
            $object['objectClass'] = $transaction[$l]['ObjectClass'];
            $object['ownerGUID'] = $transaction[$l]['OwnerGUID'];
            $object['content'] = $transaction[$l]['Content'];
            $published = $transaction[$l]['Timestamp'];

            $video_id = $transaction[$l]['ObjectId'];
            $activity_id = determineActivityId($video_id);
            if ($activity_id > 0) {
                $group_id = determineGroupId($transaction[0]['UserId'], $activity_id);
            } else {
                //If activityId couldn't be determined it might be due to object beeing posted to a group instead of an activity
                $group_id = getGroupIdFromObjectId($video_id);
                $group = get_entity($group_id);
                if ($group instanceof ElggEntity && $group->getSubtype() == ClipitGroup::SUBTYPE) {
                    $activity_id = getActivityIdFromGroupId($group_id);
                }
            }
            $type = determineObjectType($activity_id);
            $object['targetId'] = $activity_id;
            $object['targetType'] = $type[0];
            $object['targetSubtype'] = $type[1];

            $object['groupId'] = $group_id;
            $object['courseId'] = $course_id;
            $object['activityId'] = $activity_id;
            foreach ($transaction as $key => $line) {
                if ($line['Event'] == 'create' && $line['ObjectType'] == 'relationship') {
                    $temptrans[0] = $line;
                    $activity = convertLogTransactionToActivityStream($temptrans);
                    storeJSON($activity);
                }
            }

            break;
        case "CreateActivity":
            $verb = "create";
            $l = findValue($transaction, "create", ClipitActivity::SUBTYPE, "ObjectId", TRUE);
            $title = getObjectTitle($transaction[$l]['ObjectId']);
            $object['objectTitle'] = $title;
            $object['objectId'] = $transaction[$l]['ObjectId'];
            $object['objectType'] = $transaction[$l]['ObjectType'];
            $object['objectSubtype'] = $transaction[$l]['ObjectSubtype'];
            $object['objectClass'] = $transaction[$l]['ObjectClass'];
            $object['ownerGUID'] = $transaction[$l]['OwnerGUID'];
            $object['content'] = $transaction[$l]['Content'];

            $tt_id = findValue($transaction, "create", "tricky_topic", "Content", FALSE);
            if (!($tt_id == "")) {
                $object['targetId'] = $tt_id;
                $object['targetType'] = "tricky_topic";
                $object['targetSubtype'] = "tricky_topic";
            }
            $object['groupId'] = $group_id;
            $object['courseId'] = $course_id;
            $object['activityId'] = $object['objectId'];
            break;
        case "AccountCreation":
            $verb = "createUser";
            $l = findValue($transaction, "create", ClipitUser::SUBTYPE, "ObjectId", TRUE);
            $object['objectId'] = $transaction[$l]['ObjectId'];
            $user_properties = ClipitUser::get_properties($object['objectId']);
            if (is_not_null($user_properties) && !empty($user_properties['role']) && !($user_properties['role'] == "")) {
                $object['objectTitle'] = urlencode(getObjectTitle($transaction[$l]['ObjectId']));
            }
            $object['objectType'] = $transaction[$l]['ObjectType'];
            $object['objectSubtype'] = $transaction[$l]['ObjectSubtype'];
            $object['objectClass'] = $transaction[$l]['ObjectClass'];
            $object['ownerGUID'] = $transaction[$l]['OwnerGUID'];
            $object['content'] = elgg_get_site_url($CONFIG->site_guid);
            $object['groupId'] = "0";
            $object['courseId'] = "0";
            $object['activityId'] = "0";
            break;
        case "Logout":
            $verb = "logout";
            $object['objectType'] = "site";
            $object['objectSubtype'] = $transaction[0]['ObjectSubtype'];
            $object['objectClass'] = $transaction[0]['ObjectClass'];
            $object['ownerGUID'] = $transaction[0]['OwnerGUID'];
            $object['content'] = elgg_get_site_url($CONFIG->site_guid);
            $object['groupId'] = "0";
            $object['courseId'] = "0";
            $object['activityId'] = "0";
            break;
        case "AssignRelationShip":
            if ($transaction[0]['Event'] == "create") {
                $l = 0;
            }
            $verb = "add";
            $title = $transaction[$l]['ObjectSubtype'];
            $values = $transaction[$l]['Content'];
            if (!(strpos($title, "-") !== false)) {
//                error_log($transaction_id."\nTitle kaputt: ".$title);
                $verb = "Unidentified";
                break;
            } else {
                $types = preg_split('/[-]/', $title);
            }
            if (!(strpos($values, "-") !== false)) {
//                error_log($transaction_id."\nValues kaputt");
                $verb = "Unidentified";
                break;
            } else {
                $ids = preg_split('/[-]/', $values);
            }
            $object['objectId'] = $ids[1];
            $object['objectTitle'] = $title;
            $object['objectType'] = $transaction[$l]['ObjectType'];
            $object['objectSubtype'] = $types[1];
            if ($object['objectSubtype'] == "destination") {
                $objectId = $object['objectId'];
                $type = determineObjectType($objectId);
                $object['objectSubtype'] = $type[1];
            }


            $object['objectClass'] = $transaction[$l]['ObjectClass'];
            $object['ownerGUID'] = $transaction[$l]['OwnerGUID'];
            $object['targetId'] = $ids[0];
            $object['targetType'] = 'ElggEntity';
            $object['targetSubtype'] = $types[0];
//            $object['activityId'] = determineActivityId($object['targetId']);
            $activity_id = determineActivityId($object['targetId']);
            $group_id = determineGroupId($actor['actorId'], $object['activityId']);
            if ($activity_id == 0){
                // parent - clone relationship
                $group_id = getGroupIdFromObjectId($ids[0]);
                $activity_id = getActivityIdFromGroupId($group_id);
                $object['objectSubtype'] = determineObjectType($ids[1])[1];
                $object['targetSubtype'] = determineObjectType($ids[0])[1];
            }
            $object['groupId'] = $group_id;
            $object['activityId'] = $activity_id;

            if ($object['targetSubtype'] == "ClipitTag") {
                $object['targetTitle'] = urlencode(getTagContent($ids[0]));
            } else {
                $object['targetTitle'] = urlencode(getObjectTitle($ids[0]));
            }
            if ($object['objectSubtype'] == "ClipitTag") {
                $object['objectTitle'] = urlencode(getTagContent($ids[1]));
            } else {
                $object['objectTitle'] = urlencode(getObjectTitle($ids[1]));
            }
            break;
        case "ModifyRelationship":
            $verb = "remove";
            $title = $transaction[0]['ObjectSubtype'];
            $values = $transaction[0]['Content'];
            if (!(strpos($title, "-") !== false)) {
                //error_log("TitleKaputt");
//                    error_log($transaction_id."FoundNoTitle\n\n\n\n");
                $verb = "Unidentified";
                break;
            } else {
                $types = preg_split('/[-]/', $title);
            }
            if (!(strpos($values, "-") !== false)) {
                //error_log($transaction_id . "FoundNoContent\n\n\n\n");
                $verb = "Unidentified";
                break;
            } else {
                $ids = preg_split('/[-]/', $values);
            }
            $object['objectId'] = $ids[1];
            $object['objectTitle'] = $title;
            $object['objectType'] = $transaction[0]['ObjectType'];
            $object['objectSubtype'] = $types[1];
            if ($object['objectSubtype'] == "destination") {
                $objectId = $object['objectId'];
                $type = determineObjectType($objectId);
                $object['objectSubtype'] = $type[1];
            }


            $object['objectClass'] = $transaction[0]['ObjectClass'];
            $object['ownerGUID'] = $transaction[0]['OwnerGUID'];

            $object['targetId'] = $ids[0];
            $object['targetType'] = 'ElggEntity';
            $object['targetSubtype'] = $types[0];
            $activity = array('actor' => $actor, 'verb' => $verb, 'object' => $object, 'published' => $published, 'transactionId' => $transaction_id);
            storeJSON($activity);
            if (!empty($transaction[1]) && $transaction[1]['Event'] == "create") {
                $l = 1;
                $verb = "add";
                $title = $transaction[$l]['ObjectSubtype'];
                $values = $transaction[$l]['Content'];
                if (!(strpos($title, "-") !== false)) {
//                error_log($transaction_id."\nTitle kaputt: ".$title);
                    $verb = "Unidentified";
                    break;
                } else {
                    $types = preg_split('/[-]/', $title);
                }
                if (!(strpos($values, "-") !== false)) {
//                error_log($transaction_id."\nValues kaputt");
                    $verb = "Unidentified";
                    break;
                } else {
                    $ids = preg_split('/[-]/', $values);
                }
                $object['objectId'] = $ids[1];
                $object['objectTitle'] = $title;
                $object['objectType'] = $transaction[$l]['ObjectType'];
                $object['objectSubtype'] = $types[1];
                if ($object['objectSubtype'] == "destination") {
                    $objectId = $object['objectId'];
                    $type = determineObjectType($objectId);
                    $object['objectSubtype'] = $type[1];
                }

                $object['objectClass'] = $transaction[$l]['ObjectClass'];
                $object['ownerGUID'] = $transaction[$l]['OwnerGUID'];

                $object['targetId'] = $ids[0];
                $object['targetType'] = 'ElggEntity';
                $object['targetSubtype'] = $types[0];
                if ($object['targetSubtype'] == "ClipitTag") {
                    $object['targetTitle'] = urlencode(getTagContent($ids[0]));
                } else {
                    $object['targetTitle'] = urlencode(getObjectTitle($ids[0]));
                }
                if ($object['objectSubtype'] == "ClipitTag") {
                    $object['objectTitle'] = urlencode(getTagContent($ids[1]));
                } else {
                    $object['objectTitle'] = urlencode(getObjectTitle($ids[1]));
                }
            }

            break;
        case "AssignMultipleRelationships":
            foreach ($transaction as $key => $line) {
                if ($line['Event'] == 'create' && $line['ObjectType'] == 'relationship') {
                    $temptrans[0] = $line;
                    $activity = convertLogTransactionToActivityStream($temptrans);
                    storeJSON($activity);
                }
            }
            $verb = "Ignore";
            break;
        case "GroupCreation":
            $verb = "create";
            $l = findValue($transaction, "create", ClipitGroup::SUBTYPE, "ObjectId", TRUE);
            $object['objectId'] = $transaction[$l]['ObjectId'];
            $object['objectTitle'] = urlencode(getObjectTitle($object['objectId']));
            $object['objectType'] = $transaction[$l]['ObjectType'];
            $object['objectSubtype'] = $transaction[$l]['ObjectSubtype'];
            $object['objectClass'] = $transaction[$l]['ObjectClass'];
            $object['ownerGUID'] = $transaction[$l]['OwnerGUID'];
            $object['content'] = $transaction[$l]['Content'];

            $group_id = $object['objectId'];
            $activity_id = getActivityIdFromGroupId($group_id);

            $object['groupId'] = $group_id;
            $object['courseId'] = 0;
            $object['activityId'] = $activity_id;

            // relation to activity
//            $l = findValue($transaction, "create", ClipitActivity::REL_ACTIVITY_GROUP, "ObjectId", TRUE);
//            $temptrans[0] = $transaction[$l];
//            $activity = convertLogTransactionToActivityStream($temptrans);
//            storeJSON($activity);

            foreach ($transaction as $key => $line) {
                if ($line['Event'] == 'create' && $line['ObjectType'] == 'relationship') {
                    $temptrans[0] = $line;
                    $activity = convertLogTransactionToActivityStream($temptrans);
                    storeJSON($activity);
                }
            }

            //DEBUG
//            ob_start();
//            var_dump($object);
//            $outputasdf = ob_get_contents();
//            ob_end_clean();
//            error_log('testtestestetst '. $outputasdf);

            break;
        case "DeleteGroup":
            $verb = "remove";
            $object['objectId'] = $transaction[0]['ObjectId'];
            $object['objectTitle'] = urlencode($transaction[1]['Content']);
            $object['objectType'] = $transaction[0]['ObjectType'];
            $object['objectSubtype'] = $transaction[0]['ObjectSubtype'];
            $object['objectClass'] = $transaction[0]['ObjectClass'];
            $object['ownerGUID'] = $transaction[0]['OwnerGUID'];
            $object['content'] = $transaction[0]['Content'];

            $group_id = $object['objectId'];
            $activity_id = getActivityIdFromGroupId($group_id);
            $object['groupId'] = $group_id;
            $object['courseId'] = 0;
            $object['activityId'] = $activity_id;
            break;
        case "CreateTag":
            $verb = "create";
            $object['objectId'] = $transaction[2]['ObjectId'];
            $object['objectTitle'] = $transaction[0]['Content'];
            $object['objectType'] = $transaction[2]['ObjectType'];
            $object['objectSubtype'] = $transaction[2]['ObjectSubtype'];
            $object['objectClass'] = $transaction[2]['ObjectClass'];
            $object['ownerGUID'] = $transaction[0]['OwnerGUID'];
            $object['content'] = $transaction[0]['Content'];

            $object['groupId'] = 0;
            $object['courseId'] = 0;
            $object['activityId'] = 0;
            break;
        case "CreateTrickyTopic":
            $l = findValue($transaction, "create", ClipitTrickyTopic::SUBTYPE, "ObjectId", TRUE);
            $titleline = findValue($transaction, "create", "name", "ObjectId", TRUE);
            $object['objectId'] = $transaction[$l]['ObjectId'];
            $object['objectTitle'] = urlencode($transaction[$titleline]['Content']);
            $object['objectType'] = $transaction[$l]['ObjectType'];
            $object['objectSubtype'] = $transaction[$l]['ObjectSubtype'];
            $object['objectClass'] = $transaction[$l]['ObjectClass'];
            $object['ownerGUID'] = $transaction[$l]['OwnerGUID'];
            $object['content'] = $transaction[$l]['Content'];
            break;
        case "CreateTask":
            $l = findValue($transaction, "create", ClipitTask::SUBTYPE, "ObjectId", TRUE);
            $titleline = findValue($transaction, "create", "name", "ObjectId", TRUE);
            $object['objectId'] = $transaction[$l]['ObjectId'];
            $object['objectTitle'] = urlencode($transaction[$titleline]['Content']);
            $object['objectType'] = $transaction[$l]['ObjectType'];
            $object['objectSubtype'] = $transaction[$l]['ObjectSubtype'];
            $object['objectClass'] = $transaction[$l]['ObjectClass'];
            $object['ownerGUID'] = $transaction[$l]['OwnerGUID'];
            $object['content'] = $transaction[$l]['Content'];

            //Anschließend sollte man noch direkt die Activity-Zugehörigkeit klären:

            $relationline = findValue($transaction, "create", ClipitActivity::SUBTYPE . "-" . ClipitTask::SUBTYPE, "ObjectId", TRUE);
            $temptrans[0] = $transaction[$relationline];
            $activity = convertLogTransactionToActivityStream($temptrans);
            storeJSON($activity);
            break;
        case "Messaging":
            $verb = "message";
            $chatline = findValue($transaction, "create", ClipitChat::SUBTYPE, "ObjectId", TRUE);
            $object['objectId'] = $transaction[$chatline]['ObjectId'];
            $object['objectTitle'] = ClipitChat::SUBTYPE;
            $object['objectType'] = $transaction[$chatline]['ObjectType'];
            $object['objectSubtype'] = $transaction[$chatline]['ObjectSubtype'];
            $object['objectClass'] = $transaction[$chatline]['ObjectClass'];
            $object['ownerGUID'] = $transaction[$chatline]['OwnerGUID'];
            $object['content'] = urlencode($transaction[$chatline]['Content']);

            //This has been removed due to reworkings in the activitystream to graph agent...
            /*
            $temptrans[0] = $transaction[$relationline];
            $activity = convertLogTransactionToActivityStream($temptrans);
            storeJSON($activity);
            */

            $relationline = findValue($transaction, "create", ClipitChat::SUBTYPE . "-destination", "ObjectId", TRUE);
            $values = $transaction[$relationline]['Content'];
            if (!(strpos($values, "-") !== false)) {
                $verb = "Unidentified";
                break;
            } else {
                $ids = preg_split('/[-]/', $values);
            }
            $user_id = $ids[1];
            $object['targetId'] = $user_id;
            $object['targetType'] = "user";
            $user_properties = ClipitUser::get_by_id(array($user_id));
            if (is_not_null($user_properties) && is_not_null($user_properties[$user_id]) && isset($user_properties[$user_id]->role)) {
                $role = $user_properties[$user_id]->role;
                $object['targetSubtype'] = $role;
            } else {
                $verb = "Ignore";
            }
            break;
        case "Ignore":
            $verb = "Ignore";
            break;
        default:
            $verb = "Unidentified";
//			$verb = $type;
            break;

    }
    //Quick-Filter Werte sollten niemals "" oder leer sein:
    if (is_null($object['groupId']) || $object['groupId'] == "") {
        $object['groupId'] = 0;
    }
    if (is_null($object['courseId']) || $object['courseId'] == "") {
        $object['courseId'] = 0;
    }
    if (is_null($object['activityId']) || $object['activityId'] == "") {
        $object['activityId'] = 0;
    }
    if (is_null($actor['objectType']) || $actor['objectType'] == "") {
        $actor['objectType'] = "none";
    }
    if (is_null($verb) || $verb == "") {
        $verb = "Unidentified";
    }

    $activity = array('actor' => $actor, 'verb' => $verb, 'object' => $object, 'published' => $published, 'transactionId' => $transaction_id);
    return $activity;
}

function getTagContent($id)
{
    $tag = get_entity($id);
    if ($tag instanceof ElggMetadata) {
        return "ElggMetadata" . $id;
    } elseif ($tag instanceof ElggEntity) {
        return $tag->name;
    }
    return "Deleted";
}

function getObjectTitle($id)
{
    $object = get_entity($id);
    if ($object instanceof ElggEntity) {
        if ($object->getSubType() == ClipitUser::SUBTYPE || $object->getSubType() == "student" || $object->getSubType() == "teacher") {
            return $object->name;
        }
        return $object->name;
    }
    return "Deleted";
}

function getActivityIdFromGroupId($group_id)
{
    $activity_id = 0;
    $activity_array = get_entity_relationships($group_id, true);
    foreach ($activity_array as $rel) {
        if ($rel->relationship == ClipitActivity::SUBTYPE . "-" . ClipitGroup::SUBTYPE) {
            $activity_id = $rel->guid_one;
        }
    }
    return $activity_id;
}

function getGroupIdFromObjectId($object_id)
{
    $group_id = 0;
    $object = get_entity($object_id);
    if ($object instanceof ElggEntity) {
        if ($object instanceof ElggEntity && $object->getSubtype() == ClipitGroup::SUBTYPE) {
            $group_id = getActivityIdFromGroupId($group_id);
        } else {
            $subtype = $object->getSubtype();
            $group_array = get_entity_relationships($object_id, true);
            foreach ($group_array as $rel) {
                if ($subtype == ClipitComment::SUBTYPE || $subtype == ClipitPost::SUBTYPE) {
                    if ($rel->relationship == $subtype . "-destination") {
                        $group_id = $rel->guid_one;
                    }
                } else {
                    if ($rel->relationship == ClipitGroup::SUBTYPE . "-" . $subtype) {
                        $group_id = $rel->guid_one;
                    }
                }
            }
        }
    }
    return $group_id;
}

function determineGroupId($userId, $activityId)
{
    $matchedId = 0;
    $groupsFound = false;
    //First we get all groups the user is in...
    $group_array = get_entity_relationships($userId, true);
    foreach ($group_array as $rel) {
        if ($rel->relationship == ClipitGroup::SUBTYPE . "-" . ClipitUser::SUBTYPE) {
            $groupIds[] = $rel->guid_one;
            $groupsFound = true;
        }
    }
    //...then we check if one of these is in the current activity:
    if ($groupsFound) {
        foreach ($groupIds as $groupId) {
            $activity_array = get_entity_relationships($groupId, true);
            foreach ($activity_array as $rel) {
                if ($rel->relationship == ClipitActivity::SUBTYPE . "-" . ClipitGroup::SUBTYPE) {
                    if ($activityId == $rel->guid_one) {
                        $matchedId = $groupId;
                        unset($groupId);
                    }
                }
            }
        }
    }
    return $matchedId;
}

function determineObjectType($object_id)
{
    $entity = get_entity($object_id);
    if ($entity instanceof ElggEntity) {
        $type[0] = "UBItem";
        $type[1] = $entity->getSubtype();
    } else {
        $type[0] = "Unknown";
        $type[1] = "Unknown";
    }
    return $type;
}

function findValue($transaction, $event, $subtype, $field, $line)
{
    $value = 0;
    $found = false;
    $line_number = 0;
    foreach ($transaction as $log_row) {
        if (!$found AND !empty($log_row['Event']) AND $log_row['Event'] == $event AND !empty($log_row['ObjectSubtype']) AND $log_row['ObjectSubtype'] == $subtype) {
            if ($line) {
                $value = intval($line_number);
                $found = true;
            } else {
                $value = $log_row[$field];
                $found = true;
            }
        }
        $line_number++;
    }

    return $value;
}

function determineTaskId($object_id)
{
    $task_id = 0;
    $object = get_entity($object_id);
    if ($object instanceof ElggEntity) {
        $subtype = $object->getSubtype();
        if ($subtype == ClipitVideo::SUBTYPE) {
            $temp_array = get_entity_relationships($object_id, true);

            foreach ($temp_array as $rel) {
                if ($rel->relationship == ClipitTask::SUBTYPE . "-" . ClipitVideo::SUBTYPE) {
                    $task_id = $rel->guid_one;
                }
            }
        } elseif ($subtype == ClipitQuiz::SUBTYPE) {
            $temp_array = get_entity_relationships($object_id, true);

            foreach ($temp_array as $rel) {
                if ($rel->relationship == ClipitTask::SUBTYPE . "-" . ClipitQuiz::SUBTYPE) {
                    $task_id = $rel->guid_one;
                }
            }
        }
    }
    return $task_id;
}


function determineActivityId($object_id)
{
    $activity_id = 0;
    $object = get_entity($object_id);
    if ($object instanceof ElggEntity) {
        $subtype = $object->getSubtype();
        if ($subtype == ClipitComment::SUBTYPE || $subtype == ClipitPost::SUBTYPE) {
            $temp_array = get_entity_relationships($object_id);
            $target_id = 0;
            foreach ($temp_array as $rel) {
                if ($rel->relationship == $subtype . "-destination") {
                    $target_id = $rel->guid_two;
                }
            }
            if ($target_id == 0) {
                return 0;
            }
        } else {
            $target_id = $object_id;
        }
        $target = get_entity($target_id);
        if ($target->getSubtype() == ClipitActivity::SUBTYPE) {
            $activity_id = $target_id;
        } else if ($target->getSubtype() == ClipitGroup::SUBTYPE || $target->getSubtype() == ClipitFile::SUBTYPE || $target->getSubtype() == ClipitStoryboard::SUBTYPE || $target->getSubtype() == ClipitVideo::SUBTYPE ||$target->getSubtype() == ClipitTask::SUBTYPE) {

            $temp_array = get_entity_relationships($target_id, true);
            $activity_id = 0;
            foreach ($temp_array as $rel) {
                if ($rel->relationship == ClipitActivity::SUBTYPE . "-" . $target->getSubtype()) {
                    $activity_id = $rel->guid_one;
                }
            }
        } else if ($target->getSubtype() == ClipitQuiz::SUBTYPE){
            $temp_array = get_entity_relationships($target_id, true);
            foreach ($temp_array as $rel){
                if ($rel->relationship == ClipitTask::SUBTYPE . "-" . ClipitQuiz::SUBTYPE){
                    $activity_id = determineActivityId($rel->guid_one);
                    break;
                }
            }
        }
    }
    return $activity_id;
}

function removeAPILogins($transaction)
{
    if (!empty($transaction[2]) && $transaction[2]['Event'] == 'login') {
        //if transaction has no value in [3] it is a normal login, otherwise it probably is a login followed by a payload through ClipIt's API
        if (isset($transaction[3]) && !empty($transaction[3])) {
            $first_APICall = splitTransaction($transaction, 3);
            $login_transaction = $first_APICall[0];
            $new_transaction = $first_APICall[1];
            $action = convertLogTransactionToActivityStream($login_transaction);
            if (!($action['verb'] == 'Unidentified')) {
                $action['transactionId'] = $action['transactionId'];
                storeJSON($action);
            }
            $anotherLoginAt = findValue($new_transaction, "login", "none", "ObjectType", true);
            if ($anotherLoginAt > 1) {
                if ($new_transaction[$anotherLoginAt - 2]['Event'] == "update" &&
                    $new_transaction[$anotherLoginAt - 1]['Event'] == "update"
                ) {
                    foreach ($new_transaction as $line => $number) {
                        if ($number != $anotherLoginAt || $number != $anotherLoginAt - 1 || $number != $anotherLoginAt - 2) {
                            $temp_trans[] = $line;
                        }
                    }
                }
            }
            return $new_transaction;
        }
    }
    return $transaction;
}


function determineActivityType($transaction)
{
    $type = "";


    if (isset($transaction[0]) && !empty($transaction[0])) {
        if ($transaction[0]['ObjectTitle'] == "active_plugin" ||
            $transaction[0]['ObjectSubtype'] == "active_plugin" ||
            $transaction[0]['ObjectSubtype'] == "plugin" ||
            findValue($transaction, "delete", "active_plugin", "ObjectId", FALSE) > 0 ||
            findValue($transaction, "create", "active_plugin", "ObjectId", FALSE) > 0 ||
            findValue($transaction, "update", "active_plugin", "ObjectId", FALSE) > 0
        ) {
            $type = "Ignore";
        } elseif ($transaction[0]['Event'] == 'create') {
            if (findValue($transaction, "create", ClipitVideo::SUBTYPE, "ObjectId", FALSE) > 0) {
                $type = "VideoUpload";
            } elseif (findValue($transaction, "create", ClipitFile::SUBTYPE, "ObjectId", FALSE) > 0) {
                if (findValue($transaction, "create", ClipitLA::SUBTYPE, "ObjectId", FALSE) == 0 &&
                    findValue($transaction, "update", ClipitLA::SUBTYPE, "ObjectId", FALSE) == 0
                ) {
                    $type = "FileUpload";
                } else {
                    $type = "Ignore";
                }
            } elseif (findValue($transaction, "create", ClipitUser::SUBTYPE, "ObjectId", FALSE) > 0) {
                $type = "AccountCreation";
            } elseif ($transaction[0]['ObjectSubtype'] == 'name') {

                if (findValue($transaction, "create", ClipitChat::SUBTYPE, "ObjectId", FALSE) > 0) {
                    $type = "Messaging";
                } elseif (findValue($transaction, "create", ClipitPost::SUBTYPE, "ObjectId", FALSE) > 0) {
                    $type = "Discussion";
                } elseif (findValue($transaction, "create", ClipitComment::SUBTYPE, "ObjectId", FALSE) > 0) {
                    $type = "Discussion";
                } elseif (findValue($transaction, "create", ClipitGroup::SUBTYPE, "ObjectId", FALSE) > 0) {
                    $type = "GroupCreation";
                } elseif (findValue($transaction, "create", ClipitTask::SUBTYPE, "ObjectId", FALSE) > 0) {
                    if (findValue($transaction, "create", ClipitQuiz::SUBTYPE, "ObjectId", FALSE) > 0) {
                        $type = "CreateQuiz";
                    } else {
                        $type = "CreateTask";
                    }
                } elseif (findValue($transaction, "create", ClipitActivity::SUBTYPE, "ObjectId", FALSE) > 0) {
                    $type = "CreateActivity";
                } elseif (findValue($transaction, "create", ClipitTrickyTopic::SUBTYPE, "ObjectId", FALSE) > 0) {
                    $type = "CreateTrickyTopic";
                } elseif (!empty($transaction[2]) && $transaction[2]['ObjectSubtype'] == ClipitTag::SUBTYPE) {
                    $type = "CreateTag";
                }
            } elseif ($transaction[0]['ObjectType'] == 'relationship') {
                $counter = 0;
                foreach ($transaction as $line) {
                    if ($line['ObjectType'] == 'relationship' && $line['Event'] == 'create'){
                        $counter++;
                    }
                    if ($counter >1){
                        $type = "AssignMultipleRelationships";
                        break;
                    }
                }
                if ($counter == 1) {
                    $type = "AssignRelationShip";
                }
//                if (isset($transaction[1]['ObjectType']) && $transaction[1]['ObjectType'] == 'relationship' && $transaction[1]['Event'] == 'create') {
//                    $type = "AssignMultipleRelationships";
//                } else {
//                    $type = "AssignRelationShip";
//                }
            }
        } elseif ($transaction[0]['Event'] == 'update') {
            if (!empty($transaction[1])) {
                if (!empty($transaction[1]) && $transaction[1]['Event'] == 'login') {
                    $type = "Login";
                } elseif (!empty($transaction[2]) && $transaction[2]['Event'] == 'login') {
                    //if transaction has no value in [3] it is a normal login, otherwise it probably is a login followed by a payload through ClipIt's API
                    if (!isset($transaction[3]) || empty($transaction[3])) {
                        $type = "Login";
                    }

                } elseif (!empty($transaction[2]) && $transaction[2]['Event'] == 'logout') {
                    $type = "Logout";
                }
            }
        } elseif ($transaction[0]['Event'] == 'delete') {
            if ($transaction[0]['ObjectType'] == 'relationship') {
                $type = "ModifyRelationship";
            } elseif ($transaction[0]['ObjectSubtype'] == ClipitGroup::SUBTYPE) {
                $type = "DeleteGroup";
            }
        } elseif ($transaction[0]['Event'] == 'logout') {
            $type = "Logout";
        }
    }


    if ($type == "") {
        $type = "Unidentified";
    }
    //Only needed for error_log during rebuild to reflect removal of API logins
    $_SESSION['transaction'] = $transaction;
    return $type;
}

function splitTransaction($trans, $limiter)
{
    $row = 0;
    $login_transaction = array();
    $new_transaction = array();
    foreach ($trans as $key => $value) {
        if ($row < $limiter) {
            $login_transaction[$row] = $value;
            $login_transaction[$row]['TransactionId'] = $login_transaction[$row]['TransactionId'];
        } else {
            $new_transaction[] = $value;
        }
        unset($value);
        $row++;
    }
    return array($login_transaction, $new_transaction);
}