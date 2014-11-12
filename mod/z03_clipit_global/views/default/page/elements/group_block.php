<?php
/**
 * Created by JetBrains PhpStorm.
 * User: equipo
 * Date: 24/02/14
 * Time: 12:24
 * To change this template use File | Settings | File Templates.
 */
elgg_push_context('group_block');
// User
$user_id = elgg_get_logged_in_user_guid();
$user_id = $user_id;
// Activity owner object
$activity_id = elgg_get_page_owner_guid();
$activity_object = array_pop(ClipitActivity::get_by_id(array($activity_id)));

if ($activity_object instanceof ClipitActivity
    && ClipitGroup::get_from_user_activity($user_id, $activity_id)) {

    $header = '<h3>' . elgg_echo("my_group") . '</h3>';
    $body = elgg_view('output/url', array(
                    'href' => "javascript:;",
                    'text' => ' <i class="fa fa-caret-down"></i>',
                    'id'   => 'gSettings',
                    'data-toggle'  => 'dropdown',
                    'is_trusted' => true,
                ));
    // Group menu
    //$body = elgg_view_menu('group_block', array('entity' => $activity_object));
    // Group progress details
    $params_progress = array(
        'value' => 30,
        'width' => '200px'
    );
    $body .= elgg_view("page/components/progressbar", $params_progress);

    echo elgg_view('page/components/module', array(
        'header' => $header,
        'body' => $body,
        'class' => 'activity-group-block',
    ));
}

elgg_pop_context();
?>