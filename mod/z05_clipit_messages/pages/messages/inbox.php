<?php
/**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   22/04/14
 * Last update:     22/04/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$user_id = elgg_get_logged_in_user_guid();
$title = elgg_echo("messages:inbox");
elgg_push_breadcrumb($title);

$messages = ClipitChat::get_inbox($user_id);
// Search items
if($search_term = stripslashes(get_input("search"))){
    $items_search = array_keys(ClipitChat::get_from_search($search_term));
    $messages = array_uintersect($items_search, $messages, "strcasecmp");
    $messages = ClipitChat::get_by_id($messages);
}

array_reverse($messages);
if(!is_array($messages)){
    $messages = array();
}

$rows = array();
foreach($messages as $message){
    if(is_array($message)){
        $message = array_pop($message);
    }
    $user = array_pop(ClipitUser::get_by_id(array($message->owner_id)));

    $message->description = trim(elgg_strip_tags($message->description));
    // Message text truncate max length 50
    if(mb_strlen($message->description) > 50){
        $message->description = substr($message->description, 0, 50)."...";
    }
    $message_url = elgg_get_site_url()."messages/view/$user->login";

    // Option buttons
    $buttons = elgg_view('output/url', array(
            'href'  => "messages/view/{$user->login}#create_reply",
            'title' => elgg_echo("reply:create"),
            'class' => 'btn btn-default btn-xs reply-button hidden-xs',
            'text'  => '<i class="fa fa-plus"></i> '.elgg_echo("reply"),
        ));
    $remove_msg_url = "action/messages/set_options?set-option=remove&check-msg[]={$message->owner_id}";
    $buttons .= elgg_view('output/url', array(
            'href'  => elgg_add_action_tokens_to_url($remove_msg_url, true),
            'title' => elgg_echo("message:movetotrash"),
            'text'  => '<i class="fa fa-trash-o" style="color: #fff;font-size: 18px;"></i> ',
            'aria-label' => elgg_echo('delete'),
            'class' => 'btn btn-danger btn-xs',
        ));

    $check_msg = '<input type="checkbox" name="check-msg[]" value="'.$message->owner_id.'" class="select-simple">';
    $text_user_from = $user->name;
    if($message->owner_id == elgg_get_logged_in_user_guid()){
        $text_user_from = "<strong>".elgg_echo("me")."</strong>";
    }
    $user_avatar = elgg_view('output/img', array(
        'src' => get_avatar($user, 'small'),
        'class' => 'avatar-tiny',
        'alt'  => 'Avatar',
    ));
    $user_data = elgg_view('output/url', array(
        'href'  => "profile/".$user->login,
        'title' => $user->name,
        'text'  => $text_user_from));
    $last_message_data = elgg_view("messages/last_message", array('message' => $message));

    $unread_count = ClipitChat::get_conversation_unread($user_id, $message->owner_id);
    $new_messages = "";
    if($unread_count > 0){
        $new_messages = '<span class="label label-primary label-mini new-replies" title="'.elgg_echo("messages:unreads", array($unread_count)).'">+'.$unread_count.'</span>';
    }

    // row content
    $row = array(
        array(
            'class' => 'select',
            'content' => $check_msg
        ),
        array(
            'class' => 'user-avatar hidden-xs',
            'content' => $user_avatar
        ),
        array(
            'class' => 'user-owner',
            'content' => $user_data.$last_message_data
        ),
        array(
            'onclick' => "document.location.href = '{$message_url}';",
            'class' => 'click-simulate',
            'content' => $new_messages
        ),
        array(
            'onclick' => "document.location.href = '{$message_url}';",
            'class' => 'click-simulate',
            'content' => $message->description
        ),
        array('content' => $buttons),
    );
    $rows[] = array('content' => $row, 'class' => $unread_count ? "unread":"");
}

$list_options = array(
    'options_values' => array(
        ''          => '['.elgg_echo('message:options').']',
        'read'      => elgg_echo('message:markasread'),
        'unread'    => elgg_echo('message:markasunread'),
        'remove'    => elgg_echo('message:movetotrash'),
    )
);
// set content
$content_list .= elgg_view("page/elements/list/options", array('options' => $list_options));
$content_list .= elgg_view("page/elements/list/table", array('rows' => $rows, 'class' => 'messages-table', 'responsive' => true));

$content = elgg_view("search/search");
$content .= elgg_view_form("messages/set_options", array('body' => $content_list, 'style' => 'overflow-x: auto;', 'class' => 'block-total'));

if (!$messages) {
    $content = elgg_echo("messages:inbox:none");
}

$params = array(
    'content'   => $content,
    'filter'    => '',
    'title'     => $title,
    'sidebar'   => elgg_view('messages/sidebar/group_list')
);

$body = elgg_view_layout('content', $params);
echo elgg_view_page($params['title'], $body);