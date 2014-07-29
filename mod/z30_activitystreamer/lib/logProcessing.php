<?php
function storeJSON($action, $act_table, $con, $stmt = null) {
    $action['object']['content'] = 	urlencode($action['object']['content']);
    $action['object']['objectTitle'] = 	urlencode($action['object']['objectTitle']);
	$activity_json = json_encode($action);
    createActivityTable($con, $act_table);
    if (!($stmt instanceof mysqli_stmt)) {
        error_log(mysqli_errno($con));
        global $CONFIG;
        $con->close();
        $con=mysqli_connect($CONFIG->dbhost,$CONFIG->dbuser,$CONFIG->dbpass,$CONFIG->dbname);
        $stmt = $con->prepare("INSERT INTO `".$act_table."` ".
            "(transaction_id, json, actor_id, group_id, course_id, activity_id, verb, timestamp) ".
            "VALUES (?,?,?,?,?,?,?,?)");
    }
    $stmt->bind_param('ssiiiisi', $action['transactionId'], $activity_json, $action['actor']['actorId'], $action['object']['groupId'],
        $action['object']['courseId'], $action['object']['activityId'], $action['verb'], $action['published']);
    $stmt->execute();
}

function createActivityTable($con, $act_table) {
    $con->query("CREATE TABLE IF NOT EXISTS `".$act_table."` (".
        "`transaction_id` varchar(255) NOT NULL, ".
        "`json` longtext NOT NULL, ".
        "`actor_id` int(255) NOT NULL, ".
        "`group_id` int(255) NOT NULL, ".
        "`course_id` int(255) NOT NULL, ".
        "`activity_id` int(255) NOT NULL, ".
        "`verb` varchar(255) NOT NULL, ".
        "`timestamp` varchar(255) NOT NULL, ".
        "PRIMARY KEY (`transaction_id`) ".
        ") ENGINE=InnoDB DEFAULT CHARSET=utf8 DEFAULT COLLATE utf8_general_ci;");
}
function processURL($url) {
	$object_Id = 0;
	$values = explode("/", $url);
	$object_Id = end($values);
	return $object_Id;
}

function convertURLToActivityStream($url) {
	GLOBAL $con;

    $transaction_id = $_SESSION['tid'];
	$object_Id = processURL($url);
	if ($object_Id != 0) {
		$published = time();
		$user = elgg_get_logged_in_user_entity();	
		$ip_address = sanitise_string($_SERVER['REMOTE_ADDR']);
		if (is_null($ip_address)) {$ip_address = "";}	
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
		        foreach($temp_array as $rel){
		            if($rel->relationship == ClipitActivity::REL_ACTIVITY_FILE OR $rel->relationship == ClipitActivity::REL_ACTIVITY_TASK OR $rel->relationship == ClipitActivity::REL_ACTIVITY_VIDEO){
		                $activity_id = $rel->guid_one;
		            }
					elseif($rel->relationship == ClipitGroup::REL_GROUP_FILE /*OR $rel->relationship == ClipitGroup::REL_GROUP_TASK OR $rel->relationship == ClipitGroup::REL_GROUP_VIDEO */){
						$group_id = $rel->guid_one;
					}
					//TODO Add support for courses when available 
		        }
				
				//$role = ClipitUser::get_properties($performed_by, array("role"));
			}
			$object['groupId'] = $group_id;
			$object['courseId'] = $course_id;
			$object['activityId'] = $activity_id;
		}
		else {
			$verb = "Unidentified";
			mysqli_query($con,"INSERT INTO `tracking` ".
					"(transaction_id, url) ".
				"VALUES ('".$transaction_id."', '".$url."');");
		} 
	}
	else {
		mysqli_query($con,"INSERT INTO `tracking` ".
				"(transaction_id, url) ".
				"VALUES ('".$transaction_id."', '".$url."');");
		$verb = "Unidentified";
	} 
	$activity = array('actor' => $actor, 'verb' => $verb, 'object' => $object, 'published' => $published, 'transactionId' => $transaction_id);
	return $activity;
}

function convertLogTransactionToActivityStream($transaction) {
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
        $user_properties = ClipitUser::get_properties($actor['actorId'], array("role"));
        if (is_not_null($user_properties) && !empty($user_properties[0])) {
            $actor['objectType'] = $user_properties[0];
        }

    }

	// For some values, we need to determine the line number
	$l = 0;

	// These will most likely be zero, but sometimes we can put a value into them...
	$group_id = 0;
	$course_id = 0;
	$activity_id = 0;

	
//	Same is true for the published value	
	$published = $transaction[0]['Timestamp'];

