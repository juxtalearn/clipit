<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   09/04/2015
 * Last update:     09/04/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
function performance_items_available_languages($performance_item_array = ''){
    if(!$performance_item_array){
        $performance_item_array = range(0,4);
    }
    $languages = array();
    foreach($performance_item_array as $lang_code => $p_item) {
        switch ($lang_code) {
            case 0: $languages[0] = 'en'; break;
            case 1: $languages[1] = 'es'; break;
            case 2: $languages[2] = 'de'; break;
            case 3: $languages[3] = 'pt'; break;
            case 4: $languages[4] = 'sv'; break;
            default: $languages[5] = 'en'; break;
        }
    }
    return array_map('elgg_echo', $languages);
}