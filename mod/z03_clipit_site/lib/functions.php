<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   04/02/2015
 * Last update:     04/02/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */

function get_search_input($get_input){
    $s = json_decode(get_input('s'));
    if($s->$get_input) {
        return $s->$get_input;
    } else {
        return array();
    }
}

function set_search_input($page, $search_array){
    $output  = $page."?s=".json_encode($search_array);
    return $output;
}
function natural_sort_properties(&$objects, $property = 'name'){
    usort($objects, function ($a, $b) use ($property) {
        return strnatcmp($a->$property, $b->$property);
    });
}