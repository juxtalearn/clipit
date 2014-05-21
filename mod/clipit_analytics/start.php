<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   20/05/14
 * Last update:     20/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
elgg_register_event_handler('init', 'system', 'clipit_analytics_init');

function clipit_analytics_init() {
    // Register "/analytics" page handler
    elgg_register_page_handler('analytics', 'analytics_page_handler');
}

/**
 * @param $page
 */
function analytics_page_handler($page){
    $title = "Analytics";
    $params = array(
        'content' => elgg_view("analytics/page"),
        'title' => $title,
        'filter' => "",
    );
    $body = elgg_view_layout('one_column', $params);

    echo elgg_view_page($title, $body);
}