//  The rest is up to the identified action:
	switch ($type) {
		case "Unidentified":
			$verb = "Unidentified";
			break;
		case "Discussion":
			$object['objectTitle'] = $transaction[0]['ObjectTitle'];
            $l = findValue($transaction, "create", ClipitPost::SUBTYPE, "ObjectId", TRUE);
            if ($l == 0) {
                $l = findValue($transaction, "create", ClipitComment::SUBTYPE, "ObjectId", TRUE);
            }
			$verb = "annotate";
			$object['objectId'] = $transaction[$l]['ObjectId'];
			$object['objectType'] = $transaction[$l]['ObjectType'];
			$object['objectSubtype'] = $transaction[$l]['ObjectSubtype'];
			$object['objectClass'] = $transaction[$l]['ObjectClass'];
			$object['ownerGUID'] = $transaction[$l]['OwnerGUID'];
			$object['content'] = $transaction[$l]['Content'];

			$target_id = findValue($transaction, "create", $transaction[$l]['ObjectSubtype']."-destination", "Content", FALSE);
            $type = determineObjectType($target_id);
			$object['targetId'] = $target_id;
			$object['targetType'] = $type[0];
			$object['targetSubtype'] = $type[1];

            if ($target_id == "new") {
                $activity_id = determineActivityId($transaction[$l]['ObjectId']);
            }
            else {
                $activity_id = determineActivityId($target_id);
            }
            if ($activity_id > 0) {
                $group_id = determineGroupId($transaction[0]['UserId'], $activity_id);
            }
            else {
                //If activityId couldn't be determined it might be due to object beeing posted to a group instead of to an activity
                $group = get_entity($target_id);
                if ($group instanceof ElggEntity && $group->getSubtype() == ClipitGroup::SUBTYPE) {
                    $group_id = $target_id;
                    $activity_id = getActivityIdFromGroupId($group_id);
                }
            }
			$object['groupId'] = $group_id;
			$object['courseId'] = $course_id;
			$object['activityId'] = $activity_id;
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

            $video_id = $transaction[$l]['ObjectId'];
            $activity_id = determineActivityId($video_id);
            if ($activity_id > 0) {
                $group_id = determineGroupId($transaction[0]['UserId'], $activity_id);
            }
            else {
                //If activityId couldn't be determined it might be due to object beeing posted to a group instead of an activity
                $group_id = getGroupIdFromVideoId($video_id);
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
            break;
//TODO Account creation not detected
        case "AccountCreation":
            $verb = "create";
            $object['objectType'] = "user";
            $object['objectSubtype'] = $transaction[0]['ObjectSubtype'];
            $object['objectClass'] = $transaction[0]['ObjectClass'];
            $object['ownerGUID'] = $transaction[0]['OwnerGUID'];
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
//TODO GroupCreation not detected
//TODO Group Joining not detected
        case "GroupCreation":
            $verb = "create";
            $object['objectType'] = "site";
            $object['objectSubtype'] = $transaction[0]['ObjectSubtype'];
            $object['objectClass'] = $transaction[0]['ObjectClass'];
            $object['ownerGUID'] = $transaction[0]['OwnerGUID'];
            $object['content'] = "";
            $object['groupId'] = "0";
            $object['courseId'] = "0";
            $object['activityId'] = "0";
            break;
		default:
			$verb = "Unidentified";
//			$verb = $type;
			
	}

	$activity = array('actor' => $actor, 'verb' => $verb, 'object' => $object, 'published' => $published, 'transactionId' => $transaction_id);
	return $activity;
}

function getActivityIdFromGroupId($group_id) {
    $activity_id = 0;
    $activity_array = get_entity_relationships($group_id, true);
    foreach($activity_array as $rel) {
        if ($rel->relationship == ClipitActivity::SUBTYPE."-".ClipitGroup::SUBTYPE) {
            $activity_id = $rel->guid_one;
        }
    }
    return $activity_id;
}

function getGroupIdFromVideoId($video_id) {
    $group_id = 0;
    $group_array = get_entity_relationships($video_id, true);
    foreach($group_array as $rel) {
        if ($rel->relationship == ClipitGroup::SUBTYPE."-".ClipitVideo::SUBTYPE) {
            $group_id = $rel->guid_one;
        }
    }
    return $group_id;
}

