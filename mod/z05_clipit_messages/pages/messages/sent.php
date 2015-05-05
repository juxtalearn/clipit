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
$title = elgg_echo("messages:sent_email");
$user_id = elgg_get_logged_in_user_guid();
elgg_push_breadcrumb($title);
$messages = ClipitChat::get_sent($user_id);
if (!$messages) {
    $content = elgg_echo("messages:sent:none");
}
// Search items
if($search_term = stripslashes(get_input("search"))){
    $items_search = array_keys(ClipitChat::get_from_search($search_term));
    $messages = array_uintersect($items_search, $messages, "strcasecmp");
    $messages = ClipitChat::get_by_id($messages);
}
$rows = array();
foreach($messages as $message){
    $user = array_pop(ClipitUser::get_by_id(array($message->destination)));

    $message->description = trim(elgg_strip_tags($message->description));
    // Message text truncate max length 85
    if(mb_strlen($message->description) > 85){
        $message->description = substr($message->description, 0, 85)."...";
    }
    $message_url = elgg_get_site_url()."messages/view/{$user->login}#reply_{$message->id}";


    $check_msg = '<input type="checkbox" name="check-msg[]" value="'.$message->id.'" class="select-simple">';
    $text_user_from = $user->name;
    if($message->destination == elgg_get_logged_in_user_guid()){
        $text_user_from = "<strong>".elgg_echo("me")."</strong>";
    }
    $user_avatar = elgg_view('output/img', array(
        'src' => get_avatar($user, 'small'),
        'class' => 'avatar-tiny'
    ));
    $user_data = elgg_view('output/url', array(
        'href'  => "profile/".$user->login,
        'title' => $user->name,
        'text'  => $text_user_from));
    $user_data = elgg_echo("message:to") . ": " . $user_data;
    $time_created = '<small class="show">'.elgg_view('output/friendlytime', array('time' => $message->time_created)).'</small>';

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
            'content' => $user_data.$time_created
        ),
        array(
            'onclick' => "document.location.href = '{$message_url}';",
            'class' => 'click-simulate',
            'content' => $message->description
        ),
    );
    $rows[] = array('content' => $row);
}


$content = elgg_view("search/search");
$content .= elgg_view("page/elements/list/options", array('options' => $list_options));
$content .= elgg_view("page/elements/list/table", array('rows' => $rows, 'class' => 'messages-table', 'responsive' => true));


$params = array(
    'content'   => $content,
    'filter'    => '',
    'title'     => $title,
    'sidebar'   => elgg_view('messages/sidebar/group_list')
);
$body = elgg_view_layout('content', $params);
echo elgg_view_page($params['title'], $body);