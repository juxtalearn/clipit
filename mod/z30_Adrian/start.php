<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

elgg_register_event_handler('init', 'system', 'clipit_recomendacion_init');

function clipit_recomendacion_init(){
     elgg_register_page_handler('recomendaciones', 'recomendaciones_page_handler');
     elgg_extend_view("navigation/menu/top", "navigation/menu/recon", 50);
     elgg_register_action("uploaded_recommenders", elgg_get_plugins_path()."z30_Adrian/actions/uploaded_recommenders.php");
     require 'classes/cacheRecommender.php';
}

function recomendaciones_page_handler($page){
    $title = "Recomendaciones";
    $params = array(
            'name' => "Recomendaciones",
            'content' => elgg_view("recomendaciones/view"),
            'title' => $title,
            'filter' => "",
            'sidebar' => elgg_view_form("", array("body" => elgg_view("forms/sidebar/recomendaciones"),"action" => elgg_get_site_url()."action/uploaded_recommenders"))
        );
        $body = elgg_view_layout('content', $params);

        echo elgg_view_page($title, $body);
    //return true;
}
?>
