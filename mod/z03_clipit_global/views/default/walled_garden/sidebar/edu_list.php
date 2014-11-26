<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   21/10/2014
 * Last update:     21/10/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */

$edu_list = ClipitActivity::get_all($limit = 0, $offset = 0, $order_by = "name", $ascending = false);
foreach($edu_list as $edu){
    $name = strtolower(get_acronym($edu->name));
    elgg_register_menu_item('sidebar:videos', array(
        'name' => $name,
        'text' => $edu->name,
        'href' => "videos/".$name,
        'selected' => false
    ));
}

echo elgg_view_menu('sidebar:videos', array(
    'sort_by' => 'register',
));