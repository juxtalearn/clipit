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

elgg_register_event_handler('init', 'system', 'clipit_messages_init');

function clipit_messages_init() {
    // Register page handlers
    elgg_register_page_handler('messages', 'messages_page_handler');
    elgg_register_event_handler('pagesetup', 'system', 'messages_setup_sidebar_menus');
    // message actions
    elgg_register_action("messages/compose", elgg_get_plugins_path() . "z05_clipit_messages/actions/messages/create.php");
    elgg_register_action("messages/set_options", elgg_get_plugins_path() . "z05_clipit_messages/actions/messages/set_options.php");
    // reply msg actions
    elgg_register_action("messages/reply/create", elgg_get_plugins_path() . "z05_clipit_messages/actions/messages/reply/create.php");
    elgg_register_action("messages/reply/remove", elgg_get_plugins_path() . "z05_clipit_messages/actions/messages/reply/remove.php");
    elgg_register_action("messages/reply/edit", elgg_get_plugins_path() . "z05_clipit_messages/actions/messages/reply/edit.php");

    // Ajax views
    elgg_register_ajax_view("messages/search_to");
    elgg_register_ajax_view("messages/inbox_summary");
    elgg_register_ajax_view('modal/messages/send');
    elgg_register_ajax_view('modal/messages/edit');
    elgg_register_ajax_view('modal/messages/reply/edit');

    elgg_extend_view("js/clipit", "js/message", 300);
    // "Messages" Nav menu top
    elgg_extend_view("navigation/menu/top", "navigation/menu/messages", 300);

}
/**
 * Messages page handler
 *
 * URLs take the form of
 *  Messages site:    messages/inbox
 *  List topics in forum:  discussion/owner/<guid>
 *  View discussion topic: discussion/view/<guid>
 *  Add discussion topic:  discussion/add/<guid>
 *  Edit discussion topic: discussion/edit/<guid>
 *
 * @param array $page Array of url segments for routing
 * @return bool
 */
function messages_page_handler($page) {
    $current_user = elgg_get_logged_in_user_guid();
    elgg_set_context("messages_page");
    if (!$current_user) {
        register_error(elgg_echo('noaccess'));
        $_SESSION['last_forward_from'] = current_page_url();
        forward('');
    }
    // messages/ -> messages/inbox
    if(count($page)==0){
        forward('messages/inbox');
    }
    if(isset($page[0])){
        $user_id = elgg_get_logged_in_user_guid();
        elgg_push_breadcrumb(elgg_echo("messages"), "/messages/inbox");
        elgg_extend_view("page/elements/owner_block", "page/components/button_compose_message");
        $file_dir = elgg_get_plugins_path() . 'z05_clipit_messages/pages/messages';
        switch ($page[0]) {
            case 'inbox':
                include "$file_dir/inbox.php";
                break;
            case 'sent':
                include "$file_dir/sent.php";
                break;
            case 'trash':
                include "$file_dir/trash.php";
                break;
            case 'view':
                include "$file_dir/view.php";
                break;
            default:
                return false;
        }

    }
    return true;
}


function messages_setup_sidebar_menus(){
    $user_id = elgg_get_logged_in_user_guid();
    if (elgg_in_context('messages_page')) {
        $unread_count = ClipitChat::get_inbox_unread($user_id);
        $params = array(
            'name' => 'a_inbox',
            'text' => elgg_echo('messages:inbox'),
            'href' => "messages/inbox",
            'badge' => $unread_count > 0 ? $unread_count : ""
        );
        elgg_register_menu_item('page', $params);
        $params = array(
            'name' => 'sent',
            'text' => elgg_echo('messages:sent_email'),
            'href' => "messages/sent",
        );
        elgg_register_menu_item('page', $params);
        $params = array(
            'name' => 'trash',
            'text' => elgg_echo('messages:trash'),
            'href' => "messages/trash",
        );
        elgg_register_menu_item('page', $params);
    }

}
