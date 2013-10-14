<?php
	/**
	 * Elgg API Admin
	 * 
	 * @package ElggAPIAdmin
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider Ltd
	 * @copyright Curverider Ltd 2008-2010
	 * @link http://elgg.com/
	 */

	require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

	admin_gatekeeper();
	elgg_set_context('admin');

	$limit = get_input('limit', 10);
	$offset = get_input('offset', 0);
	
	// Set admin user for user block
	elgg_set_page_owner_guid($_SESSION['guid']);
	
	
	$title = elgg_view_title(elgg_echo('apiadmin'));

	// Display add form
	$content .= elgg_view('apiadmin/forms/add_key');

	// List entities
	//elgg_set_context('search');
	//$content .= elgg_list_entities('object', 'api_key');
	if($newkey)
	  $content .= elgg_view('object/api_key', array('entity' => $newkey));
	//elgg_set_context('admin');
	
	// Display main admin menu
	//page_draw(elgg_echo('apitest'), elgg_view_layout("two_column_left_sidebar", '', $title . $body));
	$body = elgg_view_layout('admin', array('content' => $content));
	echo elgg_view_page($title, $body, 'admin');
?>