<?php
/**
 * Created by JetBrains PhpStorm.
 * User: equipo
 * Date: 24/02/14
 * Time: 15:11
 * To change this template use File | Settings | File Templates.
 */
$activity_id = (int)elgg_get_page_owner_guid();
echo elgg_view('output/url', array(
    'href' => "z04_clipit_activity/{$activity_id}/join",
    'text' => elgg_echo('activity:join'),
    'class' => 'join-activity-button',
    'is_trusted' => true,
));