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
		
	$object_Id = processURL($url); 
	if ($object_Id != 0) {
		$transaction_id = $_SESSION['tid'];
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
				$temp_array = get_entity_relationships($object_id, true);
		        foreach($temp_array as $rel){
		            if($rel->relationship == ClipitActivity::REL_ACTIVITY_FILE OR $rel->relationship == ClipitActivity::REL_ACTIVITY_TASK OR $rel->relationship == ClipitActivity::REL_ACTIVITY_VIDEO){
		                $activity_id = $rel->guid_one;
		            }
					elseif($rel->relationship == ClipitGroup::REL_GROUP_FILE /*OR $rel->relationship == ClipitGroup::REL_GROUP_TASK OR $rel->relationship == ClipitGroup::REL_GROUP_VIDEO */){
						$group_id = $rel->guid_one;
					}
					//TODO Add support for courses when available 
		        }
				
				$role = ClipitUser::get_properties($performed_by, array("role"));
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
	
	
//	Same is true for the published value	
	$published = $transaction[0]['Timestamp'];

//  The rest is up to the identified action:
	switch ($type) {
		case "Unidentified":
			$verb = "Unidentified";
			break;
		case "Comment":
		case "Fivestar":
			$verb = "annotate";
			$object['objectId'] = $transaction[1]['ObjectId'];
			$object['objectType'] = $transaction[1]['ObjectType'];
			$subtype = $transaction[1]['ObjectSubtype'];
			if ($subtype == "elggx_fivestar_rating") {
				$subtype = "fivestar";
			}
			$object['objectSubtype'] = $subtype;
			$object['objectClass'] = $transaction[1]['ObjectClass'];
			$object['ownerGUID'] = $transaction[1]['OwnerGUID'];
			$object['content'] = $transaction[1]['Content'];
			$object['targetId'] = $transaction[0]['ObjectId'];
			$object['targetName'] = $transaction[0]['ObjectTitle'];
			$targetSubtype = $transaction[0]['ObjectSubtype'];
			if ($targetSubtype == "elggx_fivestar_rating") {
				$targetSubtype = "fivestar";
			echo print_r($transaction);
			echo "<br />";
			echo "<br />";
			echo "<br />";
			}
			$object['targetSubtype'] = $targetSubtype;
			$object['groupId'] = $transaction[0]['GroupId'];
			$object['courseId'] = $transaction[0]['CourseId'];
			$object['activityId'] = $transaction[0]['ActivityId'];
			break;
		case "BlogPost":
			$verb = "add";
			$objectId = findValue($transaction, "create", "blog", "ObjectId");
			$objectName = findValue($transaction, "create", "blog", "ObjectTitle");
			$object['objectId'] = $objectId;
			$object['displayName'] = $objectName;
			$object['objectType'] = $transaction[0]['ObjectType'];
			$object['objectSubtype'] = $transaction[0]['ObjectSubtype'];
			$object['objectClass'] = $transaction[0]['ObjectClass'];
			$object['ownerGUID'] = $transaction[0]['OwnerGUID'];
			$object['content'] = $transaction[0]['Content'];
			$object['groupId'] = $transaction[0]['GroupId'];
			$object['courseId'] = $transaction[0]['CourseId'];
			$object['activityId'] = $transaction[0]['ActivityId'];
			break;
		case "DeleteComment":
		case "DeleteFile":
			$verb = "delete";
			$object['objectId'] = $transaction[0]['ObjectId'];
			$object['displayName'] = $transaction[0]['ObjectTitle'];
			$object['objectType'] = $transaction[0]['ObjectType'];
			$object['objectSubtype'] = $transaction[0]['ObjectSubtype'];
			$object['objectClass'] = $transaction[0]['ObjectClass'];
			$object['ownerGUID'] = $transaction[0]['OwnerGUID'];
			$object['content'] = "";
			$object['groupId'] = $transaction[0]['GroupId'];
			$object['courseId'] = $transaction[0]['CourseId'];
			$object['activityId'] = $transaction[0]['ActivityId'];
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
		case "UploadFile":
			$verb = "add";
			$object['objectId'] = $transaction[5]['ObjectId'];
			$object['displayName'] = $transaction[5]['ObjectTitle'];
			$object['objectType'] = $transaction[5]['ObjectType'];
			$object['objectSubtype'] = $transaction[5]['ObjectSubtype'];
			$object['objectClass'] = $transaction[5]['ObjectClass'];
			$object['ownerGUID'] = $transaction[5]['OwnerGUID'];
			$object['content'] = $transaction[5]['Content'];
			$object['groupId'] = $transaction[5]['GroupId'];
			$object['courseId'] = $transaction[5]['CourseId'];
			$object['activityId'] = $transaction[5]['ActivityId'];
			break;
		case "ReadMessage":
			$verb = "read";
			$object['objectId'] = $transaction[0]['ObjectId'];
			$object['displayName'] = "message";
			$object['objectType'] = $transaction[0]['ObjectType'];
			$object['objectSubtype'] = $transaction[0]['ObjectSubtype'];
			$object['objectClass'] = $transaction[0]['ObjectClass'];
			$object['ownerGUID'] = $transaction[0]['OwnerGUID'];
			$object['content'] = "";
			$object['groupId'] = $transaction[0]['GroupId'];
			$object['courseId'] = $transaction[0]['CourseId'];
			$object['activityId'] = $transaction[0]['ActivityId'];
			break;
		default:
			$verb = "Unidentified";
//			$verb = $type;
			
	}
	
	$activity = array('actor' => $actor, 'verb' => $verb, 'object' => $object, 'published' => $published, 'transactionId' => $transaction_id);
	return $activity;
}

