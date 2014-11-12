<?php
/**
 * Created by JetBrains PhpStorm.
 * User: equipo
 * Date: 4/02/14
 * Time: 10:44
 * To change this template use File | Settings | File Templates.
 */

function get_video_thumbnail($url, $size){
    $data = video_url_parser($url);
    if($data['provider'] == 'youtube'){
        switch($size){
            case 'large':
                $size = 'maxresdefault';
                break;
            case 'normal':
                $size = 'mqdefault';
                break;
            case 'small':
                $size = 'default';
                break;
        }
        return "http://i1.ytimg.com/vi/".$data['id']."/".$size.".jpg";
    }
}
function get_acronym($title){
    $words = explode(" ", $title);
    $acronym = "";
    foreach ($words as $w) {
        $acronym .= $w[0];
    }
    return $acronym;
}
/**
 * Obtain friendly time (past|future)
 *
 * @param $time
 * @return mixed|null|string
 */
function get_friendly_time($time){
    $params = array('time' => $time);
    $result = elgg_trigger_plugin_hook('format', 'friendly:time', $params, NULL);
    if ($result) {
        return $result;
    }

    if(time() > (int) $time){
        // Ago
        $translate = "friendlytime";
        $diff = time() - (int)$time;
    } else {
        $translate = "friendlytime:next";
        $diff = (int)$time - time();
    }


    $minute = 60;
    $hour = $minute * 60;
    $day = $hour * 24;

    if ($diff < $minute) {
        return elgg_echo("$translate:justnow");
    } else if ($diff < $hour) {
        $diff = round($diff / $minute);
        if ($diff == 0) {
            $diff = 1;
        }

        if ($diff > 1) {
            return elgg_echo("$translate:minutes", array($diff));
        } else {
            return elgg_echo("$translate:minutes:singular", array($diff));
        }
    } else if ($diff < $day) {
        $diff = round($diff / $hour);
        if ($diff == 0) {
            $diff = 1;
        }

        if ($diff > 1) {
            return elgg_echo("$translate:hours", array($diff));
        } else {
            return elgg_echo("$translate:hours:singular", array($diff));
        }
    } else {
        $diff = round($diff / $day);
        if ($diff == 0) {
            $diff = 1;
        }

        if ($diff > 1) {
            return elgg_echo("$translate:days", array($diff));
        } else {
            return elgg_echo("$translate:days:singular", array($diff));
        }
    }
}

/**
 * Convert Hex Color to RGB
 *
 * @param $hex
 * @return array
 */
function hex2rgb($hex) {
    $hex = str_replace("#", "", $hex);

    if(strlen($hex) == 3) {
        $r = hexdec(substr($hex,0,1).substr($hex,0,1));
        $g = hexdec(substr($hex,1,1).substr($hex,1,1));
        $b = hexdec(substr($hex,2,1).substr($hex,2,1));
    } else {
        $r = hexdec(substr($hex,0,2));
        $g = hexdec(substr($hex,2,2));
        $b = hexdec(substr($hex,4,2));
    }
    $rgb = array($r, $g, $b);
    //return implode(",", $rgb); // returns the rgb values separated by commas
    return $rgb; // returns an array with the rgb values
}
function clipit_events_feed($entity){
    $vars['author'] = array_pop(ClipitUser::get_by_id(array($entity->performed_by_guid)));
    $vars['time'] = $entity->time_created;
    $relationship = get_relationship($entity->object_id);
    $explode_relation = explode("-", $relationship->relationship);

    if($explode_relation[1] != 'group'){
        switch($explode_relation[1]){
            case 'file':
                $vars['icon'] = "upload";
                $vars['message'] = "Upload the file";
                $object = array_pop(ClipitFile::get_by_id(array($relationship->guid_two)));
                $vars['item']['name'] = $object->name;
                $vars['item']['description'] = $object->description;
                $vars['item']['icon'] = $object->description;
                break;
            case 'user':
                $vars['icon'] = "user";
                $vars['message'] = "Se ha unido al grupo";
                $object = array_pop(ClipitGroup::get_by_id(array($relationship->guid_one)));
                $vars['item']['name'] = $object->name;
                break;

        }
    }
    // Message system
    if($explode_relation[1] == 'destination'){
        $vars['icon'] = "comment";
        $vars['message'] = "Ha creado una discussión";
        $object = array_pop(ClipitMessage::get_by_id(array($relationship->guid_one)));
        $vars['item']['name'] = $object->name;
        $vars['item']['description'] = $object->description;

    }
    if(!isset($vars['item'])){
        return false;
    }
    return $vars;
}

function register_clipit_event($type, $callback){
    global $CONFIG;
    $CONFIG->feed_callbacks[$type] = $callback;
}
//function load_clipit_event($relationship, $activity){
//    global $CONFIG;
//    $args = array($relationship, $activity);
//    foreach($CONFIG->feed_callbacks as $type => $callback){
//        if($type == $relationship->relationship){
//            if (!is_callable($callback) && (call_user_func_array($callback, $args) === false)) {
//                return false;
//            } else {
//                return call_user_func_array($callback, $args);
//            }
//        }
//
//    }
//}
function load_clipit_event($event, $relationship){
    global $CONFIG;
    $args = array($event, $relationship);
    foreach($CONFIG->feed_callbacks as $type => $callback){
        if($type == $relationship->relationship){
            if (!is_callable($callback) && (call_user_func_array($callback, $args) === false)) {
                return false;
            } else {
                return call_user_func_array($callback, $args);
            }
        }

    }
}

function get_group_activity($event){
    $object_rel = get_relationship($event->object_id);
    $activity_id = ClipitGroup::get_activity($object_rel->guid_one);
    $explode_rel = explode("-", $object_rel->relationship);
    if (strpos($object_rel->relationship, "message") !== false) {
        $activity_id = ClipitGroup::get_activity($object_rel->guid_two);
    }
    if($explode_rel[0] == 'activity'){
        $activity_id = $object_rel->guid_one;
    }
    $activity = array_pop(ClipitActivity::get_by_id(array($activity_id)));
    return $activity;
}


/**
 * Forward to $location.
 *
 * @param $delimiter
 * @param null $to
 * @return string
 */
function custom_forward_referer($delimiter, $location = null){
    $referer = $_SERVER['HTTP_REFERER'];
    $path = explode($delimiter, $referer);
    if(strpos($referer, $delimiter) !== false){
        return $path[0] . $location;
    } else {
        return $referer;
    }

}

function clipit_get_offset(){
    return get_input("offset", 0);
}
function clipit_get_limit($limit = 15){
    return get_input("limit", $limit);
}
function clipit_get_pagination($params){
    $defaults = array(
        'offset' => clipit_get_offset(),
        'limit' => clipit_get_limit()
    );
    $params = array_merge($params, $defaults);
    return elgg_view("navigation/pagination", $params);
}