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

function get_entities_order($object, $entities, $limit, $offset, $order_by, $sort_entity){
    $sort = ($sort_entity == 'asc' ? true : false);
    $relationships_array = array('tricky_topic', 'education_level');
    if(in_array($order_by, $relationships_array)){
        $entities = order_by_relationship(
            $object,
            $entities,
            $order_by,
            $sort
        );
        return $entities;
//        return array_slice($entities, clipit_get_offset(), clipit_get_limit(10));
    }
    return $object::get_by_id(
        $entities,
//        $limit,
//        $offset,
        0,
        0,
        $order_by,
        $sort
    );
}

function order_by_relationship($object, $entities, $order_by, $asc){
    $entity_array = $object::get_by_id($entities, 0, 0);
    usort($entity_array, function($a, $b) use ($order_by, $asc){
            $i = $b;
            $x = $a;
            if($asc == true){
                $i = $a;
                $x = $b;
            }
            return strcmp($i->$order_by, $x->$order_by);
        }
    );
    $entity = array();
    foreach($entity_array as $entity_object){
        $entity[] = $entity_object;
    }
    return $entity;
}

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

function trickytopic_filter_search($query){
    $item_ids = array();
    $query_ar = json_decode($query);
    foreach($query_ar as $s => $value){
        switch($s){
            case 'name':
                $item_search = array();
                $tts = ClipitTrickyTopic::get_from_search($value);
                foreach ($tts as $tt) {
                    $item_ids[] = $tt->id;
                }
                break;
            case 'tags':
                $item_search = array();
                foreach ($value as $tag_name) {
                    $tags = ClipitTag::get_from_search($tag_name);
                    foreach ($tags as $tag) {
                        $item_search = array_merge($item_search, ClipitTag::get_tricky_topics($tag->id));
                    }
                }
                if(empty($item_ids)) {
                    $item_ids = array_merge($item_ids, $item_search);
                } else {
                    $item_ids = array_intersect($item_ids, $item_search);
                }
                break;
            case 'subject':
                $item_search = array();
                $tricky_topics = ClipitTrickyTopic::get_all();
                foreach($tricky_topics as $tricky_topic){
                    if(stripos($tricky_topic->subject, $value) !== false){
                        $item_search[] = $tricky_topic->id;
                    }
                }
                if(empty($item_ids)) {
                    $item_ids = array_merge($item_ids, $item_search);
                } else {
                    $item_ids = array_intersect($item_ids, $item_search);
                }
                break;
            case 'education_level':
                $item_search = array();
                $tricky_topics = ClipitTrickyTopic::get_all();
                foreach($tricky_topics as $tricky_topic){
                    if($tricky_topic->education_level == $value){
                        $item_search[] = $tricky_topic->id;
                    }
                }
                if(empty($item_ids)) {
                    $item_ids = array_merge($item_ids, $item_search);
                } else {
                    $item_ids = array_intersect($item_ids, $item_search);
                }
                break;
        }
    }
    return $item_ids;
}
function example_filter_search($query){
    $item_ids = array();
    $query_ar = json_decode($query);
    foreach($query_ar as $s => $value){
        switch($s){
            case 'name':
                $item_search = array();
                $examples = ClipitExample::get_from_search($value);
                foreach ($examples as $example) {
                    $item_ids[] = $example->id;
                }
                break;
            case 'tricky_topic':
                $item_search = array();
                $tricky_topics = ClipitTrickyTopic::get_from_search($value);
                foreach ($tricky_topics as $tricky_topic) {
                    foreach(ClipitExample::get_from_tricky_topic($tricky_topic->id) as $example){
                        $item_search[] = $example->id;
                    }
                }
                if(empty($item_ids)) {
                    $item_ids = array_merge($item_ids, $item_search);
                } else {
                    $item_ids = array_intersect($item_ids, $item_search);
                }
                break;
            case 'tags':
                $item_search = array();
                foreach ($value as $tag_name) {
                    $tags = ClipitTag::get_from_search($tag_name);
                    foreach ($tags as $tag) {
                        foreach(ClipitExample::get_by_tag(array($tag->id)) as $example){
                            $item_search[] = $example->id;
                        }
                    }
                }
                if(empty($item_ids)) {
                    $item_ids = array_merge($item_ids, $item_search);
                } else {
                    $item_ids = array_intersect($item_ids, $item_search);
                }
                break;
            case 'country':
                $item_search = array();
                $examples = ClipitExample::get_all();
                foreach($examples as $example){
                    if($example->country == $value){
                        $item_search[] = $example->id;
                    }
                }
                if(empty($item_ids)) {
                    $item_ids = array_merge($item_ids, $item_search);
                } else {
                    $item_ids = array_intersect($item_ids, $item_search);
                }
                break;
            case 'location':
                $item_search = array();
                $examples = ClipitExample::get_all();
                foreach($examples as $example){
                    if($example->location == $value){
                        $item_search[] = $example->id;
                    }
                }
                if(empty($item_ids)) {
                    $item_ids = array_merge($item_ids, $item_search);
                } else {
                    $item_ids = array_intersect($item_ids, $item_search);
                }
                break;
        }
    }
    return $item_ids;
}


