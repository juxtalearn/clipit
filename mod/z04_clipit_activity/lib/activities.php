<?php
/**
 * Created by JetBrains PhpStorm.
 * User: equipo
 * Date: 17/02/14
 * Time: 11:17
 * To change this template use File | Settings | File Templates.
 */

function activityss_setup_sidebar_menus($entity){

    $sidebar = elgg_view('activity/sidebar/calendar', array('entity' => $entity));
    $sidebar .= elgg_view('activity/sidebar/teacher', array('entity' => $entity));
}
/**
 * Group profile page
 *
 * @param int $guid Group entity GUID
 */
function activity_handle_profile_page($guid) {
    elgg_set_page_owner_guid($guid);
    // turn this into a core function
    global $autofeed;
    $autofeed = true;

    //elgg_push_context('activity_profile');

    $activities = ClipitActivity::get_by_id(array($guid));
    $activity = array_pop($activities);
    if (!$activity) {
        forward('');
    }
    elgg_push_breadcrumb($activity->name);

    //groups_register_profile_buttons($activity);
    /*
     * Menu register
     */
    $params = array(
        'name' => 'activity_info',
        'text' => elgg_echo('activity:info'),
        'href' => "settings/statistics/",
    );
    elgg_register_menu_item('page', $params);
    $params = array(
        'name' => 'groups',
        'text' => elgg_echo('activity:groups'),
        'href' => "clipit_activity/".$guid."/groups",
    );
    elgg_register_menu_item('page', $params);
    $params = array(
        'name' => 'sta',
        'text' => elgg_echo('activity:sta'),
        'href' => "settings/statistics/",
    );
    elgg_register_menu_item('page', $params);



    $content = elgg_view('activity/profile/layout', array('entity' => $activity));

    $sidebar = elgg_view('activity/sidebar/calendar', array('entity' => $activity));
    $sidebar .= elgg_view('activity/sidebar/teacher', array('entity' => $activity));
    /*if (group_gatekeeper(false)) {
        if (elgg_is_active_plugin('search')) {
            $sidebar .= elgg_view('groups/sidebar/search', array('entity' => $activity));
        }
        $sidebar .= elgg_view('groups/sidebar/members', array('entity' => $activity));

        $subscribed = false;
        if (elgg_is_active_plugin('notifications')) {
            global $NOTIFICATION_HANDLERS;

            foreach ($NOTIFICATION_HANDLERS as $method => $foo) {
                $relationship = check_entity_relationship(elgg_get_logged_in_user_guid(),
                    'notify' . $method, $guid);

                if ($relationship) {
                    $subscribed = true;
                    break;
                }
            }
        }

        $sidebar .= elgg_view('groups/sidebar/my_status', array(
            'entity' => $activity,
            'subscribed' => $subscribed
        ));
    }*/

    $params = array(
        'content'   => $content,
        'sidebar' => $sidebar,
        'type'     => 'activity',
        'title'     => $activity->name,
        'title_style' => "background: #". $activity->color,
        'filter'    => '',
        'class'     => 'activity-profile activity-layout'
    );

    $body = elgg_view_layout('one_sidebar', $params);

    echo elgg_view_page($activity->name, $body);
}

/*
 * Groups section
 */
function activity_handle_groups_page($guid){
    $activities = ClipitActivity::get_by_id(array($guid));
    $activity = array_pop($activities);
    if (!$activity) {
        forward('');
    }

    $title = elgg_echo("activity:groups");
    //elgg_push_breadcrumb($group->name, $group->getURL());
    elgg_push_breadcrumb($title);
    $content = elgg_view('activity/groups/layout', array('entity' => $activity));
    $params = array(
        'content'   => $content,
        'filter'    => '',
        'type'     => 'activity',
        'title'     => $title,
        'sub-title' => $activity->name,
        'title_style' => "background: #". $activity->color,
        'class'     => 'activity-section activity-layout'
    );

    $body = elgg_view_layout('one_sidebar', $params);
    echo elgg_view_page("D", $body);
}