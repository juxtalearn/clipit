<?php
function storeJSON($action, $act_table, $con, $stmt = null) {
    $action['object']['content'] = 	urlencode($action['object']['content']);
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

function determineId($object_id, $type) {
    $temp_array = get_entity_relationships($object_id, true);
    foreach($temp_array as $rel) {
        $rel_id = $rel->guid_two;
        $target = get_entity($rel_id);
        if (!is_null($target) && $target instanceof ElggEntity) {
            if ($target->getSubtype() == ClipitPost::SUBTYPE || $target->getSubtype() == ClipitComment::SUBTYPE) {
                $rel_array = get_entity_relationships($rel_id, true);
                foreach($rel_array as $rel2) {
                    $target_id2 = $rel2->guid_two;
                    $target2 = get_entity($target_id2);
                    if (!is_null($target2) && $target2 instanceof ElggEntity) {
                        if ($target2->getSubtype() == ClipitGroup::SUBTYPE) {
                            $group_id = $target_id2;
                        }
                        else if ($target2->getSubtype() == ClipitActivity::SUBTYPE) {
                            $activity_id = $target_id2;
                        }
                    }
                }
            }
        }
    }
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
			$object['groupId'] = $group_id;
			$object['courseId'] = $course_id;
			$object['activityId'] = $activity_id;
			break;
		case "Login":
		case "AccountCreation":
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

function determineObjectType($object_id) {
    $entity = get_entity($object_id);
    if ($entity instanceof UBItem) {
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
	$line_number = 0;
	foreach($transaction as $log_row) {
		if (!empty($log_row['Event']) AND $log_row['Event'] == $event AND !empty($log_row['ObjectSubtype']) AND $log_row['ObjectSubtype'] == $subtype) {
			if ($line) {
				$value = intval($line_number);
			}
			else {
				$value = $log_row[$field];
			}
		}
		$line_number++;
	}
	
	return $value;
}

function determineActivityId($object_id) {
    $object = get_entity($object_id);
    if ($object instanceof UBItem) {
        $subtype = $object->getSubtype();
        if ($subtype )
            $temp_array = get_entity_relationships($object_id, true);
        foreach($temp_array as $rel) {
            $rel_id = $rel->guid_two;
            $target = get_entity($rel_id);
            if (!is_null($target) && $target instanceof ElggEntity) {
                if ($target->getSubtype() == ClipitPost::SUBTYPE || $target->getSubtype() == ClipitComment::SUBTYPE) {
                    $rel_array = get_entity_relationships($rel_id, true);
                    foreach($rel_array as $rel2) {
                        $target_id2 = $rel2->guid_two;
                        $target2 = get_entity($target_id2);
                        if (!is_null($target2) && $target2 instanceof ElggEntity) {
                            if ($target2->getSubtype() == ClipitGroup::SUBTYPE) {
                                $group_id = $target_id2;
                            }
                            else if ($target2->getSubtype() == ClipitActivity::SUBTYPE) {
                                $activity_id = $target_id2;
                            }
                        }
                    }
                }
            }
        }

    }
    else {
        $activity_id = 0;
    }
    return $activity_id;
}

function determineActivityType($transaction) {
	$type = "";
    if (isset($transaction[0]) && !empty($transaction[0])) {
        if ($transaction[0]['Event'] == 'create') {
            if ($transaction[0]['ObjectSubtype'] == 'name') {
                if (findValue($transaction, "create", ClipitPost::SUBTYPE, "ObjectId", FALSE) > 0) {
                    $type = "Discussion";
                }
                elseif (findValue($transaction, "create", ClipitComment::SUBTYPE, "ObjectId", FALSE) > 0) {
                    $type = "Discussion";
                }
                elseif (findValue($transaction, "create", ClipitGroup::SUBTYPE, "ObjectId", FALSE) > 0) {
                    $type = "GroupCreation";
                }
                elseif (findValue($transaction, "create", ClipitVideo::SUBTYPE, "ObjectId", FALSE) > 0) {
                    $type = "VideoUpload";
                }
                elseif (findValue($transaction, "create", ClipitTask::SUBTYPE, "ObjectId", FALSE) > 0) {
                    $type = "CreateTask";
                }
                elseif (findValue($transaction, "create", ClipitActivity::SUBTYPE, "ObjectId", FALSE) > 0) {
                    $type = "CreateActivity";
                }
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
                        $hybrid_transaction = splitTransaction($transaction);
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
        elseif ($transaction[0]['Event'] == 'logout') {
            $type = "Logout";
        }
    }
    if ($type == "") {
		$type = "Unidentified";
	}
	return $type;
}

function splitTransaction($trans) {
    $row = 0;
    $login_transaction = array();
    $new_transaction = array();
    foreach ($trans as $key => $value) {
        if ($row <= 2) {
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