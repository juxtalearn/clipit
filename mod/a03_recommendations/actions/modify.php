<?php
	admin_gatekeeper();
	action_gatekeeper("modify");
	
	$showga = (int)get_input('showga', 1);
	
	if (isset($showga)) {
		//First we need to find the ElggObject that contains our setting already.
		//If it doesn't exist we need to create it.
		$entities = elgg_get_entities(array("types"=>"object", "subtypes"=>"modrecommendations", "owner_guids"=> '0' , "order_by"=>"","limit"=>0));
		if(!isset($entities[0])) {
			$entity = new ElggObject;
			$entity->subtype = 'modrecommendations';
			$entity->owner_guid = $_SESSION['user']->getGUID();
		    	$entity->showga = $showga;
		    	$entity->access_id = 2;	//Make sure this object is public.
		} else {			
			$entity = $entities[0];
			$entity->showga = $showga;
			$entity->access_id = 2; //Make sure this object is public.
		}
		
		if ($entity->save()) {
			system_message(elgg_echo('recommendations:modify:success'));
			$entity->state = "active";
			forward('pg/recommendations');
		} else {
			register_error(elgg_echo('recommendations:modify:failed'));
			forward('pg/recommendations');
		}
	} else {
		
		register_error(elgg_echo('recommendations:failed:noparams'));
	    	forward('pg/recommendations');
    }
?>
