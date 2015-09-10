<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   10/09/2015
 * Last update:     10/09/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$user_id = elgg_get_logged_in_user_guid();
$user = array_pop(ClipitUser::get_by_id(array($user_id)));
$selected_tab = get_input('filter', 'all');
$title = elgg_echo('activities');
if($user->role == ClipitUser::ROLE_STUDENT){
    $id_activities_array = array();
    if($selected_tab == 'public') {
        $id_activities_array = ClipitSite::get_pub_activities();
        $activities = ClipitActivity::get_by_id($id_activities_array, 0, 0, 'end', false);
    } else {
        // Get all my activities
        $activities_ids = ClipitUser::get_activities($user_id);
        foreach ($activities_ids as $activity_id) {
            $status = array_pop(ClipitActivity::get_properties($activity_id, array("status")));
            if ($selected_tab == 'all') {
                $id_activities_array[$selected_tab][] = $activity_id;
            } else {
                $id_activities_array[$status][] = $activity_id;
            }
        }
        $activities = ClipitActivity::get_by_id($id_activities_array[$selected_tab], 0, 0, 'end', false);
    }

    $params_list = array(
        'items'         => $activities,
        'pagination'    => false,
        'list_class'    => 'my-activities',
    );
    $content = elgg_view("my_activities/list", $params_list);


    $filter = elgg_view('my_activities/filter', array('selected' => $selected_tab, 'entity' => $activity));

    if(!$activities){
        $content = elgg_view('output/empty', array('value' => elgg_echo('activities:none')));
    }
    $params = array(
        'content' => $content,
        'title' => $title,
        'filter' => $filter,
    );
    $body = elgg_view_layout('one_column', $params);

}elseif(hasTeacherAccess($user->role)){ // teacher, admin
    $order_by = get_input('order_by');
    $sort = get_input('sort');
    $selected_tab = get_input('filter', 'all');
    $filter = elgg_view('navigation/tabs', array('selected' => $selected_tab, 'href' => $page[0]));
    $sidebar = elgg_view_module('aside', elgg_echo('filter'),
        elgg_view_form(
            'filter_search',
            array(
                'id' => 'add_labels',
                'style' => 'background: #fff;padding: 15px;',
                'body' => elgg_view('activities/sidebar/filter')
            )
        ));
    // Filter search
    if($search = get_input('s')) {
        $all_entities = activity_filter_search($search);
        if($order_by){
            $all_entities = get_entities_order(
                'ClipitActivity',
                $all_entities,
                clipit_get_limit(10),
                clipit_get_offset(),
                $order_by,
                $sort
            );
        } else {
            $all_entities = ClipitActivity::get_by_id($all_entities);
        }
        $count = count($all_entities);
        $entities = array_slice($all_entities, clipit_get_offset(), clipit_get_limit(10));
    } else {
        switch($selected_tab){
            case 'mine':
                $all_entities = ClipitActivity::get_by_id(ClipitUser::get_activities(elgg_get_logged_in_user_guid()));
                break;
            default:
                $all_entities = ClipitActivity::get_all(0, 0, '', true, true);
                if($order_by) {
                    $all_entities = get_entities_order(
                        'ClipitActivity',
                        $all_entities,
                        clipit_get_limit(10),
                        clipit_get_offset(),
                        $order_by,
                        $sort
                    );
                } else {
                    $all_entities = ClipitActivity::get_by_id($all_entities);
                }

                break;
        }
        $count = count($all_entities);
        $entities = array_slice($all_entities, clipit_get_offset(), clipit_get_limit(10));
    }
    $to_order = array(
        'name' => elgg_echo('activity:title'),
        'tricky_topic' => elgg_echo('tricky_topic'),
        'status' => elgg_echo('status'),
    );
    $table_orders = table_order($to_order, $order_by, $sort);
    $content = elgg_view('activities/list', array(
        'entities' => $entities,
        'count' => $count,
        'table_orders' => $table_orders
    ));
    $params = array(
        'content' => $content,
        'title' => $title,
        'filter' => $filter,
        'sidebar' => $sidebar,
    );
    $body = elgg_view_layout('one_sidebar', $params);
}

echo elgg_view_page($title, $body);