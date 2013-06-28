<?php
	admin_gatekeeper();
	action_gatekeeper();
	
	$spacename = get_input('spacename');
	$sqlsurl = get_input('sqlsurl');
	$sqlsport = get_input('sqlsport');
	$showga = (int)get_input('showga', 0);
	
	if (isset($showga)) {
		//First we need to find the ElggObject that contains our setting already.
		//If it doesn't exist we need to create it.
		$entities = elgg_get_entities(array("types"=>"object", "subtypes"=>"modsqlspaces", "owner_guids"=> '0' , "order_by"=>"","limit"=>0));
		if(!isset($entities[0])) {
			$entity = new ElggObject;
			$entity->subtype = 'modsqlspaces';
			$entity->owner_guid = $_SESSION['user']->getGUID();
		    	$entity->spacename = $spacename;
		    	$entity->sqlsurl = $sqlsurl;
		    	$entity->sqlsport = $sqlsport;
		    	$entity->showga = $showga;
		    	$entity->access_id = 2;	//Make sure this object is public.
		} else {			
			$entity = $entities[0];
			$entity->spacename = $spacename;
			$entity->sqlsurl = $sqlsurl;
			$entity->sqlsport = $sqlsport;
			$entity->showga = $showga;
			$entity->access_id = 2; //Make sure this object is public.
		}
		
		if ($entity->save()) {
			system_message(elgg_echo('sqlspaces:modify:success'));
			$entity->state = "active";
			forward('pg/sqlspaces');
		} else {
			register_error(elgg_echo('sqlspaces:modify:failed'));
			forward('pg/sqlspaces');
		}
	} else {
		
		register_error(elgg_echo('sqlspaces:failed:noparams'));
	    	forward('pg/sqlspaces');
    	}
?>
