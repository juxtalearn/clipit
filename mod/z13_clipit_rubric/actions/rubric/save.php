<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   02/02/2015
 * Last update:     02/02/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$performance_items = get_input('item');
$item_id = get_input('entity-id');

$t = array();
for ($i = 0; $i <= (count($performance_items[0]) - 3); $i++) {
    $reference = $performance_items[0][$i]['reference'];
    if(!isset($reference) && is_array($performance_items[0][$i])){
        $item_id = ClipitPerformanceItem::create(array());
        $item = array_pop(ClipitPerformanceItem::get_by_id(array($item_id)));
        $t[$i] = $item->reference;
//        $t[$i] = mt_rand(1000, 1500);
    }
}
//print_r($performance_items);

foreach($performance_items as $lang_code => $performances) {
    if(is_array($performances)){
        $x = 0;
        foreach($performances as $key => $performance){

            if(is_array($performance)){
                $performance['language'] = $performances['language'];
                $performance['category'] = $performances['category'];
                $performance['category_description'] = $performances['category_description'];
                if(isset($t[$x])){
                    $performance['reference'] = $t[$x];
                }
//                print_r($performance);
                ClipitPerformanceItem::create(($performance));
                $x++;
            }
        }
        //echo "\n\n\n\n\n\n";
    }
}
//die;
//if($item_id){
//    // Edit Performance Item
//    foreach($performance_items as $i => $properties){
//        ClipitPerformanceItem::set_properties($item_id, $properties);
//    }
//}
forward(REFERER);