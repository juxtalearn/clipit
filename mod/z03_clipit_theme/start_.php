<?php

/**
 * Project Name:            ClipIt Theme
 * Project Description:     Theme for Elgg 1.8
 * 
 * PHP version >= 5.2 
 * 
 * Creation date:   2013-06-19
 * 
 * @category    theme
 * @package     clipit
 * @license    GNU Affero General Public License v3
 * http://www.gnu.org/licenses/agpl-3.0.txt
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, version 3. *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details. *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program. If not, see
 * http://www.gnu.org/licenses/agpl-3.0.txt.
 */
elgg_register_event_handler('init', 'system', 'clipit_home_init');

function clipit_home_init() {
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

    elgg_register_admin_menu_item('administer', 'clipit_home', 'clipit_plugins');
    elgg_register_action("clipit_home/settings", elgg_get_plugins_path() . "clipit_home/actions/settings.php", 'admin');
    elgg_register_page_handler('clipit', 'clipit_home_handler');

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
        elgg_register_js("forceAddFile", $CONFIG->url . "mod/clipit/js/force_add_file.js");
        elgg_load_css("ui-lightness");
        elgg_load_css("twitter-bootstrap");
        elgg_load_js("jquery-migrate");
        elgg_load_js("twitter-bootstrap");
        elgg_load_js("forceAddFile");
        elgg_load_css("righteous");
        elgg_load_css("ubuntu");
        elgg_load_css("bubblegum");
        elgg_load_css("clipit");
        ///////////////////////////////////////

    }
    
    
}


function clipit_home_handler($page){
    $base_plugin = elgg_get_plugins_path() . 'clipit_home/';
    if(!isset($page[0])){
        return false;
    }
    switch ($page[0]) {
        case "graphics":
            $img_type = $page[1];
            $file_img = $base_plugin."graphics/".$img_type;
            $resource = finfo_open(FILEINFO_MIME_TYPE);
            $mime = "image/png";
            $file_img_bin = $base_plugin."graphics/no_image.png";
            if(file_exists($file_img) && $resource){
                $mime = finfo_file($resource, $file_img);
                $file_img_bin = $base_plugin."graphics/".$img_type;
            }
            header("Content-type: $mime");
            header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', strtotime("+10 days")), true);
            header("Pragma: public", true);
            header("Cache-Control: public", true);
            @readfile($file_img_bin);
            die();
        break;
    default:
        return false;
    }
    return true;
}
