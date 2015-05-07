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
foreach($performance_items as $item){
    $item_data = array(
        'name' => $item['name'],
        'description' => $item['description'],
        'example' => $item['example'],
        'category' => get_input('category'),
        'category_description' => get_input('category_description')
    );
    if($item['id'] && trim($item['name'])!=''){
        // Edit performance properties
        ClipitPerformanceItem::set_properties($item['id'], $item_data);
    } else {
        // Create new performance item
        print_r($item_data);
        ClipitPerformanceItem::create($item_data);
    }
}
forward(REFERER);