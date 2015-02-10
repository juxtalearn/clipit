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
elgg_register_event_handler('init', 'system', 'learning_analytics_dashboard_init');

function learning_analytics_dashboard_init() {
    elgg_register_page_handler('stats', 'userstats_clipit_page_handler');
    elgg_register_ajax_view('metrics/get_metric');
    elgg_register_page_handler('metric', 'getmetric_clipit_page_handler');
    elgg_register_ajax_view('metrics/metric');
    elgg_register_widget_type('metric','la_metrics',elgg_echo('la_dashboard:widget:description'),'la_metrics',true);
//    // Register library
//    elgg_extend_view("navigation/menu/top", "navigation/menu/profile", 400);
    elgg_register_plugin_hook_handler('get_list', 'default_widgets', 'ladashboard_default_widgets');
    $plugin_url =  '/mod/a04_la_dashboard';

    elgg_register_css('dashboardcss',"{$plugin_url}/views/default/css/la_dashboard.css",1000);
    elgg_load_css("dashboardcss");

}

function userstats_clipit_page_handler($page){
    gatekeeper();
    elgg_set_context('la_metrics');
    $user_id = elgg_get_logged_in_user_guid();
    elgg_set_page_owner_guid($user_id);
   // $user = array_pop(ClipitUser::get_by_id(array($user_id)));
    $title = elgg_echo('dashboard');

    $orig_urjc_content=elgg_view('metrics/view', array('entity' => $user));

    $body = elgg_view_layout('one_column', array('content'=>$orig_urjc_content));
    echo elgg_view_page($title, $body);
    return true;
}
function getmetric_clipit_page_handler($page){
    if(isset($page[0])){
        $file_dir = elgg_get_plugins_path() . 'z09_clipit_profile/pages';
        $id = (int)$page[0];
        set_input("id", $id);
        include($file_dir . "/metric.php");
    }
}
/**
 * Register user dashboard with default widgets
 *
 * @param unknown_type $hook
 * @param unknown_type $type
 * @param unknown_type $return
 * @param unknown_type $params
 * @return array
 */
function ladashboard_default_widgets($hook, $type, $return, $params) {
    $return[] = array(
        'name' => elgg_echo('dashboard'),
        'widget_context' => 'la_metrics',
        'widget_columns' => 3,

        'event' => 'create',
        'entity_type' => 'user',
        'entity_subtype' => ELGG_ENTITIES_ANY_VALUE,
    );

    return $return;
}