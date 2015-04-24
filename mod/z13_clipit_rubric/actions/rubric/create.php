<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   17/04/2015
 * Last update:     17/04/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */

$performance_items = get_input('item');

for ($i = 0; $i <= (count($performance_items[0]) - 1); $i++) {
    $item_id = ClipitPerformanceItem::create(array());
    $item = array_pop(ClipitPerformanceItem::get_by_id(array($item_id)));
    $t[$i] = $item->reference;
}

foreach($performance_items as $lang_code => $performances) {
    if(is_array($performances)){
        $x = 0;
        foreach($performances as $key => $performance){
            if(is_array($performance)){
                $performance['reference'] = $t[$x];
                $performance['language'] = $performances['language'];
                $performance['category'] = $performances['category'];
                $performance['category_description'] = $performances['category_description'];
                ClipitPerformanceItem::create(($performance));
                $x++;
            }
        }
    }
}
forward(REFERER);
