<?php

/**
 * Project Name:            ClipIt Theme
 * Project Description:     Theme for Elgg 1.8
 * @license GNU Affero General Public License v3 http://www.gnu.org/licenses/agpl-3.0.txt
    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU Affero General Public License as
    published by the Free Software Foundation, version 3. *
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
    GNU Affero General Public License for more details. *
    You should have received a copy of the GNU Affero General Public License
    along with this program. If not, see http://www.gnu.org/licenses/agpl-3.0.txt.
 * 
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
        //elgg_register_js("forceAddFile", $CONFIG->url . "mod/clipit/js/force_add_file.js");
        elgg_load_css("ui-lightness");
        elgg_load_css("twitter-bootstrap");
        elgg_load_js("jquery-migrate");
        elgg_load_js("twitter-bootstrap");
        //elgg_load_js("forceAddFile");
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
    
   elgg_unregister_plugin_hook_handler('entity:icon:url', 'object', 'file_icon_url_override');
    
    elgg_register_plugin_hook_handler('entity:icon:url', 'object', 'clipit_file_icon_url_override');
}

    /**
 * Override the default entity icon for files
 *
 * Plugins can override or extend the icons using the plugin hook: 'file:icon:url', 'override'
 *
 * @return string Relative URL
 */
function clipit_file_icon_url_override($hook, $type, $returnvalue, $params) {
    $file = $params['entity'];
    $size = $params['size'];
    if (elgg_instanceof($file, 'object', 'file')) {

        // thumbnails get first priority
        if ($file->thumbnail) {
            $ts = (int)$file->icontime;
            return "mod/file/thumbnail.php?file_guid=$file->guid&size=$size&icontime=$ts";
        }

        $mapping = array(
            'application/excel' => 'excel',
            'application/msword' => 'word',
            'application/ogg' => 'music',
            'application/pdf' => 'pdf',
            'application/powerpoint' => 'ppt',
            'application/vnd.ms-excel' => 'excel',
            'application/vnd.ms-powerpoint' => 'ppt',
            'application/vnd.oasis.opendocument.text' => 'openoffice',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'word',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'excel',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'ppt',
            'application/x-gzip' => 'archive',
            'application/x-rar-compressed' => 'archive',
            'application/x-stuffit' => 'archive',
            'application/zip' => 'archive',

            'text/directory' => 'vcard',
            'text/v-card' => 'vcard',

            'application' => 'application',
            'audio' => 'music',
            'text' => 'text',
            'video' => 'video',
        );

        $mime = $file->mimetype;
        if ($mime) {
            $base_type = substr($mime, 0, strpos($mime, '/'));
        } else {
            $mime = 'none';
            $base_type = 'none';
        }

        if (isset($mapping[$mime])) {
            $type = $mapping[$mime];
        } elseif (isset($mapping[$base_type])) {
            $type = $mapping[$base_type];
        } else {
            $type = 'general';
        }

        if ($size == 'large') {
            $ext = '_lrg';
        } else {
            $ext = '';
        }

        $url = "mod/clipit/graphics/icons/{$type}{$ext}.gif";
        $url = elgg_trigger_plugin_hook('file:icon:url', 'override', $params, $url);
        return $url;
    }
}