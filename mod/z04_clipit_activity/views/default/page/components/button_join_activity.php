<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   27/06/14
 * Last update:     27/06/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$activity_id = (int)elgg_get_page_owner_guid();
echo elgg_view('output/url', array(
    'href' => "clipit_activity/{$activity_id}/join",
    'text' => elgg_echo('activity:button:join'),
    'class' => 'join-activity-button',
    'is_trusted' => true,
));