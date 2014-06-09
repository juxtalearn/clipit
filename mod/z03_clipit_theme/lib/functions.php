<?php
/**
 * Created by JetBrains PhpStorm.
 * User: equipo
 * Date: 4/02/14
 * Time: 10:44
 * To change this template use File | Settings | File Templates.
 */
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
function clipit_event($event, $view_type){

    $relationship = get_relationship($event->object_id);

//    $activity = get_group_activity($event);
//    $default = array(
//        'activity'  => $activity,
//        'event'     => $event,
//        'author'    => array_pop(ClipitUser::get_by_id(array($event->performed_by_guid))),
//        'time'      => $event->time_created
//    );
//    $feed = load_clipit_event($relationship, $activity);
//    $params = array_merge($feed, $default);

    $default = array();
    $explode_rel = explode("-", $relationship->relationship);
    switch($explode_rel[0]){
        case "group":
            if($relationship->relationship == 'group-video'){
                return false;
            }
            $object = array_pop(ClipitGroup::get_by_id(array($relationship->guid_one)));
            $activity_id = ClipitGroup::get_activity($object->id);
            $activity = array_pop(ClipitActivity::get_by_id(array($activity_id)));
            $author = array_pop(ClipitUser::get_by_id(array($event->performed_by_guid)));
            $author_elgg = new ElggUser($event->performed_by_guid);

            $default = array(
                'author'  => array(
                    'name'  => $author->name,
                    'icon'  => $author_elgg->getIconURL('small'),
                    'url'   => "profile/{$author->login}",
                ),
                'object' => array(
                    'name' => $object->name,
                    'url' => "clipit_activity/{$activity->id}/group/activity_log",
                ),
                'activity'  => $activity,
            );
            break;
        case "activity":
            $activity = array_pop(ClipitActivity::get_by_id(array($relationship->guid_one)));
            $author = array_pop(ClipitUser::get_by_id(array($event->performed_by_guid)));
            $author_elgg = new ElggUser($event->performed_by_guid);
            $default = array(
                'author'  => array(
                    'name'  => $author->name,
                    'icon'  => $author_elgg->getIconURL('small'),
                    'url'   => "profile/{$author->login}",
                ),
                'activity'  => $activity,
            );
            break;
    }
//    $params = array('event'=> load_clipit_event($event, $relationship));
    $default['time'] = $event->time_created;

    $event_params = load_clipit_event($event, $relationship);
    $params = array_merge($default, $event_params);
    $params = array('event' => $params);
    return elgg_view("feed/".$view_type, $params);
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




function clipit_student_events($rel_array){
    $content = "";
    foreach($rel_array as $relationship){
        $subtype = $relationship->object_subtype;
        $object_rel = get_relationship($relationship->object_id);
        $general_subtype = explode("-", $subtype);
        $general_subtype = (string)$general_subtype[0];
        // Group, Activity
        switch($general_subtype){
            case 'group':
                $content .= group_events($subtype, $object_rel, $relationship);
                break;
            case 'activity':
                $content .= activity_events($subtype, $object_rel, $relationship);
                break;
            case 'message':
                $content .= message_events($subtype, $object_rel, $relationship);
                break;
        }

    }
    return $content;
}

/*
 * Group events types
 */
function group_events($subtype, $object_rel, $relationship){
    $content = "";
    // Activity object
    $activity_id = ClipitGroup::get_activity($object_rel->guid_one);
    $activity = array_pop(ClipitActivity::get_by_id(array($activity_id)));
    // Group object
    $group = array_pop(ClipitGroup::get_by_id(array($object_rel->guid_one)));
    // User object
    $user = array_pop(ClipitUser::get_by_id(array($relationship->performed_by_guid)));
    $user = new ElggUser($user->id);

    switch($subtype){
        case "group-user":
            $params =  array(
                'title' => 'New member',
                'id'    => $relationship->id,
                'href'  => 'profile/'.$user->login,
                'icon'  => 'user',
                'color' => $activity->color,
                'time'  => $relationship->time_created,
                'details' => array(
                    'img'   => elgg_view('output/img', array(
                        'src' => $user->getIconURL('small'),
                        'alt' => $user->name,
                        'title' => elgg_echo('profile'),
                        'class' => 'img-thumb',
                    )),
                    'title' => $user->name,
                    'sub-title' => 'In '.$group->name,
                ),
            );
            $content .= elgg_view("page/components/timeline_event", $params);
            break;
        case "group-file":
            $file = array_pop(ClipitFile::get_by_id(array($object_rel->guid_two)));
            $params =  array(
                'title' => 'File uploaded',
                'id'    => $relationship->id,
                'href'  => 'clipit_activity/'.$activity->id.'/files/view/'.$file->id,
                'icon'  => 'upload',
                'color' => $activity->color,
                'time'  => $relationship->time_created,
                'details' => array(
                    'icon'   => 'file-text',
                    'title' => $file->name,
                    'sub-title' => 'By '.$user->name,
                    'description' => $file->description,
                ),
            );
            $content .= elgg_view("page/components/timeline_event", $params);
            break;
    }
    return $content;
}
/*
 * Activity events types
 */
function activity_events($subtype, $object_rel, $relationship){

}
/*
 * Message events types
 */
function message_events($subtype, $object_rel, $relationship){
    $user = array_pop(ClipitUser::get_by_id(array($relationship->performed_by_guid)));
    $user = new ElggUser($user->id);
    $activity_id = ClipitMessage::get_by_id(array($object_rel->guid_one));
    switch($subtype){
        case "message-destination":
            $params =  array(
                'title' => 'Message reply',
                'id'    => $relationship->id,
                'href'  => 'profile/'.$user->login,
                'icon'  => 'user',
                'color' => "fff",
                'time'  => $relationship->time_created,
                'details' => array(
                    'img'   => elgg_view('output/img', array(
                        'src' => $user->getIconURL('small'),
                        'alt' => $user->name,
                        'title' => elgg_echo('profile'),
                        'class' => 'img-thumb',
                    )),
                    'title' => $user->name,
                    'sub-title' => 'In ',
                ),
            );
            $content = elgg_view("page/components/timeline_event", $params);
            break;
    }
    return $content;
}
