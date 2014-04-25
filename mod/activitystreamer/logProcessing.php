<?php
function convertLogTransactionToActivityStream($transaction) {
	$actor = array('IPAdress' => "", 'displayName' => "", 'actorId' => "", 'objectType' => "", 'groupId' => "", 'courseId' => "", 'activityId' => "");
	$verb = "";
	$object = array('objectId' => "", 'objectType' => "", 'objectSubtype' => "", 'objectClass' => "", 'ownerGUID' => "", 'content' => "", 'targetId' => "", 'groupId' => "", 'courseId' => "", 'activityId' => "");
	$published = "";
	$transaction_id = $transaction[0]['TransactionId'];
	$type = determineActivityType($transaction);
	
// 	Getting the data about the actor is always the same, since we can just use the first log entry from the transaction	
	$actor['IPAdress'] = $transaction[0]['IPAdress'];
	$actor['displayName'] = getName("user", $transaction[0]['PerformedBy']);
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
			$object['objectSubtype'] = $transaction[1]['ObjectSubtype'];
			$object['objectClass'] = $transaction[1]['ObjectClass'];
			$object['ownerGUID'] = $transaction[1]['OwnerGUID'];
			$object['content'] = $transaction[1]['Content'];
			$object['targetId'] = $transaction[0]['ObjectId'];
			$object['targetName'] = getName("object", $transaction[0]['ObjectId']);
			$object['groupId'] = $transaction[0]['GroupId'];
			$object['courseId'] = $transaction[0]['CourseId'];
			$object['activityId'] = $transaction[0]['ActivityId'];
			break;
		case "BlogPost":
			$verb = "add";
			$object['objectId'] = $transaction[0]['ObjectId'];
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
			$verb = "delete";
			$object['objectId'] = $transaction[0]['ObjectId'];
			$object['objectType'] = $transaction[0]['ObjectType'];
			// $object['objectSubtype'] = $transaction[0]['ObjectSubtype'];
			$object['objectSubtype'] = "comment";
			$object['objectClass'] = $transaction[0]['ObjectClass'];
			$object['ownerGUID'] = $transaction[0]['OwnerGUID'];
			$object['content'] = "";
			$object['groupId'] = $transaction[0]['GroupId'];
			$object['courseId'] = $transaction[0]['CourseId'];
			$object['activityId'] = $transaction[0]['ActivityId'];
			break;
		case "Login":
		case "AccountCreation":
			$verb = "join";
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
			$verb = "leave";
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
			$object['objectType'] = $transaction[5]['ObjectType'];
			$object['objectSubtype'] = $transaction[5]['ObjectSubtype'];
			$object['objectClass'] = $transaction[5]['ObjectClass'];
			$object['ownerGUID'] = $transaction[5]['OwnerGUID'];
			$object['content'] = $transaction[5]['Content'];
			$object['groupId'] = $transaction[5]['GroupId'];
			$object['courseId'] = $transaction[5]['CourseId'];
			$object['activityId'] = $transaction[5]['ActivityId'];
			break;
		
		default:
			$verb = "Unidentified";
			// $verb = $type;
			
	}
	
	$activity = array('actor' => $actor, 'verb' => $verb, 'object' => $object, 'published' => $published, 'transactionId' => $transaction_id);
	return $activity;
}

function determineActivityType($transaction) {
	$type = "";
	if ($transaction[0]['Event'] == 'annotate') {
		if ($transaction[0]['ObjectSubtype'] == 'bb_chat') {
			$type = "ChatMessage";
		}
		if ($transaction[0]['ObjectSubtype'] == 'blog') {
			if (empty($transaction[1])) {
				$type = "BlogPost";
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
		elseif (!empty($transaction[1])) {
			if ($transaction[1]['ObjectSubtype'] == 'generic_comment') {
				$type = "Comment";
			}
			elseif ($transaction[1]['ObjectSubtype'] == 'fivestar') {
				$type = "Fivestar";
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
		elseif (!empty($transaction[1])) {
			if ($transaction[1]['ObjectSubtype'] == 'generic_comment') {
				$type = "Comment";
			}
			elseif ($transaction[1]['ObjectSubtype'] == 'fivestar') {
				$type = "Fivestar";
			}
			elseif ($transaction[1]['ObjectSubtype'] == 'filename') {
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
		}
		else {
		}
	}
	elseif ($transaction[0]['Event'] == 'update') {
		if (!empty($transaction[1])) {
			if ($transaction[1]['ObjectSubtype'] == 'generic_comment') {
				$type = "Kommentar";
			}
			elseif (!empty($transaction[2]) && $transaction[2]['Event'] == 'login') {
				$type = "Login";
			}
			elseif (!empty($transaction[2]) && $transaction[2]['Event'] == 'profileupdate') {
				$type = "ProfileUpdate";
			}
			elseif (!empty($transaction[4]) && $transaction[4]['Event'] == 'profileupdate') {
				$type = "ProfileUpdate";
			}
		}
	}
	elseif ($transaction[0]['Event'] == 'delete') {
		if ($transaction[0]['ObjectSubtype'] == 'friendrequest') {
			if (!empty($transaction[1]) && $transaction[1]['Event'] == 'create')  { 
				$type = "AcceptFriendRequest";
			}
		}
		if ($transaction[0]['ObjectSubtype'] == 'icontime') {
			if (!empty($transaction[1]) && $transaction[1]['Event'] == 'create')  { 
				if ($transaction[0]['ObjectSubtype'] == 'icontime') {
					$type = "UpdateProfilePicture";
				}
			}
		}
		elseif ($transaction[0]['ObjectType'] == 'group') {
			$type = "DeleteGroup";
		}
		elseif ($transaction[0]['ObjectType'] == 'messages') {
			$type = "DeleteMessage";
		}
		elseif ($transaction[0]['ObjectType'] == 'readYet') {
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

function getName($table, $guid) {
	global $CONFIG;
	$name = "";
	if ($table == "user") {
		$label = "name";
	}
	else {
		$label = "title";
	}
	$con=mysqli_connect($CONFIG->dbhost,$CONFIG->dbuser,$CONFIG->dbpass,$CONFIG->dbname);
	$pf = $CONFIG->dbprefix;
	if ($getNameResult = $con->query("SELECT ".$label." FROM ".$pf.$table."s_entity WHERE guid = ".$guid.";")) {
		$getName = $getNameResult->fetch_assoc();
		$name = $getName[$label];
	}
	return $name;
}	