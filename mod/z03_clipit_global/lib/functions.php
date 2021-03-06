<?php
/**
 * Created by JetBrains PhpStorm.
 * User: equipo
 * Date: 4/02/14
 * Time: 10:44
 * To change this template use File | Settings | File Templates.
 */

function format_file_size($bytes) {
    $bytes = (int)$bytes;
    if ($bytes >= 1000000000) {
        return round(($bytes / 1000000000), 2) . ' GB';
    }
    if ($bytes >= 1000000) {
        return round(($bytes / 1000000), 2) . ' MB';
    }
    return round(($bytes / 1000), 2) . ' KB';
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
function get_video_thumbnail($url, $size){
    if (strpos($url, 'youtube.com') != false || strpos($url, 'youtu.be') != false) {
        preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $url, $matches);
        $id = $matches[0];
        $href_img = 'http://img.youtube.com/vi/'.$id.'/';
        switch($size){
            case 'large':
//                $href_img .= 'maxresdefault.jpg';
                $href_img .= 'hqdefault.jpg';
                break;
            case 'normal':
                $href_img .= 'mqdefault.jpg';
                break;
            case 'small':
                $href_img .= 'default.jpg';
                break;
        }
    } else if (strpos($url, 'vimeo.com') != false) {
        preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=vimeo.com/)[^&\n]+#", $url, $matches);
        $id = $matches[0];
        $data = file_get_contents("http://vimeo.com/api/v2/video/$id.json");
        $data = array_pop(json_decode($data));
        switch($size){
            case 'large':
                $href_img = $data->thumbnail_large;
                break;
            case 'normal':
                $href_img = $data->thumbnail_medium;
                break;
            case 'small':
                $href_img = $data->thumbnail_small;
                break;
        }
    } else {
        return false;
    }
    return $href_img;
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
function clipit_get_offset_last($entities_count, $limit = 15){
    $total = ceil($entities_count / $limit);
    return ($total-1)*$limit;
}

function clipit_get_pagination($params){
    $defaults = array(
        'offset' => clipit_get_offset(),
        'limit' => clipit_get_limit()
    );
    $params = array_merge($defaults, $params);
    return elgg_view("navigation/pagination", $params);
}
/**
 * Get all countries list names
 */
function get_countries_list($key = ''){
    $countries_code = array(
        'AF','AL','DZ','AS','AD','AO','AI','AQ','AG','AR','AM','AW','AU','AT','AZ','BS',
        'BH','BD','BB','BY','BE','BZ','BJ','BM','BT','BO','BA','BW','BV','BR','BQ','IO',
        'VG','BN','BG','BF','BI','KH','CM','CA','CT','CV','KY','CF','TD','CL','CN','CX',
        'CC','CO','KM','CG','CD','CK','CR','HR','CU','CY','CZ','CI','DK','DJ','DM','DO',
        'NQ','DD','EC','EG','SV','GQ','ER','EE','ET','FK','FO','FJ','FI','FR','GF','PF',
        'TF','FQ','GA','GM','GE','DE','GH','GI','GR','GL','GD','GP','GU','GT','GG','GN',
        'GW','GY','HT','HM','HN','HK','HU','IS','IN','ID','IR','IQ','IE','IM','IL','IT',
        'JM','JP','JE','JT','JO','KZ','KE','KI','KW','KG','LA','LV','LB','LS','LR','LY',
        'LI','LT','LU','MO','MK','MG','MW','MY','MV','ML','MT','MH','MQ','MR','MU','YT',
        'FX','MX','FM','MI','MD','MC','MN','ME','MS','MA','MZ','MM','NA','NR','NP','NL',
        'AN','NT','NC','NZ','NI','NE','NG','NU','NF','KP','VD','MP','NO','OM','PC','PK',
        'PW','PS','PA','PZ','PG','PY','YD','PE','PH','PN','PL','PT','PR','QA','RO','RU',
        'RW','RE','BL','SH','KN','LC','MF','PM','VC','WS','SM','SA','SN','RS','CS','SC',
        'SL','SG','SK','SI','SB','SO','ZA','GS','KR','ES','LK','SD','SR','SJ','SZ','SE',
        'CH','SY','ST','TW','TJ','TZ','TH','TL','TG','TK','TO','TT','TN','TR','TM','TC',
        'TV','UM','PU','VI','UG','UA','SU','AE','GB','US','ZZ','UY','UZ','VU','VA','VE',
        'VN','WK','WF','EH','YE','ZM','ZW','AX'
    );
    $countries = array("" => elgg_echo('country:select'));
    foreach($countries_code as $code){
        $countries[$code] = elgg_echo('country:'.$code);
    }
    $countries = array_change_key_case($countries);
    if($key){
        return $countries[$key];
    } else {
        return $countries;
    }
}