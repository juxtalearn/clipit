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

	function log_to_sqlspace($object, $event) {
		global $CONFIG;
		session_start();		
		static $log_cache;
		static $cache_size = 0;
		$log_tuple_template = array("integer","string","string","string","string","string","string","string","integer","integer","string","integer");
		//system_message("Wert: ".$object->getContainer());
		if ($object instanceof Loggable) {
			// If the object implements loggable interface, extract the necessary information and store a tuple in the space
			$dir=dirname(__FILE__);
			require_once("$dir/client/TupleSpace.php");
			$data = elgg_get_entities(array("types"=>"object", "subtypes"=>"modsqlspaces", "owner_guids"=> '0' , "order_by"=>"","limit"=>0));
			if(isset($data[0])) {
				$entity = $data[0];
				/* We only wanna try to log into the sqlspace, if this plugin is enabled */
				if ($entity->showga) {
					/* First we connect to the SQLSpaces server and space */
					$name = $entity->spacename;					
					$url = $entity->sqlsurl;
					$port = $entity->sqlsport;
					if ($name == "") {$name = "elgglogging";}
					//system_message("spacename = ".$name);
					//system_message("socket = ".$url.":".$port);
					
					//If we want to prevent non-rendered pages due to the tuplespace connection failing, we should first try to ping the host:
					//with this code, we wait 250ms second for the server to respond. If it doesn't, we simply skip logging to the tuple space.
					$waitTimeoutInSeconds = 0.25; 
					if($fp = fsockopen($url,$port,$errCode,$errStr,$waitTimeoutInSeconds)){   
						fclose($fp);
						try {
							$i = 1;
							$ts = new TupleSpace(array($name),$url,$port);
							$log_tuple = new Tuple();
							$object_id = (int)$object->getSystemLogID();
							if (is_null($object_id)) {
							   $object_id = 0;
							}
//							echo("object_class " + $object_class + " ");
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
//							system_message("log: ".$SQLS["transaction_id"]);
							$log_tuple->addActualFields(array($object_id,"".$transaction_id, "".$object_class, "".$object_type, "".$object_subtype,  "".$event,  "".$time, "".$ip_address,  "".$performed_by,  "".$access_id,  "".$enabled,  "".$owner_guid),$log_tuple_template);
							//system_message("Logged: ".$object_id.", ".$transaction_id.", ".$object_class.", ".$object_type.", ".$object_subtype.", ".$event.", ".$time.", ".$ip_address.", ".$performed_by.", ".$access_id.", ".$enabled.", ".$owner_guid);
							$ts->write($log_tuple);
							$ts->closeSocket();
						} catch (Exception $e) {
							print_exception($e);
						}
							
					} else {
						// It didn't work 
						fclose($fp);
						//system_message("Connection to TupleSpace failed!");
					} 


				}
			}
		}
	}

	function sqls_log_default_logger($event, $object_type, $object) {
   		//log_to_sqlspace($object['object'], $object['event']);
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
 
	elgg_register_event_handler('all', 'all', 'sqls_log_listener', 401);
	elgg_register_event_handler('log', 'sqlslog', 'sqls_log_default_logger', 999);
	register_elgg_event_handler('init','system','sqlspaces_init');
	register_elgg_event_handler('plugins_boot','system','init_transaction');
	register_elgg_event_handler('shutdown','system','sqlspaces_shutdown');
	register_elgg_event_handler('pagesetup','system','sqlspaces_pagesetup');
	register_action('sqlspaces/modify',false,$CONFIG->pluginspath . "sqlspaces/actions/modify.php");
