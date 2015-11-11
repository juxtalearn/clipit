<?php
/**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   21/10/2014
 * Last update:     21/10/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */

//$edu_list = ClipitActivity::get_all($limit = 0, $offset = 0, $order_by = "name", $ascending = false);
$edu_list = ClipitRemoteSite::get_all(0, 0, 'name');

foreach($edu_list as $edu){
    $name = "videos/".elgg_get_friendly_title($edu->name)."/".$edu->id;
    elgg_register_menu_item('sidebar:videos', array(
        'name' => $edu->name,
        'text' => $edu->name,
        'href' => $name,
        'selected' => false
    ));
}

echo elgg_view_menu('sidebar:videos', array(
    'sort_by' => 'register',
));