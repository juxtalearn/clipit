<?php


function recommendations_init()
{
    include_once(elgg_get_plugins_path(). "a03_recommendations/lib/RecommendationEngine.php");
    include_once(elgg_get_plugins_path(). "a03_recommendations/lib/expose.php");
    expose_recommendation_engine();
    elgg_register_page_handler('recommendations', 'recommendations_page_handler');

}

function recommendations_page_handler($page)
{
    global $CONFIG;
    $title = "Recommendation Engine Administration";
    $params = array(
        'content' => elgg_view("recommendations/recommendations"),
        'title' => $title,
        'filter' => "",
        'class' => 'admin'
    );
    $body = elgg_view_layout('one-column', $params);
    echo elgg_view_page($title, $body);
}

//Function to add a submenu to the admin panel.
function recommendations_pagesetup()
{
    global $CONFIG;
    if (elgg_is_admin_logged_in() && elgg_get_context('recommendations')) {
        elgg_register_menu_item('page', array(
            'name' => 'Other',
            'href' => $CONFIG->wwwroot . 'recommendations',
            'text' => 'Recommendation Engine',
            'context' => 'recommendations'));
    }
}

function recommendation_shutdown()
{

}




elgg_register_event_handler('init','system','recommendations_init');
elgg_register_action('recommendations/modify', elgg_get_plugins_path() . "a03_recommendations/actions/modify.php");
elgg_register_action('recommendations/test', elgg_get_plugins_path() . "a03_recommendations/actions/test.php");
elgg_register_admin_menu_item('configure', 'recommendations', 'settings');
elgg_set_config("la_recommendations_class", "RecommendationEngine");
register_shutdown_function('recommendation_shutdown');
