<?php
	function sqlspaces_init()
	{
		global $CONFIG;
		register_page_handler('sqlspaces','sqlspaces_page_handler');
		
	}

	function sqlspaces_shutdown()
	{
		session_start();		
		$_SESSION['tid'] = "none";
	}
	
	function init_transaction()
	{
		session_start();
		$time = time();
		$ip_address = sanitise_string($_SERVER['REMOTE_ADDR']);
		$guid = get_loggedin_user()->guid;
		$_SESSION['tid'] = md5("".$time.$ip_address.$guid);
	}


	function sqlspaces_page_handler($page) 
	{
		global $CONFIG;
		include($CONFIG->pluginspath . "sqlspaces/index.php"); 
	}
	
	//Function to add a submenu to the admin panel. 
	function sqlspaces_pagesetup()
	{
		if (get_context() == 'admin' && isadminloggedin()) {
			global $CONFIG;
			add_submenu_item(elgg_echo('sqlspaces'), $CONFIG->wwwroot . 'pg/sqlspaces/');
		}
	}
	
	//Because of PHP constraints, we now implement an indirect approach and use the mysql db as a buffer. 
	function log_to_sqlspace($object, $event) {
		global $CONFIG;
		global $con;
		session_start();		
		static $log_cache;
		static $cache_size = 0;
		if ($object instanceof Loggable) {
			// If the object implements loggable interface, extract the necessary information and store a tuple in the space
			$dir=dirname(__FILE__);
			$data = elgg_get_entities(array("types"=>"object", "subtypes"=>"modsqlspaces", "owner_guids"=> '0' , "order_by"=>"","limit"=>0));
			if(isset($data[0])) {
				$entity = $data[0];
				/* We only wanna try to log if this plugin is enabled */
				if ($entity->showga) {
						$i = 1;
						$object_id = (int)$object->getSystemLogID();
						if (is_null($object_id)) {
						   $object_id = 0;
						}
						$object_class = $object->getClassName();
						if ($object_class == null) {$object_class = "";}
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
						$con=mysqli_connect($CONFIG->dbhost = 'localhost',$CONFIG->dbuser,$CONFIG->dbpass,$CONFIG->dbname);
						
						//If the table doesn't exist, we need to create it...
						mysqli_query($con,"CREATE TABLE IF NOT EXISTS `sqlslogging` (".
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
											  "PRIMARY KEY (`log_id`) ".
											") ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;");
// 						system_message("INSERT INTO `sqlslogging` ".
//											"(object_id, transaction_id, object_class, object_type, object_subtype, event, time, ip_address, performed_by, access_id, enabled, owner_guid, content) ".
//									 "VALUES (".$object_id.", '".$transaction_id."', '".$object_class."', '".$object_type."', '".$object_subtype."', '".$event."', '".$time."', '".$ip_address."', '".$performed_by."', ".$access_id.", '".$enabled."', ".$owner_guid.", 'emtpy');");
                        
						mysqli_query($con,"INSERT INTO `sqlslogging` ".
											"(object_id, transaction_id, object_class, object_type, object_subtype, event, time, ip_address, performed_by, access_id, enabled, owner_guid, content) ".
									 "VALUES (".$object_id.", '".$transaction_id."', '".$object_class."', '".$object_type."', '".$object_subtype."', '".$event."', '".$time."', '".$ip_address."', '".$performed_by."', ".$access_id.", '".$enabled."', ".$owner_guid.", 'emtpy');");
//							system_message("log: ".$SQLS["transaction_id"]);
							// $log_tuple->addActualFields(array($object_id,"".$transaction_id, "".$object_class, "".$object_type, "".$object_subtype,  "".$event,  "".$time, "".$ip_address,  $performed_by,  $access_id,  "".$enabled, $owner_guid),$log_tuple_template);
							// system_message("Logged: ".$object_id.", ".$transaction_id.", ".$object_class.", ".$object_type.", ".$object_subtype.", ".$event.", ".$time.", ".$ip_address.", ".$performed_by.", ".$access_id.", ".$enabled.", ".$owner_guid);
							// $ts->write($log_tuple);
							// $ts->closeSocket();
						// } catch (Exception $e) {
							// print_exception($e);
						// }s

				}
			}
		}
	}
	
// This function checks whether table exists
function table_exist($table){
    global $con;
    $sql = "show tables like '".$table."'";
    $res = $con->query($sql);
    return ($res->num_rows > 0);
}


	function sqls_log_default_logger($event, $object_type, $object) {
   		log_to_sqlspace($object['object'], $object['event']);
	   	return true;
 	}
 
	function sqls_log_listener($event, $object_type, $object) {
		if (($object_type != 'sqlslog') && ($event != 'log')) {
        		elgg_trigger_event('log', 'sqlslog', array('object' => $object, 'event' => $event));
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
 
	register_elgg_event_handler('all', 'all', 'sqls_log_listener', 401);
	register_elgg_event_handler('log', 'sqlslog', 'sqls_log_default_logger', 999);
	register_elgg_event_handler('init','system','sqlspaces_init');
	register_elgg_event_handler('plugins_boot','system','init_transaction');
	register_elgg_event_handler('shutdown','system','sqlspaces_shutdown');
	register_elgg_event_handler('pagesetup','system','sqlspaces_pagesetup');
	register_action('sqlspaces/modify',false,$CONFIG->pluginspath . "sqlspaces/actions/modify.php");
