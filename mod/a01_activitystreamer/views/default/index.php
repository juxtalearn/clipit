<?php
	require_once(dirname(dirname(dirname(dirname(dirname(__FILE__))))) . "/engine/start.php");

	admin_gatekeeper();
    elgg_set_context('admin');
	// Set admin user for user block
    elgg_set_page_owner_guid($_SESSION['guid']);
	
	
	$title = elgg_view_title(elgg_echo('activitystreamer'));
	

    //Vars required for action gatekeeper
	$ts = time();
	$token = generate_action_token($ts);
    
	$body = elgg_view("activitystreamer/activitystreamer", array('token' => $token, 'ts' => $ts));
	
	// Display main admin menu
	elgg_view_page(elgg_echo('activitystreamer'),$body);
?>
