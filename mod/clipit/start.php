<?php

/*
 * Project Name:            ClipIt Theme
 * Project Description:     Theme for Elgg 1.8
 */

elgg_register_event_handler('init', 'system', 'clipit_init');

function clipit_init() {
    global $CONFIG;
	
	/*
     * Set Dashboard tab on default site tab-bar
     */
    elgg_register_menu_item(
        'site',
        array(
            'name' => 'dashboard',
            'href' => 'dashboard',
            //'text' => elgg_view_icon('home')." ".elgg_echo('dashboard'),
            'text' => elgg_echo('dashboard'),
            'priority' => 450,
            'section' => 'default',
        )
    );

    if (elgg_get_context() === "admin") {
        elgg_unregister_css("twitter-bootstrap");
        elgg_unregister_css("ui-lightness");
        elgg_unregister_css("clipit");
        elgg_unregister_css("bubblegum");
        elgg_unregister_css("righteous");
        elgg_unregister_css("ubuntu");
        elgg_unregister_js("jquery-migrate");
        elgg_unregister_js("twitter-bootstrap");
    } else {
        elgg_register_css("twitter-bootstrap", $CONFIG->url . "mod/clipit/vendors/bootstrap/css/bootstrap.css");
        elgg_register_css("ui-lightness", $CONFIG->url . "mod/clipit/vendors/jquery-ui-1.10.2.custom/css/ui-lightness/jquery-ui-1.10.2.custom.min.css");
        elgg_register_css("clipit", $CONFIG->url . "mod/clipit/css/clipit.css");
        elgg_register_css("bubblegum", "http://fonts.googleapis.com/css?family=Bubblegum+Sans");
        elgg_register_css("righteous", "http://fonts.googleapis.com/css?family=Righteous");
        elgg_register_css("ubuntu", "http://fonts.googleapis.com/css?family=Ubuntu:400,300,300italic,400italic,500,500italic,700,700italic");
        elgg_register_js("clipit", $CONFIG->url . "mod/clipit/js/clipit.js");
        elgg_register_js("jquery", $CONFIG->url . "mod/clipit/vendors/jquery/jquery-1.9.1.min.js", "head", 0);
        elgg_register_js("jquery-migrate", $CONFIG->url . "mod/clipit/vendors/jquery/jquery-migrate-1.1.1.js", "head", 1);
        elgg_register_js("jquery-ui", $CONFIG->url . "mod/clipit/vendors/jquery-ui-1.10.2.custom/js/jquery-ui-1.10.2.custom.min.js", "head", 2);
        elgg_register_js("twitter-bootstrap", $CONFIG->url . "mod/clipit/vendors/bootstrap/js/bootstrap.min.js");
        elgg_load_css("ui-lightness");
        elgg_load_css("twitter-bootstrap");
        elgg_load_js("jquery-migrate");
        elgg_load_js("twitter-bootstrap");
        elgg_load_css("righteous");
        elgg_load_css("ubuntu");
        elgg_load_css("bubblegum");
        elgg_load_css("clipit");
        set_view_location("navigation/menu/site", elgg_get_plugins_path() . "clipit/new_views/");
        set_view_location("navigation/menu/elements/item", elgg_get_plugins_path() . "clipit/new_views/");
        set_view_location("navigation/menu/elements/section", elgg_get_plugins_path() . "clipit/new_views/");
        set_view_location("navigation/tabs", elgg_get_plugins_path() . "clipit/new_views/");
        set_view_location("navigation/menu/widget", elgg_get_plugins_path() . "clipit/new_views/");
    }
    // Deshabilitar la opción de no mostrar el editor de texto TinyMCE
    elgg_unregister_plugin_hook_handler('register', 'menu:longtext', 'tinymce_longtext_menu');
}