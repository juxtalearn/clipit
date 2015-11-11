<?php
/**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   27/06/14
 * Last update:     27/06/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$activity_id = (int)elgg_get_page_owner_guid();
echo elgg_view('output/url', array(
    'href' => "clipit_activity/{$activity_id}/join",
    'text' => elgg_echo('activity:button:join'),
    'class' => 'join-activity-button',
    'is_trusted' => true,
));