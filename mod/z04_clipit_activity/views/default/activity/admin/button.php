<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   18/07/14
 * Last update:     18/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$activity_id = elgg_get_page_owner_guid();
?>
<?php echo elgg_view('output/url', array(
    'title' => elgg_echo('activity:edit'),
    'text' => '<i class="fa fa-pencil" style="font-size: 21px;"></i> '.elgg_echo('activity:edit'),
    'href' => "clipit_activity/{$activity_id}/admin",
    'class' => 'compose-message-button btn btn-lg btn-admin',
));
?>