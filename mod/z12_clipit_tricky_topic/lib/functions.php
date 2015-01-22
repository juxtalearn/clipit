<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   22/01/2015
 * Last update:     22/01/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */

/**
 * Sort entities any type
 *
 * @param $entities
 * @param $order_by
 * @param $sort
 * @param $properties_available Entity::list_properties()
 * @return bool
 */
function entities_order(&$entities, $order_by, $sort, $properties_available){

    usort($entities,
        function ($a, $b) use ($order_by, $sort, $properties_available) {
            if (!$a && !$b) {
                return 0;
            } elseif (!$a) {
                return 1;
            } elseif (!$a) {
                return -1;
            }
            if(!array_key_exists($order_by, $properties_available)){
                return false;
            }


            switch($sort){
                case 'desc':
                    $i = $a;
                    $x = $b;
                    break;
                case 'asc':
                    $i = $b;
                    $x = $a;
                    break;
                default:
                    $i = $a;
                    $x = $b;
                    break;
            }
            switch($order_by){
                case 'tricky_topic':
                    $a_t = array_pop(ClipitTrickyTopic::get_by_id(array($i->tricky_topic)));
                    $b_t = array_pop(ClipitTrickyTopic::get_by_id(array($x->tricky_topic)));
                    return strcmp($a_t->name, $b_t->name);
                    break;
            }

            return strcmp($i->$order_by, $x->$order_by);
        }
    );
    return true;
}

function table_order($to_order = array(), $order_by, $sort = ''){
    $table_orders = array();
    foreach($to_order as $key => $value){
        if(!$sort){
            $sort = 'desc';
        }
        $order_sort = $sort;
        $sort_icon = 'fa-sort';
        if($order_by == $key){
            $order_sort = 'desc';
            switch($sort){
                case 'asc':
                    $order_sort = 'desc';
                    $sort_icon = 'fa-caret-up';
                    break;
                case 'desc':
                    $order_sort = 'asc';
                    $sort_icon = 'fa-caret-down';
                    break;
            }
        } else {
            $order_sort = 'desc';
        }
        $href = elgg_http_remove_url_query_element(current_page_url(), 'offset');
        $href = elgg_http_add_url_query_elements($href, array('order_by' => $key, 'sort' => $order_sort));
        if($sort == 'asc' && $order_by == $key){
            $href = elgg_http_remove_url_query_element($href, 'sort');
            $href = elgg_http_remove_url_query_element($href, 'order_by');
        }

        $table_orders[$key] = array('href' => $href, 'value' => $value, 'sort_icon' => $sort_icon);
    }
    return $table_orders;
}