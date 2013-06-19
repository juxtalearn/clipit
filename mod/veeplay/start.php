<?php
/**
* Elgg VeePlay Plugin
* @package veeplay
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
* @author Roger Grice
* @copyright 2012 DesignedbyRoger 
* @link http://DesignedbyRoger.com
* @version 1.8.3.2
*/

elgg_register_event_handler('init', 'system', 'veeplay_init');

function veeplay_init() {
	// Register jwplayer javascript
	$js_url = elgg_get_site_url() . 'mod/veeplay/player/jwplayer.js';
	elgg_register_js('veeplay', $js_url);
	// Extend system CSS with additional styles
	elgg_extend_view('css/elgg', 'veeplay/css');
}
