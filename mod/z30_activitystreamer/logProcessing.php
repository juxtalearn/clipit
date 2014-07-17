<?php
function storeJSON($action, $act_table, $con) {
	$action['object']['content'] = 	urlencode($action['object']['content']); 
	$activity_json = json_encode($action);
	
	$con->query("CREATE TABLE IF NOT EXISTS `".$act_table."` (".
					  "`transaction_id` varchar(255) NOT NULL, ".
					  "`json` longtext NOT NULL, ".
					  "`actor_id` int(255) NOT NULL, ".
					  "`group_id` int(255) NOT NULL, ".
					  "`course_id` int(255) NOT NULL, ".
					  "`activity_id` int(255) NOT NULL, ".
					  "`timestamp` varchar(255) NOT NULL, ".
					  "PRIMARY KEY (`transaction_id`) ".
					  ") ENGINE=InnoDB DEFAULT CHARSET=utf8 DEFAULT COLLATE utf8_general_ci;");
	$con->query("INSERT INTO `".$act_table."` ".
					  "(transaction_id, json, actor_id, group_id, course_id, activity_id, timestamp) ".
					  "VALUES ('".$action['transactionId']."', '".$activity_json."', '".$action['actor']['actorId']."', '".$action['object']['groupId']."', '".$action['object']['courseId']."', '".$action['object']['activityId'].
					  "', '".$action['published']."');");
}


function processURL($url) {
	$object_Id = 0;
	$values = explode("/", $url);
	$oject_Id = end($values);
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
		$actor['IPAdress'] = $ip_address;
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
	$actor = array('IPAdress' => "", 'displayName' => "", 'actorId' => "", 'objectType' => "", 'groupId' => "", 'courseId' => "", 'activityId' => "");
	$verb = "";
	$object = array('objectId' => "", 'objectTitle' => "", 'objectType' => "", 'objectSubtype' => "", 'objectClass' => "", 'ownerGUID' => "", 'content' => "", 'targetId' => "", 'groupId' => "", 'courseId' => "", 'activityId' => "");
	$published = "";
	$transaction_id = $transaction[0]['TransactionId'];
	$type = determineActivityType($transaction);
	
// 	Getting the data about the actor is always the same, since we can just use the first log entry from the transaction	
	$actor['IPAdress'] = $transaction[0]['IPAdress'];
	$actor['displayName'] = $transaction[0]['UserName'];
	$actor['actorId'] = $transaction[0]['PerformedBy'];
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
			$l = findValue($transaction, "create", "clipit_post", "ObjectId", TRUE);
			$verb = "annotate";
			$object['objectId'] = $transaction[$l]['ObjectId'];
			$object['objectType'] = $transaction[$l]['ObjectType'];
			$object['objectSubtype'] = $transaction[$l]['ObjectSubtype'];
			$object['objectClass'] = $transaction[$l]['ObjectClass'];
			$object['ownerGUID'] = $transaction[$l]['OwnerGUID'];
			$object['content'] = $transaction[$l]['Content'];
			
			$target_id = findValue($transaction, "create", "message-destination", "Content", FALSE);
			$type = "clipit_post";
			if ($target_id == "new") {
				$activity_id = findValue($transaction, "create", "message-destination", "ActivityId", FALSE);
				$group_id = findValue($transaction, "create", "message-destination", "GroupId", FALSE);
				if ($activity_id > 0) {
					$target_id = $activity_id;
					$type = "clipit_activity";
				}
				if ($group_id > 0) {
					$target_id = $group_id;
					$type = "clipit_group";
				}
			}
			$object['targetId'] = $target_id;
			$object['targetType'] = "object";
			$object['targetSubtype'] = $type;
									
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
			$object['content'] = "JuxtaLearn Platform";
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
			$object['content'] = "JuxtaLearn Platform";
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
            $object['content'] = "JuxtaLearn Platform";
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

function determineActivityType($transaction) {
	$type = "";
    if (isset($transaction[0])) {
        if ($transaction[0]['Event'] == 'create') {
            if ($transaction[0]['ObjectSubtype'] == 'name') {
                if (findValue($transaction, "create", "ClipitPost", "ObjectId", FALSE) > 0) {
                    $type = "Discussion";
                }
                elseif (findValue($transaction, "create", "ClipitGroup", "ObjectId", FALSE) > 0) {
                    $type = "GroupCreation";
                }
                elseif (findValue($transaction, "create", "ClipitVideo", "ObjectId", FALSE) > 0) {
                    $type = "VideoUpload";
                }
                elseif (findValue($transaction, "create", "ClipitTask", "ObjectId", FALSE) > 0) {
                    $type = "CreateTask";
                }
                elseif (findValue($transaction, "create", "ClipitActivity", "ObjectId", FALSE) > 0) {
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
                    if (empty($transaction[3])) {
                        $type = "Login";
                    }
                    else {
                        //If it is an API call, we will simply remove the login and restart detection:
                        $new_transaction = array_diff($transaction, array($transaction[0], $transaction[1], $transaction[2]));
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