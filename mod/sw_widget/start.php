<?php
 /**
 *
 * SW Social Web Admin Only Widgets
 * GPL plugin
 * All rights GPL =D
 */

elgg_register_event_handler('init', 'system', 'sw_widgets_init');

function sw_widgets_init() {

global $CONFIG;
elgg_extend_view('page/layouts/elgg','page/layouts/widgets');
	
	
}


?>