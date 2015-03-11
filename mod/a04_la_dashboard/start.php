<?php
/**
 * Learning Analytics - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 *
 * @author          RIAS JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
elgg_register_event_handler('init', 'system', 'learning_analytics_dashboard_init');
elgg_register_plugin_hook_handler('permissions_check', 'all', 'la_widget_permissions_hook');
elgg_register_plugin_hook_handler('permissions_check', 'all', 'la_widget_layout_permissions_hook');


function learning_analytics_dashboard_init()
{
    elgg_register_page_handler('stats', 'userstats_clipit_page_handler');
    elgg_register_ajax_view('metrics/get_metric');
    elgg_register_ajax_view('metrics/get_quiztasks');
    elgg_register_ajax_view('metrics/get_groups');
    elgg_register_ajax_view('metrics/get_targets');
    elgg_register_page_handler('metric', 'getmetric_clipit_page_handler');
    elgg_register_ajax_view('metrics/metric');
    elgg_register_widget_type('metric', elgg_echo('la_dashboard:la_metrics:title'), elgg_echo('la_dashboard:widget:la_metrics:description'), 'la_metrics', true);
    elgg_register_widget_type('quizresult', elgg_echo('la_dashboard:quizresult:title'), elgg_echo('la_dashboard:widget:quizresult:description'), 'la_metrics,quizstudents,quizgroups,quizactivity', true);
    elgg_register_widget_type('quizresultcompare', elgg_echo('la_dashboard:quizresultscompare:title'), elgg_echo('la_dashboard:widget:quizresultcompare:description'), 'la_metrics', true);
//    // Register library
//    elgg_extend_view("navigation/menu/top", "navigation/menu/profile", 400);
    elgg_register_plugin_hook_handler('get_list', 'default_widgets', 'ladashboard_default_widgets');
    $plugin_url = '/mod/a04_la_dashboard';
    elgg_register_js("dojotoolkit", "http://ajax.googleapis.com/ajax/libs/dojo/1.10.3/dojo/dojo.js");
    elgg_register_css("dojotoolkitcss", "http://ajax.googleapis.com/ajax/libs/dojo/1.10.3/dojo/resources/dojo.css");
    elgg_register_css('dashboardcss', "{$plugin_url}/views/default/css/la_dashboard.css", 1000);
    elgg_load_css("dashboardcss");

}

function userstats_clipit_page_handler($page)
{
    gatekeeper();
    elgg_set_context('la_metrics');
    $user_id = elgg_get_logged_in_user_guid();
    elgg_set_page_owner_guid($user_id);
    $user = array_pop(ClipitUser::get_by_id(array($user_id)));
    $title = elgg_echo('dashboard');

    $orig_urjc_content = elgg_view('metrics/view', array('entity' => $user));

    $body = elgg_view_layout('one_column', array('content' => $orig_urjc_content));
    echo elgg_view_page($title, $body);
    return true;
}

function getmetric_clipit_page_handler($page)
{
    if (isset($page[0])) {
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
function ladashboard_default_widgets($hook, $type, $return, $params)
{
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

function la_widget_permissions_hook($hook, $type, $returnvalue, $params)
{
    if (elgg_instanceof($params['entity'], "object", "widget")) {
        $user = $params['user'];
        switch ($params['entity']->handler) {
            case 'quizresult':
                if (elgg_in_context('activity_page')) {
                  //  return false;
                }

        }
        $clipit_user = array_pop(ClipitUser::get_by_id(array($user->guid)));
        if ($clipit_user->role == ClipitUser::ROLE_STUDENT) {
            return false;
        }

    }
}


function la_widget_layout_permissions_hook($hook, $type, $returnvalue, $params)
{
    if (isset($params['context']) && isset($params['user']) && isset($params['page_owner'])) {
        $user = $params['user'];
        $context = $params['context'];
        $pageowner = $params['page_owner'];
        $clipit_user = array_pop(ClipitUser::get_by_id(array($user->guid)));
        switch ($context) {
            case 'quizstudents':
                $widgets_columns = elgg_get_widgets($pageowner->getGUID(), $context);
                $found = false;
                foreach ($widgets_columns as $widgets) {
                    foreach ($widgets as $widget) {
                        if ($widget->handler == 'quizresult') {
                            $found = true;
                            break 2;
                        }
                    }
                }
                if (!$found) {
                    $widgetguid = elgg_create_widget($pageowner->getGUID(), 'quizresult', $context);
                    if ($widgetguid) {
                        $widget = get_entity($widgetguid);
                        $widget->activity_id = $pageowner->getGUID();
                        $widget->question_or_stumblingblock=ClipitTag::SUBTYPE;
                        $widget->scale=ClipitGroup::SUBTYPE;
                        $widget->group_id='all';
                        // position the widget
                        $widget->move(1, 0);
                        $widget->save();
                    }
                }
                return false;
            case 'quizgroups':
                $widgets_columns = elgg_get_widgets($pageowner->getGUID(), $context);
                $found = false;
                foreach ($widgets_columns as $widgets) {
                    foreach ($widgets as $widget) {
                        if ($widget->handler == 'quizresult') {
                            $found = true;
                            break 2;
                        }
                    }
                }
                if (!$found) {
                    $widgetguid = elgg_create_widget($pageowner->getGUID(), 'quizresult', $context);
                    if ($widgetguid) {
                        $widget = get_entity($widgetguid);
                        $widget->activity_id = $pageowner->getGUID();
                        $widget->question_or_stumblingblock=ClipitTag::SUBTYPE;
                        $widget->scale=ClipitActivity::SUBTYPE;
                        $widget->group_id='all';
                        // position the widget
                        $widget->move(1, 0);
                        $widget->save();
                    }
                }
                return false;
            case 'quizactivity':
                return false;
            case 'la_metrics':
                if ($context == 'la_metrics' && $clipit_user->role == ClipitUser::ROLE_STUDENT) {
                    return false;
                }
        }
    }
}

