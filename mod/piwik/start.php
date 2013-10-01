<?php
	function piwik_init()
	{
		global $CONFIG;
		register_page_handler('piwik','piwik_page_handler');
		elgg_extend_view('page_elements/footer','piwik/footer', 499);
		elgg_extend_view('page/elements/footer','piwik/footer', 499);
	}
	
	function piwik_page_handler($page) 
	{
		global $CONFIG;
		include($CONFIG->pluginspath . "piwik/index.php"); 
	}
	
	//Function to add a submenu to the admin panel. 
	function piwik_pagesetup()
	{
		if (get_context() == 'admin' && isadminloggedin()) {
			global $CONFIG;
			add_submenu_item(elgg_echo('piwik'), $CONFIG->wwwroot . 'pg/piwik/');
		}
	}
	
	register_elgg_event_handler('init','system','piwik_init');
	register_elgg_event_handler('pagesetup','system','piwik_pagesetup');
	register_action('piwik/modify',false,$CONFIG->pluginspath . "piwik/actions/modify.php");
?>