function determineGroupId($userId, $activityId) {
    $matchedId = 0;
    $groupsFound = false;
    //First we get all groups the user is in...
    $group_array = get_entity_relationships($userId, true);
    foreach($group_array as $rel) {
        if ($rel->relationship == ClipitGroup::SUBTYPE."-".ClipitUser::SUBTYPE) {
            $groupIds[] = $rel->guid_one;
            $groupsFound = true;
        }
    }
    //...then we check if one of these is in the current activity:
    if ($groupsFound) {
        foreach($groupIds as $groupId) {
            $activity_array = get_entity_relationships($groupId, true);
            foreach($activity_array as $rel) {
                if ($rel->relationship == ClipitActivity::SUBTYPE."-".ClipitGroup::SUBTYPE) {
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

function determineObjectType($object_id) {
    $entity = get_entity($object_id);
    if ($entity instanceof ElggEntity) {
        $type[0] = "UBItem";
        $type[1] = $entity->getSubtype();
    }
    else {
        $type[0] = "Unknown";
        $type[1] = "Unknown";
    }
    return $type;
}

function findValue($transaction, $event, $subtype, $field, $line) {
	$value = 0;
    $found = false;
	$line_number = 0;
	foreach($transaction as $log_row) {
		if (!$found AND !empty($log_row['Event']) AND $log_row['Event'] == $event AND !empty($log_row['ObjectSubtype']) AND $log_row['ObjectSubtype'] == $subtype) {
			if ($line) {
				$value = intval($line_number);
                $found = true;
			}
			else {
				$value = $log_row[$field];
                $found = true;
			}
		}
		$line_number++;
	}
	
	return $value;
}

function determineActivityId($object_id) {
    $activity_id = 0;
    $object = get_entity($object_id);
    if ($object instanceof ElggEntity) {
        $subtype = $object->getSubtype();
        if ($subtype == ClipitComment::SUBTYPE || $subtype == ClipitPost::SUBTYPE) {
            $temp_array = get_entity_relationships($object_id);
            $target_id = 0;
            foreach($temp_array as $rel) {
                if ($rel->relationship == $subtype."-destination") {
                    $target_id = $rel->guid_two;
                }
            }
            if ($target_id == 0) {
                return 0;
            }
        }
        else {
            $target_id = $object_id;
        }
        $target = get_entity($target_id);
        if ($target->getSubtype() == ClipitActivity::SUBTYPE) {
            $activity_id = $target_id;
        }
        else if ($target->getSubtype() == ClipitGroup::SUBTYPE || $target->getSubtype() == ClipitFile::SUBTYPE || $target->getSubtype() == ClipitStoryboard::SUBTYPE || $target->getSubtype() == ClipitVideo::SUBTYPE) {
            $temp_array = get_entity_relationships($target_id, true);
            $activity_id = 0;
            foreach($temp_array as $rel) {
                if ($rel->relationship == ClipitActivity::SUBTYPE."-".$target->getSubtype()) {
                    $activity_id = $rel->guid_one;
                }
            }
        }
    }
    if ($activity_id == 0) {
        error_log("_____________________________________________________________________________________________________________________________________\nCouldn't find ActivityID for ".$object_id."->".$target_id."\n\n".ClipitActivity::SUBTYPE."-".$target->getSubtype()."\n".$_SESSION['tid']);
    }
    return $activity_id;
}

function checkForAPIMultiples($transaction) {
    if (!empty($transaction[2]) && $transaction[2]['Event'] == 'login') {
        //if transaction has no value in [3] it is a normal login, otherwise it probably is a login followed by a payload through ClipIt's API
        if (isset($transaction[3]) && !empty($transaction[3])) {
            global $CONFIG;
            $con=mysqli_connect($CONFIG->dbhost,$CONFIG->dbuser,$CONFIG->dbpass,$CONFIG->dbname);
            $act_table = $_SESSION['activity_table'];
            $stmt = $con->prepare("INSERT INTO `".$act_table."` ".
                "(transaction_id, json, actor_id, group_id, course_id, activity_id, verb, timestamp) ".
                "VALUES (?,?,?,?,?,?,?,?)");
            $first_APICall = splitTransaction($transaction, 3);
            $login_transaction = $first_APICall[0];
            $new_transaction = $first_APICall[1];
            $action = convertLogTransactionToActivityStream($login_transaction);
            if (!($action['verb'] == 'Unidentified')) {
                storeJSON($action, $act_table, $con, $stmt);
            }
            $anotherLoginAt = findValue($new_transaction, "login", "none", "ObjectType", true);
            if ($anotherLoginAt > 0) {
                $splitTrans = splitTransaction($transaction, $anotherLoginAt + 1);
                $first_APITrans = $splitTrans[0];
                $rest = $splitTrans[1];
                $action = convertLogTransactionToActivityStream($first_APITrans);
                if (!($action['verb'] == 'Unidentified')) {
                    storeJSON($action, $act_table, $con, $stmt);
                }

                //After we have managed to go through the first API call, we will now go through the rest...
                $action = convertLogTransactionToActivityStream($rest);
                if (!($action['verb'] == 'Unidentified')) {
                    storeJSON($action, $act_table, $con, $stmt);
                }

            }
            else {
                $action = convertLogTransactionToActivityStream($new_transaction);
                if (!($action['verb'] == 'Unidentified')) {
                    storeJSON($action, $act_table, $con, $stmt);
                }
            }
            return true;
        }
    }
    return false;
}


function determineActivityType($transaction) {
    $type = "";
    if (!checkForAPIMultiples($transaction)) {
        if (isset($transaction[0]) && !empty($transaction[0])) {
            if ($transaction[0]['Event'] == 'create') {
                if (findValue($transaction, "create", ClipitVideo::SUBTYPE, "ObjectId", FALSE) > 0) {
                    $type = "VideoUpload";
                }
                elseif ($transaction[0]['ObjectSubtype'] == 'name') {
                    if (findValue($transaction, "create", ClipitPost::SUBTYPE, "ObjectId", FALSE) > 0) {
                        $type = "Discussion";
                    }
                    elseif (findValue($transaction, "create", ClipitComment::SUBTYPE, "ObjectId", FALSE) > 0) {
                        $type = "Discussion";
                    }
                    elseif (findValue($transaction, "create", ClipitGroup::SUBTYPE, "ObjectId", FALSE) > 0) {
                        $type = "GroupCreation";
                    }
                    elseif (findValue($transaction, "create", ClipitTask::SUBTYPE, "ObjectId", FALSE) > 0) {
                        $type = "CreateTask";
                    }
                    elseif (findValue($transaction, "create", ClipitActivity::SUBTYPE, "ObjectId", FALSE) > 0) {
                        $type = "CreateActivity";
                    }
                    elseif (findValue($transaction, "create", "tricky_topic", "ObjectId", FALSE) > 0) {
                        $type = "CreateTrickyTopic";
                    }
                }
                elseif ($transaction[0]['ObjectType'] == 'relationship') {
                    $type = "AssignRelationShip";
                }
            }
            elseif ($transaction[0]['Event'] == 'update') {
                if (!empty($transaction[1])) {
                    if (!empty($transaction[1]) && $transaction[1]['Event'] == 'login') {
                        $type = "Login";
                    }
                    elseif (!empty($transaction[2]) && $transaction[2]['Event'] == 'login') {
                        //if transaction has no value in [3] it is a normal login, otherwise it probably is a login followed by a payload through ClipIt's API
                        if (!isset($transaction[3]) || empty($transaction[3])) {
                            $type = "Login";
                        }
                        else {
                            //If it is an API call, we will store the login separately and restart detection:
                            $hybrid_transaction = splitTransaction($transaction, 3);
                            $login_transaction = $hybrid_transaction[0];
                            $new_transaction = $hybrid_transaction[1];
                            $action = convertLogTransactionToActivityStream($login_transaction);
                            if (!($action['verb'] == 'Unidentified')) {
                                global $CONFIG;
                                $con=mysqli_connect($CONFIG->dbhost,$CONFIG->dbuser,$CONFIG->dbpass,$CONFIG->dbname);
                                $act_table = $_SESSION['activity_table'];
                                $stmt = $con->prepare("INSERT INTO `".$act_table."` ".
                                    "(transaction_id, json, actor_id, group_id, course_id, activity_id, verb, timestamp) ".
                                    "VALUES (?,?,?,?,?,?,?,?)");
                                storeJSON($action, $act_table, $con, $stmt);
                            }
                            $type = determineActivityType($new_transaction);
                        }

                    }
                    elseif (!empty($transaction[2]) && $transaction[2]['Event'] == 'logout') {
                        $type = "Logout";
                    }
                }
            }
            elseif ($transaction[1]['Event'] == 'delete') {
                if ($transaction[1]['ObjectType'] == 'relationship') {
                    $type = "ReAssignRelationShip";
                }
            }
            elseif ($transaction[0]['Event'] == 'logout') {
                $type = "Logout";
            }
        }
    }


    if ($type == "") {
		$type = "Unidentified";
	}
	return $type;
}

function splitTransaction($trans, $limiter) {
    $row = 0;
    $login_transaction = array();
    $new_transaction = array();
    foreach ($trans as $key => $value) {
        if ($row < $limiter) {
            $login_transaction[$row] = $value;
            $login_transaction[$row]['TransactionId'] = $login_transaction[$row]['TransactionId']."l";
        }
        else {
            $new_transaction[] = $value;
        }
        unset($value);
        $row++;
    }
    return array($login_transaction, $new_transaction);
}