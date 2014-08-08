<?php


	function activitystreamer_init()
	{
		global $CONFIG;
        global $con;
        global $transaction_stmt;
        global $logging_stmt;
        elgg_register_page_handler('activitystreamer','activitystreamer_page_handler');
        $_SESSION['logging_table'] = $CONFIG->dbprefix."extended_log";
		$_SESSION['activity_table'] = $CONFIG->dbprefix."activitystreams";
		$_SESSION['logged'] = false;
		$_SESSION['enabled'] = true;
		$_SESSION['transaction_artifact'] = array();
        $con=mysqli_connect($CONFIG->dbhost,$CONFIG->dbuser,$CONFIG->dbpass,$CONFIG->dbname);
        $transaction_stmt = $con->prepare("INSERT DELAYED INTO `".$_SESSION['activity_table']."` ".
            "(transaction_id, json, actor_id, group_id, course_id, activity_id, verb, role, timestamp) ".
            "VALUES (?,?,?,?,?,?,?,?,?)");
        $logging_stmt = $con->prepare("INSERT DELAYED INTO `".$_SESSION['logging_table']."` ".
            "(object_id, object_title, transaction_id, object_class, object_type, object_subtype, event, time, ip_address, user_id, user_name, access_id, enabled, owner_guid, content, group_id, course_id, activity_id, role) ".
            "VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);");

    }

    function is_session_started()
    {
        if ( php_sapi_name() !== 'cli' ) {
            if ( version_compare(phpversion(), '5.4.0', '>=') ) {
                return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
            } else {
                return session_id() === '' ? FALSE : TRUE;
            }
        }
        return FALSE;
    }


	function init_transaction()
	{
        if ( is_session_started() === FALSE ) session_start();
        $time = time();
		$ip_address = sanitise_string($_SERVER['REMOTE_ADDR']);
		$guid = elgg_get_logged_in_user_entity()->guid;
        $pid = getmypid();
		$_SESSION['tid'] = md5("".$time.$ip_address.$guid.$pid);
	}


	function activitystreamer_page_handler($page) 
	{
        $title = "ActivityStreamer Administration";
        $params = array(
            'content' => elgg_view("activitystreamer/activitystreamer"),
            'title' => $title,
            'filter' => "",
        );
        $body = elgg_view_layout('one_column', $params);
        echo elgg_view_page($title, $body);

	}
	
	//Function to add a submenu to the admin panel. 
	function activitystreamer_pagesetup()
	{
        global $CONFIG;
        if (elgg_is_admin_logged_in() && elgg_get_context('admin')) {
            elgg_register_menu_item('page', array(
                'name' =>  'Other',
                'href' => $CONFIG->wwwroot . 'activitystreamer',
                'text' => 'ActivityStreamer',
                'context' => 'admin'));
        }
	}
	
	//Because of PHP constraints, we now implement an indirect approach and use the mysql db as a buffer. 
	function extended_log($object, $event) {
        global $logging_stmt;
        if ( is_session_started() === FALSE ) session_start();

        if ($object instanceof Loggable) {
            $group_id = 0;
            $course_id = 0;
            $activity_id = 0;
            $object_id = (int)$object->getSystemLogID();
            if (is_null($object_id)) {
               $object_id = 0;
            }
            $object_class = $object->getClassName();
            if (is_null($object_class)) {$object_class = "";}
            if ($object_class == "ElggAnnotation" || $object_class == "ElggMetadata") {
                $object_content = $object->value;
            }
            else if ($object_class == "ElggRelationship") {
                $rel = get_relationship($object_id);
                $source_id = $rel->guid_one;
                $source = get_entity($source_id);
                $target_id = $rel->guid_two;
                $target = get_entity($target_id);
                if (!is_null($target) && $target instanceof ElggEntity) {
                    if ($target->getSubtype() == ClipitGroup::SUBTYPE) {
                        if ($source->getSubtype() == ClipitActivity::SUBTYPE) {
                            $object_content = $source_id."-".$target_id;
                        }
                        else {
                            $object_content = "new";
                        }
                        $group_id = $target_id;
                    }
                    else if ($target->getSubtype() == ClipitActivity::SUBTYPE) {
                        $object_content = "new";
                        $activity_id = $target_id;
                    }
                    else {
                        $object_content = $source_id."-".$target_id;
                    }
                }
            }
            else {
                $object_content = $object->description;
            }
            if ($object_content == null) {$object_content = "";}
            $object_type = $object->getType();
            if ($object_type == null) {$object_type = "";}
            $object_subtype = $object->getSubtype();
            if ($object_subtype == null) {$object_subtype = "none";}
            if ($object_type == "object") {
                $elgg_object = get_entity($object_id);
                if (!is_null($elgg_object)) {
                    $object_title = $elgg_object->title;
                }
            }
            else {
                $object_title = $object_subtype;
            }
            $event = sanitise_string($event);
            if (is_null($event)) {$event = "";}
            $time = time();
            if (is_not_null($object->time_created) && $object->time_created != "") {
                $time = $object->time_created;
            }
            $ip_address = sanitise_string($_SERVER['REMOTE_ADDR']);
            if (is_null($ip_address)) {$ip_address = "";}
            $performed_by = (int)elgg_get_logged_in_user_guid();
            if (is_null($performed_by)) {$performed_by = 0;}
            $user_name = elgg_get_logged_in_user_entity()->name;
            if (is_null($user_name)) {$user_name = "";}
            if (isset($object->access_id)) {
                $access_id = (int)$object->access_id;
            } else {
                $access_id = ACCESS_PUBLIC;
            }
            if (isset($object->enabled)) {
                $enabled = $object->enabled;
            } else {
                $enabled = 'yes';
            }

            if (isset($object->owner_guid)) {
                $owner_guid = (int)$object->owner_guid;
            } else {
                $owner_guid = 0;
            }

            $transaction_id = $_SESSION['tid'];
            $role = "";
            $user_properties = ClipitUser::get_properties($performed_by, array("role"));
            if (is_not_null($user_properties) && !empty($user_properties['role'])) {
                $role = $user_properties['role'];
            }
//
//            $result = mysqli_query($con,"SHOW COLUMNS FROM `".$log_table."` LIKE 'user_name';");
//            if ($result) {
//                $exists_username = (mysqli_num_rows($result))?TRUE:FALSE;
//            }
//            $result = mysqli_query($con,"SHOW COLUMNS FROM `".$log_table."` LIKE 'object_title';");
//            if ($result) {
//                $exists_object_title = (mysqli_num_rows($result))?TRUE:FALSE;
//            }
//            if (!$exists_username || !$exists_object_title) {
//                if ($stmt = mysqli_prepare($con, "RENAME TABLE ".$log_table." TO ".$log_table."_".$time.";")) {
//                    mysqli_stmt_execute($stmt);
//                }
//                else {
//                    error_log($stmt->error);
//                }
//                $stmt->close();
//            }
            if ($object_content == null) {
                $object_content = "";
            }
            else {
                $object_content = urlencode($object_content);
            }
            //If the table doesn't exist, we need to create it...
//            mysqli_query($con,"CREATE TABLE IF NOT EXISTS `".$log_table."` (".
//                                  "`log_id` int(255) NOT NULL AUTO_INCREMENT,".
//                                  "`object_id` int(255) NOT NULL, ".
//                                  "`object_title` varchar(255) NOT NULL, ".
//                                  "`transaction_id` varchar(255) NOT NULL, ".
//                                  "`object_class` varchar(255) NOT NULL, ".
//                                  "`object_type` varchar(255) NOT NULL, ".
//                                  "`object_subtype` varchar(255) NOT NULL, ".
//                                  "`event` varchar(255) NOT NULL, ".
//                                  "`time` varchar(255) NOT NULL, ".
//                                  "`ip_address` varchar(255) NOT NULL, ".
//                                  "`user_id` int(255) NOT NULL, ".
//                                  "`user_name` varchar(255) NOT NULL, ".
//                                  "`access_id` int(255) NOT NULL, ".
//                                  "`enabled` varchar(255) NOT NULL, ".
//                                  "`owner_guid` int(255) NOT NULL, ".
//                                  "`content` longtext NOT NULL, ".
//                                  "`group_id` int(255) NOT NULL, ".
//                                  "`course_id` int(255) NOT NULL, ".
//                                  "`activity_id` int(255) NOT NULL, ".
//                                  "`role` varchar(255) NOT NULL, ".
//                                   "PRIMARY KEY (`log_id`) ".
//                                ") ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1;");

            $logging_stmt->bind_param('iisssssssisisisiiis', $object_id, $object_title, $transaction_id, $object_class, $object_type, $object_subtype, $event, $time, $ip_address, $performed_by,
                                                             $user_name, $access_id, $enabled, $owner_guid, $object_content, $group_id, $course_id, $activity_id, $role);
            $logging_stmt->execute();
/*            insert_data("INSERT DELAYED INTO `".$_SESSION['logging_table']."` ".
                                "(object_id, object_title, transaction_id, object_class, object_type, object_subtype, event, time, ip_address, user_id, user_name, access_id, enabled, owner_guid, content, group_id, course_id, activity_id, role) ".
                                "VALUES (".$object_id.", '".$object_title."', '".$transaction_id."', '".$object_class."', '".$object_type."', '".$object_subtype."', '".$event."', '".$time."', '".$ip_address."', '".$performed_by.
                                "', '".$user_name."', ".$access_id.", '".$enabled."', ".$owner_guid.", '".$object_content."', ".$group_id.", ".$course_id.", ".$activity_id.", '".$role."');");

*/
            $_SESSION['transaction_artifact'][] = array('ObjectId' => $object_id, 'ObjectTitle' => $object_title, 'ObjectType' => $object_type, 'ObjectSubtype' => $object_subtype, 'ObjectClass' => $object_class, 'OwnerGUID' => $owner_guid,
                                                    'GroupId' => $group_id, 'CourseId' => $course_id, 'ActivityId' => $activity_id, 'Event' => $event, 'Content' => $object_content,
                                                    'Timestamp' => $time, 'UserId'=> $performed_by, 'UserName'=> $user_name, 'IPAddress' => $ip_address, 'Role' => $role, 'TransactionId' => $transaction_id);
//            $con->close();
            //If we actually logged something, we need to let the transaction handler know
            $_SESSION['logged'] = true;
        }
	}
	
	function transactionExists($where, $con) {
        $act_table = $_SESSION['activity_table'];	
        $query = "SELECT * FROM `".$act_table."` WHERE transaction_id = `".$where."`;";
        $result = $con->query($query);
 
        if($result->num_rows > 0) {
                return true; // The record(s) do exist
        }
        return false; // No record found
	}
	
	function transaction_handling()
	{
   //     include_once(elgg_get_plugins_path(). "z30_activitystreamer" . DIRECTORY_SEPARATOR . "lib" . DIRECTORY_SEPARATOR . "logProcessing.php");
        include_once(elgg_get_plugins_path(). "z30_activitystreamer/lib/logProcessing.php");
		global $con;
        global $transaction_stmt;
       	$act_table = $_SESSION['activity_table'];
		$logged = $_SESSION['logged'];

		if($_SESSION['enabled']) {
			if ($logged) {
				//First we get the recently added transaction and transform it into json activitystream
				$action_particles = $_SESSION['transaction_artifact'];
				$action = convertLogTransactionToActivityStream($action_particles);
				//Then we put this new information into a separate table, coupled with ids for access management and timestamps for ordering purposes
				//Unless we were unable to identify the activity
				if (!($action['verb'] == 'Unidentified')) {
					storeJSON($action);
				}
                else {
                    error_log("Found no corresponding activity for ".print_r($action_particles, true));
                }
 			}
			/*
            elseif (!transactionExists($transaction_id, $con)) {
				$url = $_SERVER[ "REQUEST_URI" ];
				if (strpos($url, '/js/') == FALSE AND strpos($url, '/mod/') == FALSE AND strpos($url, '/action/') == FALSE) {
					$action = convertURLToActivityStream($url);					
					if (!($action['verb'] == 'Unidentified')) {
						storeJSON($action, $act_table, $con, $stmt);
					}
				}
			}
			*/
		}
		$con->close();
	}



