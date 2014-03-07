<?php
	admin_gatekeeper();
	action_gatekeeper("modify");
	
	$showga = (int)get_input('showga', 0);
	
	if (isset($showga)) {
		//First we need to find the ElggObject that contains our setting already.
		//If it doesn't exist we need to create it.
		$entities = elgg_get_entities(array("types"=>"object", "subtypes"=>"modactivitystreamer", "owner_guids"=> '0' , "order_by"=>"","limit"=>0));
		if(!isset($entities[0])) {
			$entity = new ElggObject;
			$entity->subtype = 'modactivitystreamer';
			$entity->owner_guid = $_SESSION['user']->getGUID();
		    	$entity->showga = $showga;
		    	$entity->access_id = 2;	//Make sure this object is public.
		} else {			
			$entity = $entities[0];
			$entity->showga = $showga;
			$entity->access_id = 2; //Make sure this object is public.
		}
		
		if ($entity->save()) {
			system_message(elgg_echo('activitystreamer:modify:success'));
			$entity->state = "active";
			forward('pg/activitystreamer');
		} else {
			register_error(elgg_echo('activitystreamer:modify:failed'));
			forward('pg/activitystreamer');
		}
	} else {
		
		register_error(elgg_echo('activitystreamer:failed:noparams'));
	    	forward('pg/activitystreamer');
    	}
?>
