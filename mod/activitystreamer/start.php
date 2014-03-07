<?php


	function activitystreamer_init()
	{
		global $CONFIG;
		register_page_handler('activitystreamer','activitystreamer_page_handler');
		session_start();		
		$_SESSION['logging_table'] = $CONFIG->dbprefix."extended_log";
		$_SESSION['activity_table'] = $CONFIG->dbprefix."activitystreams";
		$_SESSION['logged'] = false;
		$_SESSION['enabled'] = false;
		$data = elgg_get_entities(array("types"=>"object", "subtypes"=>"modactivitystreamer", "owner_guids"=> '0' , "order_by"=>"","limit"=>0));
		if(isset($data[0])) {
			$entity = $data[0];
			/* We only wanna try to log if this plugin is enabled */
			if ($entity->showga) {
				$_SESSION['enabled'] = true;
			}
		}	
	}

	function init_transaction()
	{
		session_start();
		$time = time();
		$ip_address = sanitise_string($_SERVER['REMOTE_ADDR']);
		$guid = get_loggedin_user()->guid;
		$_SESSION['tid'] = md5("".$time.$ip_address.$guid);
	}


	function activitystreamer_page_handler($page) 
	{
		global $CONFIG;
		include($CONFIG->pluginspath . "activitystreamer/index.php"); 
	}
	
	//Function to add a submenu to the admin panel. 
	function activitystreamer_pagesetup()
	{
		if (get_context() == 'admin' && isadminloggedin()) {
			global $CONFIG;
			add_submenu_item(elgg_echo('activitystreamer'), $CONFIG->wwwroot . 'pg/activitystreamer/');
		}
	}
	
	//Because of PHP constraints, we now implement an indirect approach and use the mysql db as a buffer. 
	function extended_log($object, $event) {
		global $CONFIG;
		session_start();
		$log_table = $_SESSION['logging_table'];
		$activity_table = $_SESSION['activity_table'];
		
		static $log_cache;
		static $cache_size = 0;
		if($_SESSION['enabled']) {
			if ($object instanceof Loggable) {
				// If the object implements loggable interface, extract the necessary information and store a tuple in the space
				$dir=dirname(__FILE__);
				$data = elgg_get_entities(array("types"=>"object", "subtypes"=>"modactivitystreamer", "owner_guids"=> '0' , "order_by"=>"","limit"=>0));
				$i = 1;
				$object_id = (int)$object->getSystemLogID();
				if (is_null($object_id)) {
				   $object_id = 0;
				}
				$object_class = $object->getClassName();
				if ($object_class == null) {$object_class = "";}
				if ($object_class == "ElggAnnotation") {
					$object_content = $object->value;
				}
				else {
					$object_content = $object->description;
				}
				if ($object_content == null) {$object_content = "";}
				$object_type = $object->getType();
				if ($object_type == null) {$object_type = "";}
				$object_subtype = $object->getSubtype();
				if ($object_subtype == null) {$object_subtype = "none";}
				$event = sanitise_string($event);
				if ($event == null) {$event = "";}
				$time = time();
				$ip_address = sanitise_string($_SERVER['REMOTE_ADDR']);
				if ($ip_address == null) {$ip_address = "";}
				$performed_by = (int)elgg_get_logged_in_user_guid();
				if ($performed_by == null) {$performed_by = 0;}

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
				if (is_null($transaction_id) || $transaction_id == "") {
					$transaction_id = "none";
				}
				
				
				$group_id = 0;
				$course_id = 0;
				$activity_id = 0;
				$role = "";

				$temp_array = get_entity_relationships($object_id, true);
		        foreach($temp_array as $rel){
		            if($rel->relationship == ClipitActivity::REL_ACTIVITY_FILE OR $rel->relationship == ClipitActivity::REL_ACTIVITY_TASK OR $rel->relationship == ClipitActivity::REL_ACTIVITY_VIDEO){
		                $activity_id = $rel->guid_one;
		            }
					elseif($rel->relationship == ClipitGroup::REL_GROUP_FILE OR $rel->relationship == ClipitGroup::REL_GROUP_TASK OR $rel->relationship == ClipitGroup::REL_GROUP_VIDEO){
						$group_id = $rel->guid_one;
					}
					//TODO Add support for courses when available 
		        }
				
				$role = ClipitUser::get_properties($performed_by, array("role"));
				
				
				$con=mysqli_connect($CONFIG->dbhost,$CONFIG->dbuser,$CONFIG->dbpass,$CONFIG->dbname);
				//If the table doesn't exist, we need to create it...
				mysqli_query($con,"CREATE TABLE IF NOT EXISTS `".$log_table."` (".
									  "`log_id` int(255) NOT NULL AUTO_INCREMENT,".
									  "`object_id` int(255) NOT NULL, ".
									  "`transaction_id` varchar(255) NOT NULL, ".
									  "`object_class` varchar(255) NOT NULL, ".
									  "`object_type` varchar(255) NOT NULL, ".
									  "`object_subtype` varchar(255) NOT NULL, ".
									  "`event` varchar(255) NOT NULL, ".
									  "`time` varchar(255) NOT NULL, ".
									  "`ip_address` varchar(255) NOT NULL, ".
									  "`performed_by` varchar(255) NOT NULL, ".
									  "`access_id` int(255) NOT NULL, ".
									  "`enabled` varchar(255) NOT NULL, ".
									  "`owner_guid` int(255) NOT NULL, ".
									  "`content` longtext NOT NULL, ".
									  "`group_id` int(255) NOT NULL, ".
									  "`course_id` int(255) NOT NULL, ".
									  "`activity_id` int(255) NOT NULL, ".
									  "`role` varchar(255) NOT NULL, ".
									  "PRIMARY KEY (`log_id`) ".
									") ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;");
				mysqli_query($con,"INSERT INTO `".$log_table."` ".
									"(object_id, transaction_id, object_class, object_type, object_subtype, event, time, ip_address, performed_by, access_id, enabled, owner_guid, content, group_id, course_id, activity_id, role) ".
									"VALUES (".$object_id.", '".$transaction_id."', '".$object_class."', '".$object_type."', '".$object_subtype."', '".$event."', '".$time."', '".$ip_address."', '".$performed_by."', ".$access_id.", '".$enabled."', ".$owner_guid.", '".$object_content."', ".$group_id.", ".$course_id.", ".$activity_id.", '".$role."');");
									
				mysqli_store_result($con);
				$con->close();					
				//If we actually logged something, we need to let the transaction handler know	
				$_SESSION['logged'] = true;
			}
		}
	}
	
	
	function transaction_handling()
	{
		include_once(dirname(__FILE__).DIRECTORY_SEPARATOR."logProcessing.php");
		global $CONFIG;
		$con=mysqli_connect($CONFIG->dbhost,$CONFIG->dbuser,$CONFIG->dbpass,$CONFIG->dbname);

		session_start();		
		$act_table = $_SESSION['activity_table'];
		$log_table = $_SESSION['logging_table'];
		$logged = $_SESSION['logged'];
		$transaction_id = $_SESSION['tid'];

		if($_SESSION['enabled']) {
			if ($logged) {
				//First we get the recently added transaction and transform it into json activitystream
				if ($transaction_log = $con->query("SELECT * FROM ".$log_table." WHERE transaction_id = '".$transaction_id."';")) {
					$action_particles[] = $transaction_log->num_rows;
					$i = 0;
					while ($action_row = $transaction_log->fetch_row()) {
						$content = $action_row[13];
						$action_particles[$i] = array('ObjectId' => $action_row[1], 'ObjectType' => $action_row[4], 'ObjectSubtype' => $action_row[5], 'ObjectClass' => $action_row[3], 'OwnerGUID' => $action_row[12], 
														'GroupId' => $action_row[14], 'CourseId' => $action_row[15], 'ActivityId' => $action_row[16], 'Event' => $action_row[6], 'Content' => $content,
														'Timestamp' => $action_row[7], 'PerformedBy'=> $action_row[9], 'IPAdress' => $action_row[8], 'Role' => $action_row[17], 'TransactionId' => $transaction_id);
						$i++;
					}
					$action = convertLogTransactionToActivityStream($action_particles);
					//Then we put this new information into a separate table, coupled with ids for access management and timestamps for ordering purposes
					//Unless we were unable to identify the activity
					if (!($action['verb'] == 'Unidentified')) {
						$activity_json = json_encode($action);
						//Create the table if it doesn't exist
						$con->query("CREATE TABLE IF NOT EXISTS `".$act_table."` (".
										  "`transaction_id` varchar(255) NOT NULL, ".
										  "`json` longtext NOT NULL, ".
										  "`actor_id` int(255) NOT NULL, ".
										  "`group_id` int(255) NOT NULL, ".
										  "`course_id` int(255) NOT NULL, ".
										  "`activity_id` int(255) NOT NULL, ".
										  "`timestamp` varchar(255) NOT NULL, ".
										  "PRIMARY KEY (`transaction_id`) ".
										  ") ENGINE=InnoDB DEFAULT CHARSET=latin1;");
					
						$con->query("INSERT INTO `".$act_table."` ".
										  "(transaction_id, json, actor_id, group_id, course_id, activity_id, timestamp) ".
										  "VALUES ('".$transaction_id."', '".$activity_json."', '".$action['actor']['actorId']."', '".$action['object']['groupId']."', '".$action['object']['courseId']."', '".$action['object']['activityId']."', '".$action['published']."');");
					}
					$transaction_log->close();
				}
			}
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
 
	register_elgg_event_handler('all', 'all', 'extended_log_listener', 401);
	register_elgg_event_handler('log', 'extended_log', 'extended_log_default_logger', 999);
	register_elgg_event_handler('init','system','activitystreamer_init');
	register_elgg_event_handler('plugins_boot','system','init_transaction');
	register_elgg_event_handler('shutdown','system','transaction_handling');
	register_elgg_event_handler('pagesetup','system','activitystreamer_pagesetup');
	register_action('activitystreamer/modify',false,$CONFIG->pluginspath . "activitystreamer/actions/modify.php");