function extended_log_default_logger($event, $object_type, $object) {
   		extended_log($object['object'], $object['event']);
	   	return true;
 	}
 
	function extended_log_listener($event, $object_type, $object) {
		if (($object_type != 'extended_log') && ($event != 'log')) {
        		elgg_trigger_event('log', 'extended_log', array('object' => $object, 'event' => $event));
     		}
      	return true;
 	}

	function print_exception($e) {
		echo("Exception abgefangen: ".$e->getMessage()."<br />");
		echo("Code: ".$e->getCode()."<br />");
		echo("File: ".$e->getFile()."<br />");
		echo("Line: ".$e->getLine()."<br />");
		echo("Trace: ".$e->getTraceAsString()."<br />");
	}

    elgg_register_event_handler('all', 'all', 'extended_log_listener', 401);
    elgg_register_event_handler('log', 'extended_log', 'extended_log_default_logger', 999);
    elgg_register_event_handler('init','system','activitystreamer_init');
    elgg_register_event_handler('plugins_boot','system','init_transaction');
	register_shutdown_function('transaction_handling');
    elgg_register_event_handler('pagesetup','system','activitystreamer_pagesetup');
    elgg_register_action('activitystreamer/rebuild', elgg_get_plugins_path(). "z30_activitystreamer/actions/rebuild.php");