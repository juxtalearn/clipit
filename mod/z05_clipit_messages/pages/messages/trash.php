<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   22/04/14
 * Last update:     22/04/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$title = elgg_echo("messages:trash");
elgg_push_breadcrumb($title);
$user_id = elgg_get_logged_in_user_guid();
$messages = ClipitChat::get_archived($user_id);
// Search items
if($search_term = stripslashes(get_input("search"))){
    $items_search = array_keys(ClipitChat::get_from_search($search_term));
    $messages = array_uintersect($items_search, $messages, "strcasecmp");
    $messages = ClipitChat::get_by_id($messages);
}

$rows = array();
foreach($messages as $message){
    $user = array_pop(ClipitUser::get_by_id(array($message->owner_id)));

    $message->description = trim(elgg_strip_tags($message->description));
    // Message text truncate max length 50
    if(mb_strlen($message->description) > 50){
        $message->description = substr($message->description, 0, 50)."...";
    }
    // Option buttons
    $move_msg_url = "action/messages/set_options?set-option=to_inbox&check-msg[]={$message->id}";
    $buttons =  elgg_view('output/url', array(
            'href'  => elgg_add_action_tokens_to_url($move_msg_url, true),
            'title' => elgg_echo("message:movetoinbox"),
            'style' => 'padding: 3px 9px;',
            'text'  => '<i class="fa fa-check"></i> '.elgg_echo("message:movetoinbox"),
            'class' => 'btn btn-success-o btn-xs',
        )
    );
    $check_msg = '<input type="checkbox" name="check-msg[]" value="'.$message->id.'" class="select-simple">';
    $text_user_from = $user->name;
    if($message->owner_id == elgg_get_logged_in_user_guid()){
        $text_user_from = "<strong>".elgg_echo("me")."</strong>";
    }
    $user_avatar = elgg_view('output/img', array(
        'src' => get_avatar($user, 'small'),
        'class' => 'avatar-tiny',
        'alt' => 'Avatar',
    ));
    $user_data = elgg_view('output/url', array(
        'href'  => "profile/".$user->login,
        'title' => $user->name,
        'text'  => $text_user_from));
    $time_created = '<small class="show">'.elgg_view('output/friendlytime', array('time' => $message->time_created)).'</small>';

    $row = array(
        array('content' => $check_msg),
        array(
            'class' => 'user-avatar',
            'content' => $user_avatar
        ),
        array('content' => $user_data.$time_created),
        array('content' => $message->description),
        array('content' => $buttons),
    );
    $rows[] = array('content' => $row);
}
$list_options = array(
    'options_values' => array(
        ''          => '['.elgg_echo('message:options').']',
        'read'      => elgg_echo('message:markasread'),
        'unread'    => elgg_echo('message:markasunread'),
        'to_inbox'    => elgg_echo('message:movetoinbox'),
    )
);

$content_list .= elgg_view("page/elements/list/options", array('options' => $list_options));
$content_list .= elgg_view("page/elements/list/table", array('rows' => $rows, 'class' => 'messages-table', 'responsive' => true));

$content = elgg_view("search/search");
$content .= elgg_view_form("messages/set_options", array('body' => $content_list, 'class' => 'block-total'));

if(empty($messages)){
    $content = elgg_echo("messages:trash:none");
}
$params = array(
    'content'   => $content,
    'filter'    => '',
    'title'     => $title,
    'sidebar'   => elgg_view('messages/sidebar/group_list')
);

$body = elgg_view_layout('content', $params);
echo elgg_view_page($params['title'], $body);