function findValue($transaction, $event, $subtype, $field) {
	$value = 0;
	foreach($transaction as $log_row) {
		if (!empty($transaction['Event']) AND $transaction['Event'] == $event AND !empty($transaction['ObjectSubtype']) AND $transaction['ObjectSubtype'] == $subtype) {
			$value = $transaction[$field];
		}
	}
	
	return $value;
}

function determineActivityType($transaction) {
	$type = "";
	if ($transaction[0]['Event'] == 'annotate') {
		if ($transaction[0]['ObjectSubtype'] == 'bb_chat') {
			$type = "ChatMessage";
		}
		elseif (!empty($transaction[1])) {
			if ($transaction[1]['ObjectSubtype'] == 'generic_comment') {
				$type = "Comment";
			}
			elseif ($transaction[1]['ObjectSubtype'] == 'fivestar') {
				$type = "Fivestar";
			}
		}
		elseif ($transaction[0]['ObjectSubtype'] == 'groupforumtopic') {
			if (!empty($transaction[1])) {
				if ($transaction[1]['ObjectSubtype'] == 'group_topic_post') {
					$type = "ForumReply";
				}
				elseif ($transaction[1]['ObjectSubtype'] == 'toId') {
					$type = "ForumNotification";
				}
			}
		}
	}
	elseif ($transaction[0]['Event'] == 'create') {
		if ($transaction[0]['ObjectSubtype'] == 'friendrequest') {
			$type = "SendFriendRequest";
		}
		elseif ($transaction[0]['ObjectSubtype'] == 'member_of_site') {
			$type = "AccountCreation";
		}
		elseif ($transaction[0]['ObjectSubtype'] == 'status') {
			$objectId = findValue($transaction, "create", "blog", "ObjectId");
			if ($objectId > 0) {
				$type = "BlogPost";
			}
			else {
				$objectId = findValue($transaction, "create", "groupforumtopic", "ObjectId");
				if ($objectId > 0) {
					$type = "ForumTopicCreation";
				}
				else {
//					echo("Kaputt!<br />");
				}
			}
 		}
		elseif ($transaction[0]['ObjectSubtype'] == 'membership_request') {
			$type = "SendMembershipRequest";
		}
		//The log plugin needs to decode what type of container is joined, until then group is assumed
		elseif ($transaction[0]['ObjectSubtype'] == 'member') {
			$type = "JoinGroup";
		}
		elseif ($transaction[0]['ObjectSubtype'] == 'x1') {
			$type = "AddProfilePicture";
		}
		elseif ($transaction[0]['ObjectSubtype'] == 'file') {
			$type = "UploadFile";
		}
		elseif ($transaction[0]['ObjectSubtype'] == 'filename') {
			if (!empty($transaction[4])) {
				if ($transaction[4]['ObjectSubtype'] == 'file') {
					$type = "UploadFile";
				}
			}
			elseif (!empty($transaction[12])) {
				if ($transaction[12]['ObjectSubtype'] == 'file') {
					$type = "UploadFile";
				}
			}
		}
		elseif ($transaction[0]['ObjectSubtype'] == 'tags') {
			if (!empty($transaction[5])) {
				if ($transaction[5]['ObjectSubtype'] == 'file') {
					$type = "UploadFile";
				}
			}
			elseif (!empty($transaction[13])) {
				if ($transaction[13]['ObjectSubtype'] == 'file') {
					$type = "UploadFile";
				}
			}
		}
		elseif ($transaction[0]['ObjectSubtype'] == 'bb_chat') {
			$type = "ChatMessage";
		}
		elseif (!empty($transaction[1])) {
			if ($transaction[1]['ObjectSubtype'] == 'generic_comment') {
				$type = "Comment";
			}
			elseif ($transaction[1]['ObjectSubtype'] == 'fivestar') {
				$type = "Fivestar";
			}
		}
	}
	elseif ($transaction[0]['Event'] == 'update') {
		if (!empty($transaction[1])) {
			if ($transaction[1]['ObjectSubtype'] == 'generic_comment') {
				$type = "KommentarUpdate";
			}
			elseif (!empty($transaction[1]) && $transaction[1]['Event'] == 'login') {
				$type = "Login";
			}
			elseif (!empty($transaction[2]) && $transaction[2]['Event'] == 'login') {
				$type = "Login";
			}
			elseif (!empty($transaction[2]) && $transaction[2]['Event'] == 'logout') {
				$type = "Logout";
			}
			elseif (!empty($transaction[2]) && $transaction[2]['Event'] == 'profileupdate') {
				$type = "ProfileUpdate";
			}
			elseif (!empty($transaction[4]) && $transaction[4]['Event'] == 'profileupdate') {
				$type = "ProfileUpdate";
			}
		}
		if ($transaction[0]['ObjectSubtype'] == 'fivestar') {
			if (!empty($transaction[1]) && $transaction[1]['Event'] == 'delete') {
				$type = "UpdateFivestar";
			}
		}
	}
	elseif ($transaction[0]['Event'] == 'delete') {
		if ($transaction[0]['ObjectSubtype'] == 'friendrequest') {
			if (!empty($transaction[1]) && $transaction[1]['Event'] == 'create')  { 
				$type = "AcceptFriendRequest";
			}
			else {
				$type = "DenyFriendRequest";
			}
		}
		elseif ($transaction[0]['ObjectSubtype'] == 'icontime') {
			if (!empty($transaction[1]) && $transaction[1]['Event'] == 'create')  { 
				if ($transaction[0]['ObjectSubtype'] == 'icontime') {
					$type = "UpdateProfilePicture";
				}
			}
		}
		elseif ($transaction[0]['ObjectSubtype'] == 'x1') {
			if (!empty($transaction[4]) && $transaction[4]['Event'] == 'delete' && $transaction[4]['ObjectSubtype'] == 'icontime')  { 
				$type = "DeleteProfilePicture";
			}
		}
		elseif ($transaction[0]['ObjectType'] == 'group') {
			$type = "DeleteGroup";
		}
		elseif ($transaction[0]['ObjectType'] == 'groupforumtopic') {
			$type = "DeleteForumTopic";
		}
		elseif ($transaction[0]['ObjectSubtype'] == 'file') {
			$type = "DeleteFile";
		}
		elseif ($transaction[0]['ObjectSubtype'] == 'blog') {
			$type = "DeleteBlog";
		}
		elseif ($transaction[0]['ObjectSubtype'] == 'messages') {
			$type = "DeleteMessage";
		}
		elseif ($transaction[0]['ObjectSubtype'] == 'member') {
			$type = "LeaveGroup";
		}
		elseif ($transaction[0]['ObjectSubtype'] == 'readYet') {
			$type = "ReadMessage";
		}
		elseif ($transaction[0]['ObjectSubtype'] == 'event_calendar') {
			$type = "DeleteCalendarEntry";
		}
		elseif ($transaction[0]['ObjectSubtype'] == 'generic_comment') {
			$type = "DeleteComment";
		}
	}
	elseif ($transaction[0]['Event'] == 'logout') {
		$type = "Logout";
	}
	elseif ($transaction[0]['Event'] == 'disable') {
		$type = "Disable";
	}
	if ($type == "") {
		$type = "Unidentified";
	}
	return $type;
}