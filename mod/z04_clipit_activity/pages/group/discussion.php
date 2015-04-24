<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   8/09/14
 * Last update:     8/09/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$title = elgg_echo("group:discussion");
$href = "clipit_activity/{$activity->id}/group/{$group->id}/discussion";
elgg_push_breadcrumb($title);

if($page[4] == 'view' && $page[5]){
    $message_id = (int)$page[5];
    $message = array_pop(ClipitPost::get_by_id(array($message_id)));
    elgg_pop_breadcrumb($title);
    elgg_push_breadcrumb($title, $href);
    elgg_push_breadcrumb($message->name);
    $content = false;
    if($message && $message->destination == $group->id){
        $href_multimedia = "clipit_activity/{$activity->id}/group/{$group->id}/repository/view";
        $reply = true;
        if($activity->status == ClipitActivity::STATUS_CLOSED){
            $reply = false;
        }
        $content = elgg_view('discussion/view', array(
            'entity' => $message,
            'group' => $group,
            'reply' => $reply,
            'href_multimedia' => $href_multimedia,
        ));
    } else {
        return false;
    }
} else {
    $messages = array_pop(ClipitPost::get_by_destination(array($group->id), 0, 0, false, '', false));

    $content =  elgg_view('discussion/list',
        array(
            'entity' => $group,
            'messages' => $messages,
            'attach_multimedia' => true,
            'href'   => $href,
            'create' => $canCreate
        )
    );
    if(!$messages){
        $content .= elgg_view('output/empty', array('value' => elgg_echo('discussions:none')));
    }
}
$params = array(
    'content'   => $content,
    'filter'    => '',
    'title'     => $title,
);